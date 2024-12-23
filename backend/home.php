<?php
session_start(); // Start session to track login status
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <!-- Add Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Recipe Book Website</title>
</head>
<body>
    <!-- Header with Navigation -->
    <header>
        <h1>Welcome to Recipe Book</h1>
    </header>

    <!-- Navigation -->
    <nav>
        <div class="nav-menu">
            <ul class="desktop-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="../recipes.html">Recipes</a></li>
                <li><a href="../addRecipe.html">Add Recipe</a></li>
                <li><a href="../about.html">About Us</a></li>
                <li><a href="../contact.html">Contact Us</a></li>

                <?php if (isset($_SESSION['username'])): ?>
                    <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                    <li><a href="../user.php" class="profile-icon">
                        <i class="fas fa-user"></i> Profile
                    </a></li>
                    <li><a href="logout.php">Logout</a></li>
                    </a></li>
                <?php else: ?>
                    <li><a href="../login.html">Login</a></li>
                    <li><a href="../signup.html">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Main Section -->
    <main>
        <section class="headline">
            <?php if (isset($_SESSION['username'])): ?>
                <h1>Welcome Back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p>Start exploring your favorite recipes today!</p>
            <?php else: ?>
                <h1>Discover Delicious Recipes</h1>
                <p>Explore a variety of recipes made with love and care. Join us today!</p>
            <?php endif; ?>
            <div class="btn-container">
                <a href="../recipes.html" class="btn">Explore Recipes</a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Recipe Book Website. All rights reserved.</p>
        <p>Designed with ❤️ </p>
    </footer>
</body>
</html>