<?php
// File: paye.list.php

session_start();

// Allow CORS from the front-end domain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection settings
$host = 'localhost'; // Usually 'localhost' or an IP address
$dbName = 'mdskenya_comply_tech'; // The name of the database
$username = 'mdskenya_malik186'; // Your MySQL username
$password = 'Malik@Ndoli186'; // Your MySQL password

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the username from the active session
    if (!isset($_SESSION['user']['username'])) {
        echo json_encode(['status' => 'error', 'message' => 'No active user session found.']);
        exit;
    }
    $username = $_SESSION['user']['username'];

    // Prepare and execute the SQL query to fetch all records for the user
    $stmt = $pdo->prepare("SELECT * FROM kenya_vat_results WHERE Username = :username ORDER BY date_generated DESC");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        // Prepare the response with all records
        $data = [];
        foreach ($results as $result) {
            $data[] = [
               'invoice' => $result['Invoice'],
                'date_generated' => $result['date_generated'],
                'due_date' => $result['due_date'],
                'customer_name' => $result['customer_name'],
                'customer_address' => $result['customer_address'],
                'item_description' => $result['item_description'],
                'quantity' => (int)$result['quantity'],
                'unit_price' => (float)$result['unit_price'],
                'vat' => (float)$result['vat'],
                'total_vat' => (float)$result['total_vat'],
                'payment_terms' => $result['payment_terms']
            ];
        }

        $response = [
            'status' => 'success',
            'data' => $data
        ];
    } else {
        $response = ['status' => 'error', 'message' => 'No records found for the current user.'];
    }

    // Send the response as JSON
    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
