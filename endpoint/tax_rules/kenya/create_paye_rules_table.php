<?php
// File: create_paye_rules_table.php

$host = 'localhost'; // Usually 'localhost' or an IP address
$dbName = 'mdskenya_comply_tech'; // The name of the database you manually created
$username = 'mdskenya_malik186'; // Your MySQL username
$password = 'Malik@Ndoli186'; // Your MySQL password

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

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
