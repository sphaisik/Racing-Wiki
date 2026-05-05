<?php

$mysqli = new mysqli('localhost', 'root', '', 'racing_wiki');
if ($mysqli->connect_error) {
    die('Database connection error: ' . $mysqli->connect_error);
}

$type = $_GET['type'] ?? '';
$id = (int)($_GET['id'] ?? 0);

if (!in_array($type, ['category', 'subcategory']) || $id <= 0) {
    die('Invalid parameters.');
}

$table = $type === 'category' ? 'categories' : 'subcategories';

// Get current visibility
$stmt = $mysqli->prepare("SELECT visible FROM $table WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($visible);
if (!$stmt->fetch()) {
    $stmt->close();
    die('Record not found.');
}
$stmt->close();

// Toggle visibility
$new_visible = $visible ? 0 : 1;

$stmt = $mysqli->prepare("UPDATE $table SET visible = ? WHERE id = ?");
$stmt->bind_param('ii', $new_visible, $id);
$stmt->execute();
$stmt->close();

// Redirect back to admin dashboard
header('Location: admin_dashboard.php');
exit;
