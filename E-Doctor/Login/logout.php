<?php
session_start();

// Clear all session variables
$_SESSION = [];

// Unset and destroy the session
session_unset();
session_destroy();

// Redirect to the index page
header("Location: ../index.php");
exit;
?>


