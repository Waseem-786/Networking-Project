<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment</title>
    <link rel="stylesheet" href="Signup.css">
</head>
<body>
    <div class="body">

    
        <div class="container">
            <h1>Student Enrollment in Course</h1>
            <hr>
            <form method="post">
                
                <label for="StdID">ID</label>
                <input type="text" class="input" id="StdID" name="StdID" placeholder="Enter Student ID">
                
                <label for="CrsID">Course ID</label>
                <input type="text" class="input" id="CrsID" name="CrsID" placeholder="Enter Course ID">
    
                <label for="start">Course Start Date</label>
                <input type="date" class="input" id="start" name="start" placeholder="Enter Course Start Date">
                
                <label for="end">Course End Date</label>
                <input type="date" class="input" id="end" name="end" placeholder="Enter Course End Date">
                
                <input type="submit" name="button" class="input" id="button" value="Add Course">
                <a href="Admin_DashBoard.php" id="account">Don't Want to add Course</a>

            </form>
        </div>
    </div>
                
<?php
    

    if(isset($_POST['button']))
    {
        $StdID = $_POST['StdID'];
        $CrsID = $_POST['CrsID'];
        $start = $_POST['start'];
        $end = $_POST['end'];

        $host    = $_SESSION["ip"];
        $port    = 4950;
        $message = array("Std_Crs_Enroll",$StdID,$CrsID,$start,$end);
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