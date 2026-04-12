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
    die('Invalid category ID');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $visible = isset($_POST['visible']) ? 1 : 0;

    if ($name === '') {
        $error = "Category name cannot be empty.";
    } else {
        $stmt = $mysqli->prepare("UPDATE categories SET name = ?, description = ?, visible = ? WHERE id = ?");
        $stmt->bind_param("ssii", $name, $description, $visible, $id);
        if ($stmt->execute()) {
            header("Location: admin_dashboard.php?msg=Category updated");
            exit;
        } else {
            $error = "Database update failed: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch current category data
$stmt = $mysqli->prepare("SELECT name, description, visible FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $description, $visible);
if (!$stmt->fetch()) {
    die('Category not found');
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Category</title>
</head>
<body>
    <h1>Edit Category</h1>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label>
            Name:<br>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>
        </label><br><br>
        <label>
            Description:<br>
            <textarea name="description" rows="5" cols="50"><?= htmlspecialchars($description) ?></textarea>
        </label><br><br>
        <label>
            Visible:
            <input type="checkbox" name="visible" <?= $visible ? 'checked' : '' ?>>
        </label><br><br>
        <button type="submit">Save Changes</button>
        <a href="admin_dashboard.php">Cancel</a>
    </form>
</body>
</html>
