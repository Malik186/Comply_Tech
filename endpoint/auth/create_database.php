<?php
// File: create_database.php

try {
    // Create (or open) the SQLite database
    $db = new PDO('sqlite:users.db');

    // Set error mode to exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the users table
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT NOT NULL UNIQUE,
        phone TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    )");

    echo "Database and users table created successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>