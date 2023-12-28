<?php 

 include('server.php') ;
 $login_username=$_SESSION['username'];

 session_start(); 

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in username first";
        header('location: login.php');
	}


// Session timeout duration in seconds
$timeout_duration = 1800;

// Check if the last activity timestamp is set
if (isset($_SESSION['activity'])) {
    // Calculate the session's age
    $session_age = time() - $_SESSION['activity'];
    
    // Check if the session has expired
    if ($session_age > $timeout_duration) {
        unset($_SESSION['username']);
        // Destroy the session and redirect to login page or a timeout page
        session_unset();
        session_destroy();
        header('location: login.php');
       exit();}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Manage Alert</title>
    <link rel="stylesheet" href="navBar.css">
    <link rel="stylesheet" href="mainTheme.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="Images/logo_nav.png" type="image/x-icon">
	<link href="aquasafe.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
   
    
    <style>
       html{
        width: 100%;
        height: 100%;
       }
       
        main{
            flex-direction: column;
            padding-bottom: 100px;  
        }

        header {
            width: 100%;
            margin-bottom: 50px;
        }

        .logout_section{
            padding: 20px;
        }

        .logout_button{
            border: 4px solid #000000;
            font-family: 'JetBrains Mono', monospace; 
            font-size: 20px;
            color: #ffffff;
            background-color: #000000;
            padding: 8px;
        }

        .logout_button:hover{
            background-color: #0132ab;
        }
    </style>
    
</head>
<body>
<header>
        <section>
            <!-- navbar -->
            <div>
                <div class="logout_section">
                    <a href="index.html" <?php unset($_SESSION['Username']);?> class="logout_button"> Log Out</a>
                </div>

                <div class="page_title">
                    <h1>˅ ADMIN PROFILE.
                        <div class="dropdown_maincon">
                            <div class="dropdown_con"><a class="dropdown-link" href="managealert.php">MANAGE ALERT.</a></div>
                            <div class="dropdown_con"><a class="dropdown-link" href="manageadmin.php">MANAGE ADMIN.</a></div>
                            <div class="dropdown_con"><a class="dropdown-link" href="manageuser.php">MANAGE USER.</a></div>
                        </div>
                    </h1> 
                </div>
            </div>

            <button class="hamburger" onclick="showNav(), showOver()">
                        <div id="bar1" class="bar"></div>
                        <div id="bar2" class="bar"></div>
                        <div id="bar3" class="bar"></div>
            </button>

            <div class="navigation">
                <div class="nav_line_main">
                    
                </div>

                <div class="text nav_con1">
                    <div class="nav_line">
                        <img src="Images/logo_nav.png" style="height: 3cm; border:3px solid #000000;">
                    </div>
                
                    <div>
                        <br><a href="profile.php" class="active">Profile</a>
                    </div>
                </div>
                
                <div class="text nav_con2 nav_line_main">
                    <nav>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><a href="donate.html">Donation</a></li>
                            <li><a href="floodAlert.php">Flood Alert</a></li>
                            <br><br><br><br>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    </header>

<main class="full_width center_container">
<?php require_once 'server.php'; ?>

<?php
if (isset($_SESSION['message'])): ?>
<div class="alert alert-<?=$_SESSION['msg_type']?>">

<?php
    echo $_SESSION['message'];
    unset($_SESSION['message']); ?>

</div>
<?php endif ?>

<?php include('errors.php');?> 
<div class="center_container start">
<?php 
    $mysqli = new mysqli('localhost', 'root', '', 'flood_website') or die(mysqli_error($mysqli));
    $result = $mysqli->query("SELECT * FROM user") or die($mysqli_error);
  
    ?>
    <div class="table_title_align">
                <div><p  class="title_text">&nbsp;Users Table:</p><br>   </div>
            </div>
    <div class="row justify-content-center table_container">
        <table class="table">
            <thead>
                <tr>
                    <th>UserID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Active</th>
                    <th>PhoneNumber</th>
                    <th>Address</th>
                    <th>Age</th>
                    <th>Dateofbirth</th>
                    <th>Gender</th>
                    <th>Occupation</th>
                    <th>ForgetPasswordQuestion</th>
                    <th>ForgetPasswordAnswer</th>

                    
                    <th colspan="13">Action</th>
                <tr>
            </thead>
    <?php
        while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['UserID']; ?></td>
                <td><?php echo $row['Username']; ?></td>      
                <td><?php echo $row['Email']; ?></td>
                <td><?php echo $row['Password']; ?></td>
                <td><?php echo $row['Active']; ?></td>
                <td><?php echo $row['PhoneNumber']; ?></td>
                <td><?php echo $row['Address']; ?></td>      
                <td><?php echo $row['Age']; ?></td>
                <td><?php echo $row['Dateofbirth']; ?></td>
                <td><?php echo $row['Gender']; ?></td>
                <td><?php echo $row['Occupation']; ?></td>
                <td><?php echo $row['ForgetPasswordQuestion']; ?></td>
                <td><?php echo $row['ForgetPasswordAnswer']; ?></td>
                
                
                <td>
                    <a href="manageuser.php?edituser=<?php echo $row['UserID']; ?>"
                        class="edit_delete_button">Edit</a>
                        
                        <a href="manageuser.php?deleteuser=<?php echo $row['UserID']; ?>"
                        class="edit_delete_button">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </table>
    </div>

    <?php
    
    function pre_r( $array ){
        echo'<pre>';
        print_r($array);
        echo '</pre>';}
?>

<?php   
    $display_edit = "display: none;";

    if(isset($_GET['edituser'])) {    
        $display_edit = "display: flex;";
        $edit_id = $_GET['edituser'];
        // Fetch data from the database based on $edit_id
        $result = $mysqli->query("SELECT * FROM user WHERE UserID='$edit_id'") or die($mysqli_error);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $Username = $row['Username'];
            $Email = $row['Email'];
            $Password = $row['Password'];
            $Active = $row['Active'];
            $PhoneNumber = $row['PhoneNumber'];
            $Address = $row['Address'];
            $Age = $row['Age'];
            $Dateofbirth = $row['Dateofbirth'];
            $Gender = $row['Gender'];
            $Occupation = $row['Occupation'];
        }

    }
    if(isset($_GET['deleteuser'])) {
        //do delete sql here
        $delete_id = $_GET['deleteuser'];
        $result = $mysqli->query("DELETE FROM user WHERE UserID=$delete_id");

        // Check for errors
        if (!$result) {
            echo "Error deleting row: " . $mysqli->error;
        } else {
            // Check the number of affected rows
            if ($mysqli->affected_rows > 0) {
                echo "<script>alert('The data was deleted. Please refresh the page again.');</script>";
            }
        }
        
    }
?>


<div class="popUpForm" style="<?php echo $display_edit?>">

<form action="manageuser.php" method="POST">
<a href="manageuser.php" class="closebutton" style="font-weight: 700; font-size: 22px;">X</a>
<p>Edit User Details</p>
    <input type="hidden" name="update_userID" value="<?php echo $edit_id; ?>">
        
        <div class="form-group">
        <label>Username:</label>
        <input type="text" name="update_user_username" value="<?php echo $Username;?>" readonly>
        </div>

        <div class="form-group">
        <label>Email:</label>
        <input type="datetime" name="update_user_email"  value="<?php echo $Email;?>" readonly>
        </div>
        
        <div class="form-group">
        <label>Password:</label>
        <input type="text" name="update_user_Password" value="<?php echo $Password;?>" readonly>
        </div>

        <div class="form-group">
        <label>Active:</label>
             <select name="update_user_active">
            <option value="T"<?php if("T"==$row["Active"]) echo 'selected="selected"'; ?>>Active</option>
            <option value="F"<?php if("F"==$row["Active"]) echo 'selected="selected"'; ?>>InActive</option>
            </select>
        </div>
        
        <div class="form-group">
        <label>PhoneNumber:</label>
        <input type="text" name="update_user_PhoneNumber" value="<?php echo $PhoneNumber;?>">
        </div>

        <div class="form-group">
        <label>Address:</label>
        <input type="text" name="update_user_Address" value="<?php echo $Address;?>">
        </div>

        <div class="form-group">
        <label>Age:</label>
        <select name="update_user_Age" >
            <option value="" disabled selected>Please Select</option>
            <option <?php if("18-24"==$row["Age"]) echo 'selected="selected"'; ?>>18-24</option>
            <option <?php if("25-34"==$row["Age"]) echo 'selected="selected"'; ?>>25-34</option>
            <option <?php if("35-44"==$row["Age"]) echo 'selected="selected"'; ?>>35-44</option>
            <option <?php if("45-54"==$row["Age"]) echo 'selected="selected"'; ?>>45-54</option>
            <option <?php if("55-64"==$row["Age"]) echo 'selected="selected"'; ?>>55-64</option>
            <option <?php if("65+"==$row["Age"]) echo 'selected="selected"'; ?>>65+</option>
        </select>
       </div>
         
        <div class="form-group">
        <label>Dateofbirth:</label>
        <input type="date" name="update_user_Dateofbirth" value="<?php echo $Dateofbirth;?>">
        </div>

        <div class="form-group">
        <label>Gender:</label>
             <select name="update_user_gender">
            <option <?php if("M"==$row["Gender"]) echo 'selected="selected"'; ?>>Male</option>
            <option <?php if("F"==$row["Gender"]) echo 'selected="selected"'; ?>>Female</option>
            </select>
        </div>


        <div class="form-group">    
        <label>Occupation:</label>
        <select name="update_user_occupation">
            <option value="" disabled selected>Please Select</option>
            <option <?php if("Student"==$row["Occupation"]) echo 'selected="selected"'; ?>>Student</option>
            <option <?php if("Worker"==$row["Occupation"]) echo 'selected="selected"'; ?>>Worker</option>
            <option <?php if("No Work"==$row["Occupation"]) echo 'selected="selected"'; ?>>No Work</option>
            <option <?php if("Engineering"==$row["Occupation"]) echo 'selected="selected"'; ?>>Engineering</option>
            <option <?php if("Teacher"==$row["Occupation"]) echo 'selected="selected"'; ?>>Teacher</option>
            <option <?php if("Doctor"==$row["Occupation"]) echo 'selected="selected"'; ?>>Doctor</option>
            <option <?php if("Developer"==$row["Occupation"]) echo 'selected="selected"'; ?>>Developer</option>
            <option <?php if("Artist"==$row["Occupation"]) echo 'selected="selected"'; ?>>Artist</option>
            <option <?php if("Entrepreneur"==$row["Occupation"]) echo 'selected="selected"'; ?>>Entrepreneur</option>
            <option <?php if("Writer"==$row["Occupation"]) echo 'selected="selected"'; ?>>Writer</option>
            <option <?php if("Other"==$row["Occupation"]) echo 'selected="selected"'; ?>>Other</option>
        </select>
    </div>

        <!-- <button type=submit >Update</button> -->
        <button type="submit" name="edituser_detial">Update</button>


</form>
</div>
</main>

    
<footer class="footer_container content_text" style="line-height: 1.5;">
        <div class="border"></div>
        <div class="footer_main">
            <div class="footer_content">&nbsp;'CONTACT</div>
            <div class="footer_content" style="justify-content: right;">DETAILS.'&nbsp;</div>
        </div>
        <div style="padding-bottom: 20px;">
            <div class="footer_row">
                <div class="content_alignment">
                    <div >01. AquaSafe Developer:</div><br>
                    <div>Toh Kar Ming. </div>
                    <div>21091137.</div>
                </div>
                <div class="content_alignment">
                    <div >02. AquaSafe Developer:</div><br>
                    <div>James Hwang Qi Leong.</div>
                    <div>22004097.</div>
                </div>
                <div class="content_alignment" >
                    <div >03. Copyright &copy; 2023. </div><br>
                    <div>Group 1-3-1.<br>
                    <div>WEB2202: Final Assessment.</div>
                </div>
            </div>
        </div>
    </footer>
    <script src="navScript.js"></script>
</body>
</html>






