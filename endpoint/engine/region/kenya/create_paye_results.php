<?php
// File: create_tax_results_table.php

$host = 'localhost'; // Usually 'localhost' or an IP address
$dbName = 'mdskenya_comply_tech'; // The name of the database
$username = 'mdskenya_malik186'; // Your MySQL username
$password = 'Malik@Ndoli186'; // Your MySQL password

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the tax_results table
    $pdo->exec("CREATE TABLE IF NOT EXISTS tax_overview (
        id INT AUTO_INCREMENT PRIMARY KEY,
        Username VARCHAR(255) NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        Tax_Type VARCHAR(255) NOT NULL,
        Status TINYINT(1) NOT NULL,      -- 1 or 0 for Status
        Activity TINYINT(1) NOT NULL,    -- 1 or 0 for Activity
        Report TINYINT(1) DEFAULT NULL,      -- 1 or 0 for Report
        Payroll TINYINT(1) DEFAULT NULL,     -- 1 or 0 for Payroll
        Invoice TINYINT(1) DEFAULT NULL      -- 1 or 0 for Invoice
    )");

    echo "Tax Results table created successfully in the '$dbName' database.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
