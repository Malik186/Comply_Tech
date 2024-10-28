<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Database configuration
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

// Function to calculate CGT
function calculateCGT($data) {
    $capitalGain = $data['financial']['disposalProceeds'] - 
                   $data['financial']['acquisitionCost'] - 
                   $data['financial']['improvementCosts'] - 
                   $data['financial']['sellingCosts'];

    // Apply annual exclusion for individuals and special trusts
    $annualExclusionApplied = 0;
    if (in_array($data['taxpayer']['type'], ['individual', 'specialTrust'])) {
        $annualExclusionAvailable = 40000; // R40,000 annual exclusion
        $annualExclusionApplied = min($annualExclusionAvailable - $data['exemptions']['annualExclusion'], $capitalGain);
        $capitalGain -= $annualExclusionApplied;
    }

    // Apply inclusion rate
    $inclusionRate = in_array($data['taxpayer']['type'], ['individual', 'specialTrust']) ? 0.4 : 0.8;
    $taxableCapitalGain = max(0, $capitalGain * $inclusionRate);

    // Estimate CGT payable (using maximum marginal rate as an example)
    $taxRate = $data['taxpayer']['type'] === 'company' ? 0.27 : 0.45;
    $cgtPayable = $taxableCapitalGain * $taxRate;

    return [
        'capitalGain' => $capitalGain,
        'annualExclusionApplied' => $annualExclusionApplied,
        'taxableCapitalGain' => $taxableCapitalGain,
        'cgtPayable' => $cgtPayable
    ];
}

// Function to save results to database
function saveResults($conn, $username, $data, $results) {
    try {
        // Prepare CGT results insertion
        $stmt = $conn->prepare("
            INSERT INTO southafrica_cgt_results (
                username, taxpayer_name, tax_number, tax_year, taxpayer_type,
                asset_type, acquisition_date, disposal_date, is_primary_residence,
                acquisition_cost, disposal_proceeds, improvement_costs, selling_costs,
                valuation_method, valuation_date_value, annual_exclusion, other_exemptions,
                capital_gain, taxable_capital_gain, cgt_payable
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ");

        $stmt->execute([
            $username,
            $data['taxpayer']['name'],
            $data['taxpayer']['taxNumber'],
            $data['taxpayer']['taxYear'],
            $data['taxpayer']['type'],
            $data['asset']['type'],
            $data['asset']['acquisitionDate'],
            $data['asset']['disposalDate'],
            $data['asset']['isPrimaryResidence'],
            $data['financial']['acquisitionCost'],
            $data['financial']['disposalProceeds'],
            $data['financial']['improvementCosts'],
            $data['financial']['sellingCosts'],
            $data['preValuation']['method'],
            $data['preValuation']['valuationDateValue'],
            $data['exemptions']['annualExclusion'],
            $data['exemptions']['otherExemptions'],
            $results['capitalGain'],
            $results['taxableCapitalGain'],
            $results['cgtPayable']
        ]);

        return $conn->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception("Error saving CGT results: " . $e->getMessage());
    }
}

// Function to update tax overview
function updateTaxOverview($conn, $username) {
    try {
        $stmt = $conn->prepare("
            INSERT INTO tax_overview (
                username, tax_type, status, activity, report, payroll, invoice
            ) VALUES (
                ?, 'South_Africa CGT', 1, 1, 1, 0, 0
            )
        ");

        $stmt->execute([$username]);
        return true;
    } catch (PDOException $e) {
        throw new Exception("Error updating tax overview: " . $e->getMessage());
    }
}

// Main execution
try {
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

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

    // Calculate CGT
    $results = calculateCGT($data);

    // Initialize PDO connection
    $conn = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_username'],
        $config['db_password']
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Start transaction
    $conn->beginTransaction();

    // Save CGT results
    $resultId = saveResults($conn, $username, $data, $results);

    // Update tax overview
    updateTaxOverview($conn, $username);

    // Commit transaction
    $conn->commit();

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'CGT calculation completed successfully',
        'results' => $results
    ]);

} catch (Exception $e) {
    // Rollback transaction if active
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }

    // Return error response
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
