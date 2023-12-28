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
    
	<link href="aquasafe.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="mainTheme.css">
    <link rel="stylesheet" href="navBar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="Images/logo_nav.png" type="image/x-icon">
    
    <style>
       html{
        width: 100%;
        height: 100%;
       }
       
        main{
            flex-direction: column;
            padding: 100px 0; 
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

        .table{
            overflow-x: scroll;
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
    <div class="center_container">
        <?php 
            $mysqli = new mysqli('localhost', 'root', '', 'flood_website') or die(mysqli_error($mysqli));
            $result = $mysqli->query("SELECT * FROM admin") or die($mysqli_error);
        ?>

        <div class="table_title_align">
                <div><a href="manageadmin.php?addadmin=true" class="add_btn">+</a></div> 
                <div><p  class="title_text">&nbsp;Admin Table:</p><br>   </div>
        </div>
        
        <div class="row justify-content-center table_container">
            <table class="table">
                <tr>
                    <th>AdminID</th>
                    <th>Username</th>
                    <th>Password</th>                   
                    <th colspan="3">Action</th>
                <tr>
        <?php
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['AdminID']; ?></td>
                    <td><?php echo $row['Username']; ?></td>      
                    <td><?php echo $row['Password']; ?></td>

                    <td>
                        <a href="manageadmin.php?editadmin=<?php echo $row['AdminID']; ?>"
                            class="edit_delete_button">Edit</a>
                            
                            <a href="manageadmin.php?deleteadmin=<?php echo $row['AdminID']; ?>"
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

        if(isset($_GET['editadmin'])) {    
            $display_edit = "display: flex;";
            $edit_id = $_GET['editadmin'];
            // Fetch data from the database based on $edit_id
            $result = $mysqli->query("SELECT * FROM admin WHERE AdminID='$edit_id'") or die($mysqli_error);
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $Username = $row['Username'];
                $Password = $row['Password'];
            }

        }
        if(isset($_GET['deleteadmin'])) {
            //do delete sql here
            $delete_id = $_GET['deleteadmin'];
            $result = $mysqli->query("DELETE FROM admin WHERE AdminID=$delete_id");

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
    <form action="manageadmin.php" method="POST">
    <a href="manageadmin.php" class="closebutton" style="font-weight: 700; font-size: 22px;">X</a>
        <p>Edit Admin Details</p>
        <input type="hidden" name="update_adminID" value="<?php echo $edit_id; ?>">
            
            <div class="form-group">
            <label>Username:</label>
            <input type="text" name="update_admin_username" value="<?php echo $Username;?>">
            </div>
            
            <div class="form-group">
            <label>Password:</label>
            <input type="text" name="update_admin_Password" value="<?php echo $Password;?>">
            </div>

            <!-- <button type=submit >Update</button> -->
            <button type="submit" name="editadmin_detial">Update</button>

    </form>
    </div>
    


    <?php

    $display_add = "display: none;";
    if(isset($_GET['addadmin'])) {    
    $display_add = "display: flex;";
    }

    ?>

    <!-- ADD ADMIN -->
    <!-- Add alert -->
    <div class="popUpForm" style="<?php echo $display_add?>">
        <form action="manageadmin.php?do=add_admin" method="POST">
        <a href="manageadmin.php" class="closebutton" style="font-weight: 700; font-size: 22px;">X</a>
        <p>Add Admin</p>
            <!-- add input HERE -->
            <div class="form-group">
            <label>Username:</label>
            <input type="text" name="add_adminUsername" placeholder="Username">
            </div>
            
            <div class="form-group">
            <label>Password:</label>
            <input type="text" name="add_adminPassword" placeholder="Password">
            </div>

            <!-- <button type=submit >Update</button> -->
            <button type="submit" name="add_admin">Update</button>
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






