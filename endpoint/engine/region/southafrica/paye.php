<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Include database configuration
$config = include '/home/mdskenya/config/comply_tech/config.php';

// Function to validate request origin
function validateOrigin() {
    $allowedOrigin = 'https://complytech.mdskenya.co.ke';
    
    if (!isset($_SERVER['HTTP_ORIGIN']) || $_SERVER['HTTP_ORIGIN'] !== $allowedOrigin) {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized origin']);
        exit;
    }
    
    // Set CORS headers
    header("Access-Control-Allow-Origin: $allowedOrigin");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");
}

// Function to calculate PAYE
function calculatePAYE($data) {
    // Extract annual values regardless of frequency
    $frequency = $data['salaryInfo']['frequency'];
    $basicSalary = $data['salaryInfo']['basicSalary'];
    
    // Convert to annual values based on frequency
    switch ($frequency) {
        case 'monthly':
            $annualSalary = $basicSalary * 12;
            break;
        case 'weekly':
            $annualSalary = $basicSalary * 52;
            break;
        case 'biweekly':
            $annualSalary = $basicSalary * 26;
            break;
        case 'annual':
            $annualSalary = $basicSalary;
            break;
        default:
            throw new Exception('Invalid salary frequency');
    }
    
    // Add other income
    $totalAnnualIncome = $annualSalary +
        $data['salaryInfo']['annualBonus'] +
        $data['salaryInfo']['commission'] +
        $data['benefits']['carAllowance'] +
        $data['benefits']['travelAllowance'] +
        $data['benefits']['housingAllowance'] +
        $data['benefits']['otherAllowances'];
    
    // Calculate deductions
    $totalDeductions = $data['deductions']['retirementFunding'] +
        $data['deductions']['medicalAidContributions'] +
        $data['deductions']['otherDeductions'];
    
    // Calculate taxable income
    $taxableIncome = $totalAnnualIncome - $totalDeductions;
    
    // Apply tax brackets (2024/2025 tax year)
    $tax = 0;
    if ($taxableIncome <= 237100) {
        $tax = $taxableIncome * 0.18;
    } elseif ($taxableIncome <= 370500) {
        $tax = 42678 + ($taxableIncome - 237100) * 0.26;
    } elseif ($taxableIncome <= 512800) {
        $tax = 77362 + ($taxableIncome - 370500) * 0.31;
    } elseif ($taxableIncome <= 673000) {
        $tax = 121475 + ($taxableIncome - 512800) * 0.36;
    } elseif ($taxableIncome <= 857900) {
        $tax = 179147 + ($taxableIncome - 673000) * 0.39;
    } elseif ($taxableIncome <= 1817000) {
        $tax = 251258 + ($taxableIncome - 857900) * 0.41;
    } else {
        $tax = 644489 + ($taxableIncome - 1817000) * 0.45;
    }
    
    // Apply rebates based on age
    $primaryRebate = 17235;
    $secondaryRebate = ($data['employeeDetails']['age'] >= 65) ? 9444 : 0;
    $tertiaryRebate = ($data['employeeDetails']['age'] >= 75) ? 3145 : 0;
    
    $totalRebates = $primaryRebate + $secondaryRebate + $tertiaryRebate;
    $finalTax = max(0, $tax - $totalRebates);
    
    // Calculate monthly PAYE
    $monthlyPAYE = $finalTax / 12;
    
    // Calculate UIF (1% of gross remuneration up to R17,712)
    $monthlyUIF = min(($totalAnnualIncome / 12) * 0.01, 177.12);
    
    return [
        'annualPAYE' => $finalTax,
        'monthlyPAYE' => $monthlyPAYE,
        'taxCredits' => $totalRebates,
        'uifContribution' => $monthlyUIF,
        'netTakeHome' => ($totalAnnualIncome / 12) - $monthlyPAYE - $monthlyUIF,
        'effectiveTaxRate' => ($finalTax / $totalAnnualIncome) * 100
    ];
}

// Function to save results to database
function saveResults($pdo, $data, $results, $username) {
    try {
        // Begin transaction
        $pdo->beginTransaction();
        
        // Insert into southafrica_paye_results
        $stmt = $pdo->prepare("
            INSERT INTO southafrica_paye_results (
                username, tax_year, employee_name, id_number, basic_salary,
                salary_frequency, annual_bonus, commission, car_allowance,
                travel_allowance, housing_allowance, other_allowances,
                retirement_funding, medical_aid, medical_dependents,
                other_deductions, foreign_income, foreign_days,
                annual_paye, monthly_paye, tax_credits, uif_contribution,
                net_take_home, effective_tax_rate, calculation_date
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, NOW()
            )
        ");
        
        $stmt->execute([
            $username,
            $data['employeeDetails']['taxYear'],
            $data['employeeDetails']['name'],
            $data['employeeDetails']['idNumber'],
            $data['salaryInfo']['basicSalary'],
            $data['salaryInfo']['frequency'],
            $data['salaryInfo']['annualBonus'],
            $data['salaryInfo']['commission'],
            $data['benefits']['carAllowance'],
            $data['benefits']['travelAllowance'],
            $data['benefits']['housingAllowance'],
            $data['benefits']['otherAllowances'],
            $data['deductions']['retirementFunding'],
            $data['deductions']['medicalAidContributions'],
            $data['deductions']['medicalDependents'],
            $data['deductions']['otherDeductions'],
            $data['foreignEmployment']['hasForeignIncome'] ? 1 : 0,
            $data['foreignEmployment']['daysOutsideSA'],
            $results['annualPAYE'],
            $results['monthlyPAYE'],
            $results['taxCredits'],
            $results['uifContribution'],
            $results['netTakeHome'],
            $results['effectiveTaxRate']
        ]);
        
        // Insert into tax_overview
        $stmt = $pdo->prepare("
            INSERT INTO tax_overview (
                Username, Tax_Type, Status, Activity, Report, Payroll, Invoice
            ) VALUES (
                ?, 'South_Africa PAYE', 1, 1, 1, 1, 0
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

// Main execution
try {
    // Validate request origin
    validateOrigin();
    
    // Check request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }
    
    // Check session
    if (!isset($_SESSION['user']['username'])) {
        throw new Exception('No active session or user not logged in');
    }
    
    // Get username from session
    $username = $_SESSION['user']['username'];
    
    // Get POST data
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    if (!$data) {
        throw new Exception('Invalid JSON data');
    }
    
    // Connect to database
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_username'],
        $config['db_password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Calculate PAYE
    $results = calculatePAYE($data);
    
    // Save results to database
    saveResults($pdo, $data, $results, $username);
    
    // Return results
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'results' => $results]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>