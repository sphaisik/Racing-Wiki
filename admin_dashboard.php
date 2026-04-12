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

// Fetch categories without 'visible'
$categories = [];
$cat_result = $mysqli->query("SELECT id, name FROM categories ORDER BY id ASC");
while ($row = $cat_result->fetch_assoc()) {
    $categories[] = $row;
}

// Fetch subcategories without 'visible'
$subcategories = [];
$sub_result = $mysqli->query("
    SELECT s.id, s.name, s.slug, c.name AS category_name 
    FROM subcategories s
    JOIN categories c ON s.category_id = c.id
    ORDER BY c.name ASC, s.name ASC
");
while ($row = $sub_result->fetch_assoc()) {
    $subcategories[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard - Manage Categories & Subcategories</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #121212;
            color: #eee;
            padding: 20px;
        }
        a.add-new {
            display: inline-block;
            margin-bottom: 10px;
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a.add-new:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #222;
        }
        tr:nth-child(even) {
            background-color: #1a1a1a;
        }
        a {
            color: #66aaff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Admin Dashboard</h1>

<section>
    <h2>Categories</h2>
    <a href="add_category.php" class="add-new">+ Add New Category</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Visible</th> <!-- Kept for layout, but no data -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= htmlspecialchars($cat['id']) ?></td>
                        <td><?= htmlspecialchars($cat['name']) ?></td>
                        <td>—</td> <!-- No visibility info available -->
                        <td>
                            <a href="edit_category.php?id=<?= $cat['id'] ?>">Edit</a> |
                            <a href="delete_category.php?id=<?= $cat['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">No categories found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<section>
    <h2>Subcategories</h2>
    <a href="add_subcategory.php" class="add-new">+ Add New Subcategory</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Category</th>
                <th>Visible</th> <!-- Kept for layout, but no data -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($subcategories)): ?>
                <?php foreach ($subcategories as $sub): ?>
                    <tr>
                        <td><?= htmlspecialchars($sub['id']) ?></td>
                        <td><?= htmlspecialchars($sub['name']) ?></td>
                        <td><?= htmlspecialchars($sub['slug']) ?></td>
                        <td><?= htmlspecialchars($sub['category_name']) ?></td>
                        <td>—</td> <!-- No visibility info available -->
                        <td>
                            <a href="edit_subcategory.php?id=<?= $sub['id'] ?>">Edit</a> |
                            <a href="delete_subcategory.php?id=<?= $sub['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No subcategories found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

</body>
</html>