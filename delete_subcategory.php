<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit('Access denied');
}

$mysqli = new mysqli('localhost', 'root', '', 'racing_wiki');
if ($mysqli->connect_error) {
    die('Database connection error: ' . $mysqli->connect_error);
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    die('Invalid subcategory ID');
}

// Confirm deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        $stmt = $mysqli->prepare("DELETE FROM subcategories WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: admin_dashboard.php?msg=Subcategory deleted");
            exit;
        } else {
            $error = "Failed to delete subcategory: " . $stmt->error;
        }
        $stmt->close();
    } else {
        header("Location: admin_dashboard.php");
        exit;
    }
}

// Fetch subcategory name for confirmation message
$stmt = $mysqli->prepare("SELECT name FROM subcategories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name);
if (!$stmt->fetch()) {
    die('Subcategory not found');
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Subcategory</title>
</head>
<body>
    <h1>Delete Subcategory</h1>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <p>Are you sure you want to delete the subcategory "<strong><?= htmlspecialchars($name) ?></strong>"?</p>
    <form method="post" action="">
        <button type="submit" name="confirm" value="yes">Yes, Delete</button>
        <button type="submit" name="confirm" value="no">Cancel</button>
    </form>
</body>
</html>
