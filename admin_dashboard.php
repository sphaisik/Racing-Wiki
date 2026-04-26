<?php
include 'header.php';

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

// Fetch categories including 'visible'
$categories = [];
$cat_result = $mysqli->query("SELECT id, name, visible FROM categories ORDER BY id ASC");
while ($row = $cat_result->fetch_assoc()) {
    $categories[] = $row;
}

// Fetch subcategories including 'visible', ordered by subcategory id
$subcategories = [];
$sub_result = $mysqli->query("
    SELECT s.id, s.name, s.slug, s.visible, c.name AS category_name 
    FROM subcategories s
    JOIN categories c ON s.category_id = c.id
    ORDER BY s.id ASC
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
        /* Reset and base */
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #222;
            margin-bottom: 10px;
        }
        a.add-new {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 18px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        a.add-new:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            margin-bottom: 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
        }
        thead tr {
            background-color: #007bff;
            color: white;
            border-radius: 8px 8px 0 0;
        }
        thead th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }
        tbody tr {
            background: #fafafa;
            transition: background-color 0.2s ease;
            border-radius: 6px;
        }
        tbody tr:hover {
            background-color: #e6f0ff;
        }
        tbody td {
            padding: 12px 15px;
            font-size: 14px;
            vertical-align: middle;
        }
        tbody tr td:first-child {
            border-radius: 6px 0 0 6px;
        }
        tbody tr td:last-child {
            border-radius: 0 6px 6px 0;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
            margin-right: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        /* Responsive */
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                display: none;
            }
            tbody tr {
                margin-bottom: 20px;
                box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
                border-radius: 8px;
                background: white;
                padding: 15px;
            }
            tbody td {
                padding-left: 50%;
                position: relative;
                text-align: right;
                font-size: 13px;
            }
            tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                top: 12px;
                font-weight: 600;
                text-align: left;
                color: #555;
                font-size: 13px;
            }
            tbody tr td:first-child {
                border-radius: 8px 8px 0 0;
            }
            tbody tr td:last-child {
                border-radius: 0 0 8px 8px;
            }
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
                <th>Visible</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td data-label="ID"><?= htmlspecialchars($cat['id']) ?></td>
                        <td data-label="Name"><?= htmlspecialchars($cat['name']) ?></td>
                        <td data-label="Visible"><?= $cat['visible'] ? 'Visible' : 'Hidden' ?></td>
                        <td data-label="Actions">
                            <a href="edit_category.php?id=<?= $cat['id'] ?>">Edit</a>
                            <a href="delete_category.php?id=<?= $cat['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
                            <a href="toggle_visibility.php?type=category&id=<?= $cat['id'] ?>">
                                <?= $cat['visible'] ? 'Hide' : 'Show' ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center;">No categories found.</td></tr>
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
                <th>Visible</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($subcategories)): ?>
                <?php foreach ($subcategories as $sub): ?>
                    <tr>
                        <td data-label="ID"><?= htmlspecialchars($sub['id']) ?></td>
                        <td data-label="Name"><?= htmlspecialchars($sub['name']) ?></td>
                        <td data-label="Slug"><?= htmlspecialchars($sub['slug']) ?></td>
                        <td data-label="Category"><?= htmlspecialchars($sub['category_name']) ?></td>
                        <td data-label="Visible"><?= $sub['visible'] ? 'Visible' : 'Hidden' ?></td>
                        <td data-label="Actions">
                            <a href="edit_subcategory.php?id=<?= $sub['id'] ?>">Edit</a>
                            <a href="delete_subcategory.php?id=<?= $sub['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
                            <a href="toggle_visibility.php?type=subcategory&id=<?= $sub['id'] ?>">
                                <?= $sub['visible'] ? 'Hide' : 'Show' ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">No subcategories found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

</body>
</html>
