<?php
// ----------> Site configurations 

// ----------> Define constants
defined("site") or define("site", $_SERVER['DOCUMENT_ROOT'] . "/");
defined("page_title") or define("page_title", "Welcome");
defined("site_title") or define("site_title", "Comply Tech");

// ----------> display all errors 
include_once site . "/error.php";
// ----------- error display ------------

// ----------> check for session
include_once site . "/session.php";
// ----------- error display ------------

include site . "/dashboard/pages/welcome/welcome.php";
