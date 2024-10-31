<?php
// Load database configuration
$config = include '/home/mdskenya/config/comply_tech/config.php';

// Start session to get username
session_start();
if (!isset($_SESSION['user']['username'])) {
    echo json_encode(['error' => 'No active session or user not logged in']);
    exit;
}
$username = $_SESSION['user']['username'];

// Validate the request origin
function validate_request_origin() {
    if ($_SERVER['HTTP_ORIGIN'] !== 'https://complytech.mdskenya.co.ke') {
        echo json_encode(['error' => 'Unauthorized request origin']);
        exit;
    }
}

// Establish a PDO connection
function db_connect($config) {
    try {
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8";
        return new PDO($dsn, $config['db_username'], $config['db_password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Calculate CIT and additional insights
function calculate_cit($data) {
    $totalRevenue = $data['revenueSources']['domesticRevenue'] + 
                    $data['revenueSources']['foreignRevenue'] + 
                    $data['revenueSources']['interestIncome'] + 
                    $data['revenueSources']['dividendsReceived'] + 
                    $data['revenueSources']['capitalGains'] + 
                    $data['revenueSources']['otherIncome'];
    
    $totalExpenses = $data['operationalExpenses']['salaries'] + 
                     $data['operationalExpenses']['rentalExpenses'] + 
                     $data['operationalExpenses']['marketingExpenses'] + 
                     $data['operationalExpenses']['interestOnLoans'] + 
                     $data['operationalExpenses']['depreciation'] + 
                     $data['operationalExpenses']['otherExpenses'];

    $totalDeductions = $data['taxDeductionsAndCredits']['investmentDeductions'] + 
                       $data['taxDeductionsAndCredits']['employmentCredits'] + 
                       $data['taxDeductionsAndCredits']['energyEfficiencyCredits'] + 
                       $data['taxDeductionsAndCredits']['otherTaxCredits'];

    // Calculate taxable income and CIT
    $taxableIncome = max(0, $totalRevenue - $totalExpenses);
    $cit = ($taxableIncome * 0.25) - $totalDeductions; // 25% CIT rate
    $cit = max(0, $cit); // Ensure CIT is not negative

    // Additional insights
    $effectiveTaxRate = ($totalRevenue > 0) ? ($cit / $totalRevenue) * 100 : 0;
    $expensePercentage = ($totalRevenue > 0) ? ($totalExpenses / $totalRevenue) * 100 : 0;
    $deductionSavings = $totalDeductions;  // Total savings from deductions

    return [
        'totalRevenue' => $totalRevenue,
        'totalExpenses' => $totalExpenses,
        'totalDeductions' => $totalDeductions,
        'taxableIncome' => $taxableIncome,
        'cit' => $cit,
        'effectiveTaxRate' => round($effectiveTaxRate, 2),
        'expensePercentage' => round($expensePercentage, 2),
        'deductionSavings' => round($deductionSavings, 2)
    ];
}

// Insert CIT results into morocco_cit_results table
function insert_cit_results($conn, $username, $data, $citData) {
    $stmt = $conn->prepare("INSERT INTO morocco_cit_results 
        (username, companyName, corporateID, industry, taxYear, employees, domesticRevenue, foreignRevenue, interestIncome, dividendsReceived, capitalGains, otherIncome, salaries, rentalExpenses, marketingExpenses, interestOnLoans, depreciation, otherExpenses, investmentDeductions, employmentCredits, energyEfficiencyCredits, otherTaxCredits, taxableIncome, cit, effectiveTaxRate, expensePercentage, deductionSavings) 
        VALUES (:username, :companyName, :corporateID, :industry, :taxYear, :employees, :domesticRevenue, :foreignRevenue, :interestIncome, :dividendsReceived, :capitalGains, :otherIncome, :salaries, :rentalExpenses, :marketingExpenses, :interestOnLoans, :depreciation, :otherExpenses, :investmentDeductions, :employmentCredits, :energyEfficiencyCredits, :otherTaxCredits, :taxableIncome, :cit, :effectiveTaxRate, :expensePercentage, :deductionSavings)");

    $stmt->execute([
        ':username' => $username,
        ':companyName' => $data['companyInfo']['companyName'],
        ':corporateID' => $data['companyInfo']['corporateID'],
        ':industry' => $data['companyInfo']['industry'],
        ':taxYear' => $data['companyInfo']['taxYear'],
        ':employees' => $data['companyInfo']['employees'],
        ':domesticRevenue' => $data['revenueSources']['domesticRevenue'],
        ':foreignRevenue' => $data['revenueSources']['foreignRevenue'],
        ':interestIncome' => $data['revenueSources']['interestIncome'],
        ':dividendsReceived' => $data['revenueSources']['dividendsReceived'],
        ':capitalGains' => $data['revenueSources']['capitalGains'],
        ':otherIncome' => $data['revenueSources']['otherIncome'],
        ':salaries' => $data['operationalExpenses']['salaries'],
        ':rentalExpenses' => $data['operationalExpenses']['rentalExpenses'],
        ':marketingExpenses' => $data['operationalExpenses']['marketingExpenses'],
        ':interestOnLoans' => $data['operationalExpenses']['interestOnLoans'],
        ':depreciation' => $data['operationalExpenses']['depreciation'],
        ':otherExpenses' => $data['operationalExpenses']['otherExpenses'],
        ':investmentDeductions' => $data['taxDeductionsAndCredits']['investmentDeductions'],
        ':employmentCredits' => $data['taxDeductionsAndCredits']['employmentCredits'],
        ':energyEfficiencyCredits' => $data['taxDeductionsAndCredits']['energyEfficiencyCredits'],
        ':otherTaxCredits' => $data['taxDeductionsAndCredits']['otherTaxCredits'],
        ':taxableIncome' => $citData['taxableIncome'],
        ':cit' => $citData['cit'],
        ':effectiveTaxRate' => $citData['effectiveTaxRate'],
        ':expensePercentage' => $citData['expensePercentage'],
        ':deductionSavings' => $citData['deductionSavings']
    ]);
}

// Insert summary into tax_overview table
function insert_tax_overview($conn, $username) {
    $stmt = $conn->prepare("INSERT INTO tax_overview 
        (Username, Tax_Type, Status, Activity, Report, Payroll, Invoice) 
        VALUES (:username, 'Morocco CIT', 1, 1, 1, 0, 0)");
    $stmt->execute([':username' => $username]);
}

// Main code execution
validate_request_origin();
$conn = db_connect($config);

// Get JSON data and decode
$requestData = json_decode(file_get_contents('php://input'), true);
if (!$requestData) {
    echo json_encode(['error' => 'Invalid input data']);
    exit;
}

// Calculate CIT and additional insights
$citData = calculate_cit($requestData);

// Insert data into tables
try {
    $conn->beginTransaction();
    insert_cit_results($conn, $username, $requestData, $citData);
    $conn->commit();

    echo json_encode(['success' => 'CIT calculation and storage completed successfully', 'citResults' => $citData]);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['error' => 'Failed to process CIT calculation: ' . $e->getMessage()]);
}

$conn = null;
?>
