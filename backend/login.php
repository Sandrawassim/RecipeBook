<?php
// Include the database connection file
include 'db.php';

// Start session
session_start();

// Prepare response array
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve email and password from the request
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare SQL statement to check if the email exists
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    if (!$stmt) {
        $response['error'] = "Database error: " . $conn->error;
        echo json_encode($response);
        exit();
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the provided password
        if (password_verify($password, $row['password'])) {
            // Successful login
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $response['success'] = true;
        } else {
            // Invalid password
            $response['error'] = "Invalid password. Please try again.";
        }
    } else {
        // No user found
        $response['error'] = "No user found with this email address.";
    }

    $stmt->close();
} else {
    // Invalid request method
    $response['error'] = "Invalid request method.";
}

// Close the database connection
$conn->close();

// Return the JSON response
echo json_encode($response);
?>