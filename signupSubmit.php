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

        $password = $_GET['password'];
        $chk_pswd = $_GET['chk_pswd'];

        if ($username === "" or $email === "" or $password === "" or $chk_pswd === ""):
            echo "<h2>Please return to the Sign Up form and fill in all fields.<h2>";

        elseif ($password !== $chk_pswd):
            echo "<h2>Please return to the Sign Up form and make sure your password confirmation matches.<h2>";

        else:
            // sql statement, adds values to  table
            $sql = "insert into users (id, username, email, password_hash, role_id) values (0, '$username', '$email', '$password_hash', '$role')";

            // connect to the database
            require 'DBConnect.php';

            // process sql command using PHP code with connection object.
            try {
                $conn->query($sql);
                echo "<h2>Registration successful.</h2>";
                echo "<h2>Hello $username!</h2>";
                echo "<h2>Welcome, you may now log in.<h2>";
            } catch (Exception $ex) {
                echo "<h2>Update failed: " . $ex->getMessage() . "</h2>";
            }
            $conn->close();

        endif;
        ?>


    </body>
</html>
<?php include 'footer.php'; ?> 