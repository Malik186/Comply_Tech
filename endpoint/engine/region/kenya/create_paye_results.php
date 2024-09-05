<?php
// File: create_vat_results_table.php

$host = 'localhost'; // Usually 'localhost' or an IP address
$dbName = 'mdskenya_comply_tech'; // The name of the database
$username = 'mdskenya_malik186'; // Your MySQL username
$password = 'Malik@Ndoli186'; // Your MySQL password

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the kenya_vat_results table
    $pdo->exec("CREATE TABLE IF NOT EXISTS kenya_vat_results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        Username VARCHAR(255) NOT NULL,
        Invoice VARCHAR(255) NOT NULL,
        date_generated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        due_date DATE NOT NULL,
        customer_name VARCHAR(255) NOT NULL,
        customer_address VARCHAR(255) NOT NULL,
        item_description TEXT NOT NULL,
        quantity INT NOT NULL,
        unit_price DECIMAL(10, 2) NOT NULL,
        payment_terms VARCHAR(255) NOT NULL
    )");

    echo "Kenya VAT results table created successfully in the '$dbName' database.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
