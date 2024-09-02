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

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
    <div class="wrapper">
    <div id="loader"></div>
    <header class="main-header">
        <!-- Header-->
    <?php
    include_once site . "/dashboard/modules/header/header.php";
    ?>
    </header>

    <aside class="main-sidebar">

        <!-- Left Nav-->
    <?php
    include_once site . "/dashboard/modules/nav/side.nav.php";
    ?>
    </aside>

    <div class="content-wrapper">
    <!-- Content-->
    <?php
    include_once site . "/dashboard/pages/admin/content/content.php";
    ?>
    </div>

    <!-- footer-->
    <?php
    include_once site . "/dashboard/modules/footer/footer.php";
    ?>
    <!-- righ nav-->
    <?php
    include_once site . "/dashboard/modules/nav/right.nav.php";
    ?>
    </div>

    <!-- chat nav-->
    <?php
    include_once site . "/dashboard/modules/nav/chat.nav.php";
    ?>

<!-- Vendor JS -->
<script src="js/vendors.min.js"></script>
	<script src="js/pages/chat-popup.js"></script>
    <script src="assets/icons/feather-icons/feather.min.js"></script>	<script src="assets/vendor_components/jquery-steps-master/build/jquery.steps.js"></script>
    <script src="assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.min.js"></script>
    <script src="assets/vendor_components/sweetalert/sweetalert.min.js"></script>
	
	<!-- Master Admin App -->
	<script src="js/template.js"></script>
	
    <script src="js/pages/steps.js"></script>
</body>

</html>