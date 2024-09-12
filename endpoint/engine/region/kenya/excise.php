<?php
// File: excise.php

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

// Function to calculate excise duty for different goods
function calculateExciseDuty($data) {
    $exciseDuty = 0;

    switch ($data['typeOfGoods']) {
        case 'Alcoholic Beverages':
            if ($data['additional']['alcoholType'] === 'Spirits') {
                $ratePerLiter = 335;
                $exciseDuty = $ratePerLiter * $data['additional']['alcoholQuantity'];
            } elseif ($data['additional']['alcoholType'] === 'Beer') {
                $ratePerLiter = max(134, 0.15 * $data['retailSellingPrice']);
                $exciseDuty = $ratePerLiter * $data['additional']['alcoholQuantity'];
            }
            break;
        case 'Tobacco Products':
            if ($data['additional']['tobaccoType'] === 'Cigarettes') {
                $exciseDuty = 3825 * ($data['additional']['tobaccoQuantity'] / 1000); // Per mille
            }
            break;
        case 'Petroleum Products':
            if ($data['additional']['petroleumType'] === 'Petrol') {
                $exciseDuty = 21.95 * $data['additional']['petroleumQuantity'];
            }
            break;
        case 'Motor Vehicles':
            if ($data['additional']['vehicleType'] === 'Vehicle') {
                $exciseDuty = ($data['cif']['cost'] > 1500 && $data['cif']['cost'] <= 3000) ? 
                              $data['cif']['cost'] * 0.20 : 
                              $data['cif']['cost'] * 0.30;
            }
            break;
        default:
            break;
    }

    return $exciseDuty;
}

// Database connection details
$host = 'localhost';
$dbName = 'mdskenya_comply_tech';
$usernameDb = 'mdskenya_malik186';
$passwordDb = 'Malik@Ndoli186';

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $usernameDb, $passwordDb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (!isset($data['importerManufacturer'], $data['contactInfo'], $data['typeOfGoods'], $data['cif'], $data['goodsOrigin'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
            exit;
        }

        // Extracting data from the request
        $username = $_SESSION['user']['username'];
        $importerManufacturer = $data['importerManufacturer'];
        $contactInfo = $data['contactInfo'];
        $typeOfGoods = $data['typeOfGoods'];
        $goodsDescription = $data['goodsDescription'];
        $goodsOrigin = $data['goodsOrigin'];

        // Extract CIF details
        $cost = $data['cif']['cost'] ?? 0;
        $insurance = $data['cif']['insurance'] ?? 0;
        $freight = $data['cif']['freight'] ?? 0;
        $totalCIF = $cost + $insurance + $freight;

        // Calculate Excise Duty
        $exciseDuty = calculateExciseDuty($data);

        // Calculate VAT (16% of the dutiable value)
        $vat = ($totalCIF + $exciseDuty) * 0.16;

        // Additional charges (IDF, RDL) based on CIF
        $idf = $totalCIF * 0.035;
        $rdl = $totalCIF * 0.02;

        // Calculate total custom duty if applicable
        $customDuty = ($goodsOrigin === 'Imported Goods') ? calculateImportDuty($typeOfGoods, $totalCIF) : 0;

        // Prepare SQL to insert data into kenya_excise_results table
        $stmt = $pdo->prepare("
            INSERT INTO kenya_excise_results (
                username, 
                importerManufacturer, 
                contactInfo, 
                typeOfGoods, 
                goodsDescription, 
                cif_cost, 
                cif_insurance, 
                cif_freight, 
                Custom_Duty, 
                Excise_Duty, 
                VAT, 
                IDF, 
                RDL, 
                goodsOrigin, 
                alcoholType, 
                alcoholQuantity, 
                tobaccoType, 
                tobaccoQuantity, 
                petroleumType, 
                petroleumQuantity, 
                vehicleType, 
                vehicleQuantity
            ) VALUES (
                :username, 
                :importerManufacturer, 
                :contactInfo, 
                :typeOfGoods, 
                :goodsDescription, 
                :cif_cost, 
                :cif_insurance, 
                :cif_freight, 
                :Custom_Duty, 
                :Excise_Duty, 
                :VAT, 
                :IDF, 
                :RDL, 
                :goodsOrigin, 
                :alcoholType, 
                :alcoholQuantity, 
                :tobaccoType, 
                :tobaccoQuantity, 
                :petroleumType, 
                :petroleumQuantity, 
                :vehicleType, 
                :vehicleQuantity
            )
        ");

        // Bind parameters to the query
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':importerManufacturer', $importerManufacturer);
        $stmt->bindParam(':contactInfo', $contactInfo);
        $stmt->bindParam(':typeOfGoods', $typeOfGoods);
        $stmt->bindParam(':goodsDescription', $goodsDescription);
        $stmt->bindParam(':cif_cost', $cost);
        $stmt->bindParam(':cif_insurance', $insurance);
        $stmt->bindParam(':cif_freight', $freight);
        $stmt->bindParam(':Custom_Duty', $customDuty);
        $stmt->bindParam(':Excise_Duty', $exciseDuty);
        $stmt->bindParam(':VAT', $vat);
        $stmt->bindParam(':IDF', $idf);
        $stmt->bindParam(':RDL', $rdl);
        $stmt->bindParam(':goodsOrigin', $goodsOrigin);
        $stmt->bindParam(':alcoholType', $data['additional']['alcoholType'] ?? null);
        $stmt->bindParam(':alcoholQuantity', $data['additional']['alcoholQuantity'] ?? null);
        $stmt->bindParam(':tobaccoType', $data['additional']['tobaccoType'] ?? null);
        $stmt->bindParam(':tobaccoQuantity', $data['additional']['tobaccoQuantity'] ?? null);
        $stmt->bindParam(':petroleumType', $data['additional']['petroleumType'] ?? null);
        $stmt->bindParam(':petroleumQuantity', $data['additional']['petroleumQuantity'] ?? null);
        $stmt->bindParam(':vehicleType', $data['additional']['vehicleType'] ?? null);
        $stmt->bindParam(':vehicleQuantity', $data['additional']['vehicleQuantity'] ?? null);

        // Execute the query
        $stmt->execute();

        // Return success response
        echo json_encode([
            'status' => 'success',
            'message' => 'Excise duty calculated and data inserted successfully',
            'excise_duty' => $exciseDuty
        ]);
    }
} catch (PDOException $e) {
    logError('Database error: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
}
?>
