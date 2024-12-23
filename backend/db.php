<?php
$host = "localhost";
$db_user = "root";
$db_pass = ""; // Update if you have a password
$db_name = "recipe_book"; // Ensure this is the correct DB name

// Establish database connection
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
