<?php
// File: kenya.php

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

function calculateNHIF($gross_salary) {
    $nhif_rates = [
        [0, 5999, 150],
        [6000, 7999, 300],
        [8000, 11999, 400],
        [12000, 14999, 500],
        [15000, 19999, 600],
        [20000, 24999, 750],
        [25000, 29999, 850],
        [30000, 34999, 900],
        [35000, 39999, 950],
        [40000, 44999, 1000],
        [45000, 49999, 1100],
        [50000, 59999, 1200],
        [60000, 69999, 1300],
        [70000, 79999, 1400],
        [80000, 89999, 1500],
        [90000, 99999, 1600],
        [100000, PHP_INT_MAX, 1700],
    ];
    
    foreach ($nhif_rates as $rate) {
        if ($gross_salary >= $rate[0] && $gross_salary <= $rate[1]) {
            return $rate[2];
        }
    }
    return 0; 
}

function calculatePAYE($taxable_income) {
    $paye_bands = [
        [0, 288000, 0.10],
        [288001, 388000, 0.25],
        [388001, PHP_INT_MAX, 0.30]
    ];

    $paye = 0;
    $remaining_income = $taxable_income;
    
    foreach ($paye_bands as $band) {
        if ($remaining_income > 0) {
            $taxable_in_band = min($remaining_income, $band[1] - $band[0] + 1);
            $paye += $taxable_in_band * $band[2];
            $remaining_income -= $taxable_in_band;
        } else {
            break;
        }
    }
    
    // Apply personal relief
    $personal_relief = 2400 * 12;  // 2400 per month
    $paye = max(0, $paye - $personal_relief);
    
    return $paye;
}

function calculateNSSF($gross_salary) {
    $nssf_rate = 0.06;  // 6%
    $nssf_cap = 1080;   // Maximum NSSF contribution
    return min($gross_salary * $nssf_rate, $nssf_cap);
}

function calculateDeductions($data, $gross_salary) {
    $deductions = [];
    
    if (isset($data['mortgage_interest'])) {
        $deductions['mortgage_interest'] = $data['mortgage_interest'];
    }
    
    if (isset($data['insurance_premium'])) {
        $deductions['insurance_premium'] = $data['insurance_premium'];
    }
    
    if (isset($data['savings_deposit'])) {
        $deductions['savings_deposit'] = $data['savings_deposit'];
    }
    
    $deductions['affordable_housing_levy'] = $gross_salary * 0.015;
    $deductions['nssf'] = calculateNSSF($gross_salary);
    $deductions['nhif'] = calculateNHIF($gross_salary);

    if (isset($data['other_deductions'])) {
        $deductions['other_deductions'] = $data['other_deductions'];
    }
    
    return $deductions;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['gross_salary']) || !isset($data['calculation_period'])) {
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }
    
    $gross_salary = $data['gross_salary'];
    $deductions = calculateDeductions($data, $gross_salary);
    
    // Calculate taxable income
    $taxable_income = $gross_salary - $deductions['nssf'];
    
    $paye = calculatePAYE($taxable_income * 12) / 12;  // Calculate annual PAYE and convert back to monthly
    $total_deductions = array_sum($deductions);
    $net_salary = $gross_salary - $paye - $total_deductions;

    if ($data['calculation_period'] === 'yearly') {
        $gross_salary *= 12;
        $paye *= 12;
        $total_deductions *= 12;
        $net_salary *= 12;
    }
    
    $response = [
        'gross_salary' => $gross_salary,
        'paye' => $paye,
        'deductions' => $deductions,
        'total_deductions' => $total_deductions,
        'net_salary' => $net_salary
    ];
    
    // Load the database configuration
    $config = include '/home/mdskenya/config/comply_tech/config.php';
    
    try {
        // Connect to the MySQL database
        $pdo = new PDO(
            "mysql:host={$config['db_host']};dbname={$config['db_name']}",
            $config['db_username'],
            $config['db_password']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check if the session username is set
        if (!isset($_SESSION['user']['username'])) {
            echo json_encode(['error' => 'No active session or user not logged in']);
            exit;
        }

        $user = $_SESSION['user']['username'];
        
        // Prepare SQL to insert data into kenya_paye_results table
                $stmt = $pdo->prepare("
            INSERT INTO kenya_paye_results (
                Username, 
                gross_salary, 
                paye, 
                housing_levy, 
                nhif, 
                nssf, 
                mortgage_interest, 
                insurance_premium, 
                savings_deposit, 
                deductions, 
                total_deductions, 
                net_salary
            ) VALUES (
                :Username, 
                :gross_salary, 
                :paye, 
                :housing_levy, 
                :nhif, 
                :nssf, 
                :mortgage_interest, 
                :insurance_premium, 
                :savings_deposit, 
                :deductions, 
                :total_deductions, 
                :net_salary
            )
            ");
        
        // Bind parameters
        $stmt->bindParam(':Username', $user);
        $stmt->bindParam(':gross_salary', $gross_salary);
        $stmt->bindParam(':paye', $paye);
        $stmt->bindParam(':housing_levy', $deductions['affordable_housing_levy']);
        $stmt->bindParam(':nhif', $deductions['nhif']);
        $stmt->bindParam(':nssf', $deductions['nssf']);
        $stmt->bindParam(':mortgage_interest', $deductions['mortgage_interest']);
        $stmt->bindParam(':insurance_premium', $deductions['insurance_premium']);
        $stmt->bindParam(':savings_deposit', $deductions['savings_deposit']);
        $stmt->bindParam(':deductions', $data['other_deductions']);
        $stmt->bindParam(':total_deductions', $total_deductions);
        $stmt->bindParam(':net_salary', $net_salary);
        
        $stmt->execute();
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
        logError("PAYE calculation failed: " . $e->getMessage());
    }
    
    // Determine Payroll and Invoice fields based on input
    $payroll = isset($data['payroll_calculated']) ? 1 : 0;
    $invoice = isset($data['invoice_calculated']) ? 1 : 0;
    
    // Insert data into tax_overview table
    insertTaxOverview($pdo, $user, "Kenya PAYE", $status, $activity, $payroll, $invoice, $report);
}
?>