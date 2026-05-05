<?php
include 'header.php';

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
    <style>
        /* Light, clean styling similar to add_category.php */
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
        textarea {
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
        }
        input[type="text"]:focus,
        textarea:focus {
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
    </style>
</head>
<body>

<h1>Edit Category</h1>

<?php if (!empty($error)): ?>
    <div class="error-message"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="">
    <label for="name">Name *</label>
    <input type="text" id="name" name="name" required value="<?= htmlspecialchars($name) ?>">

    <label for="description">Description</label>
    <textarea id="description" name="description"><?= htmlspecialchars($description) ?></textarea>

    <label>
        <input type="checkbox" name="visible" <?= $visible ? 'checked' : '' ?>>
        Visible
    </label>

    <button type="submit">Save Changes</button>
    <a href="admin_dashboard.php">Cancel</a>
</form>

<?php include 'footer.php'; ?>

</body>
</html>
