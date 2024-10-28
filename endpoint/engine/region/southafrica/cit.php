<?php

// Load the database configuration
$config = include '/home/mdskenya/config/comply_tech/config.php';
// Update the SouthAfricanCITCalculator class
class SouthAfricanCITCalculator {
    private $pdo;

    // Define the tax rate constant (example rate: 28%)
    private const STANDARD_RATE = 0.28;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function calculateTax($data, $username) {
        try {

            // Validate and sanitize input data
            $this->validateInput($data);
            
            // Basic company information
            $companyInfo = [
                'company_name' => $data['companyName'],
                'registration_number' => $data['registrationNumber'],
                'tax_year' => $data['taxYear'],
                'year_end' => $data['yearEnd'],
                'company_type' => $data['companyType'],
                'residency_status' => $data['residencyStatus']
            ];

            // Financial figures
            $financials = [
                'annual_turnover' => (float)$data['annualTurnover'],
                'gross_income' => (float)$data['grossIncome'],
                'operating_expenses' => (float)$data['operatingExpenses'],
                'capital_allowances' => (float)($data['capitalAllowances'] ?? 0),
                'rd_expenses' => (float)($data['rdExpenses'] ?? 0),
                'learnership_allowances' => (float)($data['learnershipAllowances'] ?? 0),
                'employment_tax_incentive' => (float)($data['employmentTaxIncentive'] ?? 0),
                'bad_debts' => (float)($data['badDebts'] ?? 0),
                'foreign_income' => (float)($data['foreignIncome'] ?? 0),
                'foreign_tax_credits' => (float)($data['foreignTaxCredits'] ?? 0),
                'assessed_losses' => (float)($data['assessedLosses'] ?? 0),
                'dividends_received' => (float)($data['dividendsReceived'] ?? 0)
            ];

            // Calculate taxable income
            $taxCalculation = $this->calculateTaxableIncome($financials);
            
            // Apply company-specific tax rates and calculations
            $taxResults = $this->applyTaxRates(
                $companyInfo['company_type'],
                $taxCalculation['taxableIncome'],
                $financials
            );

            // Apply foreign tax credits
            $taxResults['finalTaxPayable'] = $this->applyForeignTaxCredits(
                $taxResults['taxPayable'],
                $financials['foreign_tax_credits']
            );

            // Store results in database
            $this->saveResults($companyInfo, $financials, $taxCalculation, $taxResults, $username); // Pass $username

            return [
                'status' => 'success',
                'data' => [
                    'grossIncome' => $financials['gross_income'],
                    'totalDeductions' => $taxCalculation['totalDeductions'],
                    'taxableIncome' => $taxCalculation['taxableIncome'],
                    'taxPayable' => $taxResults['taxPayable'],
                    'foreignTaxCredits' => $financials['foreign_tax_credits'],
                    'finalTaxPayable' => $taxResults['finalTaxPayable'],
                    'effectiveTaxRate' => ($taxResults['finalTaxPayable'] / $financials['gross_income']) * 100,
                    'deductionsBreakdown' => $taxCalculation['deductionsBreakdown']
                ]
            ];

        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    private function calculateTaxableIncome($financials) {
        // Initialize deductions breakdown
        $deductionsBreakdown = [];

        // Basic deductions
        $deductionsBreakdown['operatingExpenses'] = $financials['operating_expenses'];
        $deductionsBreakdown['capitalAllowances'] = $financials['capital_allowances'];
        
        // Enhanced R&D deduction (150%)
        $deductionsBreakdown['rdExpenses'] = $financials['rd_expenses'] * 1.5;
        
        // Standard deductions
        $deductionsBreakdown['learnershipAllowances'] = $financials['learnership_allowances'];
        $deductionsBreakdown['employmentTaxIncentive'] = $financials['employment_tax_incentive'];
        $deductionsBreakdown['badDebts'] = $financials['bad_debts'];
        
        // Exempt income
        $deductionsBreakdown['exemptDividends'] = $financials['dividends_received'];
        
        // Calculate total deductions
        $totalDeductions = array_sum($deductionsBreakdown);
        
        // Calculate taxable income
        $taxableIncome = $financials['gross_income'] - $totalDeductions;
        
        // Apply assessed losses from previous years
        if ($financials['assessed_losses'] > 0) {
            $taxableIncome = max(0, $taxableIncome - $financials['assessed_losses']);
            $deductionsBreakdown['assessedLosses'] = min($financials['assessed_losses'], $taxableIncome);
        }

        return [
            'taxableIncome' => $taxableIncome,
            'totalDeductions' => $totalDeductions,
            'deductionsBreakdown' => $deductionsBreakdown
        ];
    }

    private function applyTaxRates($companyType, $taxableIncome, $financials) {
        switch ($companyType) {
            case 'standard':
                return [
                    'taxPayable' => $taxableIncome * self::STANDARD_RATE
                ];

            case 'sbc': // Small Business Corporation
                return $this->calculateSBCTax($taxableIncome);

            case 'micro': // Turnover Tax for Micro Businesses
                return $this->calculateTurnoverTax($financials['annual_turnover']);

            case 'manufacturing':
                // Additional manufacturing allowances
                $adjustedIncome = $this->applyManufacturingAllowances($taxableIncome, $financials);
                return [
                    'taxPayable' => $adjustedIncome * self::STANDARD_RATE
                ];

            case 'mining':
                // Special mining formula and capital expenditure provisions
                return $this->calculateMiningTax($taxableIncome, $financials);

            default:
                throw new Exception("Invalid company type");
        }
    }

    private function calculateSBCTax($taxableIncome) {
        // Small Business Corporation tax rates for 2023/24
        if ($taxableIncome <= 91250) {
            return ['taxPayable' => 0];
        } elseif ($taxableIncome <= 365000) {
            return ['taxPayable' => ($taxableIncome - 91250) * 0.07];
        } elseif ($taxableIncome <= 550000) {
            return ['taxPayable' => 19163 + ($taxableIncome - 365000) * 0.21];
        } else {
            return ['taxPayable' => 58013 + ($taxableIncome - 550000) * 0.27];
        }
    }

    private function calculateTurnoverTax($annualTurnover) {
        // Turnover Tax rates for 2023/24
        if ($annualTurnover <= 335000) {
            return ['taxPayable' => 0];
        } elseif ($annualTurnover <= 500000) {
            return ['taxPayable' => ($annualTurnover - 335000) * 0.01];
        } elseif ($annualTurnover <= 750000) {
            return ['taxPayable' => 1650 + ($annualTurnover - 500000) * 0.02];
        } else {
            return ['taxPayable' => 6650 + ($annualTurnover - 750000) * 0.03];
        }
    }

    private function applyManufacturingAllowances($taxableIncome, $financials) {
        // Additional allowances for manufacturing companies
        $acceleratedDepreciation = $financials['capital_allowances'] * 0.4; // 40/20/20/20 rule
        return $taxableIncome - $acceleratedDepreciation;
    }

    private function calculateMiningTax($taxableIncome, $financials) {
        // Mining formula: y = a - (ab/x), where:
        // y = tax rate to be determined
        // a = 27 (standard rate)
        // b = portion of tax-free revenue (5%)
        // x = ratio of taxable income to total income
        
        $a = 27;
        $b = 5;
        $x = ($taxableIncome / $financials['gross_income']) * 100;
        $taxRate = $a - ($a * $b / $x);
        $taxRate = min(max($taxRate, 0), 27) / 100; // Convert to decimal and cap between 0 and 27%
        
        return [
            'taxPayable' => $taxableIncome * $taxRate
        ];
    }

    private function applyForeignTaxCredits($taxPayable, $foreignTaxCredits) {
        // Cannot reduce tax payable below zero
        return max(0, $taxPayable - $foreignTaxCredits);
    }

    private function validateInput($data) {
        $requiredFields = [
            'companyName', 'registrationNumber', 'taxYear', 'yearEnd',
            'companyType', 'annualTurnover', 'grossIncome', 'operatingExpenses'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                throw new Exception("Missing required field: {$field}");
            }
        }

        if ($data['annualTurnover'] < 0 || $data['grossIncome'] < 0) {
            throw new Exception("Financial figures cannot be negative");
        }
    }

    

    private function saveResults($companyInfo, $financials, $taxCalculation, $taxResults, $username) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO southafrica_cit_results (
                    company_name, registration_number, tax_year, year_end, company_type,
                    residency_status, annual_turnover, gross_income, operating_expenses,
                    capital_allowances, rd_expenses, learnership_allowances,
                    employment_tax_incentive, bad_debts, foreign_income,
                    foreign_tax_credits, assessed_losses, dividends_received,
                    taxable_income, total_deductions, tax_payable, final_tax_payable,
                    calculation_date, deductions_breakdown, username
                ) VALUES (
                    :company_name, :registration_number, :tax_year, :year_end, :company_type,
                    :residency_status, :annual_turnover, :gross_income, :operating_expenses,
                    :capital_allowances, :rd_expenses, :learnership_allowances,
                    :employment_tax_incentive, :bad_debts, :foreign_income,
                    :foreign_tax_credits, :assessed_losses, :dividends_received,
                    :taxable_income, :total_deductions, :tax_payable, :final_tax_payable,
                    NOW(), :deductions_breakdown, :username
                )
            ");
    
            if ($stmt) {
                $stmt->execute([
                    ':company_name' => $companyInfo['company_name'],
                    ':registration_number' => $companyInfo['registration_number'],
                    ':tax_year' => $companyInfo['tax_year'],
                    ':year_end' => $companyInfo['year_end'],
                    ':company_type' => $companyInfo['company_type'],
                    ':residency_status' => $companyInfo['residency_status'],
                    ':annual_turnover' => $financials['annual_turnover'],
                    ':gross_income' => $financials['gross_income'],
                    ':operating_expenses' => $financials['operating_expenses'],
                    ':capital_allowances' => $financials['capital_allowances'],
                    ':rd_expenses' => $financials['rd_expenses'],
                    ':learnership_allowances' => $financials['learnership_allowances'],
                    ':employment_tax_incentive' => $financials['employment_tax_incentive'],
                    ':bad_debts' => $financials['bad_debts'],
                    ':foreign_income' => $financials['foreign_income'],
                    ':foreign_tax_credits' => $financials['foreign_tax_credits'],
                    ':assessed_losses' => $financials['assessed_losses'],
                    ':dividends_received' => $financials['dividends_received'],
                    ':taxable_income' => $taxCalculation['taxableIncome'],
                    ':total_deductions' => $taxCalculation['totalDeductions'],
                    ':tax_payable' => $taxResults['taxPayable'],
                    ':final_tax_payable' => $taxResults['finalTaxPayable'],
                    ':deductions_breakdown' => json_encode($taxCalculation['deductionsBreakdown']),
                    ':username' => $username
                ]);
            } else {
                throw new Exception("Failed to prepare SQL statement.");
            }
        } catch (Exception $e) {
            // Handle or log the exception
            echo "Error saving results: " . $e->getMessage();
        }
    }
    

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
                logError("VAT calculation failed: " . $e->getMessage());
            }
            
            // Determine Payroll and Invoice fields based on input
            $payroll = isset($data['payroll_calculated']) ? 1 : 0;
            $invoice = isset($vat) ? 1 : 0;
            
            // Insert data into tax_overview table
            insertTaxOverview($pdo, $user, "South_Africa CIT", $status, $activity, $payroll, $invoice, $report);
// Usage example:
try {
        // Check if the session username is set
        session_start(); // Ensure the session is started before accessing session variables
        if (!isset($_SESSION['user']['username'])) {
            echo json_encode(['error' => 'No active session or user not logged in']);
            exit;
        }
    
        $user = $_SESSION['user']['username'];
    
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Only POST requests are allowed.']);
            exit;
            
        }
        
    // Validate the request origin
    validateOrigin();

     // Database connection using loaded configuration
     $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_username'],
        $config['db_password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize the calculator
    $calculator = new SouthAfricanCITCalculator($pdo);
    
    // Retrieve and decode the input data
    $data = json_decode(file_get_contents("php://input"), true);
    
      // Calculate tax and pass the $user as $username
      $result = $calculator->calculateTax($data, $user); // Pass $user to the method
    
    // Return the result as JSON
    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>