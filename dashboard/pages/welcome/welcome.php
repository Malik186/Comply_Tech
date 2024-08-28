<?php
// ----------> Site configurations 

// ----------> Define constants 
defined("site") or define("site", $_SERVER['DOCUMENT_ROOT'] . "/");
defined("page_title") or define("page_title", "Welcome");
defined("site_title") or define("site_title", "Comply Tech");

// ----------> display all errors 
include_once site . "/error.php";
// ----------- error display ------------

// ----------> display all errors 
//include_once site . "/authentication/welcome/session.php";
// ----------- error display ------------
?>

<!doctype html>
<html class="no-js" lang="eng">

<head>
    <?php
    include_once site . "/dashboard/modules/html_head.copy.php";
    ?>
</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url(dashboard/img/auth-bg/bg-1.jpg)">
    
    <!-- Content-->
    <?php
    include_once site . "/dashboard/pages/welcome/content/content.php";
    ?>

   <!-- Vendor JS -->
	<script src="js/vendors.min.js"></script>
	<script src="js/pages/chat-popup.js"></script>
    <script src="js/icons/feather-icons/feather.min.js"></script>
    <!-- The Script File for this page-->
</body>

</html>