<?php
session_start(); // Start the session to destroy it
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: home.php"); // Redirect to home page
exit();
?>
