<!DOCTYPE html>
<?php
include "header.php";
require 'db.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT username, email, role_id, display_name, bio, created_at, updated_at FROM users WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$users = $stmt->get_result()->fetch_assoc();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="w3-row">
            <div class="w3-half" style="padding-right:25px">
                <section class="w3-panel w3-padding-16 w3-round-large w3-card"
                         style="margin-top: 18px;
                         background: linear-gradient(135deg, rgba(0,128,128,.18), rgba(0,0,0,.06));
                         border: 1px solid rgba(0,0,0,.08);">
                    <h1 style="margin: 0 0 10px; font-weight: 800; letter-spacing: -0.02em;">
                        Profile Info:
                    </h1>

                    <div class="w3-row w3-section"> 
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user" style="color:#009688"></i></div>
                        <div class="w3-rest" style="font-size: 25px; margin: 0 0 10px; font-weight: 600; letter-spacing: -0.02em;">
                            Display Name: <?php echo htmlspecialchars($users['display_name']); ?>
                        </div>
                    </div>
                    <div class="w3-row w3-section"> 
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user" style="color:#009688"></i></div>
                        <div class="w3-rest" style="font-size: 25px; margin: 0 0 10px; font-weight: 600; letter-spacing: -0.02em;">
                            Username: <?php echo htmlspecialchars($users['username']); ?>
                        </div>
                    </div>
                    <div class="w3-row w3-section"> 
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-pencil" style="color:#009688"></i></div>
                        <div class="w3-rest" style="font-size: 25px; margin: 0 0 10px; font-weight: 600; letter-spacing: -0.02em;">
                            Bio: <?php echo htmlspecialchars($users['bio']); ?>
                        </div>
                    </div>
                    <div class="w3-row w3-section"> 
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope" style="color:#009688"></i></div>
                        <div class="w3-rest" style="font-size: 25px; margin: 0 0 10px; font-weight: 600; letter-spacing: -0.02em;">
                            Email: <?php echo htmlspecialchars($users['email']); ?>
                        </div>
                    </div>
                    <div class="w3-row w3-section"> 
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-calendar" style="color:#009688"></i></div>
                        <div class="w3-rest" style="font-size: 25px; margin: 0 0 10px; font-weight: 600; letter-spacing: -0.02em;">
                            Created: <?php echo htmlspecialchars($users['created_at']); ?>
                        </div>
                    </div>
                    <div class="w3-row w3-section"> 
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-clock" style="color:#009688"></i></div>
                        <div class="w3-rest" style="font-size: 25px; margin: 0 0 10px; font-weight: 600; letter-spacing: -0.02em;">
                            Updated: <?php echo htmlspecialchars($users['updated_at']); ?>
                        </div>
                    </div>
            </div>

            <div class="w3-half" style="padding-left:25px">
                <section class="w3-panel w3-padding-16 w3-round-large w3-card"
                         style="margin-top: 18px;
                         background: linear-gradient(135deg, rgba(0,128,128,.18), rgba(0,0,0,.06));
                         border: 1px solid rgba(0,0,0,.08);">
                    <form action="profileSubmit.php" class="form w3-container w3-margin">
                        <h1 style="margin: 0 0 10px; font-weight: 800; letter-spacing: -0.02em;">
                            Edit Info:
                        </h1>

                        <div class="w3-row w3-section"> 
                            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user" style="color:#009688"></i></div>
                            <div class="w3-rest">
                                <input class="w3-input w3-border" name="display_name" type="text" placeholder="Change Display Name">
                            </div>
                        </div>

                        <div class="w3-row w3-section"> 
                            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user" style="color:#009688"></i></div>
                            <div class="w3-rest">
                                <input class="w3-input w3-border" name="username" type="text" placeholder="Change Username">
                            </div>
                        </div>

                        <div class="w3-row w3-section"> 
                            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-pencil" style="color:#009688"></i></div>
                            <div class="w3-rest">
                                <input class="w3-input w3-border" name="bio" type="text" placeholder="Change Bio">
                            </div>
                        </div>

                        <div class="w3-row w3-section"> 
                            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope" style="color:#009688"></i></div>
                            <div class="w3-rest">
                                <input class="w3-input w3-border" name="email" type="text" placeholder="Change Email">
                            </div>
                        </div>

                        <div class="w3-row w3-section"> 
                            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-asterisk" style="color:#009688"></i></div>
                            <div class="w3-rest">
                                <input class="w3-input w3-border" name="new_pswd" type="text" placeholder="Change Password">
                            </div>
                        </div>
                        
                        <div class="w3-row w3-section"> 
                            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-asterisk" style="color:#009688"></i></div>
                            <div class="w3-rest">
                                <input class="w3-input w3-border" name="password" type="text" placeholder="Enter Current Password to Submit">
                            </div>
                        </div>

                        <button class="w3-button w3-block w3-section w3-teal w3-ripple w3-padding">Submit</button>
                    </form>
                </section>
            </div>
        </div>

        <!--
        <form action="xChange.php" class="form w3-container w3-margin">
            
        <!-- Change Username -- >
        <div class="w3-row w3-section"> 
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-X" style="color:#009688"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="username" type="text" placeholder="X">
            </div>
        </div>
        <button class="w3-button w3-block w3-section w3-teal w3-ripple w3-padding">Update</button>
    </form> 
        -->

    </section>
</html>
<?php include 'footer.php'; ?>