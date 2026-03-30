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

    <link rel="stylesheet" href="mystyles.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .header-banner {
            position: relative;
            width: 100%;
            height: 280px;/*Images height*/
            overflow: hidden;
        }

        .header-images {
            display: grid;
            grid-template-columns: repeat(9, 1fr);
            width: 100%;
            height: 100%;
        }

        .header-images img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.3);
        }
/*left side of header*/
        .header-left { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
        .header-left a, .header-left button {
            color: white;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 14px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            font-weight: 500;
            transition: 0.3s;
        }


        .site-title { font-size: 22px; font-weight: bold; }
        
        /*right side of header (login, sign up)*/
        .header-right { display: flex; gap: 10px; }
    </style>
</head>
<body>

<div class="header-banner">
    <div class="header-images">
        <img src="Logo-img/img1.jpg">
        <img src="Logo-img/img2.jpg">
        <img src="Logo-img/img3.jpg">
        <img src="Logo-img/img4.jpg">
        <img src="Logo-img/img5.jpg">
        <img src="Logo-img/img6.jpg">
        <img src="Logo-img/img7.jpg">
        <img src="Logo-img/img8.jpg">
        <img src="Logo-img/img9.jpg">
    </div>

    <div class="header-overlay">
        <div class="header-left">
            <a href="index.php" class="site-title">
                <i class="fas fa-flag-checkered"></i> Racing Wiki
            </a>
            <a href="search.php"><i class="fas fa-magnifying-glass"></i> Search</a>
            <a href="categories.php"><i class="fas fa-layer-group"></i> Categories</a>

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
        </div>

        <div class="header-right">
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <a href="profile.php" class="w3-button w3-green" style="border-radius:8px;">
                    <i class="fas fa-user"></i> Profile
                </a>
            <?php else: ?>
                <a href="signup.php" class="w3-button w3-green" style="border-radius:8px;">
                    <i class="fas fa-user-plus"></i> Sign Up
                </a>
                <a href="login.php" class="w3-button w3-white" style="border-radius:8px;">
                    <i class="fas fa-right-to-bracket"></i> Login
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="w3-container" style="max-width: 1600px; margin: 0 auto;">
