<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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

// Include header (make sure header.php does not output before session_start)
include 'header.php';

// Get user ID from session
$user_id = $_SESSION['user_id'] ?? null;

// Use POST for sensitive data; fallback to GET if needed (adjust your form accordingly)
$display_name = $_POST['display_name'] ?? '';
$username = $_POST['username'] ?? '';
$bio = $_POST['bio'] ?? '';
$email = $_POST['email'] ?? '';
$new_pswd = $_POST['new_pswd'] ?? '';
$current_password = $_POST['password'] ?? '';

if ($current_password === '') {
    echo "<h1>Please enter your current password to confirm changes.</h1>";
    include 'footer.php';
    exit;
}

// Fetch current password hash and current profile data from DB
$stmt = $conn->prepare("SELECT display_name, username, bio, email, password_hash FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$current_data = $result->fetch_assoc();

if (!$current_data || !password_verify($current_password, $current_data['password_hash'])) {
    echo "<h1>The Password you entered was incorrect. Please return to the Profile page and try again.</h1>";
    include 'footer.php';
    exit;
}

// Track if any changes were made
$changes_made = false;

// Update display_name if changed and not empty
if ($display_name !== '' && $display_name !== $current_data['display_name']) {
    $stmt = $conn->prepare("UPDATE users SET display_name = ? WHERE id = ?");
    $stmt->bind_param('si', $display_name, $user_id);
    $stmt->execute();
    echo "<h2>Your Display Name has been updated.</h2>";
    $changes_made = true;
}

// Update username if changed and not empty
if ($username !== '' && $username !== $current_data['username']) {
    $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->bind_param('si', $username, $user_id);
    $stmt->execute();
    echo "<h2>Your Username has been updated.</h2>";
    $changes_made = true;
}

// Update bio if changed and not empty
if ($bio !== '' && $bio !== $current_data['bio']) {
    $stmt = $conn->prepare("UPDATE users SET bio = ? WHERE id = ?");
    $stmt->bind_param('si', $bio, $user_id);
    $stmt->execute();
    echo "<h2>Your Bio has been updated.</h2>";
    $changes_made = true;
}

// Update email if changed and not empty
if ($email !== '' && $email !== $current_data['email']) {
    $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
    $stmt->bind_param('si', $email, $user_id);
    $stmt->execute();
    echo "<h2>Your Email has been updated.</h2>";
    $changes_made = true;
}

// Update password if new password is provided
if ($new_pswd !== '') {
    $new_pswd_hash = password_hash($new_pswd, PASSWORD_DEFAULT);
    // Optionally, you can check if the new password hash differs from the old one,
    // but since password_hash uses a random salt, hashes will always differ.
    $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
    $stmt->bind_param('si', $new_pswd_hash, $user_id);
    $stmt->execute();
    echo "<h2>Your Password has been updated.</h2>";
    $changes_made = true;
}

if (!$changes_made) {
    echo "<h2>No information has been changed.</h2>";
}

$conn->close();

include 'footer.php';
?>
