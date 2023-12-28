<?php include('server.php')
 ?>
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
    <div class="forgetpassword-container">
        <div class="forgetpassword-form-container">
            
            <div class="forgetpassword-form-nav">
            <a href="login.php">X</a>
            <h2>FORGET PASSWORD PAGE.</h2>
              
            </div>
            <hr>

            <h3 class=>Please key your email to reset the password.</h3>

            <form class="forgetpassword-form" action="forgetpassword.php" method="post">
            <?php include('errors.php'); ?> 
                 
            <label for="e-mail">E-mail*</label>
                
                <div class="forgetpassword-form-group">                    
                    <img src="icon/Email.png" alt="E-mail">
                    <input type="text" id="email" name="fgt_email" placeholder="E-mail">
                </div>   
              
                <label>Security Question:</label>
                <div class="forgetpassword-form-group">                    

                
                <select name="fgt_question" style="font-family: 'JetBrains Mono', monospace; font-size: 15px;">
                    <option value="" disabled selected>Please Select</option>
                    <option value="What was your childhood nickname?"<?php if("What was your childhood nickname?"==$row["ForgetPasswordQuestion"]) echo 'selected="selected"'; ?>>What was your childhood nickname?</option>
                    <option value="What's the name of the first school you attended?"<?php if("What's the name of the first school you attended?"==$row["ForgetPasswordQuestion"]) echo 'selected="selected"'; ?>>What's the name of the first school you attended?</option>
                    <option value="What was your first pet's name?"<?php if("What was your first pet's name?"==$row["ForgetPasswordQuestion"]) echo 'selected="selected"'; ?>>What was your first pet's name?</option>
                </select>
</div>


               
               <label>Answer:</label>
               <div class="forgetpassword-form-group">                    
                    <input type="text" name="fgt_usr_answer" placeholder="Answer">
                </div>

                <button type="submit" class="forgetpassword-button" name="fgt_password" style="margin-top:1em;">SUBMIT</button>

            </form>

            <hr> 
        </div>


    </div>
</body>
</html>
