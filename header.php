<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Racing Wiki</title>

    <!-- Local styles (recommended in NetBeans project root /assets or same folder) -->
    <link rel="stylesheet" href="mystyles.css">

    <!-- Libraries (as requested in your format) -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<!-- Top bar -->
<div class="w3-bar w3-teal w3-card">
    <a href="index.php" class="w3-bar-item w3-button w3-mobile">
        <i class="fas fa-flag-checkered"></i> Racing Wiki
    </a>

    <a href="search.php" class="w3-bar-item w3-button w3-mobile">
        <i class="fas fa-magnifying-glass"></i> Search
    </a>

    <a href="categories.php" class="w3-bar-item w3-button w3-mobile">
        <i class="fas fa-layer-group"></i> Categories
    </a>

    <div class="w3-dropdown-hover w3-mobile">
        <button class="w3-button">
            About <i class="fa fa-caret-down"></i>
        </button>
        <div class="w3-dropdown-content w3-bar-block w3-dark-grey" style="min-width: 320px;">
            <span class="w3-bar-item w3-text-white" style="white-space: normal; line-height: 1.25;">
                Racing Wiki is a community site for learning about race series, events, drivers, and history.
                Search pages, browse categories, bookmark favorites, and discuss with comments.
            </span>
        </div>
    </div>

    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <a href="profile.php" class="w3-bar-item w3-button w3-green w3-right" style="margin-right: 5px;">Profile</a>
        <?php else: ?>
            <a href="signup.php" class="w3-bar-item w3-button w3-green w3-right w3-mobile">
            <i class="fas fa-user-plus"></i> Sign Up
        </a>
        <a href="login.php" class="w3-bar-item w3-button w3-right w3-mobile">
            <i class="fas fa-right-to-bracket"></i> Login
        </a>
        <?php endif; ?>
</div>

<!-- Page container -->
<div class="w3-container" style="max-width: 1100px; margin: 0 auto;">
