<?php 
    require ("connect.php");
    // connect to database
    $db = mysqli_connect("localhost", "root", "", "flood_website");


    $popup = '';
if(isset($_GET['action'])){
    if($_GET['action'] == "open_popup" && isset($_GET['alert_id'])) { 
        $alert_id = $_GET['alert_id'];

        $a = "SELECT * FROM alerts where id = $alert_id";
        $run = @mysqli_query($db, $a);  // Run the query.

        if ($run){
            while ($row = mysqli_fetch_array($run, MYSQLI_ASSOC)) {
            $popup = '
                <div class="pop_up">
                    <div style="width:20%;">
                        <a href="?action=none"  class="close-btn alert_arrow" style:align-items:flex-start;"">
                            <img src="Images/black_arrow.png">
                        </a> 
                    </div>       
                    <div style="width:70%;">
                        <div class="title_text" style="color: #0132ab;">'.$row["location"].'.</div><br>
                        <div class="content_text">
                            <div>District: '.$row["district"].'</div><br><br>
                            <div style="color:red; font-weight: 700;">Severity: '.$row["severity"].'/4</div>
                            <div>Trend: '.$row["trend"].'</div><br>
                            <div>Last Update: '.$row["date_time"].'</div>
                        </div>
                    </div>
                </div>';
            }
        };
    };
};
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="navBar.css">
    <link rel="stylesheet" href="mainTheme.css">
    <link rel="stylesheet" href="alert.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="Images/logo_nav.png" type="image/x-icon">
<body>
    <header>
        <section>
            <!-- navbar -->
            <div>
                <div class="redirect_home">
                    <a href="index.html" >AQUA SAFE.</a>
                </div>

                <div class="page_title">
                    <h1> FLOOD ALERT. </h1>
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
                        <br><a href="profile.php">Profile</a>
                    </div>
                </div>
                
                <div class="text nav_con2 nav_line_main">
                    <nav>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><a href="donate.html">Donation</a></li>
                            <li><a href="floodAlert.php" class="active">Flood Alert</a></li>
                            <br><br><br><br>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    </header>

    <main class="full_width">
        <section style="z-index: 2; inset: initial;">
            <section class="content_container"> 
                <div class="map_container" id="map">
                    
                </div>
            </section>
            
            <section>
                <div class="search_container">
                    <form method="post" class="overall_alignmentL" style="display:flex;">
                        <input type="text" placeholder="Search Locations..." name="search" class="content_text search_bar ">
                        <button class="form_button" name="submit">Search</button>
                        <a class="refresh_button" name="refresh" href="floodAlert.php">
                            <img src="Images/refresh.png" alt="refresh button" class="refresh_img">

                        </a>
                    </form>
                </div>
                <div class="alert_section">

                    <table class="overall_alignmentL">
                        <?php 
                        // Make the query:
                            $q = "SELECT id,  location, district, severity, date_time FROM alerts ORDER BY date_time DESC";
                            $r = @mysqli_query($db, $q);                      // Run the query.
                            $table_row = "";

                            // Count the number of returned rows:
                            $num = mysqli_num_rows($r);
                            if ($num > 0) { // If it ran OK, display the records.

                                echo '<table class="alert_container content_text">';
                                // Fetch and print all the records:
                                while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                                    $table_row .= "<tr id='p".$row['id']."'><td align='left' class='alert_align'> 
                                    <div class='alert_info'>
                                        <div style='font-size: 24px; font-weight: 700; text-decoration: underline;'>$row[location].<br></div>
                                        <div class='info_subcontainer'> 
                                            <div>$row[district]</div>
                                            <div>$row[severity]/4</div> 
                                            <div>$row[date_time]</div>
                                        </div>
                                    </div>
                                    <a id='open-pop_up'  href='?action=open_popup&alert_id=". $row['id'] ."' class='alert_arrow'><img src='Images/black_arrow.png'></a>
                                    </td></tr>";
                                };                                
                                mysqli_free_result ($r); // Free up the resources.	
                            
                            } else { // If no records were returned.
                                echo '<p class="error">There are Currently no Alerts.</p>';
                            }
                            
                            if(isset($_POST['submit'])){
                                $search = $_POST['search'];
                                //alerts is table name in databse
                                $sql = "Select * from alerts where location='".$search."' or district='".$search."'";
                                $result = mysqli_query($db, $sql);
                                $table_row = "";
                                if($result){
                                    if(mysqli_num_rows($result)>0){
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                                            
                                            $table_row .= "<tr id='p".$row['id']."'><td align='left' class='alert_align'>
                                                                <div class='alert_info'>
                                                                <div style='font-size: 24px; font-weight: 700; text-decoration: underline;'>".$row['location']."<br></div>
                                                                <div class='info_subcontainer'> 
                                                                    <div>".$row['district']."</div>
                                                                    <div>".$row['severity']."/4</div> 
                                                                    <div>".$row['date_time']."</div>
                                                                </div>
                                                            </div>
                                                            <a id='pop_up' href='?action=open_popup&alert_id=". $row['id'] ."' class='alert_arrow'><img src='Images/black_arrow.png'></a>
                                                            </td></tr>";
                                        }
                                    } else {
                                        $table_row .=  '<h2 class="title_text">Data not Found</h2>';
                                    }
                                }
                              
                            }
                            echo $table_row;
                            echo '</table>'; // Close the table.
                            
                        ?>
                        
                    </table>
                    
                </div>
            </section>

        </section> 

       
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

    <?php echo $popup; ?>

    <script src="navScript.js"></script>

    <script>

        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
            key:"AIzaSyBabJ8R0XRxfQzHHHPQ0pgRueSi5ygmJ_A",
            v: "weekly",
            // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
            // Add other bootstrap parameters as needed, using camel case.
        });

        //location string input is translated to long and lat codes
        async function getLatLng(geocoder, address) {
            return new Promise((resolve, reject) => {
                geocoder.geocode({ 'address': address }, (results, status) => {
                    if (status === 'OK') {
                        resolve({
                            lat: results[0].geometry.location.lat(),
                            lng: results[0].geometry.location.lng()
                        });
                    } else {
                        reject('Geocode was not successful for the following reason: ' + status);
                    }
                });
            });
        }
        
        let map;

        //initialiasing the map
        async function initMap() {
            const { Map, Geocoder, Marker } = await google.maps.importLibrary("maps");

            map = new Map(document.getElementById("map"), {
                //setting the view focus of the map
                center: { lat: 3.1142292206934625, lng: 107.88125877188936 },
                zoom: 6.5,
            });

            

        const geocoder = new google.maps.Geocoder()

            <?php 
                $sql = "Select * from alerts";
                $result = mysqli_query($db, $sql);

                if($result){
                    if(mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                        $img_array = array(
                            "Images/0.png",
                            "Images/1.png",
                            "Images/2.png",
                            "Images/3.png",
                            "Images/4.png"
                        );

                        $icon = $img_array[$row['severity']];

                        
                        $lat =0;
                        $lng = 0;

                        echo '
                        const address'.$row['id'].' = "'.$row['location'].', ' .$row['district'].'"
                        try {
                        const coordinate'.$row['id'].' = await getLatLng(geocoder, address'.$row['id'].');
                        
                        //add marker
                        const marker'.$row['id'].' = new google.maps.Marker({
                            map,
                            position: coordinate'.$row['id'].',
                            title: "'.$row['location'].'",
                            icon: {
                            url: "'.$icon.'"
                            }
                          });

                        //add php to scroll to specific alert when click on marker
                        google.maps.event.addListener(marker'.$row['id'].', "click", function() {
                            window.location.hash="p'.$row['id'].'";
                            return true;
                        });

                        } catch (e) {
                            console.error("Error:", e);
                        }

                        ';
                    }
                    } else {
                        echo '<h2 class="title_text">Data not Found</h2>';
                    }
                }
            ?>

            }


        initMap();
    </script>

</body>

</html>