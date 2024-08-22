<?php
// File: session.php

session_start();

$current_page = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['email']) || $_SESSION['email'] == "") {
    if ($current_page !== 'welcome.php') {
        header("Location: /welcome.php");
        exit();
    }
} else {
    if ($current_page === 'welcome.php') {
        header("Location: /dashboard/index.php");
        exit();
    }
}

$inactive = 600; // 10 minutes
if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_destroy();
        header("Location: /welcome.php");
        exit();
    }
}
$_SESSION['timeout'] = time();
