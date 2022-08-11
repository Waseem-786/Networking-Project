<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty DashBoard</title>
    <link rel="stylesheet" href="Faculty_DashBoard.css">
</head>
<body>
    <div class="container">
        <div class="container">
            <nav>
                <ul>
                    <li id="list-1"><img src="Icons/menu.png" alt="Loading"></li>
                    <li class="list" id="list-2" onmouseover="showtext(2)" onmouseout="hidetext(2)"><a href=""><img
                                src="Icons/dashboard.png" alt="Loading"></a>
                        <p id="text-2">DashBoard</p>
                    </li>
                    <li class="list" id="list-3" onmouseover="showtext(3)" onmouseout="hidetext(3)"><a href=""><img
                                src="Icons/home.png" alt="Loading"></a>
                        <p id="text-3">Home</p>
                    </li>
                    <li class="list" id="list-4" onmouseover="showtext(4)" onmouseout="hidetext(4)"><a href=""><img
                                src="Icons/view-shedule.png" alt="Loading"></a>
                        <p id="text-4">Calender</p>
                    </li>
                    <li class="list" id="list-5" onmouseover="showtext(5)" onmouseout="hidetext(5)"><a href=""><img
                                src="Icons/attendance.png" alt="Loading"></a>
                        <p id="text-5">Attendance</p>
                    </li>
                    <li class="list" id="list-6" onmouseover="showtext(6)" onmouseout="hidetext(6)"><a href=""><img
                                src="Icons/result.png" alt="Loading"></a>
                        <p id="text-6">Result</p>
                    </li>
    
                    <li class="list" id="list-7" onmouseover="showtext(7)" onmouseout="hidetext(7)"><a href="Chat_App.php"><img
                            src="Icons/feedback.png" alt="Loading"></a>
                    <p id="text-7">Chat Application</p>
                    </li>
                </ul>
            </nav>
    
    
            <section>
                <!-- This is Section -->
                <div class="logo">
<?php
$email = $_SESSION['email'];

    // $sql3 = "Select Fac_Image from Faculty as F
            // inner join Account as A
            // on A.FacID = F.FacID
            // where A.Email = '$email' and A.type = 'Faculty';";
    // $stmt3 = mysqli_query($conn,$sql3);
    // if($stmt3)
    // $row3 = mysqli_fetch_array($stmt3);
?>     
                    <img src="/DB_Project/Images/LMS Logo.png" alt="Loading">
    
                    <div class="right">
                        <span id='currentDate'></span>
                        <a href="Account_Type.php">Logout</a>
                    </div>
                </div>
                <div class="profile">
                    <img src="<?php echo $row3[0]; ?>" alt="Add Pic">

<?php
$host    = $_SESSION["ip"];
$port    = 4950;
$message = array("Faculty_Dashboard","name",$email);
$message = json_encode($message);
            
// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
// send string to server
        
socket_write($socket, $message,strlen($message)) or die("Could not send data to server\n");

// From Server
$result = socket_read($socket, 1024) or die("Could not read server response\n");
$result = json_decode($result);
            

$name = $result[0]." ".$result[1];
$_SESSION['name'] = $name;
socket_close($socket);
?>      
                    <span>
                        <?php echo $name; ?>
                    </span>
                    <a href="Faculty_Edit_Profile.php"><input type="button" value="Edit_Profile"></a>
    
                </div>
                <div class="courses">
                    <span>My Classes</span>
                    <div class="subjects">
<?php
$host    = $_SESSION["ip"];
$port    = 4950;
$message = array("Faculty_Dashboard","count_classes",$email);
$message = json_encode($message);

// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
// send string to server

socket_write($socket, $message,strlen($message)) or die("Could not send data to server\n");

// From Server
$result = socket_read($socket, 1024) or die("Could not read server response\n");
$count = json_decode($result);
$count = $count[0];

socket_close($socket);

$host    = $_SESSION["ip"];
$port    = 4950;
$message = array("Faculty_Dashboard","classes",$email);
$message = json_encode($message);
            
// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
// send string to server
        
socket_write($socket, $message,strlen($message)) or die("Could not send data to server\n");

// From Server
$result = socket_read($socket, 1024) or die("Could not read server response\n");
$result = json_decode($result);
            

$i = 0;
while($i!=$count)
{
?>
    <div class="subject">
        <p id="section"><?php echo $result[$i][0].$result[$i][1];?></p>
        <p> Subject : <?php echo $result[$i][2]; ?></p>
        <p> Class : <?php echo $result[$i][3]; ?></p>
        <p> Class Start Time : <?php echo $result[$i][4]; ?></p>
        <p> Credit End Time : <?php echo $result[$i][5]; ?></p>
    </div>
<?php
    $i++;
}
socket_close($socket);
?>
                    </div>
                </div>
                <div id="Contact_us">
                    <div class="container">
                        <div class="info">
                            <h1>INFO</h1>
                        </div>
                        <div class="cont">
                            <h1>Contact us</h1>
                            <p>NUST - LMS @ SEECS NUST H-12 Islamabad</p>
                            <p>E-mail : lms@seecs.edu.pk</p>
                            <p>LMS Focal Person (Institute Wise)</p>
                        </div>
                        <div class="social_links">
                            <h1>Social Links</h1>
                        </div>
                    </div>
                    <div class="copy_right">
                        <p>2020 © NUST - LMS. All rights reserved.</p>
                    </div>
                </div>
            </section>
        </div>
    
    
        <script>
            let t = new Date();
    
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    
            document.getElementById("currentDate").innerHTML = monthNames[t.getMonth()] + ", " + t.getDate() + " " + t.getFullYear() + " " + t.getHours() + ":" + t.getMinutes() + ":" + t.getSeconds();
        </script>
    
        <script>
            function showtext(a) {
                if (a == 2) {
                    let para = document.getElementById('text-2');
                    para.style.visibility = 'visible';
                }
                else if (a == 3) {
                    let para = document.getElementById('text-3');
                    para.style.visibility = 'visible';
                }
                else if (a == 4) {
                    let para = document.getElementById('text-4');
                    para.style.visibility = 'visible';
                }
                else if (a == 5) {
                    let para = document.getElementById('text-5');
                    para.style.visibility = 'visible';
                }
                else if (a == 6) {
                    let para = document.getElementById('text-6');
                    para.style.visibility = 'visible';
                }
                else if (a == 7) {
                    let para = document.getElementById('text-7');
                    para.style.visibility = 'visible';
                }
            }
            function hidetext(a) {
                if (a == 2) {
                    let para = document.getElementById('text-2');
                    para.style.visibility = 'hidden';
                }
                else if (a == 3) {
                    let para = document.getElementById('text-3');
                    para.style.visibility = 'hidden';
                }
                else if (a == 4) {
                    let para = document.getElementById('text-4');
                    para.style.visibility = 'hidden';
                }
                else if (a == 5) {
                    let para = document.getElementById('text-5');
                    para.style.visibility = 'hidden';
                }
                else if (a == 6) {
                    let para = document.getElementById('text-6');
                    para.style.visibility = 'hidden';
                }
                else if (a == 7) {
                    let para = document.getElementById('text-7');
                    para.style.visibility = 'hidden';
                }
            }
        </script>
</body>
</html>