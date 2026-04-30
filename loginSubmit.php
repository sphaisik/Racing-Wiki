<html>
    <head>
        <meta charset="UTF-8">
        <?php include 'header.php'; ?>
    </head>
    <body class = form>
        <?php
        $username = $_GET['username'];
        $password_hash = $_GET['password'];

        $password = $_GET['password'];

        $sql = "SELECT id, username, password_hash FROM users WHERE username = ?";
        require 'db.php';

        if ($username === "" or $password === ""):
            echo "<h1>Please return to the Login form and fill in all fields.<h1>";

        else:
            try {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $username);
                //$username = $user;
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if (password_verify($password_hash, $row['password_hash'])) {
                        session_start();
                        $_SESSION['user'] = $row['username'];
                        $_SESSION['logged_in'] = true;
                        $_SESSION['user_id'] = $row['id'];
                        header("Location:index.php");
                    } else {
                        echo "<h1>Login failed, please go back and try again.<h1>";
                    }
                } else {
                    echo "<h1>Login failed, please go back and try again.<h1>";
                }
                $conn->close();
            } catch (Exception $ex) {
                $conn->close();
                header("Location:error.php?error=" . $ex->getMessage());
            }
        endif;
        ?>
    </body>
</html>
<?php include 'footer.php'; ?> 