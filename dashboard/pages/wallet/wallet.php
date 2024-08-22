<?php
// ----------> Site configurations 

// ----------> Define constants 
defined("site") or define("site", $_SERVER['DOCUMENT_ROOT'] . "/");
defined("page_title") or define("page_title", "Wallet");
defined("site_title") or define("site_title", "Social Transact App");

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

<body id="crancy-dark-light">
    <div class="crancy-body-area">

        <!-- Left Nav-->
    <?php
    include_once site . "/dashboard/modules/nav/left.nav.php";
    ?>

    <!-- Header-->
    <?php
    include_once site . "/dashboard/modules/header/wallet.header.php";
    ?>

    <!-- Content-->
    <?php
    include_once site . "/dashboard/pages/wallet/content/content.php";
    ?>
    </div>

    <!-- script-->
    <?php
    include_once site . "/dashboard/pages/wallet/script.php";
    ?>

<!--  Scripts -->
<script src="/dashboard/js/jquery.min.js"></script>
    <script src="/dashboard/js/jquery-migrate.js"></script>
    <script src="/dashboard/js/popper.min.js"></script>
    <script src="/dashboard/js/bootstrap.min.js"></script>
    <script src="/dashboard/js/charts.js"></script>
    <script src="/dashboard/js/final-countdown.min.js"></script>
    <script src="/dashboard/js/fancy-box.min.js"></script>
    <script src="/dashboard/js/fullcalendar.min.js"></script>
    <script src="/dashboard/js/datatables.min.js"></script>
    <script src="/dashboard/js/circle-progress.min.js"></script>
    <script src="/dashboard/js/nice-select.min.js"></script>
    <script src="/dashboard/js/pikaday.min.js"></script>
    <script src="/dashboard/js/main.js"></script>

    <!-- The Script File for this page-->
</body>

</html>