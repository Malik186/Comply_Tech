<?php
// File: modify_users_table_mysql.php

try {
    // Create a connection to the MySQL database
    $db = new PDO('mysql:host=localhost;dbname=mdskenya_comply_tech', 'mdskenya_malik186', 'Malik@Ndoli186');

    // Set error mode to exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Modify the users table to add new columns
    $db->exec("ALTER TABLE users 
        ADD COLUMN avatar LONGBLOB,   -- Store the image file in binary format
        ADD COLUMN street VARCHAR(255),   -- Store street name as a string
        ADD COLUMN city VARCHAR(100),     -- Store city name as a string
        ADD COLUMN state VARCHAR(100),    -- Store state name as a string
        ADD COLUMN post_code VARCHAR(20)  -- Store postal code as a string
    ");

    echo "Users table modified successfully. New columns added.";
} catch (PDOException $e) {
    // Handle any exceptions/errors
    echo "Error: " . $e->getMessage();
}
?>
