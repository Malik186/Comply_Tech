<?php
// File: sign.in.up.php

// Allow CORS from the front-end domain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to log errors
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'error.log');
}

try {
    // Start the session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Connect to the SQLite database
    $db = new PDO('sqlite:/home/mdskenya/database/comply_tech/users.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Log received data for debugging
    logError("Received data: " . print_r($data, true));

    if (isset($data['password'])) {
        $password = $data['password'];

        // Handle sign-in request
        $identifier = isset($data['email']) ? $data['email'] : $data['phone'];
        $field = isset($data['email']) ? 'email' : 'phone';

        $stmt = $db->prepare("SELECT * FROM users WHERE $field = :identifier");
        $stmt->bindParam(':identifier', $identifier);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Start session and set session variables
            $_SESSION['user'] = [
                'email' => $user['email'],
                'phone' => $user['phone'],
                // Add any other user-related data you need to store in the session
            ];

            // Debugging output
            logError("Session started. Session variables: " . print_r($_SESSION, true));

            echo json_encode(['status' => 'success', 'message' => 'Sign-in successful.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Password is required.']);
    }
} catch (PDOException $e) {
    logError("Database error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    logError("General error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
}
