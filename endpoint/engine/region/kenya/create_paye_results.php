<?php
// File: create_kenya_custom_results_table.php

$host = 'localhost'; // Usually 'localhost' or an IP address
$dbName = 'mdskenya_comply_tech'; // The name of the database
$username = 'mdskenya_malik186'; // Your MySQL username
$password = 'Malik@Ndoli186'; // Your MySQL password

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the kenya_custom_results table
    $pdo->exec("CREATE TABLE IF NOT EXISTS kenya_custom_results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        name VARCHAR(255) NOT NULL,
        nameOfGoods VARCHAR(255) NOT NULL,
        typeOfGoods ENUM('Capital Goods and Raw Materials', 'Intermediate Goods', 'Finished Goods', 'Sensitive Items') NOT NULL,
        cif DECIMAL(10, 2) DEFAULT 0,
        cost DECIMAL(10, 2) NOT NULL,
        insurance DECIMAL(10, 2) NOT NULL,
        freight DECIMAL(10, 2) NOT NULL,
        Custom_Duty DECIMAL(10, 2) NOT NULL
    )");

    echo "Kenya Custom Results table created successfully in the '$dbName' database.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
