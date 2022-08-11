<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Type</title>
    <link rel="stylesheet" href="Account_Type.css">
        
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
            <form action="Account_Type.php" method="post">
                <h3>Account Type</h3>
                <div class="radio_btn" id="faculty">
                    <label for="fac">Faculty :</label>
                    <input type="radio" name="type" id="fac" value='Faculty'>
                </div>
                <div class="radio_btn" id="admin">
                    <label for="admin">Admin :&nbsp;</label>
                    <input type="radio" name="type" id="admin" value='Admin'>
                </div>
                <div class="radio_btn" id="student">
                    <label for="std">Student :</label>
                    <input type="radio" name="type" id="std" value='Student'>
                </div>
                <input type="submit" name="button" id="button" value="Next">
            </form>
        </section>
    </div>


    <script>
        let t = new Date();

        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        document.getElementById("currentDate").innerHTML = monthNames[t.getMonth()] + ", " + t.getDate() + " " + t.getFullYear() + " " + t.getHours() + ":" + t.getMinutes() + ":" + t.getSeconds();
    </script>


    <?php
    if(isset($_POST['button']))
    {
        if(isset($_POST['type']))
        {
            $radio = $_POST['type'];
            $_SESSION['type'] = $radio;
        }
        else
        {
            $radio =  "No button selected";
        }
        if($radio == 'Faculty')
        {
            header("Location:Portal.php");
        }
        else if($radio == 'Admin')
        {
            header("Location:Portal.php");
        }
        else if($radio == 'Student')
        {
            header("Location:Portal.php");
        }
        else
        {
            echo "<p class='php'>$radio</p>";
        }
    }
    
    ?>
</body>

</html>