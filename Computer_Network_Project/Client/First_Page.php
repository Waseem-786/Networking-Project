<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First_Page</title>
    <!-- <link rel="stylesheet" href="First_Page.css"> -->
    <link rel="stylesheet" href="First_Page.css">

</head>

<body>
<?php
            if(isset($_POST['button']))
            {
                // Change IP here will result change IP in all other files.
                // IP address of Server
                $host = "192.168.43.246";
                $_SESSION["ip"] = $host;
                $port    = 4950;
                $message = array("create_table");
                $message = json_encode($message);
                 // create socket
                $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
                // connect to server
                $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
                // send string to server
                
                socket_write($socket, $message,strlen($message)) or die("Could not send data to server\n");
                
                // From Server
                $result = socket_read($socket, 1024) or die("Could not read server response\n");
                $result = trim($result);
                if($result == 'Table Created Successfully' || $result = "Procedure,Tables,Triggers already created")
                {
                    // Move to Account_Type Page
                    header("Location: Account_Type.php");
                    socket_close($socket);
                }
                else
                {
                    echo '<br>'."Reply From Server  :".$result;
                    socket_close($socket);
                }
                
        
            }
        
    ?>
    <div class="container" >
        <nav class="navbar" >
            <div class="left">
                <span>LMS</span>
            </div>
            <div class="mid">
                <ul>
                    <li class="list"><a href="#Home">Home</a></li>
                    <li class="list"><a href="#About_us">About us</a></li>
                    <li class="list"><a href="#Team">Team</a></li>
                    <li class="list"><a href="#Contact_us">Contact us</a></li>
                </ul>
            </div>
            <form method="post" class="right">
                <input type="submit" name="button" id="button" value="Portal">
            </form>
        </nav>

        <header id="Home">
            <div class="text">
                <img src="/DB_Project/Images/Nust_Logo.png" alt="Nust_Logo">
                <h1 class="heading">Learning Management System</h1>
            </div>
        </header>

        <hr id="After_Home">
        <section id="About_us">
            <h1 id="main_heading">About us</h1>
            <h1 class="sub_heading">OverView:</h1>
            <div class="overview">

                <div class="text">
                    <span>The history of NUST LMS Portal spans over a period of 3 years since it was introduced in NUST
                        Islamabad. NUST School of Electrical Engineering and Computer Science (SEECS) started using
                        Moodle
                        as LMS from spring of 2008. The deployment of Learning Management System for NUST H-12 campus
                        was
                        approved in May 2010. In a very short time LMS project has moved from being just a pilot project
                        to
                        becoming the integral part of the NUST experience.
                        <br>
                        Keeping in view the scope of the project, the overall deployment was divided in several phases
                        which
                        cover all the campuses of NUST H-12.</span>
                </div>

                <img src="/DB_Project/Images/Overview.jpg" alt="Loading_Overview">
            </div>
        </section>
        <hr id="After_About_us">
        <section id="Team">
            <h1>Our Team</h1>
            <div class="container">
                <div class="row">
                    <div class="team_member">
                        <div class="pic">
                            <img src="/DB_Project/Images/Waseem.jpg" alt="Loading">
                            pic
                        </div>
                        <h3 class="name">Waseem Shahzad</h3>
                        <span class="working">Developer</span>
                        <ul class="social">
                            <li><a href="https://www.facebook.com/" target="_blank" class="facebook"><img
                                        src="/DB_Project/Images/FB.png" alt="Loading"></a></li>
                            <li><a href="https://twitter.com/S13969271Waseem" target="_blank" class="twitter"><img
                                        src="/DB_Project/Images/twitter.png" alt=""></a></li>
                            <li><a href="https://myaccount.google.com/personal-info" target="_blank"
                                    class="google-plus"><img src="/DB_Project/Images/Google_Logo.png" alt="Loading"></a></li>
                            <li><a href="https://www.instagram.com/wshahzad444/" target="_blank" class="instagram"><img
                                        src="/DB_Project/Images/Instagram_Logo.png" alt=""></a></li>
                        </ul>
                    </div>

                    <div class="team_member">
                        <div class="pic">
                            <img src="/DB_Project/Images/Hashir.jpeg" alt="">
                        </div>
                        <h3 class="name">Hashir Iqbal</h3>
                        <span class="working">Developer</span>
                        <ul class="social">
                            <li><a href="#" class="facebook"><img src="/DB_Project/Images/FB.png" alt="Loading"></a>
                            </li>
                            <li><a href="#" class="twitter"><img src="/DB_Project/Images/twitter.png" alt="Loading"></a>
                            </li>
                            <li><a href="#" class="google-plus"><img src="/DB_Project/Images/Google_Logo.png"
                                        alt="Loading"></a></li>
                            <li><a href="#" class="instagram"><img src="/DB_Project/Images/Instagram_Logo.png"
                                        alt="Loading"></a></li>
                        </ul>
                    </div>

                    <div class="team_member">
                        <div class="pic">
                            <img src="/DB_Project/Images/Faizan.jpeg" alt="Loading">
                        </div>
                        <h3 class="name">Faizan Yousaf</h3>
                        <span class="working">Developer</span>
                        <ul class="social">
                            <li><a href="#" class="facebook"><img src="/DB_Project/Images/FB.png" alt="Loading"></a>
                            </li>
                            <li><a href="#" class="twitter"><img src="/DB_Project/Images/twitter.png" alt="Loading"></a>
                            </li>
                            <li><a href="#" class="google-plus"><img src="/DB_Project/Images/Google_Logo.png"
                                        alt="Loading"></a></li>
                            <li><a href="#" class="instagram"><img src="/DB_Project/Images/Instagram_Logo.png"
                                        alt="Loading"></a></li>
                        </ul>
                    </div>

                    <div class="team_member">
                        <div class="pic">
                            <img src="/DB_Project/Images/Ali_Tahir.jpeg" alt="">
                        </div>
                        <h3 class="name">Ali Tahir</h3>
                        <span class="working">Developer</span>
                        <ul class="social">
                            <li><a href="https://www.facebook.com/profile.php?id=100039912797082" target="_blank"
                                    class="facebook"><img src="/DB_Project/Images/FB.png" alt="Loading"></a></li>
                            <li><a href="https://twitter.com/AliTahi56385263" target="_blank" class="twitter"><img
                                        src="/DB_Project/Images/twitter.png" alt="Loading"></a></li>
                            <li><a href="#" class="google-plus"><img src="/DB_Project/Images/Google_Logo.png"
                                        alt="Loading"></a></li>
                            <li><a href="https://www.instagram.com/itx__alee_tahir/" target="_blank"
                                    class="instagram"><img src="/DB_Project/Images/Instagram_Logo.png" alt="Loading"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <hr id="After_Team">
        <section id="Contact_us">
            <div class="container">
                <div class="info">
                    <h1>INFO</h1>
                </div>
                <div class="cont">
                    <h1>Contact us</h1>
                    <p>NUST - LMS @ SEECS NUST H-12 Islamabad</p>
                    <p>E-mail : lms@seecs.edu.pk</p>
                    <p>LMS Focal Person (Institute Wise)</p>
                </div>
                <div class="social_links">
                    <h1>Social Links</h1>
                </div>
            </div>
            <div class="copy_right">
                <p>2020 © NUST - LMS. All rights reserved.</p> 
            </div>
        </section>
</div>

    
</body>

</html>