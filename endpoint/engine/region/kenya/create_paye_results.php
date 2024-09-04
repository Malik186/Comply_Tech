<?php
// File: create_paye_results_table.php

$host = 'localhost'; // Usually 'localhost' or an IP address
$dbName = 'mdskenya_comply_tech'; // The name of the database you manually created
$username = 'mdskenya_malik186'; // Your MySQL username
$password = 'Malik@Ndoli186'; // Your MySQL password

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the kenya_paye_results table
    $pdo->exec("CREATE TABLE IF NOT EXISTS kenya_paye_results (
        Username VARCHAR(255) NOT NULL PRIMARY KEY,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        gross_salary DECIMAL(10,2) NOT NULL,
        paye DECIMAL(10,2) NOT NULL,
        housing_levy DECIMAL(10,2) NOT NULL,
        nhif DECIMAL(10,2) NOT NULL,
        nssf DECIMAL(10,2) NOT NULL,
        mortgage_interest DECIMAL(10,2) NOT NULL,
        insurance_premium DECIMAL(10,2) NOT NULL,
        savings_deposit DECIMAL(10,2) NOT NULL,
        deductions DECIMAL(10,2) NOT NULL,
        total_deductions DECIMAL(10,2) NOT NULL,
        net_salary DECIMAL(10,2) NOT NULL
    )");

    echo "Kenya PAYE results table created successfully in the '$dbName' database.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
