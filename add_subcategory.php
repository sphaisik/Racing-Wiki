<?php
include 'header.php';

$mysqli = new mysqli('localhost', 'root', '', 'racing_wiki');
if ($mysqli->connect_error) {
    die('Database connection error: ' . $mysqli->connect_error);
}

$message = '';
$categories = [];

// Fetch categories for dropdown
$cat_result = $mysqli->query("SELECT id, name FROM categories ORDER BY name ASC");
while ($row = $cat_result->fetch_assoc()) {
    $categories[] = $row;
}

$name = '';
$slug = '';
$category_id = 0;
$description = '';
$visible = 1;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $visible = isset($_POST['visible']) ? 1 : 0;

    // Basic validation
    if ($name === '' || $slug === '' || $category_id <= 0) {
        $message = 'Name, Slug, and Category are required.';
    } else {
        // Optional: Auto-generate slug if empty
        if ($slug === '') {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        }

        // Check slug uniqueness
        $slug_check_stmt = $mysqli->prepare("SELECT COUNT(*) FROM subcategories WHERE slug = ?");
        $slug_check_stmt->bind_param('s', $slug);
        $slug_check_stmt->execute();
        $slug_check_stmt->bind_result($slug_count);
        $slug_check_stmt->fetch();
        $slug_check_stmt->close();

        if ($slug_count > 0) {
            $message = 'Slug already exists. Please choose a different slug.';
        } else {
            // Insert new subcategory
            $stmt = $mysqli->prepare("INSERT INTO subcategories (name, slug, category_id, description, visible) VALUES (?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param('ssisi', $name, $slug, $category_id, $description, $visible);
                if ($stmt->execute()) {
                    $message = 'Subcategory added successfully.';
                    // Clear form fields after success
                    $name = $slug = $description = '';
                    $category_id = 0;
                    $visible = 1;
                } else {
                    $message = 'Database error: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $message = 'Database prepare error: ' . $mysqli->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Subcategory</title>
    <style>
        /* Light, clean styling */
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
        .message {
            max-width: 600px;
            margin-bottom: 20px;
            padding: 12px 16px;
            background-color: #e0f2fe;
            border: 1px solid #bae6fd;
            border-radius: 6px;
            color: #0369a1;
            font-weight: 600;
        }
        a.back-link {
            display: inline-block;
            margin-top: 20px;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        a.back-link:hover {
            color: #2563eb;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Add New Subcategory</h1>

<?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="post" action="add_subcategory.php">
    <label for="name">Name *</label>
    <input type="text" id="name" name="name" required value="<?= htmlspecialchars($name) ?>">

    <label for="slug">Slug *</label>
    <input type="text" id="slug" name="slug" required value="<?= htmlspecialchars($slug) ?>">

    <label for="category_id">Category *</label>
    <select id="category_id" name="category_id" required>
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $category_id ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="description">Description</label>
    <textarea id="description" name="description"><?= htmlspecialchars($description) ?></textarea>

    <label>
        <input type="checkbox" name="visible" value="1" <?= $visible ? 'checked' : '' ?>>
        Visible
    </label>

    <button type="submit">Add Subcategory</button>
</form>

<a href="admin_dashboard.php" class="back-link">&larr; Back to Admin Dashboard</a>

<?php include 'footer.php'; ?>

</body>
</html>
