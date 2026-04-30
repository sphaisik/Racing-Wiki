<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php
        include 'header.php';
        require 'db.php'
        ?>
    </head>
    <body class = form>
        <?php
        $user_id = $_SESSION['user_id'];

        $display_name = $_GET['display_name'];
        $username = $_GET['username'];
        $bio = $_GET['bio'];
        $email = $_GET['email'];
        $new_pswd = $_GET['new_pswd'];
        

        $new_pswd_hash = password_hash($_GET['new_pswd'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!password_verify($_GET['password'], $row['password_hash'])):
            echo "<h1>The Password you entered was incorrect. Please Return to the Profile page and try again.</h1>";

        elseif ($display_name === "" and $username === "" and $bio === "" and $email === "" and $new_pswd === ""):
            echo "<h2>No information has been changed.<h2>";

        else:
            if ($display_name !== ""):
                $stmt = $conn->prepare("UPDATE users SET display_name = ? WHERE id = ?");
                $stmt->bind_param('si', $display_name, $user_id);
                $stmt->execute();
                echo "<h2>Your Display Name has been updated.</h2>";
            endif;
            if ($username !== ""):
                $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
                $stmt->bind_param('si', $username, $user_id);
                $stmt->execute();
                echo "<h2>Your Userame has been updated.</h2>";
            endif;
            if ($bio !== ""):
                $stmt = $conn->prepare("UPDATE users SET bio = ? WHERE id = ?");
                $stmt->bind_param('si', $bio, $user_id);
                $stmt->execute();
                echo "<h2>Your Bio has been updated.</h2>";
            endif;
            if ($email !== ""):
                $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
                $stmt->bind_param('si', $email, $user_id);
                $stmt->execute();
                echo "<h2>Your Email has been updated.</h2>";
            endif;
            if ($new_pswd !== ""):
                $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $stmt->bind_param('si', $new_pswd_hash, $user_id);
                $stmt->execute();
                echo "<h2>Your Password has been updated.</h2>";
            endif;
            $conn->close();
        endif;
        ?>
    </body>
</html>
<?php include 'footer.php'; ?> 