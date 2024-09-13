<?php
// File: create_kenya_excise_results_table.php

$host = 'localhost'; // Usually 'localhost' or an IP address
$dbName = 'mdskenya_comply_tech'; // The name of the database
$username = 'mdskenya_malik186'; // Your MySQL username
$password = 'Malik@Ndoli186'; // Your MySQL password

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the kenya_corporate_results table
    $pdo->exec("CREATE TABLE IF NOT EXISTS kenya_corporate_results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        Username VARCHAR(255) NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        companyName VARCHAR(255) NOT NULL,
        yearsOfOperation DECIMAL(10, 2) NOT NULL,
        typeOfCompany ENUM('Resident Company', 'Non-Resident Company', 'Special Rates', 'Repatriated Income', 'Turnover Tax') NOT NULL,
        yearlyProfit DECIMAL(10, 2) NOT NULL,
        specialRatesType VARCHAR(255) NOT NULL,
        corporate_tax DECIMAL(10, 2) NOT NULL,
        net_profit DECIMAL(10, 2) NOT NULL
    )");

    echo "Kenya Corporate Results table created successfully in the '$dbName' database.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
