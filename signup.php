<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php include "header.php" ?>
    </head>
    <body>
        <section class="w3-panel w3-padding-16 w3-round-large w3-card"
                 style="margin-top: 18px;
                 background: linear-gradient(135deg, rgba(0,128,128,.18), rgba(0,0,0,.06));
                 border: 1px solid rgba(0,0,0,.08);">
            <form action="signupSubmit.php" class="form w3-container w3-margin">
                <h1 style="margin: 0 0 10px; font-weight: 800; letter-spacing: -0.02em;">
                Sign Up
                </h1>

                <!-- Username -->
                <div class="w3-row w3-section">
                    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user" style="color:#009688"></i></div>
                    <div class="w3-rest">
                        <input class="w3-input w3-border" name="user" type="text" placeholder="Username">
                    </div>
                </div>

                <!-- Email -->
                <div class="w3-row w3-section">
                    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope" style="color:#009688"></i></div>
                    <div class="w3-rest">
                        <input class="w3-input w3-border" name="email" type="text" placeholder="Email">
                    </div>
                </div>

                <!-- Password -->
                <div class="w3-row w3-section">
                    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-asterisk" style="color:#009688"></i></div>
                    <div class="w3-rest">
                        <input class="w3-input w3-border" name="password" type="text" placeholder="Password">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="w3-row w3-section">
                    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-asterisk" style="color:#009688"></i></div>
                    <div class="w3-rest">
                        <input class="w3-input w3-border" name="chk_pswd" type="text" placeholder="Confirm Password">
                    </div>
                </div>

                <button class="w3-button w3-block w3-section w3-teal w3-ripple w3-padding">Submit</button>


            </form>
        </section>

        <section class="w3-panel w3-padding-8 w3-round-large w3-card"
         style="margin-top: 18px;
                background: linear-gradient(135deg, rgba(0,128,128,.18), rgba(0,0,0,.06));
                border: 1px solid rgba(0,0,0,.08);">
        <form action="signup.php" class="w3-container w3-text-blue w3-margin form">
            <button class="w3-button w3-block w3-section w3-teal w3-ripple w3-padding">Reset</button>
        </form>
        </section>
        <?php include 'footer.php'; ?>
    </body>
</html>