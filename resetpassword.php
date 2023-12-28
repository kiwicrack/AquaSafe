<?php 
include('server.php') ;
 $fgt_email=$_SESSION['Email'];
 $query = "SELECT * FROM `user` WHERE Email='$fgt_email'";
 $result = mysqli_query($db, $query) or die(mysqli_error($db));
 $row = mysqli_fetch_assoc($result);


 session_start(); 

	if (!isset($_SESSION['Email'])) {
		$_SESSION['msg'] = "You must log in email first";
        header('location: login.php');
	}



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
    <div class="resetpassword-container">
        <div class="resetpassword-form-container">
            
            <div class="resetpassword-form-nav">
            <a href="login.php">X</a>
            <h2>RESET PASSWORD.</h2>
            </div>

            <hr>  

            <h3>Please key new password.</h3>

            <form class="resetpassword-form" action="resetpassword.php" method="post">
            <?php include('errors.php'); ?> 
            <label for="e-mail" style="margin-left: 106px;">E-mail*</label>
                
                <div class="resetpassword-form-group">                    
                    <img src="icon/Email.png" alt="E-mail">
                    <input type="text" name="reset_user_email" value="<?php echo $row['Email']; ?>" readonly>
                </div>

            <label for="password" style="margin-left: 106px;">Password*</label>
                
                <div class="resetpassword-form-group">                    
                    <img src="icon/Lock.png" alt="Lock"> 
                    <input type="password" id="password" name="reset_user_password" placeholder="Password">
                </div>
            
            <label for="confirm-password" style="margin-left: 105px;">Confirm-Password*</label>
                
                <div class="resetpassword-form-group">                    
                    <img src="icon/Lock.png" alt="Lock">
                    <input type="password" id="confirm-password" name="reset_user_confirm_password" placeholder="Confirm-Password">
                </div>

            <button type="submit" class="resetpassword-button" name="rst_usr_pd" style="margin-top:1em;">SUBMIT</button>

            </form>

            <hr> 
        </div>


    </div>
</body>
</html>
