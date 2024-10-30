<?php
// Start session
session_start();

// Load configuration
$config = include '/home/mdskenya/config/comply_tech/config.php';

// Function to validate request origin
function validateOrigin() {
    $allowedOrigin = 'https://complytech.mdskenya.co.ke';
    
    if (!isset($_SERVER['HTTP_ORIGIN']) || $_SERVER['HTTP_ORIGIN'] !== $allowedOrigin) {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized origin']);
        exit;
    }
}

// Function to validate session
function validateSession() {
    if (!isset($_SESSION['user']['username'])) {
        http_response_code(401);
        echo json_encode(['error' => 'No active session or user not logged in']);
        exit;
    }
    return $_SESSION['user']['username'];
}

// Function to connect to database
function getDatabaseConnection($config) {
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

// Function to calculate CIT
function calculateCIT($data) {
    // Calculate total income
    $totalIncome = $data['revenue']['totalRevenue'];
    
    // Calculate total deductions
    $totalDeductions = $data['expenses']['operatingExpenses'] +
                      $data['expenses']['capitalAllowances'] +
                      $data['expenses']['pioneerStatus'] +
                      $data['expenses']['investmentAllowance'] +
                      $data['incentives']['ruralInvestment'] +
                      $data['incentives']['exportIncentives'] +
                      $data['incentives']['infrastructureCredit'] +
                      $data['incentives']['previousLosses'];

    // Calculate taxable income
    $taxableIncome = max(0, $totalIncome - $totalDeductions);

    // Determine tax rate based on company type
    $taxRate = 0;
    switch ($data['classification']['companyType']) {
        case 'small':
            $taxRate = 20;
            break;
        case 'medium':
            $taxRate = 25;
            break;
        case 'large':
            $taxRate = 30;
            break;
    }

    // Calculate initial tax
    $calculatedTax = ($taxableIncome * $taxRate) / 100;

    // Calculate total credits
    $totalCredits = $data['incentives']['exportIncentives'] +
                   $data['incentives']['infrastructureCredit'];

    // Calculate final tax payable
    $finalTaxPayable = max(0, $calculatedTax - $totalCredits);

    // Check for minimum tax if applicable
    if ($data['minimumTax']['isApplicable'] && $finalTaxPayable < $data['minimumTax']['baseAmount']) {
        $finalTaxPayable = $data['minimumTax']['baseAmount'];
    }

    return [
        'taxableIncome' => $taxableIncome,
        'taxRate' => $taxRate,
        'calculatedTax' => $calculatedTax,
        'totalDeductions' => $totalDeductions,
        'totalCredits' => $totalCredits,
        'finalTaxPayable' => $finalTaxPayable
    ];
}

// Function to save results to database
function saveResults($conn, $username, $data, $results) {
    try {
        // Save to nigeria_cit_results
        $stmt = $conn->prepare("
            INSERT INTO nigeria_cit_results (
                username, company_name, rc_number, tax_year, year_end,
                company_type, business_sector, total_revenue, taxable_income,
                tax_rate, calculated_tax, total_deductions, total_credits,
                final_tax_payable
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ");

        $stmt->execute([
            $username,
            $data['companyDetails']['companyName'],
            $data['companyDetails']['rcNumber'],
            $data['companyDetails']['taxYear'],
            $data['companyDetails']['yearEnd'],
            $data['classification']['companyType'],
            $data['classification']['businessSector'],
            $data['revenue']['totalRevenue'],
            $results['taxableIncome'],
            $results['taxRate'],
            $results['calculatedTax'],
            $results['totalDeductions'],
            $results['totalCredits'],
            $results['finalTaxPayable']
        ]);

        // Update tax_overview
        $stmt = $conn->prepare("
            INSERT INTO tax_overview (
                Username, Tax_Type, Status, Activity, Report,
                Payroll, Invoice
            ) VALUES (
                ?, 'Nigeria CIT', 1, 1, 1, 0, 0
            )
        ");

        $stmt->execute([$username]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Main execution
header('Content-Type: application/json');

try {
    // Validate origin
    validateOrigin();

    // Validate session and get username
    $username = validateSession();

    // Get POST data
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if (!$data) {
        throw new Exception('Invalid input data');
    }

    // Get database connection
    $conn = getDatabaseConnection($config);

    // Calculate CIT
    $results = calculateCIT($data);

    // Save results to database
    if (!saveResults($conn, $username, $data, $results)) {
        throw new Exception('Failed to save results');
    }

    // Return results
    echo json_encode([
        'success' => true,
        'results' => $results
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>