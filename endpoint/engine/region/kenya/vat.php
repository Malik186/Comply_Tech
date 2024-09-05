<?php
// File: kenya_vat.php

session_start(); // Start the session to access session variables

// Allow CORS from the front-end domain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to log errors
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'error.log');
}

// Function to validate the request origin
function validateOrigin() {
    $allowedDomain = 'https://complytech.mdskenya.co.ke';
    
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = $_SERVER['HTTP_REFERER'];
        if (strpos($referer, $allowedDomain) !== 0) {
            logError("Unauthorized access attempt from: " . $referer);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized domain.']);
            exit;
        }
    } else {
        logError("Unauthorized access attempt with no referer.");
        echo json_encode(['status' => 'error', 'message' => 'No referer. Unauthorized domain.']);
        exit;
    }
}

// Function to calculate VAT (default rate: 16%)
function calculateVAT($unit_price, $quantity, $vat_rate = 0.16) {
    $total_price = $unit_price * $quantity;
    $vat_amount = $total_price * $vat_rate;
    return $vat_amount;
}

// Function to generate a unique invoice number
function generateUniqueInvoiceNumber($pdo) {
    do {
        $invoiceNumber = 'INV-' . rand(1000, 9999) . '-' . time();
        // Check if invoice number already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM kenya_vat_results WHERE Invoice = :Invoice");
        $stmt->bindParam(':Invoice', $invoiceNumber);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    } while ($count > 0); // Repeat if invoice number is not unique

    return $invoiceNumber;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Ensure required fields are present
    if (!isset($data['customer_name'], $data['items']) || empty($data['items'])) {
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    // Assigning received data to variables
    $customer_name = $data['customer_name'];
    $customer_address = $data['customer_address'] ?? 'No address provided';
    $payment_terms = $data['payment_terms'] ?? 'None';
    $due_date = $data['due_date'] ?? date('Y-m-d', strtotime('+30 days'));

    // Database connection details
    $host = 'localhost';
    $dbName = 'mdskenya_comply_tech';
    $username = 'mdskenya_malik186';
    $password = 'Malik@Ndoli186';

    try {
        // Connect to the MySQL database
        $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the session username is set
        if (!isset($_SESSION['user']['username'])) {
            echo json_encode(['error' => 'No active session or user not logged in']);
            exit;
        }

        $user = $_SESSION['user']['username'];

        // Generate a unique invoice number
        $invoiceNumber = generateUniqueInvoiceNumber($pdo);

        // Prepare SQL to insert data into kenya_vat_results table
        $stmt = $pdo->prepare("
            INSERT INTO kenya_vat_results (
                Username, 
                Invoice, 
                date_generated, 
                due_date, 
                customer_name, 
                customer_address, 
                item_description, 
                quantity, 
                unit_price, 
                payment_terms
            ) VALUES (
                :Username, 
                :Invoice, 
                NOW(), 
                :due_date, 
                :customer_name, 
                :customer_address, 
                :item_description, 
                :quantity, 
                :unit_price, 
                :payment_terms
            )
        ");

        $total_vat = 0;

        // Iterate over the items and insert each one into the database
        foreach ($data['items'] as $item) {
            $item_description = $item['item_description'];
            $quantity = $item['quantity'];
            $unit_price = $item['unit_price'];

            // Calculate VAT for each item
            $vat = calculateVAT($unit_price, $quantity);
            $total_vat += $vat;

            // Bind parameters for each item
            $stmt->bindParam(':Username', $user);
            $stmt->bindParam(':Invoice', $invoiceNumber);
            $stmt->bindParam(':due_date', $due_date);
            $stmt->bindParam(':customer_name', $customer_name);
            $stmt->bindParam(':customer_address', $customer_address);
            $stmt->bindParam(':item_description', $item_description);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':unit_price', $unit_price);
            $stmt->bindParam(':payment_terms', $payment_terms);

            // Execute the query for each item
            $stmt->execute();
        }

        // Return response with calculated VAT and invoice details
        $response = [
            'status' => 'success',
            'message' => 'Data inserted successfully',
            'invoice_number' => $invoiceNumber,
            'customer_name' => $customer_name,
            'total_vat' => $total_vat
        ];

        echo json_encode($response);

    } catch (PDOException $e) {
        logError('Database error: ' . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    }
}
?>
