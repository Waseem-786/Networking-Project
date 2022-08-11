<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="Signup.css">
</head>
<body>
    <div class="body">

    
    <div class="container">
        <h1>SignUp Form</h1>
        <hr>
        <form method="post">
            
            <label for="StdID">ID</label>
            <input type="text" class="input" id="ID" name="ID" placeholder="Enter Your ID">

            <label for="FirstName">FirstName</label>
            <input type="text" class="input" id="FirstName" name="FName" placeholder="Enter Your Name">
            
            <label for="LastName">LastName</label>
            <input type="text" class="input" id="LastName" name="LName" placeholder="Enter Your Last Name">
            
            <label for="father_name">Father Name</label>
            <input type="text" class="input" name="father_name" id="father_name" placeholder="Enter Your Father Name">

            <label for="age">Age</label>
            <input type="number" class="input" name="age" id="age" placeholder="Enter Your Age">

            <label for="num">Mobile Number</label>
            <input type="number" class="input" name="num" id="num" placeholder="Enter Your Mobile Number">

            <label for="city">City</label>
            <input type="text" class="input" name="city" id="city" placeholder="Enter Your City Name">
            
            <label for="country">Country</label>
            <input type="text" class="input" name="country" id="country" placeholder="Enter Your Country Name">
            
            <label for="postal_code">Postal Code</label>
            <input type="number" class="input" name="postal_code" id="postal_code" placeholder="Enter Postal Code">
            
            <label for="Institute">Institute</label>
            <select name="Institute" id="Institute" class="input">
                <option value="none">Choose Institute</option>
                <option value="H12">NUST_H12</option>
                <option value="MCS">MCS</option>
                <option value="EME">EME</option>
            </select>

            <label for="type">Account Type</label>
            <select name="type" id="type" class="input">
                <option value="none">Choose Account Type</option>
                <option value="Student">Student</option>
                <option value="Admin">Admin</option>
                <option value="Faculty">Faculty</option>
            </select>

            <label for="Email">Email</label>
            <input type="text" class="input" id="Email" name="Email" placeholder="Enter Your Email">
            
            <label for="Password">Password</label>
            <input type="password" class="input" name="password" id="Password" placeholder="Enter Your Password">
            
            <label for="Password">Confirm Password</label>
            <input type="password" class="input" name="confirm_password" id="Password" placeholder="Re-Enter Your Password">

            <input type="submit" name="button" class="input" id="button" value="SignUp">
            <a href="Admin_DashBoard.php" id="account">Already have an account</a>
        </form>
    </div>
</div>
    <?php
    if(isset($_POST['button']))
    {
            $ID = $_POST['ID'];
            $fname = $_POST['FName'];
            $lname = $_POST['LName'];
            $father_name = $_POST['father_name'];
            $age = $_POST['age'];
            $num = $_POST['num'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $postal_code = $_POST['postal_code'];
            $institute = $_POST['Institute'];
            $type = $_POST['type'];
            $email = $_POST['Email'];
            $pass = $_POST['password'];
            $confirm = $_POST['confirm_password'];
            
            $host    = $_SESSION["ip"];
            $port    = 4950;
            $message = array("Signup",$ID,$fname,$lname,$father_name,$age,$num,$city,$country,$postal_code,$institute,$type,$email,$pass,$confirm);
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
            echo $result;
            if($result=="true")
            {
                header("Location: Admin_Dashboard.php");
                socket_close($socket);
            }
            else
            {
                echo "Query Not executed.".$result;
                socket_close($socket);
            }
        }
    
    ?>
</body>
</html>
