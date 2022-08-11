<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="Edit_Profile.css">
</head>
<body>
<?php
if(isset($_POST['button']))
{
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $father_name = $_POST['father_name'];
    $age = $_POST['age'];
    $num = $_POST['number'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $postal_code = $_POST['postal_code'];
    $Img = $_POST['pic'];
    $institute = $_POST['institute'];
    $DOB = $_POST['DOB'];
    $Dept_Id = $_POST['deptId'];
    $email_1 = $_POST['email'];
    $Img = "/DB_Project/Images/".$Img;
    
    $host    = $_SESSION["ip"];
    $port    = 4950;
    $message = array("Faculty_Edit","Faculty_Update",$fname,$lname,$father_name,$age,$num,$city,$country,$postal_code,$Img,$institute,$DOB,$Dept_Id,$email_1);
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
    
    if($result=="true")
    {
        header("Location:Faculty_Dashboard.php");
        socket_close($socket);
    }
    else
    {
        echo "Query Not executed.".$result;
        socket_close($socket);
    }
}
?>
    <div class="container">
        <nav>
            <ul>
                <li id="list-1"><img src="Icons/menu.png" alt="Loading"></li>
                    
                <li class="list" id="list-2" onmouseover="showtext(2)" onmouseout="hidetext(2)"><a href="Faculty_DashBoard.php"><img
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
                            src="Icons/education.png" alt="Loading"></a>
                    <p id="text-5">My Courses</p>
                </li>
                <li class="list" id="list-6" onmouseover="showtext(6)" onmouseout="hidetext(6)"><a href=""><img
                            src="Icons/result.png" alt="Loading"></a>
                    <p id="text-6">Result</p>
                </li>

                <li class="list" id="list-7" onmouseover="showtext(7)" onmouseout="hidetext(7)"><a href=""><img
                            src="Icons/files.png" alt="Loading"></a>
                    <p id="text-7">Private Files</p>
                </li>
            </ul>
        </nav>


        <section>
            <!-- This is Section -->
            <div class="logo">

            
                <img src="/DB_Project/Images/LMS Logo.png" alt="Loading">

                <div class="right">
                    <span id='currentDate'></span>
                </div>
            </div>
            <div class="profile">

<?php
$email = $_SESSION['email'];
$type = $_SESSION['type'];
$name = $_SESSION['name'];

    // $sql3 = "Select Fac_Image from Faculty as F
    //         inner join Account as A
    //         on A.FacID = F.FacID
    //         where A.Email = '$email' and A.type = 'Faculty';";
    // $stmt3 = mysqli_query($conn,$sql3);

?>     
                    
                <img src="<?php echo "pic/image"; ?>" alt="Add Pic">
                <span><?php echo $name; ?></span>
            </div>
            <div class="edit">
                <span><?php echo $name; ?></span>
                <form class="input" method="post">


<?php
$host    = $_SESSION["ip"];
$port    = 4950;
$message = array("Faculty_Edit","Faculty_Values",$email,$type);
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
            

socket_close($socket)
?>


                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" value="<?php echo $result[0]; ?>">

                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" value="<?php echo $result[1]; ?>">

                    <label for="father_name">Father Name</label>
                    <input type="text" name="father_name" id="father_name" value="<?php echo $result[2];?>">
                    
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $result[3]; ?>">

                    <label for="number">Mobile Number</label>
                    <input type="number" name="number" id="number" value="<?php echo $result[4]; ?>">

                    <label for="city">City/Town</label>
                    <input type="text" name="city" id="city" value="<?php echo $result[5]; ?>">
                    
                    <label for="country">Counrty</label>
                    <input type="text" id="country" name="country" value="<?php echo $result[6]; ?>">
                    
                    <label for="postal_code">Postal Code</label>
                    <input type="text" id="postal_code" name="postal_code" value="<?php echo $result[7]; ?>">

                    <label for="current_pic">Current Picture</label>
                    <img src="<?php echo $result[8]; ?>" alt="Loading" height=150px width=150px>
                    <label for="pic">Picture</label>
                    <input type="file" name="pic" id="pic" value="<?php echo $result[8]; ?>">
                    
                    <label for="institute">Institute</label>
                    <input type="text" id="institute" name="institute" value="<?php echo $result[9]; ?>">
                    
                    <label for="DOB">Date of Birth</label>
                    <input type="date" name="DOB" id="DOB" value="<?php echo $result[10]; ?>">
                    
                    <label for="institute">DeptID</label>
                    <input type="text" id="dept" name="deptId" value="<?php echo $result[11]; ?>">
                    
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="<?php echo $result[12]; ?>">
                    
                    <input type="submit" name="button" id="button" value="Update">
                </from>
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