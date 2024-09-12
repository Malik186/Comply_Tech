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

    // Create the kenya_excise_results table
    $pdo->exec("CREATE TABLE IF NOT EXISTS kenya_excise_results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        importerManufacturer VARCHAR(255) NOT NULL,
        contactInfo VARCHAR(255) NOT NULL,
        typeOfGoods ENUM('Alcoholic Beverages', 'Tobacco Products', 'Petroleum Products', 'Motor Vehicles') NOT NULL,
        goodsDescription VARCHAR(255) NOT NULL,
        cif_cost DECIMAL(10, 2) NOT NULL,
        cif_insurance DECIMAL(10, 2) NOT NULL,
        cif_freight DECIMAL(10, 2) NOT NULL,
        Custom_Duty DECIMAL(10, 2) DEFAULT 0,
        Excise_Duty DECIMAL(10, 2) DEFAULT 0,
        VAT DECIMAL(10, 2) DEFAULT 0,
        IDF DECIMAL(10, 2) DEFAULT 0,
        RDL DECIMAL(10, 2) DEFAULT 0,
        goodsOrigin ENUM('Locally Manufactured', 'Imported Goods') NOT NULL,
        alcoholType VARCHAR(255) DEFAULT NULL,
        alcoholQuantity DECIMAL(10, 2) DEFAULT NULL,
        tobaccoType VARCHAR(255) DEFAULT NULL,
        tobaccoQuantity DECIMAL(10, 2) DEFAULT NULL,
        petroleumType VARCHAR(255) DEFAULT NULL,
        petroleumQuantity DECIMAL(10, 2) DEFAULT NULL,
        vehicleType VARCHAR(255) DEFAULT NULL,
        vehicleQuantity DECIMAL(10, 2) DEFAULT NULL
    )");

    echo "Kenya Excise Results table created successfully in the '$dbName' database.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
