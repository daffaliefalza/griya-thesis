<?php
session_start();
// Unset all session variables
$_SESSION = array();
// Destroy the session
session_destroy();
// Redirect to the produk.php page
header("Location: produk.php");
exit();
