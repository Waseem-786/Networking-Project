<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment of Classes</title>
    <link rel="stylesheet" href="Signup.css">
</head>
<body>
    <div class="body">

    
        <div class="container">
            <h1>Classes Assigned to Faculty</h1>
            <hr>
            <form method="post">
                
                <label for="cname">Class Name</label>
                <select name="cname" id="cname" class="input">
                    <option value="none">Choose Class</option>
                    <option value="CR_31">CR_31</option>
                    <option value="CR_32">CR_32</option>
                    <option value="CR_33">CR_33</option>
                    <option value="CR_34">CR_34</option>
                    <option value="CR_35">CR_35</option>
                    <option value="CR_36">CR_36</option>
                </select>
                
                <label for="batch">Batch</label>
                <input type="text" class="input" id="batch" name="batch" placeholder="Enter Batch Name">
    
                <label for="section">Section</label>
                <input type="text" class="input" id="section" name="section" placeholder="Enter Section name">
                
                <label for="FID">Faculty ID</label>
                <input type="text" class="input" id="FID" name="FID" placeholder="Enter Faculty ID">
                
                <label for="start_time">Class Start Time</label>
                <input type="time" class="input" name="start_time" id="start_time" placeholder="Enter Class Start time">
                
                <label for="end_time">Class End Time</label>
                <input type="time" class="input" name="end_time" id="end_time" placeholder="Enter Class End time">

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
        $cname = $_POST['cname'];
        $batch = $_POST['batch'];
        $section = $_POST['section'];
        $FID = $_POST['FID'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $CrsID = $_POST['CrsID'];
        $start = $_POST['start'];
        $end = $_POST['end'];

        $host = $_SESSION["ip"];
        $port    = 4950;
        $message = array("Class_Crs_Assign_Faculty",$cname,$batch,$section,$FID,$start_time,$end_time,$CrsID,$start,$end);
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