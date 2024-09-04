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

    // Prepare and execute the SQL query to fetch data
    $stmt = $pdo->prepare("SELECT * FROM kenya_paye_results WHERE Username = :username ORDER BY timestamp DESC LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Prepare the response in the specified format
        $response = [
            'status' => 'success',
            'data' => [
                'timestamp' => $result['timestamp'],
                'gross_salary' => (float)$result['gross_salary'],
                'paye' => (float)$result['paye'],
                'housing_levy' => (float)$result['housing_levy'],
                'nhif' => (float)$result['nhif'],
                'nssf' => (float)$result['nssf'],
                'mortgage_interest' => (float)$result['mortgage_interest'],
                'insurance_premium' => (float)$result['insurance_premium'],
                'savings_deposit' => (float)$result['savings_deposit'],
                'deductions' => (float)$result['deductions'],
                'total_deductions' => (float)$result['total_deductions'],
                'net_salary' => (float)$result['net_salary']
            ]
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
