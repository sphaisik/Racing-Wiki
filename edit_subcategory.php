<?php
include 'header.php';

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
    <style>
        /* Light, clean styling consistent with previous forms */
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            color: #222;
            padding: 20px;
            margin: 0;
        }
        h1 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
        }
        form {
            max-width: 600px;
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
            border: 1px solid #e2e8f0;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #444;
        }
        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 15px;
            color: #333;
            background: #fefefe;
            transition: border-color 0.3s ease;
            font-family: inherit;
            box-sizing: border-box;
        }
        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            border-color: #3b82f6;
            outline: none;
            background: #fff;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        button {
            margin-top: 25px;
            padding: 12px 20px;
            background-color: #3b82f6;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: inherit;
        }
        button:hover {
            background-color: #2563eb;
        }
        a {
            margin-left: 15px;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
            font-family: inherit;
        }
        a:hover {
            color: #2563eb;
            text-decoration: underline;
        }
        .error-message {
            max-width: 600px;
            margin-bottom: 20px;
            padding: 12px 16px;
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 6px;
            color: #b91c1c;
            font-weight: 600;
        }
        /* Checkbox label inline */
        label.checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
            font-weight: 600;
            color: #444;
        }
        input[type="checkbox"] {
            width: auto;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Edit Subcategory</h1>

<?php if (!empty($error)): ?>
    <div class="error-message"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="">
    <label for="name">Name *</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>

    <label for="slug">Slug *</label>
    <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($slug) ?>" required>

    <label for="description">Description</label>
    <textarea id="description" name="description"><?= htmlspecialchars($description) ?></textarea>

    <label for="category_id">Category *</label>
    <select id="category_id" name="category_id" required>
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $category_id ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label class="checkbox-label">
        <input type="checkbox" name="visible" <?= $visible ? 'checked' : '' ?>>
        Visible
    </label>

    <button type="submit">Save Changes</button>
    <a href="admin_dashboard.php">Cancel</a>
</form>

<?php include 'footer.php'; ?>

</body>
</html>
