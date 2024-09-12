<?php
// File: dashboard.php

// Retrieve the selected country and tax type
$country = $_POST['country'] ?? '';
$taxType = $_POST['taxType'] ?? '';

// Validate input
if (empty($country) || empty($taxType)) {
    die("Invalid input. Please go back and select a country and tax type.");
}

// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Log session data for debugging
error_log("Session data on page load (in dashboard.php): " . print_r($_SESSION, true));

// ----------> Define constants
defined("site") or define("site", $_SERVER['DOCUMENT_ROOT'] . "/");
defined("page_title") or define("page_title", "$country $taxType Form");
defined("site_title") or define("site_title", "Comply Tech");

// ----------> display all errors 
include_once site . "/error.php";

// ----------> check for session
include_once site . "/session.php";

// ----------> Your dashboard content starts here
include site . "/region/kenya/Excise/index.php";