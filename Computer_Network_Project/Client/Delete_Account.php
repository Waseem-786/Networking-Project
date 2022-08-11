<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="Signup.css">
</head>
<body>
    <div class="body">
    
    <div class="container">
        <h1>Delete Account</h1>
        <hr>
        <form method="post">
            
            <label for="StdID">ID</label>
            <input type="text" class="input" id="ID" name="ID" placeholder="Enter Your ID">

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
            
            <input type="submit" name="button" class="input" id="button" value="Delete">
            <a href="Admin_DashBoard.php" id="account">Don't want to delete</a>
        </form>
    </div>
</div>
    <?php
if(isset($_POST['button']))
{
    $ID = $_POST['ID'];
    $type = $_POST['type'];
    $email = $_POST['Email'];
    $pass = $_POST['password'];
            
    $host    = $_SESSION["ip"];
    $port    = 4950;
    $message = array("Delete_Account",$ID,$type,$email,$pass);
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
