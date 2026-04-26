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
    die('Invalid subcategory ID');
}

// Fetch categories for dropdown
$categories = [];
$cat_result = $mysqli->query("SELECT id, name FROM categories WHERE visible = 1 ORDER BY name ASC");
while ($row = $cat_result->fetch_assoc()) {
    $categories[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $visible = isset($_POST['visible']) ? 1 : 0;

    if ($name === '' || $slug === '' || $category_id <= 0) {
        $error = "Please fill in all required fields.";
    } else {
        $stmt = $mysqli->prepare("UPDATE subcategories SET name = ?, description = ?, slug = ?, category_id = ?, visible = ? WHERE id = ?");
        $stmt->bind_param("sssiii", $name, $description, $slug, $category_id, $visible, $id);
        if ($stmt->execute()) {
            header("Location: admin_dashboard.php?msg=Subcategory updated");
            exit;
        } else {
            $error = "Database update failed: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch current subcategory data
$stmt = $mysqli->prepare("SELECT name, description, slug, category_id, visible FROM subcategories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $description, $slug, $category_id, $visible);
if (!$stmt->fetch()) {
    die('Subcategory not found');
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Subcategory</title>
</head>
<body>
    <h1>Edit Subcategory</h1>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label>
            Name:<br>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>
        </label><br><br>
        <label>
            Slug:<br>
            <input type="text" name="slug" value="<?= htmlspecialchars($slug) ?>" required>
        </label><br><br>
        <label>
            Description:<br>
            <textarea name="description" rows="5" cols="50"><?= htmlspecialchars($description) ?></textarea>
        </label><br><br>
        <label>
            Category:<br>
            <select name="category_id" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $category_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
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
