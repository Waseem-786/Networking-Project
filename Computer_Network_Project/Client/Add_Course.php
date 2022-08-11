<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="Signup.css">
</head>
<body>
    <div class="body">

    
        <div class="container">
            <h1>Add Course in University</h1>
            <hr>
            <form method="post">
                
                <label for="CrsID">Course ID</label>
                <input type="text" class="input" id="CrsID" name="CrsID" placeholder="Enter Course ID">
    
                <label for="CrsName">Course Name</label>
                <input type="text" class="input" id="CrsName" name="CrsName" placeholder="Enter Course Name">
                
                <label for="hours">Credit Hours</label>
                <select name="hours" id="hours" class="input">
                    <option value="none">Choose Credit Hours</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>

                <label for="P_CrsName">Pre-Req Course Name</label>
                <select name="P_CrsName" id="P_CrsName" class="input">
                    <option value="none">Choose Pre Req</option>
                    <option value="NULL">NULL</option>
                
<?php
    
    $host    = $_SESSION["ip"];
    $port    = 4950;
    $message = array("Pre_Req");
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
    if($result)
    {
        $name = $result[0];
?>
            <option value="<?php echo $name;?>"><?php echo $name;?></option>
<?php            
        socket_close($socket);    
    }
    else
    {
        echo "Query Not executed.".$result;
        socket_close($socket);
    }
?>

</select>
        <input type="submit" name="button" class="input" id="button" value="Add Course">
        <a href="Admin_DashBoard.php" id="account">Don't Want to add Course</a>

        </form>
    </div>
</div>

<?php    
    if(isset($_POST['button']))
    {
        $CrsID = $_POST['CrsID'];
        $CrsName = $_POST['CrsName'];
        $P_CrsName = $_POST['P_CrsName'];
        $hours = $_POST['hours'];

        $message = array("Add_Course",$CrsID,$CrsName,$P_CrsName,$hours);
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

        if($result == 'true')
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