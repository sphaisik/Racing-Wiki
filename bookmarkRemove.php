<?php
include 'header.php';

// Database connection parameters
$host = 'localhost';
$db   = 'racing_wiki';
$user = 'root';
$pass = '';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

if (!isset($_POST['bookmark_id'])) {
    die("Invalid request");
}

$user_id = $_SESSION['user_id'];
$bookmark_id = (int)$_POST['bookmark_id'];

/* Critical: ensure user owns the bookmark */
$stmt = $conn->prepare("DELETE FROM bookmarks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $bookmark_id, $user_id);
$stmt->execute();

header("Location: bookmarks.php");
exit();
?>
