<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';
header('Content-Type: application/json'); // Ensure JSON response header

$response = ["success" => false, "message" => ""]; // Default response

// Start output buffering to prevent any unexpected output
ob_start();

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? null;
        $ingredients = $_POST['ingredients'] ?? null;
        $directions = $_POST['directions'] ?? null;

        // Handle file upload
        $image = $_FILES['image']['name'] ?? null;
        $image_tmp = $_FILES['image']['tmp_name'] ?? null;
        $image_folder = '..\backend\uploads' . $image;

        if (!$image || !$image_tmp) {
            throw new Exception("Image upload error");
        }

        if (!move_uploaded_file($image_tmp, $image_folder)) {
            throw new Exception("Failed to upload image.");
        }

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO recipes (title, description, ingredients, directions, image) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Database prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssss", $title, $description, $ingredients, $directions, $image_folder);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Recipe added successfully!";
        } else {
            throw new Exception("Database error: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();
    }
} catch (Exception $e) {
    // Log any exception and return a friendly error message
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

// End output buffering and clean unexpected output
ob_end_clean();
echo json_encode($response); // Ensure clean JSON output
exit;
?>
