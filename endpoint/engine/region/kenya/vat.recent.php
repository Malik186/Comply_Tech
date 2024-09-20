<?php
// File: vat.list.php

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

    // Find the most recent invoice number for the user
    $invoiceStmt = $pdo->prepare("SELECT Invoice FROM kenya_vat_results WHERE Username = :username ORDER BY date_generated DESC LIMIT 1");
    $invoiceStmt->bindParam(':username', $username);
    $invoiceStmt->execute();
    $invoice = $invoiceStmt->fetchColumn();

    if ($invoice) {
        // Prepare and execute the SQL query to fetch all products for the most recent invoice
        $stmt = $pdo->prepare("SELECT * FROM kenya_vat_results WHERE Username = :username AND Invoice = :invoice ORDER BY date_generated DESC");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':invoice', $invoice);
        $stmt->execute();

        // Fetch all the results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            // Prepare the response, excluding 'id' and 'Username' fields
            $filteredResults = array_map(function($result) {
                unset($result['id'], $result['Username']); // Remove 'id' and 'Username'
                return $result;
            }, $results);

            $response = [
                'status' => 'success',
                'data' => $filteredResults
            ];
        } else {
            $response = ['status' => 'error', 'message' => 'No VAT records found for the current user.'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'No recent invoice found for the current user.'];
    }

    // Send the response as JSON
    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
