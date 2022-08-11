<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Record</title>
    <link rel="stylesheet" href="Student_Record.css">
</head>

<body>
    <div class="container">
        <div class="nav">
            <h1>Student Course Record</h1>
            <form class="search" method="post">
                <input type="submit" value="Show All" name="show">
                <input type="search" name="search" id="search">
                <input type="submit" name="submit" id="submit" value="Search">
            </form>
        </div>

        <Table>
            <tr id='Main'>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Course Start Date</th>
                <th>Course End Date</th>
            </tr>

<?php

    if(isset($_POST['submit'])==false or isset($_POST['show'])) //Default and Show All Condition
    {
        $host    = $_SESSION["ip"];
        $port    = 4950;
        $message = array("Count_Std_Crs_Record");
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

        $message = array("Std_Crs_Record");
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
                <tr class='row'>
                    <th><?php echo $result[$i][0]; ?></th>
                    <th><?php echo $result[$i][1]; ?></th>
                    <th><?php echo $result[$i][2]; ?></th>
                    <th><?php echo $result[$i][3]; ?></th>
                    <th><?php echo $result[$i][4]; ?></th>
                    <th><?php echo $result[$i][5]; ?></th>
                </tr>

<?php
            $i++;
        }
        socket_close($socket);
    }
?>


<?php
    if(isset($_POST['submit']))
        {
            $search = $_POST['search'];

            $host    = $_SESSION["ip"];
            $port    = 4950;
            $message = array("Count_Show_Std_Crs_Record",$search);
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

            $message = array("Show_Std_Crs_Record",$search);
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
            <style>
                .row {
                    display: none;
                }
            </style>
            <tr class='search'>
                <th><?php echo $result[$i][0]; ?></th>
                <th><?php echo $result[$i][1]; ?></th>
                <th><?php echo $result[$i][2]; ?></th>
                <th><?php echo $result[$i][3]; ?></th>
                <th><?php echo $result[$i][4]; ?></th>
                <th><?php echo $result[$i][5]; ?></th>
            </tr>

<?php
                $i++;
            }
        }
?>
        </Table>
    </div>
</body>

</html>