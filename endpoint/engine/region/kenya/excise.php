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

// Excise Duty Calculation Function
function calculateExciseDuty($data) {
    $exciseDuty = 0;

    switch ($data['typeOfProducts']) {
        case 'Alcoholic Beverages':
            switch ($data['additional']['alcoholType']) {
                case 'Spirits':
                    $ratePerLiter = 335;
                    $exciseDuty = $ratePerLiter * $data['additional']['alcoholQuantity'];
                    break;
                case 'Beer':
                case 'Cider':
                case 'Perry':
                case 'Mead':
                case 'Opaque Beer':
                case 'Fermented Beverages':
                    $ratePerLiter = 134;
                    $exciseDuty = max($ratePerLiter * $data['additional']['alcoholQuantity'], 0.15 * $data['retailSellingPrice'] * $data['additional']['alcoholQuantity']);
                    break;
                case 'Wines':
                    $ratePerLiter = 229;
                    $exciseDuty = $ratePerLiter * $data['additional']['alcoholQuantity'];
                    break;
            }
            break;

        case 'Tobacco Products':
            if (isset($data['additional']['tobaccoType'])) {
                switch ($data['additional']['tobaccoType']) {
                    case 'Cigarettes':
                        $exciseDuty = 3825 * ($data['additional']['tobaccoQuantity'] / 1000);
                        break;
                    case 'Cigars':
                        $exciseDuty = 12000 * $data['additional']['tobaccoQuantity'];
                        break;
                    case 'Manufactured Tobacco':
                        $exciseDuty = 8000 * $data['additional']['tobaccoQuantity'];
                        break;
                }
            }
            break;

        case 'Petroleum Products':
            if (isset($data['additional']['petroleumType'])) {
                switch ($data['additional']['petroleumType']) {
                    case 'Petrol':
                        $exciseDuty = 21.95 * $data['additional']['petroleumQuantity'];
                        break;
                    case 'Diesel':
                    case 'Kerosene':
                        $exciseDuty = 11.37 * $data['additional']['petroleumQuantity'];
                        break;
                }
            }
            break;

        case 'Motor Vehicles':
            if (isset($data['additional']['vehicleType'])) {
                switch ($data['additional']['vehicleType']) {
                    case '1500-3000cc':
                        $exciseDuty = $data['cif']['cost'] * 0.20;
                        break;
                    case '3000cc':
                        $exciseDuty = $data['cif']['cost'] * 0.30;
                        break;
                }
            }
            break;

        default:
            break;
    }

    return $exciseDuty;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    if (!isset($data['importerManufacturer'], $data['contactInfo'], $data['typeOfProducts'], $data['typeOfGoods'], $data['cif'], $data['goodsOrigin'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    // Extracting data from the request
    $username = $_SESSION['user']['username'];
    $importerManufacturer = $data['importerManufacturer'];
    $contactInfo = $data['contactInfo'];
    $nameOfGoods = $data['nameOfGoods'];
    $typeOfProducts = $data['typeOfProducts'];
    $typeOfGoods = $data['typeOfGoods'];
    $tobaccotype = $data['additional']['tobaccoType'];
    $tobaccoQuantity = $data['additional']['tobaccoQuantity'];
    $alcoholtype = $data['additional']['alcoholType'];
    $alcoholQuantity = $data['additional']['alcoholQuantity'];
    $petroleumtype = $data['additional']['petroleumType'];
    $petroleumQuantity = $data['additional']['petroleumQuantity'];
    $vehicletype = $data['additional']['vehicleType'];
    $vehicleEngine = $data['additional']['vehicleQuantity'];
    $goodsDescription = $data['goodsDescription'];
    $goodsOrigin = $data['goodsOrigin'];
    
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

    // Calculate Excise Duty based on the goods
    $exciseDuty = calculateExciseDuty($data);

    // Total Customs Duty (Import Duty + VAT + IDF + RDL + Excise Duty)
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

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':importerManufacturer', $importerManufacturer);
        $stmt->bindParam(':contactInfo', $contactInfo);
        $stmt->bindParam(':typeOfGoods', $typeOfProducts);
        $stmt->bindParam(':goodsDescription', $goodsDescription);
        $stmt->bindParam(':cif_cost', $cost);
        $stmt->bindParam(':cif_insurance', $insurance);
        $stmt->bindParam(':cif_freight', $freight);
        $stmt->bindParam(':Custom_Duty', $importDuty);
        $stmt->bindParam(':Excise_Duty', $exciseDuty);
        $stmt->bindParam(':VAT', $vat);
        $stmt->bindParam(':IDF', $idf);
        $stmt->bindParam(':RDL', $rdl);
        $stmt->bindParam(':goodsOrigin', $goodsOrigin);
        $stmt->bindParam(':alcoholType', $alcoholtype);
        $stmt->bindParam(':alcoholQuantity', $alcoholQuantity);
        $stmt->bindParam(':tobaccoType', $tobaccotype);
        $stmt->bindParam(':tobaccoQuantity', $tobaccoQuantity);
        $stmt->bindParam(':petroleumType', $petroleumtype);
        $stmt->bindParam(':petroleumQuantity', $petroleumQuantity);
        $stmt->bindParam(':vehicleType', $vehicletype);
        $stmt->bindParam(':vehicleQuantity', $vehicleEngine);

        // Execute the query
        $stmt->execute();

        // Return response with calculated Custom Duty
        echo json_encode([
            'status' => 'success', 
            'Custom_Duty' => $totalCustomDuty
        ]);

    } catch (PDOException $e) {
        logError("Database connection failed: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Failed to connect to the database']);
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
            logError("Excise calculation failed: " . $e->getMessage());
        }
        
        // Determine Payroll and Invoice fields based on input
        $payroll = isset($net_salary) ? 1 : 0;
        $invoice = isset($vat) ? 1 : 0;
        
        // Insert data into tax_overview table
        insertTaxOverview($pdo, $username, "Kenya Excise", $status, $activity, $payroll, $invoice, $report);

} else {
    // Invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
