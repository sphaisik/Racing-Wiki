<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php include 'header.php'; ?>
    </head>
    <body class = form>
        <?php
        $username = $_GET['user'];
        $email = $_GET['email'];
        $password_hash = password_hash($_GET['password'], PASSWORD_DEFAULT);
        $role = 2; // role_id for registered user
        echo "<h2>Hello $username!</h2>";

// sql statement, adds values to  table
        $sql = "insert into users (id, username, email, password_hash, role_id) values (0, '$username', '$email', '$password_hash', '$role')";

// connect to the database
        require 'DBConnect.php';

// process sql command using PHP code with connection object.
        try {
            $conn->query($sql);
            echo "<h2>Registration successful.</h2>";
        } catch (Exception $ex) {
            echo "<h2>Update failed: " . $ex->getMessage() . "</h2>";
        }
        $conn->close();

        echo "Welcome! You may now log in."
        ?>
        
        <?php include 'footer.php'; ?> 
    </body>
</html>