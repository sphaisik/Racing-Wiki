<?php
session_start();
/*
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit('Access denied');
}
*/

$mysqli = new mysqli('localhost', 'root', '', 'racing_wiki');
if ($mysqli->connect_error) {
    die('Database connection error: ' . $mysqli->connect_error);
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    die('Invalid category ID');
}

// Confirm deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        // Optional: Delete subcategories first or set them hidden
        $stmt = $mysqli->prepare("DELETE FROM subcategories WHERE category_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Delete category
        $stmt = $mysqli->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: admin_dashboard.php?msg=Category deleted");
            exit;
        } else {
            $error = "Failed to delete category: " . $stmt->error;
        }
        $stmt->close();
    } else {
        header("Location: admin_dashboard.php");
        exit;
    }
}

// Fetch category name for confirmation message
$stmt = $mysqli->prepare("SELECT name FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name);
if (!$stmt->fetch()) {
    die('Category not found');
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Category</title>
</head>
<body>
    <h1>Delete Category</h1>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <p>Are you sure you want to delete the category "<strong><?= htmlspecialchars($name) ?></strong>" and all its subcategories?</p>
    <form method="post" action="">
        <button type="submit" name="confirm" value="yes">Yes, Delete</button>
        <button type="submit" name="confirm" value="no">Cancel</button>
    </form>
</body>
</html>
