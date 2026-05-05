<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';

if ($username === "" || $password === "") {
    // No output before header redirect, so just show message and exit
    echo "<h1>Please return to the Login form and fill in all fields.</h1>";
    exit;
}

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

// Prepare SQL
$sql = "SELECT id, username, password_hash, role_id FROM users WHERE username = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password_hash'])) {
        // Set session variables
        $_SESSION['user'] = $row['username'];
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role_id'];

        // Redirect before any output
        header("Location: index.php");
        exit;
    } else {
        echo "<h1>Login failed, please go back and try again.</h1>";
        exit;
    }
} else {
    echo "<h1>Login failed, please go back and try again.</h1>";
    exit;
}

$stmt->close();
$conn->close();
?>
