<?php 
include('server.php') ;
$login_username=$_SESSION['username'];
$query = "SELECT * FROM `user` WHERE Username='$login_username'";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$row = mysqli_fetch_assoc($result);

session_start(); 

   if (!isset($_SESSION['username'])) {
       $_SESSION['msg'] = "You must log in username first";
       header('location: login.php');
   }


// Session timeout duration in seconds
$timeout_duration = 1800; // 1800 seconds = 30 minutes / 30 seconds = 1 minutes

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="navBar.css">
    <link rel="stylesheet" href="mainTheme.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="Images/logo_nav.png" type="image/x-icon">
    
    <style>

        html,body{
            overflow-x: hidden;
        }

        body {
            flex-direction: column;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0; /* Set your desired background color */
            margin: 0;
            width: 100%;
        }

        header {
            width: 100%;
        }

        .Userform{
            background-color: #FAF1DF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add a box shadow for a card-like effect */
            width: 100%;  
            font-family: 'JetBrains Mono', monospace; 
            font-size: 18px;
            font-weight: 700;
        }

        .Userform input{
            font-family: 'JetBrains Mono', monospace; 
            font-size: 16px;
        }

        .Userform select{
            font-family: 'JetBrains Mono', monospace; 
            font-size: 16px;
        }

        main {
            margin: 50px 0px;
            flex-direction: column;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        form.UserProfile {
            text-align: left;
            flex-direction: column;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 90%;
            max-width: 600px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        select, input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            background-color: transparent;
            border: none;
            border-bottom: solid 2px #000;
        }

        .userprofile-button {
            padding: 10px 20px;
            background-color: #000;
            color: #fff;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            cursor: pointer;       
            margin-top: 50px;
            font-family: 'JetBrains Mono', monospace; 
            font-size: 20px;
            border: 4px solid #000000;
        }

        .userprofile-button:hover {
            background-color: #0132ab; /* Set your desired button hover color */
        }
        
        hr{
            width:75%;
            margin-top: 50px;
            border-color: #000;
            background-color: #000000;
            height: 4px;
        }
        .error {
            width: 80%; 
            margin: 0px auto; 
            padding-left: 5px;
            padding-right: 5px; 
            padding-top: 5px;
            padding-bottom: 5px;
            border: 1px solid #a94442; 
            color: #a94442; 
            background: #f2dede; 
            border-radius: 5px; 
            font-size: 15px;
            text-align: left;
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

<body>
    <header>
        <section>
            <!-- navbar -->
            <div>
                <div class="logout_section">
                    <a href="index.html" <?php unset($_SESSION['username']);?> class="logout_button"> Log Out</a>
                </div>

                <div class="page_title">
                    <h1> PROFILE. </h1>
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
    
    <main>
      
       
        <?php include('errors.php');?> 
        <form class="UserProfile" action="profile.php" method="post">
        <div class="Userform">
        <input type="hidden" name="usrprofile_userID" value="<?php echo $row['UserID']; ?>">
        <div>
            <label>Username:</label>
            <input type="text" name="usrprofile_username" value="<?php echo $row['Username']; ?>">
        </div>   
        <div>
            <label>Phone Number:</label>
            <input type="text" name="usrprofile_phone_number" value="<?php echo $row['PhoneNumber']; ?>">
        </div>
        <div>
            <label>Address:</label>
            <input type="text" name="usrprofile_address" value="<?php echo $row['Address']; ?>">
       </div>
       <div>
            <label>Age:</label>
            <select name="usrprofile_age" >
                <option value="" disabled selected>Please Select</option>
                <option <?php if("18-24"==$row["Age"]) echo 'selected="selected"'; ?>>18-24</option>
                <option <?php if("25-34"==$row["Age"]) echo 'selected="selected"'; ?>>25-34</option>
                <option <?php if("35-44"==$row["Age"]) echo 'selected="selected"'; ?>>35-44</option>
                <option <?php if("45-54"==$row["Age"]) echo 'selected="selected"'; ?>>45-54</option>
                <option <?php if("55-64"==$row["Age"]) echo 'selected="selected"'; ?>>55-64</option>
                <option <?php if("65+"==$row["Age"]) echo 'selected="selected"'; ?>>65+</option>
            </select>
        </div> 
        <div>
            <label for="dateofbirth">Date of Birth:</label>
            <input type="date" name="usrprofile_dateofbirth" value="<?php echo $row['Dateofbirth']; ?>">
              
       </div>
         
         <div>
            <label>Gender:</label>
                 <select name="usrprofile_gender">
                <option <?php if("M"==$row["Gender"]) echo 'selected="selected"'; ?>>Male</option>
                <option <?php if("F"==$row["Gender"]) echo 'selected="selected"'; ?>>Female</option>
        		</select>
         </div>

        <div>    
            <label>Occupation:</label>
            <select name="usrprofile_occupation">
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
    </div>
    <button type="submit" class="userprofile-button" name="usrprofile_user" >Update</button>
    <hr>
        </form>
      
     
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