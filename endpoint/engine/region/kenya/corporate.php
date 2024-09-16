<?php
// File: corporate.php

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

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input data as JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    if (!isset($data['companyName'], $data['yearsOfOperation'], $data['typeOfCompany'], $data['yearlyProfit'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    // Extract data from the request
    $companyName = $data['companyName'];
    $yearsOfOperation = intval($data['yearsOfOperation']);
    $typeOfCompany = $data['typeOfCompany'];
    $yearlyProfit = floatval($data['yearlyProfit']);
    $specialRatesType = $data['specialRatesType'] ?? null; // only relevant for special rates companies

    // Function to calculate corporate tax
    function calculateCorporateTax($typeOfCompany, $yearsOfOperation, $yearlyProfit, $specialRatesType = null) {
        $taxRate = 0;

        switch ($typeOfCompany) {
            case 'Resident Company':
            case 'Non-Resident Company':
                // Standard tax rate for resident and non-resident companies is 30%
                $taxRate = 0.30;
                break;

            case 'Special Rates':
                // Special rates depending on the company type and years of operation
                switch ($specialRatesType) {
                    case 'EPZ Enterprises':
                        if ($yearsOfOperation <= 10) {
                            $taxRate = 0.00; // 0% for first 10 years
                        } elseif ($yearsOfOperation <= 20) {
                            $taxRate = 0.25; // 25% for the next 10 years
                        } else {
                            $taxRate = 0.30; // 30% thereafter
                        }
                        break;

                    case 'SEZ Enterprises':
                        if ($yearsOfOperation <= 10) {
                            $taxRate = 0.10; // 10% for first 10 years
                        } else {
                            $taxRate = 0.15; // 15% for the next 10 years
                        }
                        break;

                    case 'SEZ Developers':
                        if ($yearsOfOperation <= 10) {
                            $taxRate = 0.10; // 10% for first 10 years
                        } else {
                            $taxRate = 0.15; // 15% for the next 10 years
                        }
                        break;

                    case 'Listed Companies':
                        if ($yearsOfOperation <= 5) {
                            $taxRate = 0.25; // 25% for first 5 years
                        } else {
                            $taxRate = 0.30; // standard 30% rate after 5 years
                        }
                        break;

                    case 'Vehicle Assembly':
                        $taxRate = 0.15; // 15% for first 5 years, extends based on conditions
                        break;

                    default:
                        return ['status' => 'error', 'message' => 'Invalid Special Rates type'];
                }
                break;

            case 'Turnover Tax':
                // Turnover tax is applied at 3%
                $taxRate = 0.03;
                break;

            case 'Repatriated Income':
                // Repatriated income is taxed at 15%
                $taxRate = 0.15;
                break;

            default:
                return ['status' => 'error', 'message' => 'Invalid Company Type'];
        }

        // Calculate the tax
        $corporateTax = $yearlyProfit * $taxRate;
        return [
            'status' => 'success',
            'taxRate' => $taxRate * 100 . '%',
            'corporateTax' => $corporateTax,
        ];
    }

    // Call the function to calculate the tax
    $result = calculateCorporateTax($typeOfCompany, $yearsOfOperation, $yearlyProfit, $specialRatesType);

    // Extract the corporateTax value from the result array
    $corporateTax = $result['corporateTax'];

    // Calculate net profit
    $netprofit = $yearlyProfit - $corporateTax;

    // Database connection details
    $host = 'localhost';
    $dbName = 'mdskenya_comply_tech';
    $username = 'mdskenya_malik186';
    $password = 'Malik@Ndoli186';
    
    try {
        // Connect to the MySQL database
        $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the session username is set
        if (!isset($_SESSION['user']['username'])) {
            echo json_encode(['error' => 'No active session or user not logged in']);
            exit;
        }

        $user = $_SESSION['user']['username'];
        
        // Prepare SQL to insert data into kenya_corporate_results table
        $stmt = $pdo->prepare("
            INSERT INTO kenya_corporate_results (
                Username, 
                companyName,
                yearsOfOperation,
                typeOfCompany,
                yearlyProfit,
                specialRatesType,
                corporate_tax,
                net_profit
            ) VALUES (
                :Username,
                :companyName,
                :yearsOfOperation,
                :typeOfCompany,
                :yearlyProfit,
                :specialRatesType,
                :corporate_tax,
                :net_profit
            )
        ");
        
        // Bind parameters
        $stmt->bindParam(':Username', $user);
        $stmt->bindParam(':companyName', $companyName);
        $stmt->bindParam(':yearsOfOperation', $yearsOfOperation);
        $stmt->bindParam(':typeOfCompany', $typeOfCompany);
        $stmt->bindParam(':yearlyProfit', $yearlyProfit);
        $stmt->bindParam(':specialRatesType', $specialRatesType);
        $stmt->bindParam(':corporate_tax', $corporateTax);
        $stmt->bindParam(':net_profit', $netprofit);
        
        // Execute the statement
        $stmt->execute();
        
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        logError($e->getMessage());
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }

    // Return the result as a JSON response
    echo json_encode($result);
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
            logError("Corporate calculation failed: " . $e->getMessage());
        }
        
        // Determine Payroll and Invoice fields based on input
        $payroll = isset($net_salary) ? 1 : 0;
        $invoice = isset($vat) ? 1 : 0;
        
        // Insert data into tax_overview table
        insertTaxOverview($pdo, $user, "Kenya Corporate", $status, $activity, $payroll, $invoice, $report);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
