<?php
// Database connection settings
$host = "localhost";
$db_user = "root";
$db_pass = ""; // Adjust with your DB password
$db_name = "recipe_book";
session_start(); // Start session to store messages

$response = [];

// Connect to the database
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check for POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phoneNumber = trim($_POST['phoneNumber']);

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($phoneNumber)) {
        $response['error'] = 'All fields are required.';
    } else {
        // Check if the username already exists
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response['error'] = 'Username already exists. Please choose a different one.';
        } else {
            // Check if the email already exists
            $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $response['error'] = 'Email already exists. Please use a different one.';
            } else {
                // Hash the password
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);

                // Prepare SQL statement
                $stmt = $conn->prepare("INSERT INTO users (username, email, password, phone_number) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $username, $email, $password_hashed, $phoneNumber);

                if ($stmt->execute()) {
                    // Success message
                    $response['success'] = 'Account created successfully!';
                } else {
                    $response['error'] = 'Error while creating the account. Please try again later.';
                }
                $stmt->close();
            }
        }
    }

    $conn->close();
}

// Return JSON response
echo json_encode($response);
?>
