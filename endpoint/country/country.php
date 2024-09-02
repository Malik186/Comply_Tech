<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --------------------> Define root directory if not defined
defined("site") or define("site", $_SERVER['DOCUMENT_ROOT'] . "/");

// --------------------> Define page title
// defined("page_title") or define("page_title", "Engine");
// defined("SiteName") or define("SiteName", "Comply Tech");

// --------------------> Toggle errors display 
include_once site . "/error.php";

// --------------------> Include different country pages
include_once site . "/endpoint/country/kenya/kenya.php";
include_once site . "/endpoint/country/uganda/uganda.php";
// ----------- /Go to site home page ------------ 