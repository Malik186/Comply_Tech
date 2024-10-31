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

// Calculate PIT and additional insights
function calculate_pit($data) {
    $totalIncome = $data['incomeSources']['salaryIncome'] + 
                   $data['incomeSources']['businessIncome'] + 
                   $data['incomeSources']['rentalIncome'] + 
                   $data['incomeSources']['investmentIncome'] + 
                   $data['incomeSources']['foreignIncome'] + 
                   $data['incomeSources']['otherIncome'];
    
    $totalDeductions = $data['deductions']['healthInsurance'] + 
                       $data['deductions']['retirementContributions'] + 
                       $data['deductions']['educationExpenses'] + 
                       $data['deductions']['mortgageInterest'] + 
                       $data['deductions']['charitableDonations'] + 
                       $data['deductions']['dependentCareExpenses'];

    $totalCredits = $data['taxReliefsAndCredits']['foreignTaxCredits'] + 
                    $data['taxReliefsAndCredits']['taxReliefForDisabled'] + 
                    $data['taxReliefsAndCredits']['taxCreditChildren'] + 
                    $data['taxReliefsAndCredits']['specialExemptions'];

    // Calculate taxable income and PIT
    $taxableIncome = max(0, $totalIncome - $totalDeductions);
    $pit = ($taxableIncome * 0.3) - $totalCredits; // Adjust PIT rate as required
    $pit = max(0, $pit); // Ensure PIT is not negative

    // Additional insights
    $effectiveTaxRate = ($totalIncome > 0) ? ($pit / $totalIncome) * 100 : 0;
    $deductionPercentage = ($totalIncome > 0) ? ($totalDeductions / $totalIncome) * 100 : 0;
    $creditSavings = $totalCredits;  // Total savings from credits

    return [
        'totalIncome' => $totalIncome,
        'totalDeductions' => $totalDeductions,
        'totalCredits' => $totalCredits,
        'taxableIncome' => $taxableIncome,
        'pit' => $pit,
        'effectiveTaxRate' => round($effectiveTaxRate, 2),
        'deductionPercentage' => round($deductionPercentage, 2),
        'creditSavings' => round($creditSavings, 2)
    ];
}

// Insert PIT results into morocco_pit_results table
function insert_pit_results($conn, $username, $data, $pitData) {
    $stmt = $conn->prepare("INSERT INTO morocco_pit_results 
        (username, fullName, nationalID, residencyStatus, taxYear, dependents, salaryIncome, businessIncome, rentalIncome, investmentIncome, foreignIncome, otherIncome, healthInsurance, retirementContributions, educationExpenses, mortgageInterest, charitableDonations, dependentCareExpenses, foreignTaxCredits, taxReliefForDisabled, taxCreditChildren, specialExemptions, taxableIncome, pit, effectiveTaxRate, deductionPercentage, creditSavings) 
        VALUES (:username, :fullName, :nationalID, :residencyStatus, :taxYear, :dependents, :salaryIncome, :businessIncome, :rentalIncome, :investmentIncome, :foreignIncome, :otherIncome, :healthInsurance, :retirementContributions, :educationExpenses, :mortgageInterest, :charitableDonations, :dependentCareExpenses, :foreignTaxCredits, :taxReliefForDisabled, :taxCreditChildren, :specialExemptions, :taxableIncome, :pit, :effectiveTaxRate, :deductionPercentage, :creditSavings)");

    $stmt->execute([
        ':username' => $username,
        ':fullName' => $data['personalDetails']['fullName'],
        ':nationalID' => $data['personalDetails']['nationalID'],
        ':residencyStatus' => $data['personalDetails']['residencyStatus'],
        ':taxYear' => $data['personalDetails']['taxYear'],
        ':dependents' => $data['personalDetails']['dependents'],
        ':salaryIncome' => $data['incomeSources']['salaryIncome'],
        ':businessIncome' => $data['incomeSources']['businessIncome'],
        ':rentalIncome' => $data['incomeSources']['rentalIncome'],
        ':investmentIncome' => $data['incomeSources']['investmentIncome'],
        ':foreignIncome' => $data['incomeSources']['foreignIncome'],
        ':otherIncome' => $data['incomeSources']['otherIncome'],
        ':healthInsurance' => $data['deductions']['healthInsurance'],
        ':retirementContributions' => $data['deductions']['retirementContributions'],
        ':educationExpenses' => $data['deductions']['educationExpenses'],
        ':mortgageInterest' => $data['deductions']['mortgageInterest'],
        ':charitableDonations' => $data['deductions']['charitableDonations'],
        ':dependentCareExpenses' => $data['deductions']['dependentCareExpenses'],
        ':foreignTaxCredits' => $data['taxReliefsAndCredits']['foreignTaxCredits'],
        ':taxReliefForDisabled' => $data['taxReliefsAndCredits']['taxReliefForDisabled'],
        ':taxCreditChildren' => $data['taxReliefsAndCredits']['taxCreditChildren'],
        ':specialExemptions' => $data['taxReliefsAndCredits']['specialExemptions'],
        ':taxableIncome' => $pitData['taxableIncome'],
        ':pit' => $pitData['pit'],
        ':effectiveTaxRate' => $pitData['effectiveTaxRate'],
        ':deductionPercentage' => $pitData['deductionPercentage'],
        ':creditSavings' => $pitData['creditSavings']
    ]);
}

// Insert summary into tax_overview table
function insert_tax_overview($conn, $username) {
    $stmt = $conn->prepare("INSERT INTO tax_overview 
        (Username, Tax_Type, Status, Activity, Report, Payroll, Invoice) 
        VALUES (:username, 'Morocco PIT', 1, 1, 1, 0, 0)");
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

// Calculate PIT and additional insights
$pitData = calculate_pit($requestData);

// Insert data into tables
try {
    $conn->beginTransaction();
    insert_pit_results($conn, $username, $requestData, $pitData);
    insert_tax_overview($conn, $username);
    $conn->commit();

    echo json_encode(['success' => 'Tax calculation and storage completed successfully', 'pitResults' => $pitData]);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['error' => 'Failed to process tax calculation: ' . $e->getMessage()]);
}

$conn = null;
?>
