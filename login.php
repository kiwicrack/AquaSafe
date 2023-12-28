<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqua Safe.</title>
    <link href="aquasafe.css" rel="stylesheet">
    <link rel="shortcut icon" href="Images/logo_nav.png" type="image/x-icon">

    <style>
        body{
            overflow-y: scroll;
            padding: 50px 0;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="form-container">
            
            <div class="form-nav">
            <h2><a href="index.html" class="closebutton">X</a>LOGIN PAGE.</h2>
            <hr> 

            </div>

            <form class="login-form" action="login.php" method="post">
                
                <?php include('errors.php'); ?> 
                <label for="username">Username*</label>
                
                <div class="form-group">                    
                    <img src="icon/people.png" alt="People">
                    <input type="text" id="username" name="login_username" placeholder="Username">
                    
                </div>
                
                
                <label for="password">Password*</label>
                
                <div class="form-group">                    
                    <img src="icon/Lock.png" alt="Lock"> 
                    <input type="password" id="password" name="login_password" placeholder="Password">
                    <a href="forgetpassword.php"><p7 style="color: #A09D98; font-size: small;"><span style="font-weight: 100;">|</span >Forgot?</p7></a>
                </div>

                    <button type="submit" class="login-button" name="login_user" style="margin-top:5em;">LOGIN NOW</button>

            </form>

            <div class="signup-link">
                <p>Don't have an account?</p>
                <a href="register.php">Sign up</a>
            </div>

            <hr>  <!-- Bold: Updated selector to target hr inside .form-container -->
        </div>


        <div class="image-container"></div>
    </div>
</body>
</html>
