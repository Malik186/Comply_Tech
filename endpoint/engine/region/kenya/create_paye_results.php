<?php
// File: modify_vat_results_table.php

$host = 'localhost'; // Usually 'localhost' or an IP address
$dbName = 'mdskenya_comply_tech'; // The name of the database
$username = 'mdskenya_malik186'; // Your MySQL username
$password = 'Malik@Ndoli186'; // Your MySQL password

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Modify the kenya_vat_results table to add new columns
    $pdo->exec("ALTER TABLE kenya_vat_results
        ADD COLUMN email_address VARCHAR(255) NOT NULL,
        ADD COLUMN phone_number VARCHAR(15) NOT NULL,
        ADD COLUMN account_no VARCHAR(50) DEFAULT NULL,
        ADD COLUMN bank VARCHAR(255) DEFAULT NULL");

    echo "Kenya VAT results table modified successfully to add new columns.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
