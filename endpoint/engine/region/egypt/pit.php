<?php
// Start session
session_start();

// Include database configuration
$config = include '/home/mdskenya/config/comply_tech/config.php';

// Establish database connection
try {
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_username'],
        $config['db_password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Function to validate request origin
function validateOrigin() {
    $allowedOrigin = 'https://complytech.mdskenya.co.ke';
    
    if (!isset($_SERVER['HTTP_ORIGIN']) || $_SERVER['HTTP_ORIGIN'] !== $allowedOrigin) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Unauthorized origin']);
        exit;
    }
}

// Function to validate session
function validateSession() {
    if (!isset($_SESSION['user']['username'])) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'No active session or user not logged in']);
        exit;
    }
    return $_SESSION['user']['username'];
}

// Function to calculate PIT tax
function calculatePITTax($data) {
    // Get total employment income
    $employmentIncome = floatval($data['basicSalary']) + 
                       floatval($data['bonuses']) + 
                       floatval($data['allowances']) + 
                       floatval($data['overtime']);

    // Get total additional income
    $additionalIncome = floatval($data['professionalIncome']) + 
                       floatval($data['rentalIncome']) + 
                       floatval($data['investmentIncome']) + 
                       floatval($data['foreignIncome']);

    // Calculate total income
    $totalIncome = $employmentIncome + $additionalIncome;

    // Calculate total deductions
    $totalDeductions = floatval($data['socialInsurance']) + 
                      floatval($data['medicalExpenses']) + 
                      floatval($data['personalExemption']) + 
                      floatval($data['dependentExemptions']);

    // Calculate taxable income
    $taxableIncome = $totalIncome - $totalDeductions;

    // Calculate tax based on Egypt's tax brackets (2024 rates)
    $tax = 0;
    if ($taxableIncome <= 15000) {
        $tax = $taxableIncome * 0.0;
    } elseif ($taxableIncome <= 30000) {
        $tax = ($taxableIncome - 15000) * 0.1;
    } elseif ($taxableIncome <= 45000) {
        $tax = (15000 * 0.1) + ($taxableIncome - 30000) * 0.15;
    } elseif ($taxableIncome <= 60000) {
        $tax = (15000 * 0.1) + (15000 * 0.15) + ($taxableIncome - 45000) * 0.2;
    } else {
        $tax = (15000 * 0.1) + (15000 * 0.15) + (15000 * 0.2) + ($taxableIncome - 60000) * 0.25;
    }

    // Apply tax credits
    $totalCredits = floatval($data['foreignTaxCredit']) + floatval($data['otherCredits']);
    $finalTax = max(0, $tax - $totalCredits);

    return [
        'total_income' => $totalIncome,
        'total_deductions' => $totalDeductions,
        'taxable_income' => $taxableIncome,
        'tax_before_credits' => $tax,
        'tax_credits' => $totalCredits,
        'final_tax' => $finalTax
    ];
}

// Function to insert results into database
function insertResults($pdo, $username, $data, $results) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO egypt_pit_results (
                username, full_name, national_id, tax_year, residency_status,
                basic_salary, bonuses, allowances, overtime,
                professional_income, rental_income, investment_income, foreign_income,
                social_insurance, medical_expenses, personal_exemption, dependent_exemptions,
                foreign_tax_credit, other_credits,
                total_income, total_deductions, taxable_income,
                tax_before_credits, tax_credits, final_tax,
                calculation_date
            ) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?,
                ?, ?, ?,
                ?, ?, ?,
                NOW()
            )
        ");

        $stmt->execute([
            $username, $data['fullName'], $data['nationalId'], $data['taxYear'], $data['residencyStatus'],
            $data['basicSalary'], $data['bonuses'], $data['allowances'], $data['overtime'],
            $data['professionalIncome'], $data['rentalIncome'], $data['investmentIncome'], $data['foreignIncome'],
            $data['socialInsurance'], $data['medicalExpenses'], $data['personalExemption'], $data['dependentExemptions'],
            $data['foreignTaxCredit'], $data['otherCredits'],
            $results['total_income'], $results['total_deductions'], $results['taxable_income'],
            $results['tax_before_credits'], $results['tax_credits'], $results['final_tax']
        ]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Function to update tax overview
function updateTaxOverview($pdo, $username) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO tax_overview (
                Username, Tax_Type, Status, Activity, Report, Payroll, Invoice
            ) VALUES (
                ?, 'Egypt PIT', 1, 1, 1, 1, 0
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
    
    // Get and decode JSON data
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    if (!$data) {
        throw new Exception('Invalid JSON data');
    }
    
    // Calculate tax
    $results = calculatePITTax($data);
    
    // Insert results into database
    if (!insertResults($pdo, $username, $data, $results)) {
        throw new Exception('Failed to save results');
    }
    
    // Update tax overview
    if (!updateTaxOverview($pdo, $username)) {
        throw new Exception('Failed to update tax overview');
    }
    
    // Return success response
    echo json_encode([
        'status' => 'success',
        'results' => $results
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}