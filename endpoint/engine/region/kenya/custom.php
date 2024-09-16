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
            return 0;  // 0% duty
        case 'Intermediate Goods':
            return $cif * 0.10; // 10% duty
        case 'Finished Goods':
            return $cif * 0.25; // 25% duty
        default:
            return 0;
    }
}

// Function to calculate VAT (16% of Dutiable Value)
function calculateVAT($dutiableValue, $vatRate = 0.16) {
    return $dutiableValue * $vatRate;
}

// Function to calculate IDF (3.5% of CIF)
function calculateIDF($cif, $idfRate = 0.035) {
    return $cif * $idfRate;
}

// Function to calculate RDL (2% of CIF)
function calculateRDL($cif, $rdlRate = 0.02) {
    return $cif * $rdlRate;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Ensure required fields are present
    if (!isset($data['nameOfGoods'], $data['typeOfGoods'], $data['cif']) || empty($data['typeOfGoods'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    // Extracting data from the request
    $username = $_SESSION['user']['username'];
    $nameOfGoods = $data['nameOfGoods'];
    $typeOfGoods = $data['typeOfGoods'];
    
    // Extract CIF details
    $cif = $data['cif'];
    $cost = $cif['cost'] ?? 0;       // Assign 0 if not set
    $insurance = $cif['insurance'] ?? 0;
    $freight = $cif['freight'] ?? 0;

    // Calculate the total CIF
    $totalCIF = $cost + $insurance + $freight;

    // Calculate Import Duty
    $importDuty = calculateImportDuty($typeOfGoods, $totalCIF);
    
    // Calculate Dutiable Value (CIF + Import Duty)
    $dutiableValue = $totalCIF + $importDuty;

    // Calculate VAT on the Dutiable Value
    $vat = calculateVAT($dutiableValue);

    // Calculate IDF and RDL based on CIF
    $idf = calculateIDF($totalCIF);
    $rdl = calculateRDL($totalCIF);

    // Total Customs Duty (Import Duty + VAT + IDF + RDL)
    $totalCustomDuty = $importDuty + $vat + $idf + $rdl;

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
                nameOfGoods, 
                typeOfGoods, 
                cif, 
                cost, 
                insurance, 
                freight, 
                Custom_Duty
            ) VALUES (
               :username, 
                :nameOfGoods, 
                :typeOfGoods, 
                :cif, 
                :cost, 
                :insurance, 
                :freight, 
                :Custom_Duty
            )
        ");

        // Bind parameters
         $stmt->bindParam(':username', $username);
        $stmt->bindParam(':nameOfGoods', $nameOfGoods);
        $stmt->bindParam(':typeOfGoods', $typeOfGoods);
        $stmt->bindParam(':cif', $totalCIF);
        $stmt->bindParam(':cost', $cost);
        $stmt->bindParam(':insurance', $insurance);
        $stmt->bindParam(':freight', $freight);
        $stmt->bindParam(':Custom_Duty', $totalCustomDuty);

        // Execute the query
        $stmt->execute();

        // Return response with calculated Custom Duty
        $response = [
            'status' => 'success',
            'message' => 'Custom Duty calculated and data inserted successfully',
            'custom_duty' => $totalCustomDuty
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
            logError("Custom calculation failed: " . $e->getMessage());
        }
        
        // Determine Payroll and Invoice fields based on input
        $payroll = isset($net_salary) ? 1 : 0;
        $invoice = isset($vat) ? 1 : 0;
        
        // Insert data into tax_overview table
        insertTaxOverview($pdo, $username, "Kenya Custom", $status, $activity, $payroll, $invoice, $report);
}
?>
