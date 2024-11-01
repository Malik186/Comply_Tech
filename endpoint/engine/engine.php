<?php
// File: dashboard.php

// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// ----------> Define constants
defined("site") or define("site", $_SERVER['DOCUMENT_ROOT'] . "/");
defined("page_title") or define("page_title", "Engine");
defined("site_title") or define("site_title", "Comply Tech");

// ----------> display all errors 
include_once site . "/error.php";

// ----------> check for session
include_once site . "/session.php";

// ----------> Your dashboard content starts here
include site . "/endpoint/engine/region/kenya/kenya.php";