<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department</title>
    <link rel="stylesheet" href="Signup.css">
</head>
<body>
    <div class="body">

    
        <div class="container">
            <h1>Add Department in University</h1>
            <hr>
            <form method="post">
                
                <label for="DID">Department ID</label>
                <input type="text" class="input" id="DID" name="DID" placeholder="Enter Department ID">
    
                <label for="name">Department Name</label>
                <input type="text" class="input" id="name" name="name" placeholder="Enter Department Name">
                
                <label for="location">Location</label>
                <input type="text" class="input" id="location" name="location" placeholder="Enter Department Locatin">
                
                <input type="submit" name="button" class="input" id="button" value="Add Department">
                <a href="Admin_DashBoard.php" id="account">Don't Want to add Department</a>
            </form>
        </div>
    </div>

<?php
    
    if(isset($_POST['button']))
    {
        $DID = $_POST['DID'];
        $name = $_POST['name'];
        $location = $_POST['location'];
        
        $host = $_SESSION["ip"];
        $port    = 4950;
        $message = array("Add_Dept",$DID,$name,$location);
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