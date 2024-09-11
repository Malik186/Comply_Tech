<?php
// File: create_payroll_results_table.php

$host = 'localhost'; // Usually 'localhost' or an IP address
$dbName = 'mdskenya_comply_tech'; // The name of the database
$username = 'mdskenya_malik186'; // Your MySQL username
$password = 'Malik@Ndoli186'; // Your MySQL password

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the kenya_payroll_results table
    $pdo->exec("CREATE TABLE IF NOT EXISTS kenya_payroll_results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        gross_salary DECIMAL(10, 2) NOT NULL,
        employee_name VARCHAR(255) NOT NULL,
        id_number VARCHAR(20) NOT NULL,
        employee_no VARCHAR(50) NOT NULL,
        job_title VARCHAR(255) NOT NULL,
        allowances DECIMAL(10, 2) DEFAULT 0,
        paye DECIMAL(10, 2) NOT NULL,
        housing_levy DECIMAL(10, 2) DEFAULT 0,
        nhif DECIMAL(10, 2) NOT NULL,
        nssf DECIMAL(10, 2) NOT NULL,
        mortgage_interest DECIMAL(10, 2) DEFAULT 0,
        insurance_premium DECIMAL(10, 2) DEFAULT 0,
        savings_deposit DECIMAL(10, 2) DEFAULT 0,
        deductions DECIMAL(10, 2) DEFAULT 0,
        payment_method VARCHAR(255) NOT NULL,
        bank_name VARCHAR(255) NOT NULL,
        account_no VARCHAR(50) NOT NULL,
        total_deductions DECIMAL(10, 2) NOT NULL,
        net_salary DECIMAL(10, 2) NOT NULL
    )");

    echo "Kenya Payroll Results table created successfully in the '$dbName' database.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
