<?php
// File: logout.php
session_start();
session_unset(); // Unset session variables
session_destroy(); // Destroy the session
header("Location: welcome.php");
exit();
?>
