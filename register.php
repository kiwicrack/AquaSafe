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
    <div class="register-container">
        <div class="form-container">
            
            <div class="form-nav">
            <h2><a href="login.php" class="closebutton">X</a>REGISTER PAGE.</h2>
            <hr>  <!-- Bold: Updated selector to target hr inside .form-nav -->

            </div>

            <form class="login-form" action="register.php" method="post"> 
            <?php include('errors.php'); ?> 
                <label for="username">Username*</label>
                <div class="form-group">                    
                    <img src="icon/people.png" alt="People">
                    <input type="text" id="username" name="rgs_usr_username" placeholder="Username">
                </div>
                
               
                <label for="e-mail">E-mail*</label>
                
                <div class="form-group">                    
                    <img src="icon/Email.png" alt="E-mail">
                    <input type="text" id="email" name="rgs_usr_email" placeholder="E-mail (user@example.com)">
                </div>
                
                <label for="password">Password*</label>
                
                <div class="form-group">                    
                    <img src="icon/Lock.png" alt="Lock">
                    <input type="password" id="password" name="rgs_usr_password1" placeholder="Password">
                </div>

                <label for="password">Confirm-Password*</label>
                
                <div class="form-group">                    
                    <img src="icon/Lock.png" alt="Lock">
                    <input type="password" id=" confirm-password" name="rgs_usr_password2" placeholder="Confirm-Password">
                </div>

                <label>Security Question:</label>
                <div  class="form-group selection-group">    
                    
                <select name="rgs_fgt_question">
                    <option value="" disabled selected>Please Select</option>
                    <option value="What was your childhood nickname?"<?php if("What was your childhood nickname?"==$row["ForgetPasswordQuestion"]) echo 'selected="selected"'; ?>>What was your childhood nickname?</option>
                    <option value="What's the name of the first school you attended?"<?php if("What's the name of the first school you attended?"==$row["ForgetPasswordQuestion"]) echo 'selected="selected"'; ?>>What's the name of the first school you attended?</option>
                    <option value="What was your first pet's name?"<?php if("What was your first pet's name?"==$row["ForgetPasswordQuestion"]) echo 'selected="selected"'; ?>>What was your first pet's name?</option>
                </select>
               </div>
     
               <label>Answer:</label>
               <div class="form-group">                    
                    <input type="text" name="rgs_usr_answer" placeholder="Answer">
                </div>

                 
                <div class="form-group-checkbox">
                <input type="hidden" name="rgs_active" value="F">
                <input type="checkbox" name="rgs_active" value="T">
                <label for="conditions" class="conditions">I agree to the Terms and Conditions</label><br>
                 </div>
                    <button type="submit" class="register-button" name="reg_user" style="margin-top:2em;">SIGN UP</button>
                </form>

            <div class="login-link">
                <p>Already have an account?</p>
                <a href="login.php">Login</a>
            </div>

            <hr>            
        </div>


        <div class="image-container"></div>
    </div>
</body>
</html>
