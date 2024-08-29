<!--?php
// File: session.php

// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Debug: Check if session ID is being generated
error_log("Session ID: " . session_id());
error_log("Session data on page load (in session.php): " . print_r($_SESSION, true));

$current_page = basename($_SERVER['PHP_SELF']);

// Redirect to welcome.php if the user is not logged in
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    if ($current_page !== 'welcome.php') {
        error_log("User not logged in. Redirecting to welcome.php from $current_page");
        header("Location: /welcome.php");
        exit();
    }
} else {
    // Redirect to dashboard.php if the user is logged in and on the welcome page
    if ($current_page === 'welcome.php') {
        error_log("User logged in. Redirecting to dashboard.php from welcome.php");
        header("Location: /dashboard.php");
        exit();
    }
}