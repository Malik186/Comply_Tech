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

// Function to calculate VAT (default rate: 20%)
function calculateVAT($unit_price, $quantity, $vat_rate = 0.2) {
    $total_price = $unit_price * $quantity;
    $vat_amount = $total_price * $vat_rate;
    return $vat_amount;
}

// Function to generate a unique invoice number
function generateUniqueInvoiceNumber($pdo) {
    do {
        $invoiceNumber = 'INV-' . rand(1000, 9999) . '-' . time();
        // Check if invoice number already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM morocco_vat_results WHERE Invoice = :Invoice");
        $stmt->bindParam(':Invoice', $invoiceNumber);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    } while ($count > 0); // Repeat if invoice number is not unique

    return $invoiceNumber;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Ensure required fields are present
    if (!isset($data['customer_name'], $data['customer_address'], $data['customer_email'], $data['customer_number'], $data['items']) || empty($data['items'])) {
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    // Assigning received data to variables
    $customer_name = $data['customer_name'];
    $customer_address = $data['customer_address'] ?? 'No address provided';
    $customer_email = $data['customer_email'];
    $customer_number = $data['customer_number'];
    $payment_terms = $data['payment_terms'] ?? 'None';
    $due_date = $data['due_date'] ?? date('Y-m-d', strtotime('+30 days'));
    $bank_name = $data['bank_name'];
    $acc_no = $data['acc_no'];

    // Load the database configuration
    $config = include '/home/mdskenya/config/comply_tech/config.php';
    try {
        // Connect to the MySQL database
        $pdo = new PDO(
            "mysql:host={$config['db_host']};dbname={$config['db_name']}",
            $config['db_username'],
            $config['db_password']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the session username is set
        if (!isset($_SESSION['user']['username'])) {
            echo json_encode(['error' => 'No active session or user not logged in']);
            exit;
        }

        $user = $_SESSION['user']['username'];

        // Generate a unique invoice number
        $invoiceNumber = generateUniqueInvoiceNumber($pdo);

        // Prepare SQL to insert data into morocco_vat_results table
        $stmt = $pdo->prepare("
            INSERT INTO morocco_vat_results (
                Username, 
                Invoice, 
                date_generated, 
                due_date, 
                customer_name, 
                customer_address,
                email_address,
                phone_number, 
                item_description, 
                quantity, 
                unit_price, 
                vat,
                total_vat,
                payment_terms,
                account_no,
                bank
            ) VALUES (
                :Username, 
                :Invoice, 
                NOW(), 
                DATE_ADD(NOW(), INTERVAL 30 DAY), 
                :customer_name, 
                :customer_address,
                :email_address,
                :phone_number, 
                :item_description, 
                :quantity, 
                :unit_price, 
                :vat,
                :total_vat,
                :payment_terms,
                :account_no,
                :bank
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
            $stmt->bindParam(':customer_name', $customer_name);
            $stmt->bindParam(':customer_address', $customer_address);
            $stmt->bindParam(':email_address', $customer_email);
            $stmt->bindParam(':phone_number', $customer_number);
            $stmt->bindParam(':item_description', $item_description);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':unit_price', $unit_price);
            $stmt->bindParam(':vat', $vat);
            $stmt->bindParam(':total_vat', $total_vat);
            $stmt->bindParam(':payment_terms', $payment_terms);
            $stmt->bindParam(':account_no', $acc_no);
            $stmt->bindParam(':bank', $bank_name);

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
    // Function to insert results into the tax_overview table
    function insertTaxOverview($pdo, $username, $tax_type, $status, $activity, $payroll, $invoice, $report) {
        $sql = "INSERT INTO tax_overview (Username, Tax_Type, Status, Activity, Payroll, Invoice, Report) 
                VALUES (:Username, :Tax_Type, :Status, :Activity, :Payroll, :Invoice, :Report)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':Username' => $username,
            ':Tax_Type' => $tax_type,
            ':Status' => $status,
            ':Activity' => $activity,
            ':Payroll' => $payroll,
            ':Invoice' => $invoice,
            ':Report' => $report
        ]);
        }
        // Try PAYE calculation
        try {
            $status = 1;  // Calculation success
            $activity = 1;  // Calculation successful
            $report = 1;    // Report is generated by default on success
        } catch (Exception $e) {
            $status = 0;  // Calculation failed
            $activity = 0;  // Activity failed
            $report = 0;    // Report not generated
            logError("VAT calculation failed: " . $e->getMessage());
        }
        
        // Determine Payroll and Invoice fields based on input
        $payroll = isset($data['payroll_calculated']) ? 1 : 0;
        $invoice = isset($vat) ? 1 : 0;
        
        // Insert data into tax_overview table
        insertTaxOverview($pdo, $user, "Morocco VAT", $status, $activity, $payroll, $invoice, $report);
}
?>
