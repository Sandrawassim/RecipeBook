<?php
session_start();
require 'backend/db.php'; // Include your database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("No user found for ID: " . $user_id);
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>User Profile</h1>
  </header>
  <main>
    <section class="profile-container">
      <div class="content">
        <h2>Edit Your Profile</h2>
        <form action="backend/user.php" method="POST">
          <div class="form-group">
            <label for="username">Name</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter new password (optional)">
          </div>
          <button type="submit" class="submit-btn">Save Changes</button>
        </form>
        <?php if (isset($_SESSION['success_message'])): ?>
          <p class="success"><?= htmlspecialchars($_SESSION['success_message']) ?></p>
          <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
      </div>
    </section>
  </main>
  <footer>
    <p>&copy; 2024 Recipe Book | <a href="#">Privacy Policy</a></p>
  </footer>
</body>
</html>