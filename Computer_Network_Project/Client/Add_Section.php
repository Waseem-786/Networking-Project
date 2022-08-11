<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Section</title>
    <link rel="stylesheet" href="Signup.css">
</head>
<body>
    <div class="body">

    
        <div class="container">
            <h1>Add Section in Batch</h1>
            <hr>
            <form method="post">
                
                <label for="section">Section</label>
                <input type="text" class="input" id="section" name="section" placeholder="Enter Section name">
    
                <label for="batch">Batch</label>
                <input type="text" class="input" id="batch" name="batch" placeholder="Enter Batch Name">
                
                <input type="submit" name="button" class="input" id="button" value="Add Section">
                <a href="Admin_DashBoard.php?email=<?php echo $_GET['email']; ?>" id="account">Don't Want to add Section</a>
            </form>
        </div>
    </div>

<?php
    
    if(isset($_POST['button']))
    {
        $section = $_POST['section'];
        $batch = $_POST['batch'];

        $host = $_SESSION["ip"];
        $port    = 4950;
        $message = array("Add_Section",$section,$batch);
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