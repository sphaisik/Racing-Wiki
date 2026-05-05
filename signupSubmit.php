<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
</head>
<body class="form">
<?php
$username = $_GET['user'] ?? '';
$email = $_GET['email'] ?? '';
$password = $_GET['password'] ?? '';
$chk_pswd = $_GET['chk_pswd'] ?? '';

// Role ID for 'registered' users from your roles table
$registered_role_id = 2;

if ($username === "" || $email === "" || $password === "" || $chk_pswd === ""):
    echo "<h2>Please return to the Sign Up form and fill in all fields.<h2>";

elseif ($password !== $chk_pswd):
    echo "<h2>Please return to the Sign Up form and make sure your password confirmation matches.<h2>";

else:
    // Hash the password securely
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

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

    // Prepare SQL statement
    $sql = "INSERT INTO users (username, email, password_hash, role_id) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param('sssi', $username, $email, $password_hash, $registered_role_id);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    } else {
        echo "<h2>Registration successful.</h2>";
        echo "<h2>Hello " . htmlspecialchars($username) . "!</h2>";
        echo "<h2>Welcome, you may now log in.</h2>";
    }

    $stmt->close();
    $conn->close();

endif;
?>
</body>
</html>
<?php include 'footer.php'; ?>
