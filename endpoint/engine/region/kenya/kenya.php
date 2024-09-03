<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output buffering
ob_start();

// Set up logging
$logFile = 'paye_calculation_log.txt';
function logMessage($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message" . PHP_EOL, FILE_APPEND);
}

logMessage("Script started");

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

logMessage("Headers set");

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

function calculatePAYE($gross_salary) {
    $paye_bands = [
        [0, 24000, 0.10],
        [24001, 32333, 0.25],
        [32334, 500000, 0.30],
        [500001, 800000, 0.325],
        [800001, PHP_INT_MAX, 0.35]
    ];

    $paye = 0;
    
    foreach ($paye_bands as $band) {
        if ($gross_salary > $band[1]) {
            $paye += ($band[1] - $band[0] + 1) * $band[2];
        } else {
            $paye += ($gross_salary - $band[0]) * $band[2];
            break;
        }
    }
    
    return $paye;
}

function calculateNSSF($gross_salary) {
    $nssf_tier1 = min(6000, $gross_salary) * 0.06; // Employee's contribution (6%)
    $nssf_tier2 = ($gross_salary > 6000) ? (min(18000, $gross_salary) - 6000) * 0.06 : 0;
    return $nssf_tier1 + $nssf_tier2; // Total employee contribution
}

function calculateDeductions($data, $gross_salary) {
    $deductions = [];
    
    if (isset($data['mortgage'])) {
        $deductions['mortgage'] = $data['mortgage'];
    }
    
    if (isset($data['life_insurance'])) {
        $deductions['life_insurance'] = $data['life_insurance'];
    }
    
    if (isset($data['home_ownership_savings_plan'])) {
        $deductions['home_ownership_savings_plan'] = $data['home_ownership_savings_plan'];
    }
    
    $deductions['affordable_housing_levy'] = $gross_salary * 0.015;
    $deductions['nssf'] = calculateNSSF($gross_salary);
    $deductions['nhif'] = calculateNHIF($gross_salary);

    if (isset($data['other_deductions'])) {
        $deductions['other_deductions'] = $data['other_deductions'];
    }
    
    return array_sum($deductions);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logMessage("POST request received");
    
    $rawData = file_get_contents('php://input');
    logMessage("Raw input data: " . $rawData);
    
    $data = json_decode($rawData, true);
    logMessage("Decoded data: " . print_r($data, true));
    
    if (!isset($data['gross_salary']) || !isset($data['calculation_period'])) {
        logMessage("Error: Missing required fields");
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }
    
    $gross_salary = $data['gross_salary'];
    logMessage("Gross salary: " . $gross_salary);
    
    $paye = calculatePAYE($gross_salary);
    logMessage("Calculated PAYE: " . $paye);
    
    $total_deductions = calculateDeductions($data, $gross_salary);
    logMessage("Calculated total deductions: " . $total_deductions);
    
    $net_salary = $gross_salary - $paye - $total_deductions;
    logMessage("Calculated net salary: " . $net_salary);

    if ($data['calculation_period'] === 'yearly') {
        $net_salary *= 12;
        $paye *= 12;
        $total_deductions *= 12;
        logMessage("Adjusted for yearly calculation");
    }
    
    $response = [
        'gross_salary' => $gross_salary,
        'paye' => $paye,
        'total_deductions' => $total_deductions,
        'net_salary' => $net_salary
    ];
    
    logMessage("Final response: " . print_r($response, true));
    
    echo json_encode($response);
    logMessage("Response sent");
} else {
    logMessage("Error: Method not allowed");
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}

// End output buffering and log the output
$output = ob_get_clean();
logMessage("Script output: " . $output);

// Actually send the output
echo $output;

logMessage("Script ended");
?>
