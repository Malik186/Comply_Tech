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
    $stmt = $pdo->prepare("SELECT * FROM kenya_excise_results WHERE username = :username ORDER BY timestamp DESC");
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
