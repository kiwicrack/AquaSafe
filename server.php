<?php
    error_reporting(E_ERROR | E_PARSE);
    session_start();

    // variable declaration
    $rgs_usr_username = '';
    $rgs_usr_email= "";
    $rgs_user_password1="";
    $rgs_user_password2="";
    $errors = array(); 
    $_SESSION['success'] = "";



//==============================================================
//  Connect to database
//==============================================================
    $db = mysqli_connect("localhost", "root", "", "flood_website");
    


//==============================================================
//  REGISTER User
//==============================================================
    if (isset($_POST['reg_user'])) {
    // receive all input values from the form

    $rgs_usr_username = mysqli_real_escape_string($db, $_POST['rgs_usr_username']);
    $rgs_usr_email  = mysqli_real_escape_string($db, $_POST['rgs_usr_email']);
    $rgs_usr_password1 = mysqli_real_escape_string($db, $_POST['rgs_usr_password1']);
    $rgs_usr_password2 = mysqli_real_escape_string($db, $_POST['rgs_usr_password2']);
    $rgs_active = mysqli_real_escape_string($db, $_POST['rgs_active']);
    $rgs_fgt_question = mysqli_real_escape_string($db, $_POST['rgs_fgt_question']);
    $rgs_usr_answer = mysqli_real_escape_string($db, $_POST['rgs_usr_answer']);



    // form validation: ensure that the form is correctly filled
    if (empty($rgs_fgt_question)) { array_push($errors, "Security Question is required"); }
    if (empty($rgs_usr_answer)) { array_push($errors, "Security Question Answer is required"); }

    if (empty($rgs_usr_username)) { array_push($errors, "Username is required"); }
    // Filter_var function is used to check if the email is in a valid format.
    // example: user@example.com
    if (empty($rgs_usr_email)) { array_push($errors, "Email is required"); }
    elseif (!filter_var($rgs_usr_email, FILTER_VALIDATE_EMAIL)) {   //The FILTER_VALIDATE_EMAIL filter is applied to validate the email address.
        array_push($errors, "Invalid email format");
    }
    if (empty($rgs_usr_password1)) { array_push($errors, "Password is required"); }
        elseif (strlen($rgs_usr_password1) < 8) {
            array_push($errors, "Password should be at least 8 characters long");       
    }
        elseif (!preg_match('/[A-Za-z]/', $rgs_usr_password1) || !preg_match('/\d/', $rgs_usr_password1) || !preg_match('/[^A-Za-z\d]/', $rgs_usr_password1)) {
            array_push($errors, "Password should include at least one uppercase letter, one lowercase letter, one number, and one special character");
    }
    if (empty($rgs_usr_password2 )) { array_push($errors, "Confirm Password is required"); }
    if (empty($rgs_active)){ array_push($errors, "You must agree the Terms and Conditions"); }

    //find username already exist or not
    $query = "SELECT * FROM `user` WHERE Username='$rgs_usr_username'";
    $results2 = mysqli_query($db,$query);

    //find email already exist or not
    $query = "SELECT * FROM `user` WHERE Email='$rgs_usr_email'";
    $results3= mysqli_query($db,$query);

    if (mysqli_num_rows($results2)>0){
            array_push($errors, "This username already exist");
        }

    if (mysqli_num_rows($results3)>0){
            array_push($errors, "This email already exist");
    }


    if ($rgs_usr_password1 != $rgs_usr_password2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
    
        // Hash the password using the password_hash function   
        $encrpt_rgs_usr_password1= sha1($rgs_usr_password1);
        $query = "INSERT INTO `user` ( `Username`, `Email`, `Password`, `Active`, `ForgetPasswordQuestion`, `ForgetPasswordAnswer`) VALUES ('$rgs_usr_username','$rgs_usr_email','$encrpt_rgs_usr_password1','$rgs_active', '$rgs_fgt_question', '$rgs_usr_answer')";
            mysqli_query($db, $query);
        $_SESSION['username'] = $rgs_usr_username;
        $_SESSION['success'] = "You are now logged in";
        header('location: login.php');
    }
}


//==============================================================
//  Login User/Admin Function
//==============================================================
if (isset($_POST['login_user'])) {
    $login_username = mysqli_real_escape_string($db, $_POST['login_username']);
    $login_password = mysqli_real_escape_string($db, $_POST['login_password']);

    if (empty($login_username)) {
        array_push($errors, "Username is required");
    }
    if (empty($login_password)) {
        array_push($errors, "Password is required");
    }

    $encrypted_password = sha1($login_password);   

    if (count($errors) == 0) {
        // Check admin table first
        $queryadmin = "SELECT * FROM admin WHERE Username='$login_username' AND Password='$encrypted_password'";
        $resultadmin = mysqli_query($db, $queryadmin);

        if (mysqli_num_rows($resultadmin) == 1) {
            $_SESSION['username'] = $login_username;
            $_SESSION['activity'] = time();
            header('location: managealert.php');
        } else {
            // If not found in admin table, check user table
            $queryuser = "SELECT * FROM user WHERE Username='$login_username' AND Password='$encrypted_password'";
            $resultuser = mysqli_query($db, $queryuser);
            
            if (mysqli_num_rows($resultuser) == 1) {
                $_SESSION['username'] = $login_username;
                $_SESSION['activity'] = time();
                header('location: profile.php');
            } else {
                array_push($errors, "Wrong username/password combination");
            }
        }
    }
}

//==============================================================
//  Forgetpassword Function
//==============================================================
if (isset($_POST['fgt_password'])) {
    $fgt_email = mysqli_real_escape_string($db, $_POST['fgt_email']);
    $fgt_question = mysqli_real_escape_string($db, $_POST['fgt_question']);
    $fgt_usr_answer = mysqli_real_escape_string($db, $_POST['fgt_usr_answer']);

    //validation
    if (empty($fgt_email)) {
        array_push($errors, "E-mail is required");
    } 
    if (empty($fgt_question)) {
        array_push($errors, "Security Question is required");
    } 
    if (empty($fgt_usr_answer)) {
        array_push($errors, "Security Question Answer is required");
    } 
    

    
    if (count($errors) == 0) {
        // $queryfgt_password = "SELECT * FROM user WHERE Email='" . $fgt_email . "'";
        $queryfgt_password = "SELECT Email, ForgetPasswordQuestion, ForgetPasswordAnswer From user Where Email='$fgt_email' AND ForgetPasswordQuestion='$fgt_question' AND ForgetPasswordAnswer='$fgt_usr_answer' ";
        $resultfgt_password = mysqli_query($db, $queryfgt_password);  
        
    
        if (mysqli_num_rows($resultfgt_password) == 1) {
            $_SESSION['Email'] = $fgt_email;
            header('location: resetpassword.php');
        }
        else 
        {
            array_push($errors, "Invalid answer/Email not found. Please double-check and select the correct 'forgot password' question, then try again.");
        }
    }
}

//==============================================================
//  Reset Password
//==============================================================
if (isset($_POST['rst_usr_pd'])) {
    $reset_user_email = mysqli_real_escape_string($db, $_POST['reset_user_email']);
    $reset_user_password = mysqli_real_escape_string($db, $_POST['reset_user_password']);
    $reset_user_confirm_password = mysqli_real_escape_string($db, $_POST['reset_user_confirm_password']);
    // Validation
    if (empty($reset_user_password)) { array_push($errors, "Password is required");} 
    elseif (strlen($reset_user_password) < 8) { array_push($errors, "Password should be at least 8 characters long"); }
    elseif (!preg_match('/[A-Za-z]/', $reset_user_password) || !preg_match('/\d/', $reset_user_password) || !preg_match('/[^A-Za-z\d]/', $reset_user_password)) {
        array_push($errors, "Password should include at least one uppercase letter, one lowercase letter, one number, and one special character");
    }
    if (empty($reset_user_confirm_password)) { array_push($errors, "Confirm Password is required");}
    
    if ($reset_user_password != $reset_user_confirm_password) {
        array_push($errors, "The two passwords do not match");
    }
   
    if (count($errors) == 0) {

        // Hash the password using the password_hash function   
        $encrpt_rst_usr_passwordrst = sha1($reset_user_password);
        $queryrst_password = "UPDATE user SET `Password`= '$encrpt_rst_usr_passwordrst' WHERE Email='$reset_user_email' ";

        $resultrst_password = mysqli_query($db, $queryrst_password);  
        // Check if the update was successful
        if ($resultrst_password) {
            $affected_rows = mysqli_affected_rows($db);

            if ($affected_rows > 0) {
                echo '<script language="javascript">';
                echo 'alert("update complete")';
                echo '</script>';
                header('location: login.php');
            } else {
                
                array_push($errors, "Try to put different password.");
            }
        } else {
            die('Error: ' . mysqli_error($db));
        }
    }
}

//==============================================================
//  User Profile Page
//==============================================================
if (isset($_POST['usrprofile_user'])) {
    $usrprofile_userID = mysqli_real_escape_string($db, $_POST['usrprofile_userID']);
    $usrprofile_username = mysqli_real_escape_string($db, $_POST['usrprofile_username']);
    $usrprofile_phone_number = mysqli_real_escape_string($db, $_POST['usrprofile_phone_number']);
    $usrprofile_address = mysqli_real_escape_string($db, $_POST['usrprofile_address']);
    $usrprofile_age = mysqli_real_escape_string($db, $_POST['usrprofile_age']);
    $usrprofile_dateofbirth = mysqli_real_escape_string($db, $_POST['usrprofile_dateofbirth']);
    $usrprofile_gender = mysqli_real_escape_string($db, $_POST['usrprofile_gender']);
    $usrprofile_occupation = mysqli_real_escape_string($db, $_POST['usrprofile_occupation']);
   
    // Validation
    if (empty($usrprofile_username)) { array_push($errors, "Username is required");} 
    if (empty($usrprofile_phone_number)) {
        array_push($errors, "Phone Number is required");
    } else {
        // Validate phone number format (e.g., 016-7654345)
        $phone_pattern = '/^01[0-9]-[0-9]{7}$/';
    
        if (!preg_match($phone_pattern, $usrprofile_phone_number)) {
            array_push($errors, "Invalid Phone Number format.Please enter a valid phone number like 016-7654345 .");
        }
    }   
    if (empty($usrprofile_address)) { array_push($errors, "Address is required");} 
    if (empty($usrprofile_age)) { array_push($errors, "Age is required");} 
    if (empty($usrprofile_dateofbirth)) { array_push($errors, "Dateofbirth is required");} 
    if (empty($usrprofile_gender)) { array_push($errors, "Gender is required");} 
    if (empty($usrprofile_occupation)) { array_push($errors, "Occupation is required");} 

    $queryuserprofile = "SELECT * FROM `user` WHERE Username='$usrprofile_username'";
    $resultsuserprofile = mysqli_query($db,$queryuserprofile);

    if (mysqli_num_rows($resultsuserprofile)>1){
            array_push($errors, "This username already exist");
        }
    if (count($errors) == 0) {
    $_SESSION['username']=$usrprofile_username;
    $query = "UPDATE user SET Username='$usrprofile_username',PhoneNumber='$usrprofile_phone_number',Address='$usrprofile_address', Age='$usrprofile_age',Dateofbirth='$usrprofile_dateofbirth',Gender='$usrprofile_gender', Occupation='$usrprofile_occupation' WHERE UserID='$usrprofile_userID'";
    mysqli_query($db, $query) or die(mysqli_error($db));
    
    echo '<script language="javascript">';
    echo 'alert("Update complete")';
    echo '</script>';
    }
}
    
//==============================================================
//  Edit Alert Page
//==============================================================
if (isset($_POST['editalert']) && isset($_GET['do'])) {
    if($_GET['do'] == "edit_data") {
        $update_alertsID = $_POST['update_alertsID'];
        $update_alertsSeverity = $_POST['update_alertsSeverity'];
        $update_alertstrend = $_POST['update_alertstrend'];
        
        // Map alert trends to severity levels
        if ($update_alertstrend == 'No Flood') {
            $update_alertsSeverity = 0;
        } elseif ($update_alertstrend == 'Minor Flood') {
            $update_alertsSeverity = 1;
        } elseif ($update_alertstrend == 'Moderate Flood') {
            $update_alertsSeverity = 2;
        } elseif ($update_alertstrend == 'Severe Flood') {
            $update_alertsSeverity = 3;
        } else{
            $update_alertsSeverity = 4;
        } 
        
    
    
        $query = "UPDATE alerts SET date_time = CURRENT_TIMESTAMP ,severity='$update_alertsSeverity',trend='$update_alertstrend' WHERE id='$update_alertsID' ";
         mysqli_query($db, $query) or die(mysqli_error($db));
         if( mysqli_affected_rows($db) > 0) {
    
             echo '<script language="javascript">';
             echo 'alert("Update complete")';
             echo '</script>';
         }
    } 
  
    }

//==============================================================
//  Add Alert Page
//==============================================================
if (isset($_GET['do'])) {
    if($_GET['do'] == "add_data") {
        // insert sql data here
        $add_alertslocation = $_POST['add_alertslocation'];
        $add_alertsdistrict  = $_POST['add_alertsdistrict'];
        $add_alertstrend  = $_POST['add_alertstrend'];
        $add_alertsSeverity = $_POST['add_alertsSeverity'];
        
        if (empty($add_alertslocation)) { array_push($errors, "Location is required");} 
        if (empty($add_alertsdistrict)) { array_push($errors, "District is required");} 
        if (empty($add_alertstrend)) { array_push($errors, "Trent is required");} 

         // Map alert trends to severity levels
         if ($add_alertstrend == 'No Flood') {
            $add_alertsSeverity = 0;
        } elseif ($add_alertstrend == 'Minor Flood') {
            $add_alertsSeverity = 1;
        } elseif ($add_alertstrend == 'Moderate Flood') {
            $add_alertsSeverity = 2;
        } elseif ($add_alertstrend == 'Severe Flood') {
            $add_alertsSeverity = 3;
        } else{
            $add_alertsSeverity = 4;
        } 
        
        if (count($errors) == 0) {
        $queryadd_alerts = "INSERT INTO `alerts` ( `location`, `date_time`, `district`, `severity`, `trend`) VALUES ('$add_alertslocation',CURRENT_TIMESTAMP,'$add_alertsdistrict','$add_alertsSeverity','$add_alertstrend')";
        mysqli_query($db, $queryadd_alerts) or die(mysqli_error($db));
        if( mysqli_affected_rows($db) > 0) {
   
            echo '<script language="javascript">';
            echo 'alert("Update complete")';
            echo '</script>';
        }
    }
    }
}

//==============================================================
//  Edit User Detail (Admin)
//==============================================================
if (isset($_POST['edituser_detial'])) {
    $update_userID = mysqli_real_escape_string($db, $_POST['update_userID']);
    $update_user_active = mysqli_real_escape_string($db, $_POST['update_user_active']);
    $update_user_PhoneNumber = mysqli_real_escape_string($db, $_POST['update_user_PhoneNumber']);
    $update_user_Address = mysqli_real_escape_string($db, $_POST['update_user_Address']);
    $update_user_Age = mysqli_real_escape_string($db, $_POST['update_user_Age']);
    $update_user_Dateofbirth = mysqli_real_escape_string($db, $_POST['update_user_Dateofbirth']);
    $update_user_gender = mysqli_real_escape_string($db, $_POST['update_user_gender']);
    $update_user_occupation = mysqli_real_escape_string($db, $_POST['update_user_occupation']);
  
    // Validation
    if (empty($update_user_PhoneNumber)) {
        array_push($errors, "Phone Number is required");
    } else {
        // Validate phone number format (e.g., 016-7654345)
        $phone_pattern = '/^01[0-9]-[0-9]{7}$/';
    
        if (!preg_match($phone_pattern, $update_user_PhoneNumber)) {
            array_push($errors, "Invalid Phone Number format.Please enter a valid phone number like 016-7654345 .");
        }
    }   
    if (empty($update_user_Address)) { array_push($errors, "Address is required");} 
    if (empty($update_user_Age)) { array_push($errors, "Age is required");} 
    if (empty($update_user_Dateofbirth)) { array_push($errors, "Dateofbirth is required");} 
    if (empty($update_user_gender)) { array_push($errors, "Gender is required");} 
    if (empty($update_user_occupation)) { array_push($errors, "Occupation is required");} 

    if (count($errors) == 0) {
    $queryedit_userdetail = "UPDATE user SET Active = '$update_user_active', PhoneNumber ='$update_user_PhoneNumber', Address = '$update_user_Address', Age = '$update_user_Age', DateofBirth = '$update_user_Dateofbirth', Gender = '$update_user_gender', Occupation = '$update_user_occupation' WHERE UserID='$update_userID'";
    mysqli_query($db, $queryedit_userdetail) or die(mysqli_error($db));
    echo '<script language="javascript">';
    echo 'alert("Update complete")';
    echo '</script>';
    }
}

//==============================================================
//  Edit Admin Detail (Admin)
//==============================================================
if (isset($_POST['editadmin_detial'])) {
    $update_adminID = mysqli_real_escape_string($db, $_POST['update_adminID']);
    $update_admin_username = mysqli_real_escape_string($db, $_POST['update_admin_username']);
    $update_admin_Password = mysqli_real_escape_string($db, $_POST['update_admin_Password']);
  
    if (empty($update_admin_username)) { array_push($errors, "Username is required");} 
    if (empty($update_admin_Password)) { array_push($errors, "Password is required"); }
    elseif (strlen($update_admin_Password) < 8) {
        array_push($errors, "Password should be at least 8 characters long");       
    }
    elseif (!preg_match('/[A-Za-z]/', $update_admin_Password) || !preg_match('/\d/', $update_admin_Password) || !preg_match('/[^A-Za-z\d]/', $update_admin_Password)) {
        array_push($errors, "Password should include at least one uppercase letter, one lowercase letter, one number, and one special character");
    }
    

    if (count($errors) == 0) {

    // Hash the password using the password_hash function   
    $encrpt_edit_admin_passwordadmin= sha1($update_admin_Password);
    $queryedit_admindetail = "UPDATE admin SET Username = '$update_admin_username', Password = '$encrpt_edit_admin_passwordadmin' WHERE AdminID='$update_adminID'";
    mysqli_query($db, $queryedit_admindetail) or die(mysqli_error($db));
    echo '<script language="javascript">';
    echo 'alert("Update complete")';
    echo '</script>';
    }
}

//==============================================================
//  Add Admin Page (Admin)
//==============================================================
    if (isset($_GET['do'])) {
        if($_GET['do'] == "add_admin") {

            //insert into database for admin HERE
            $add_adminUsername = mysqli_real_escape_string($db, $_POST['add_adminUsername']);
            $add_adminPassword = mysqli_real_escape_string($db, $_POST['add_adminPassword']);

            if (empty($add_adminUsername)) { array_push($errors, "Username is required");} 
            if (empty($add_adminPassword)) { array_push($errors, "Password is required"); }
            elseif (strlen($add_adminPassword) < 8) {
                array_push($errors, "Password should be at least 8 characters long");       
            }
            elseif (!preg_match('/[A-Za-z]/', $add_adminPassword) || !preg_match('/\d/', $add_adminPassword) || !preg_match('/[^A-Za-z\d]/', $add_adminPassword)) {

                array_push($errors, "Password should include at least one uppercase letter, one lowercase letter, one number, and one special character");
            }

             //find Admin Username already exist or not
            $queryadmin = "SELECT * FROM `admin` WHERE Username='$add_adminUsername'";
            $resultsadmin = mysqli_query($db,$queryadmin);


            if (mysqli_num_rows($resultsadmin)>0){
                    echo '<script language="javascript">';
                    echo 'alert("This Admin username already exist")';
                    echo '</script>';
                }
            
            if (count($errors) == 0) {
                 // Hash the password using the password_hash function   
                $encrpt_add_usr_passwordadmin= sha1($add_adminPassword);
                $queryadd_admindetail = "INSERT INTO `admin` ( `Username`, `Password`) VALUES ('$add_adminUsername','$encrpt_add_usr_passwordadmin')";
                mysqli_query($db, $queryadd_admindetail) or die(mysqli_error($db));
                echo '<script language="javascript">';
                echo 'alert("Update complete")';
                echo '</script>';
                }


        }
    }


     
?>
