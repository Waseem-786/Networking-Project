<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal</title>
    <link rel="stylesheet" href="Portal.css">
</head>

<body>
    <div class="container">
        <nav class="logo">
                <img src="/DB_Project/Images/LMS Logo.png" alt="Loading" height="70px">
                <div class="right">
                    <span id='currentDate'></span>
                </div>
        </nav>

        <section>
            <form action="" method="post" class="login">
                <h3>Access to the platform</h3>
                <label for="Email">Email</label>
                <input type="text" class="input" id="Email" name="Email" placeholder="Enter Your Email">
        
                <label for="Password">Password</label>
                <input type="password" class="input" name="password" id="Password" placeholder="Enter Your Password">
        
                <input type="submit" name="button" class="input" id="button" value="Login">
    
            </form>
        </section>
    </div>

    <script>
        let t = new Date();

        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        document.getElementById("currentDate").innerHTML = monthNames[t.getMonth()] + ", " + t.getDate() + " " + t.getFullYear() + " " + t.getHours() + ":" + t.getMinutes() + ":" + t.getSeconds();
    </script>
    <?php
        $type = $_SESSION['type'];  //From Account Type file Get Selected value.
        
    
        if(isset($_POST['button']))
        {
            $email = $_POST['Email'];
            $pass = $_POST['password'];
            // Email Session
            $_SESSION['email'] = $email;
            // End
            $host    = $_SESSION["ip"];
            $port    = 4950;
            $message = array("email_pass_validator",$email,$pass,$type);
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
            if($result == "true")
            {
                if($type == 'Student')
                    header("Location:Student_DashBoard.php");
                else if($type == 'Faculty')
                    header("Location:Faculty_DashBoard.php");
                else
                    header("Location:Admin_DashBoard.php");
                socket_close($socket);
            }
            else if($result == "false")
            {
    ?>
                <style>
                    .incorrect
                    {
                        color: red;
                        margin: -80px 0px 0px 70%;
                    }
                </style>
                <p class='incorrect'><?php echo "Email or Password is Incorrect"; ?></p> 
    <?php
                socket_close($socket);
            }    
        }
    ?>
</body>
</html>