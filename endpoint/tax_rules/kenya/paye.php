<?php
// File: paye.php

// Allow CORS from the front-end domain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to log errors
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'error.log');
}

// Function to validate the request origin
function validateOrigin() {
    $allowedDomain = 'https://complytech.mdskenya.co.ke';
    
    // Check if the HTTP_REFERER header is set and matches the allowed domain
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = $_SERVER['HTTP_REFERER'];
        if (strpos($referer, $allowedDomain) !== 0) {
            // Log unauthorized access attempt
            logError("Unauthorized access attempt from: " . $referer);
            // Return an error response
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized domain.']);
            exit;
        }
    } else {
        // If the HTTP_REFERER is not set, reject the request
        logError("Unauthorized access attempt with no referer.");
        echo json_encode(['status' => 'error', 'message' => 'No referer. Unauthorized domain.']);
        exit;
    }
}

try {
    // Start the session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Validate the request origin
    validateOrigin();

    // MySQL database connection details
    $host = 'localhost'; // Usually 'localhost' or an IP address
    $dbName = 'mdskenya_comply_tech'; // The name of the database you manually created
    $username = 'mdskenya_malik186'; // Your MySQL username
    $password = 'Malik@Ndoli186'; // Your MySQL password

    // Connect to the MySQL database
    $db = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Log received data for debugging
    logError("Received data: " . print_r($data, true));

    // Check if PAYE bands exist
    if (isset($data['paye_bands']) && is_array($data['paye_bands'])) {
        foreach ($data['paye_bands'] as $band) {
            if (isset($band['band'], $band['rate'])) {
                $tax_band = $band['band'];
                $tax_rate = $band['rate'];

                // Insert or update the PAYE band
                $stmt = $db->prepare("INSERT INTO `Kenya PAYE rules` 
                    (tax_band, tax_rate) 
                    VALUES (:tax_band, :tax_rate)
                    ON DUPLICATE KEY UPDATE 
                    tax_rate = VALUES(tax_rate)");

                $stmt->bindParam(':tax_band', $tax_band);
                $stmt->bindParam(':tax_rate', $tax_rate);
                
                $stmt->execute();
            }
        }
    }

    // Check if housing levy exists
    if (isset($data['housing_levy'])) {
        $housing_levy = $data['housing_levy'];

        // Insert or update the housing levy
        $stmt = $db->prepare("INSERT INTO `Kenya PAYE rules` 
            (tax_band, housing_levy) 
            VALUES ('Housing Levy', :housing_levy)
            ON DUPLICATE KEY UPDATE 
            housing_levy = VALUES(housing_levy)");

        $stmt->bindParam(':housing_levy', $housing_levy);
        
        $stmt->execute();
    }

    // Check if NSSF contributions exist
    if (isset($data['nssf']['tier_1'], $data['nssf']['tier_2'])) {
        $nssf_tier_1 = $data['nssf']['tier_1'];
        $nssf_tier_2 = $data['nssf']['tier_2'];

        // Insert or update NSSF contributions
        $stmt = $db->prepare("INSERT INTO `Kenya PAYE rules` 
            (tax_band, nssf_tier_1, nssf_tier_2) 
            VALUES ('NSSF', :nssf_tier_1, :nssf_tier_2)
            ON DUPLICATE KEY UPDATE 
            nssf_tier_1 = VALUES(nssf_tier_1),
            nssf_tier_2 = VALUES(nssf_tier_2)");

        $stmt->bindParam(':nssf_tier_1', $nssf_tier_1);
        $stmt->bindParam(':nssf_tier_2', $nssf_tier_2);
        
        $stmt->execute();
    }

    // Check if NHIF rates exist
    if (isset($data['nhif_rates']) && is_array($data['nhif_rates'])) {
        foreach ($data['nhif_rates'] as $rate) {
            if (isset($rate['income_range'], $rate['contribution'])) {
                $income_range = $rate['income_range'];
                $nhif_contribution = $rate['contribution'];

                // Insert or update the NHIF contribution
                $stmt = $db->prepare("INSERT INTO `Kenya PAYE rules` 
                    (tax_band, income_range, nhif_contribution) 
                    VALUES ('NHIF', :income_range, :nhif_contribution)
                    ON DUPLICATE KEY UPDATE 
                    nhif_contribution = VALUES(nhif_contribution)");

                $stmt->bindParam(':income_range', $income_range);
                $stmt->bindParam(':nhif_contribution', $nhif_contribution);
                
                $stmt->execute();
            }
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Tax rules updated successfully.']);
} catch (PDOException $e) {
    logError("Database error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    logError("General error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
}
