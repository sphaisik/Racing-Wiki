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
        require 'DBConnect.php';

        if ($username === "" or $password === ""):
            echo "<h2>Please return to the Login form and fill in all fields.<h2>";

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
                        header("Location:error.php?error=Login failed, please go back and try again.");
                    }
                } else {
                    header("Location:error.php?error=Login failed, please go back and try again.");
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