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
    // Connect to the MySQL database
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

    // Prepare and execute the SQL query to fetch data
    $stmt = $pdo->prepare("SELECT * FROM kenya_excise_results WHERE username = :username ORDER BY timestamp DESC LIMIT 1");
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
                'importerManufacturer' => $result['importerManufacturer'],
                'contactInfo' => $result['contactInfo'],
                'typeOfGoods' => $result['typeOfGoods'],
                'goodsDescription' => $result['goodsDescription'],
                'cif_cost' => (float)$result['cif_cost'],
                'cif_insurance' => (float)$result['cif_insurance'],
                'cif_freight' => (float)$result['cif_freight'],
                'Custom_Duty' => (float)$result['Custom_Duty'],
                'Excise_Duty' => (float)$result['Excise_Duty'],
                'VAT' => (float)$result['VAT'],
                'IDF' => (float)$result['IDF'],
                'RDL' => (float)$result['RDL'],
                'goodsOrigin' => $result['goodsOrigin'],
                'alcoholType' => $result['alcoholType'],
                'alcoholQuantity' => (float)$result['alcoholQuantity'],
                'tobaccoType' => $result['tobaccoType'],
                'tobaccoQuantity' => (float)$result['tobaccoQuantity'],
                'petroleumType' => $result['petroleumType'],
                'petroleumQuantity' => (float)$result['petroleumQuantity'],
                'vehicleType' => $result['vehicleType'],
                'vehicleEngine' => (float)$result['vehicleQuantity']
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
