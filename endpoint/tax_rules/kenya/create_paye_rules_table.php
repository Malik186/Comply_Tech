<?php
// File: create_paye_rules_table.php

// Database connection 
$config = include '/home/mdskenya/config/comply_tech/config.php';

try {
    // Connect to the MySQL database
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_username'],
        $config['db_password']
    );
    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the PAYE rules table
    $pdo->exec("CREATE TABLE IF NOT EXISTS kenya_paye_rules (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        tax_band VARCHAR(255) NOT NULL,
        tax_rate DECIMAL(5,2) NOT NULL,
        housing_levy DECIMAL(5,2) NOT NULL,
        nssf_tier_1 DECIMAL(10,2) NOT NULL,
        nssf_tier_2 DECIMAL(10,2) NOT NULL,
        nhif_contribution DECIMAL(10,2) NOT NULL,
        income_range VARCHAR(255) NOT NULL
    )");

    echo "Kenya PAYE rules table created successfully in the '$dbName' database.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
