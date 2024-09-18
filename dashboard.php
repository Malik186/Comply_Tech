<?php
// File: dashboard.php

// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Log session data for debugging
error_log("Session data on page load (in dashboard.php): " . print_r($_SESSION, true));

// ----------> Define constants
defined("site") or define("site", $_SERVER['DOCUMENT_ROOT'] . "/");
defined("page_title") or define("page_title", "Overview");
defined("site_title") or define("site_title", "Comply Tech");

// ----------> display all errors 
include_once site . "/error.php";

// ----------> check for session
include_once site . "/session.php";

// ----------> Your dashboard content starts here
include site . "/dashboard/pages/overview/overview.php";