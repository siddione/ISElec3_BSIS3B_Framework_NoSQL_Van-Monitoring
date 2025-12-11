<?php
// Start the session
session_start();

// Destroy all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page (or homepage)
header("Location: login.php"); // change the filename if needed
exit();
?>
