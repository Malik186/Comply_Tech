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

// Load the database configuration
$config = include '/home/mdskenya/config/comply_tech/config.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_username'],
        $config['db_password']
    );
    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the username from the active session
    if (!isset($_SESSION['user']['username'])) {
        echo json_encode(['status' => 'error', 'message' => 'No active user session found.']);
        exit;
    }
    $username = $_SESSION['user']['username'];

    // Prepare and execute the SQL query to fetch all records for the user
    $stmt = $pdo->prepare("SELECT * FROM kenya_corporate_results WHERE Username = :username ORDER BY timestamp DESC");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        // Prepare the response with all records
        $data = [];
        foreach ($results as $result) {
            $data[] = [
               'timestamp' => $result['timestamp'],
                'companyName' => $result['companyName'],
                'yearsOfOperation' => $result['yearsOfOperation'],
                'typeOfCompany' => $result['typeOfCompany'],
                'yearlyProfit' => $result['yearlyProfit'],
                'specialRatesType' => $result['specialRatesType'],
                'corporate_tax' => $result['corporate_tax'],
                'net_profit' => $result['net_profit']
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
