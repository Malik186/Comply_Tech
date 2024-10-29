<?php
// Start session
session_start();

// Load configuration
$config = include '/home/mdskenya/config/comply_tech/config.php';

// Function to validate request origin
function validateOrigin() {
    $allowedOrigin = 'https://complytech.mdskenya.co.ke';
    
    if (!isset($_SERVER['HTTP_ORIGIN']) || $_SERVER['HTTP_ORIGIN'] !== $allowedOrigin) {
        header('HTTP/1.1 403 Forbidden');
        echo json_encode(['error' => 'Invalid origin']);
        exit;
    }
    
    header("Access-Control-Allow-Origin: $allowedOrigin");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");
}

// Function to validate session
function validateSession() {
    if (!isset($_SESSION['user']['username'])) {
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['error' => 'No active session or user not logged in']);
        exit;
    }
    return $_SESSION['user']['username'];
}

// Function to calculate PIT
function calculateNigerianPIT($data) {
    // Get gross income
    $grossIncome = 
        $data['employmentIncome']['basicSalary'] +
        $data['employmentIncome']['housingAllowance'] +
        $data['employmentIncome']['transportAllowance'] +
        $data['employmentIncome']['utilityAllowance'] +
        $data['employmentIncome']['mealAllowance'] +
        $data['employmentIncome']['otherAllowances'] +
        $data['otherIncome']['businessIncome'] +
        $data['otherIncome']['investmentIncome'] +
        $data['otherIncome']['rentalIncome'] +
        $data['otherIncome']['otherIncome'];

    // Calculate total relief (Consolidated Relief Allowance - CRA)
    $cra = min(200000, $grossIncome * 0.01) + ($grossIncome * 0.20);
    
    // Calculate total deductions
    $totalDeductions = 
        $data['deductions']['nhf'] +
        $data['deductions']['pension'] +
        $data['deductions']['nhis'] +
        $data['deductions']['lifeInsurance'];

    // Calculate taxable income
    $taxableIncome = $grossIncome - ($cra + $totalDeductions);
    if ($taxableIncome < 0) $taxableIncome = 0;

    // Calculate tax using Nigerian PIT rates
    $taxRates = [
        300000 => 0.07,
        300000 => 0.11,
        500000 => 0.15,
        500000 => 0.19,
        1600000 => 0.21,
        PHP_FLOAT_MAX => 0.24
    ];

    $remainingIncome = $taxableIncome;
    $totalTax = 0;

    foreach ($taxRates as $bracket => $rate) {
        if ($remainingIncome <= 0) break;
        
        $taxableAmount = min($bracket, $remainingIncome);
        $totalTax += $taxableAmount * $rate;
        $remainingIncome -= $bracket;
    }

    $monthlyTax = $totalTax / 12;

    return [
        'gross_income' => $grossIncome,
        'total_relief' => $cra,
        'total_deductions' => $totalDeductions,
        'taxable_income' => $taxableIncome,
        'calculated_tax' => $totalTax,
        'monthly_tax' => $monthlyTax
    ];
}

// Function to save results to database
function saveResults($pdo, $username, $data, $calculations) {
    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Insert into nigeria_pit_results
        $stmt = $pdo->prepare("
            INSERT INTO nigeria_pit_results (
                username, tin, full_name, tax_state, tax_year,
                gross_income, basic_salary, total_allowances,
                total_relief, taxable_income, calculated_tax,
                final_tax, monthly_tax, tax_data
            ) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?,
                ?, ?, ?,
                ?, ?, ?
            )
        ");

        $totalAllowances = 
            $data['employmentIncome']['housingAllowance'] +
            $data['employmentIncome']['transportAllowance'] +
            $data['employmentIncome']['utilityAllowance'] +
            $data['employmentIncome']['mealAllowance'] +
            $data['employmentIncome']['otherAllowances'];

        $stmt->execute([
            $username,
            $data['personalDetails']['tin'],
            $data['personalDetails']['fullName'],
            $data['personalDetails']['taxState'],
            $data['personalDetails']['taxYear'],
            $calculations['gross_income'],
            $data['employmentIncome']['basicSalary'],
            $totalAllowances,
            $calculations['total_relief'],
            $calculations['taxable_income'],
            $calculations['calculated_tax'],
            $calculations['calculated_tax'],
            $calculations['monthly_tax'],
            json_encode($data)
        ]);

        // Insert into tax_overview
        $stmt = $pdo->prepare("
            INSERT INTO tax_overview (
                Username, Tax_Type, Status,
                Activity, Report, Payroll, Invoice
            ) VALUES (
                ?, 'Nigeria PIT', 1,
                1, 1, 1, 0
            )
        ");

        $stmt->execute([$username]);

        // Commit transaction
        $pdo->commit();
        return true;

    } catch (Exception $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        throw $e;
    }
}

// Main processing
try {
    // Validate request origin
    validateOrigin();

    // Validate session and get username
    $username = validateSession();

    // Get and validate input data
    $inputJSON = file_get_contents('php://input');
    $data = json_decode($inputJSON, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data received');
    }

    // Connect to database
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_username'],
        $config['db_password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Calculate PIT
    $calculations = calculateNigerianPIT($data);

    // Save results to database
    saveResults($pdo, $username, $data, $calculations);

    // Send success response
    echo json_encode([
        'status' => 'success',
        'message' => 'Tax calculation completed successfully',
        'calculations' => $calculations
    ]);

} catch (Exception $e) {
    // Handle errors
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>