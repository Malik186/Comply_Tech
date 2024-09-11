<?php
// File: custom.php

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

// Function to calculate the Import Duty based on the type of goods
function calculateImportDuty($typeOfGoods, $cif) {
    switch ($typeOfGoods) {
        case 'Capital Goods and Raw Materials':
            return 0;
        case 'Intermediate Goods':
            return $cif * 0.10;
        case 'Finished Goods':
            return $cif * 0.25;
        case 'Sensitive Items':
            return $cif * 0.25; // Assuming same rate as Finished Goods for Sensitive Items
        default:
            return 0;
    }
}

// Function to calculate VAT
function calculateVAT($dutiableValue, $vatRate = 0.16) {
    return $dutiableValue * $vatRate;
}

// Function to calculate IDF and RDL
function calculateIDF($cif, $idfRate = 0.035) {
    return $cif * $idfRate;
}

function calculateRDL($cif, $rdlRate = 0.02) {
    return $cif * $rdlRate;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Ensure required fields are present
    if (!isset($data['name'], $data['nameOfGoods'], $data['typeOfGoods'], $data['cif'], $data['cost'], $data['insurance'], $data['freight']) || empty($data['typeOfGoods'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    // Assigning received data to variables
    $username = $_SESSION['user']['username'];
    $name = $data['name'];
    $nameOfGoods = $data['nameOfGoods'];
    $typeOfGoods = $data['typeOfGoods'];
    $cif = $data['cif'];
    $cost = $data['cost'];
    $insurance = $data['insurance'];
    $freight = $data['freight'];
    
    // Calculate Import Duty
    $importDuty = calculateImportDuty($typeOfGoods, $cif);
    
    // Calculate Dutiable Value
    $dutiableValue = $cif + $importDuty;

    // Calculate VAT
    $vat = calculateVAT($dutiableValue);

    // Calculate IDF and RDL
    $idf = calculateIDF($cif);
    $rdl = calculateRDL($cif);

    // Total Customs Duty
    $customDuty = $importDuty + $vat + $idf + $rdl;

    // Database connection details
    $host = 'localhost';
    $dbName = 'mdskenya_comply_tech';
    $usernameDb = 'mdskenya_malik186';
    $passwordDb = 'Malik@Ndoli186';

    try {
        // Connect to the MySQL database
        $pdo = new PDO("mysql:host=$host;dbname=$dbName", $usernameDb, $passwordDb);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL to insert data into kenya_custom_results table
        $stmt = $pdo->prepare("
            INSERT INTO kenya_custom_results (
                username, 
                name, 
                nameOfGoods, 
                typeOfGoods, 
                cif, 
                cost, 
                insurance, 
                freight, 
                customDuty
            ) VALUES (
                :username, 
                :name, 
                :nameOfGoods, 
                :typeOfGoods, 
                :cif, 
                :cost, 
                :insurance, 
                :freight, 
                :customDuty
            )
        ");

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':nameOfGoods', $nameOfGoods);
        $stmt->bindParam(':typeOfGoods', $typeOfGoods);
        $stmt->bindParam(':cif', $cif);
        $stmt->bindParam(':cost', $cost);
        $stmt->bindParam(':insurance', $insurance);
        $stmt->bindParam(':freight', $freight);
        $stmt->bindParam(':customDuty', $customDuty);

        // Execute the query
        $stmt->execute();

        // Return response with calculated Custom Duty
        $response = [
            'status' => 'success',
            'message' => 'Custom Duty calculated and data inserted successfully',
            'custom_duty' => $customDuty
        ];

        echo json_encode($response);

    } catch (PDOException $e) {
        logError('Database error: ' . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    }
}
?>
