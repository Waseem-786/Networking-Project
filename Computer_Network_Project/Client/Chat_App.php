<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Application</title>
    <link rel="stylesheet" href="chat.css">

</head>
<body>

<?php
$type = $_SESSION['type'];
$personal_name = $_SESSION['name'];
$email = $_SESSION['email'];

$host    = $_SESSION["ip"];
$port    = 4950;
$message = array("Chat_App","personal_id",$email,$type);
$message = json_encode($message);

// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
// send string to server

socket_write($socket, $message,strlen($message)) or die("Could not send data to server\n");

// From Server
$result = socket_read($socket, 1024) or die("Could not read server response\n");
$personal_id = json_decode($result);
$personal_id = $personal_id[0];
socket_close($socket);
?>

<div class="container">
    <form name="myform" action="" method="post" id="form">
        <div class="main">
            <div class="members">
                <div class="profile">
                    <p class="name"><?php echo $personal_name; ?></p>
                    <div class="search">
                        <label for="search">Search </label>
                        <input type="text" name="search" id="search">
                    </div>
                </div>
                <div class="friends">

<?php
$host    = $_SESSION["ip"];
$port    = 4950;
$message = array("Chat_App","count_student_friends",$email);
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

$host    = $_SESSION["ip"];
$port    = 4950;
$message = array("Chat_App","student_friends",$email);
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
$i=0;
while($i!=$count)
{
    $name = $result[$i][0]." ".$result[$i][1];
?>
    <input type="submit" id="student" name='button' class="friend" onclick="showfriends()" value="<?php echo $name; ?> (Student)">
<?php
    $i++;
}
socket_close($socket);
?>

<!-- Faculty -->
<?php
$host    = $_SESSION["ip"];
$port    = 4950;
$message = array("Chat_App","count_faculty_friends",$email);
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

$host    = $_SESSION["ip"];
$port    = 4950;
$message = array("Chat_App","faculty_friends",$email);
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
$i=0;
while($i!=$count)
{
    $name = $result[$i][0]." ".$result[$i][1];
?>
    <form action="Chat_App.php" method="post">
        <input type="submit" id="faculty" name='button' class="friend" value="<?php echo $name; ?> (Faculty)">
    </form>
<?php
    $i++;
}
socket_close($socket);
?>

<!-- Admin -->
<?php
$host    = $_SESSION["ip"];
$port    = 4950;
$message = array("Chat_App","count_admin_friends",$email);
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

$host    = $_SESSION["ip"];
$port    = 4950;
$message = array("Chat_App","admin_friends",$email);
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
$i=0;
while($i!=$count)
{
    $name = $result[$i][0]." ".$result[$i][1];
?>
    <input type="submit" id="admin" name='button' class="friend" value="<?php echo $name; ?> (Admin)">
<?php
    $i++;
}
socket_close($socket);
?>

                    </div>
                </div>
                <div class="chat" id="Chat_Page">

                    <h1 id="other_name" class="other_name"></h1>
                    <div class="page">
                    </div>
                    <hr>
                    <div class="write">
                        <label for="message">Type a Message </label>
                        <input type="text" name="message" class="message">
                        <input type="submit" value="Send" id="send" name="send">
                    </div>
                </div>
            </div>
        </form>
    </div>

       <?php
       if(isset($_POST['button']))
       {
           $other_name = $_POST['button'];
           $_SESSION['other_name'] = $other_name;
           header('location:Chat.php');
       }
       ?> 
</body>
</html>