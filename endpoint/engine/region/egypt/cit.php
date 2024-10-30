<?php
// Start session
session_start();

// Set headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://complytech.mdskenya.co.ke');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Include database configuration
$config = include '/home/mdskenya/config/comply_tech/config.php';

// Validate request origin
function validateOrigin() {
    if (!isset($_SERVER['HTTP_ORIGIN']) || $_SERVER['HTTP_ORIGIN'] !== 'https://complytech.mdskenya.co.ke') {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized origin']);
        exit;
    }
}

// Validate session and get username
function validateSession() {
    if (!isset($_SESSION['user']['username'])) {
        http_response_code(401);
        echo json_encode(['error' => 'No active session or user not logged in']);
        exit;
    }
    return $_SESSION['user']['username'];
}

// Database connection function
function getDbConnection($config) {
    try {
        $conn = new PDO(
            "mysql:host={$config['db_host']};dbname={$config['db_name']}",
            $config['db_username'],
            $config['db_password']
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database connection failed']);
        exit;
    }
}

// Calculate tax function
function calculateEgyptianCIT($data) {
    $taxRate = 0;
    
    // Determine tax rate based on company type
    switch ($data['companyType']) {
        case 'standard':
            $taxRate = 22.5;
            break;
        case 'suez':
            $taxRate = 15;
            break;
        case 'petroleum':
            $taxRate = 40.55;
            break;
        case 'bank':
            $taxRate = 25;
            break;
        case 'microfinance':
            $taxRate = 20;
            break;
        default:
            $taxRate = 22.5;
    }

    // Calculate total deductions
    $totalDeductions = $data['deductibleExpenses'] +
                      $data['depreciation'] +
                      $data['investmentIncentives'] +
                      $data['exportIncentives'] +
                      $data['donations'] +
                      $data['carryForwardLosses'];

    // Calculate taxable income
    $taxableIncome = $data['totalIncome'] - $totalDeductions;
    if ($taxableIncome < 0) $taxableIncome = 0;

    // Calculate tax due
    $taxDue = ($taxableIncome * $taxRate) / 100;

    // Apply foreign tax credits if available
    $taxDue = max(0, $taxDue - $data['foreignTaxCredit']);

    // Calculate effective tax rate
    $effectiveRate = $data['totalIncome'] > 0 ? ($taxDue / $data['totalIncome']) * 100 : 0;

    return [
        'taxableIncome' => $taxableIncome,
        'taxRate' => $taxRate,
        'taxDue' => $taxDue,
        'effectiveRate' => round($effectiveRate, 2)
    ];
}

// Save results to database
function saveResults($conn, $username, $data, $results) {
    try {
        // Insert into egypt_cit_results
        $stmt = $conn->prepare("
            INSERT INTO egypt_cit_results (
                username, company_name, tax_registration_number, tax_year, year_end,
                company_type, economic_zone, residency_status, sme_status,
                annual_revenue, total_income, deductible_expenses, depreciation,
                investment_incentives, export_incentives, donations, carry_forward_losses,
                foreign_income, foreign_tax_credit, withholding_tax, transfer_pricing,
                taxable_income, tax_rate, tax_due, effective_tax_rate
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ");

        $stmt->execute([
            $username, $data['companyName'], $data['taxRegistrationNumber'],
            $data['taxYear'], $data['yearEnd'], $data['companyType'],
            $data['economicZone'], $data['residencyStatus'], $data['smeStatus'],
            $data['annualRevenue'], $data['totalIncome'], $data['deductibleExpenses'],
            $data['depreciation'], $data['investmentIncentives'], $data['exportIncentives'],
            $data['donations'], $data['carryForwardLosses'], $data['foreignIncome'],
            $data['foreignTaxCredit'], $data['withholdingTax'], $data['transferPricing'],
            $results['taxableIncome'], $results['taxRate'], $results['taxDue'],
            $results['effectiveRate']
        ]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Update tax overview
function updateTaxOverview($conn, $username) {
    try {
        $stmt = $conn->prepare("
            INSERT INTO tax_overview (
                Username, Tax_Type, Status, Activity, Report, Payroll, Invoice
            ) VALUES (
                ?, 'Egypt CIT', 1, 1, 1, 0, 0
            )
        ");
        
        $stmt->execute([$username]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Main process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateOrigin();
    $username = validateSession();
    
    // Get and decode JSON data
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    if (!$data) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON data']);
        exit;
    }

    // Get database connection
    $conn = getDbConnection($config);
    
    // Calculate tax
    $results = calculateEgyptianCIT($data);
    
    // Save results
    if (saveResults($conn, $username, $data, $results)) {
        // Update tax overview
        if (updateTaxOverview($conn, $username)) {
            echo json_encode([
                'success' => true,
                'message' => 'Tax calculation completed successfully',
                'taxableIncome' => $results['taxableIncome'],
                'taxRate' => $results['taxRate'],
                'taxDue' => $results['taxDue'],
                'effectiveRate' => $results['effectiveRate']
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'message' => 'Tax calculation saved but overview update failed',
                'results' => $results
            ]);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save calculation results']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>