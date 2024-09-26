<?php
// ----------> Site configurations 

// ----------> Define constants 
defined("site") or define("site", $_SERVER['DOCUMENT_ROOT'] . "/");
defined("page_title") or define("page_title", "Dashboard");
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
    include_once site . "/dashboard/modules/html_head.php";
    ?>
</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url(/dashboard/img/auth-bg/bg-4.jpg)">
    <!-- Content-->
    <?php
    include_once site . "/dashboard/pages/error/404/content/content.php";
    ?>

   

<!-- Vendor JS -->
<script src="js/vendors.min.js"></script>
    <script src="assets/icons/feather-icons/feather.min.js"></script>
	
	<!-- Comply Tech App -->
	<script src="js/template.js"></script>
</body>

</html>