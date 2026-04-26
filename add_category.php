<?php
session_start();

// Temporarily disable login check to allow access without login
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

$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');

    // Basic validation
    if ($name === '' || $slug === '') {
        $message = 'Name and Slug are required.';
    } else {
        // Prepare and bind
        $stmt = $mysqli->prepare("INSERT INTO categories (name, slug, description, image) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('ssss', $name, $slug, $description, $image);
            if ($stmt->execute()) {
                $message = 'Category added successfully.';
                // Clear form fields after success
                $name = $slug = $description = $image = '';
            } else {
                $message = 'Database error: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = 'Database prepare error: ' . $mysqli->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Category</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #121212;
            color: #eee;
            padding: 20px;
        }
        form {
            max-width: 600px;
            background: #222;
            padding: 20px;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            border: none;
            border-radius: 4px;
            background: #333;
            color: #eee;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        button {
            margin-top: 20px;
            padding: 10px 16px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #444;
            border-radius: 4px;
        }
        a.back-link {
            display: inline-block;
            margin-top: 20px;
            color: #66aaff;
            text-decoration: none;
        }
        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Add New Category</h1>

<?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="post" action="add_category.php">
    <label for="name">Name *</label>
    <input type="text" id="name" name="name" required value="<?= htmlspecialchars($name ?? '') ?>">

    <label for="slug">Slug *</label>
    <input type="text" id="slug" name="slug" required value="<?= htmlspecialchars($slug ?? '') ?>">

    <label for="description">Description</label>
    <textarea id="description" name="description"><?= htmlspecialchars($description ?? '') ?></textarea>

    <label for="image">Image URL or Path</label>
    <input type="text" id="image" name="image" value="<?= htmlspecialchars($image ?? '') ?>">

    <button type="submit">Add Category</button>
</form>

<a href="admin_dashboard.php" class="back-link">&larr; Back to Admin Dashboard</a>

</body>
</html>
