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
        $hosts = gethostbynamel(gethostname()); 
        //hosts is array which gives us two ipv4 addresses. One is Ethernet adapter and 2nd is wireless network. We use 2nd one.
        $host = $hosts[1];
        $port = 4950;
        // don't timeout!
        set_time_limit(0);
        // create socket
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        // bind socket
        socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
        // lstening on socket
        socket_listen($socket,3) or die("Could not set up socket listener\n");
        // accept incoming connections
        // spawn another socket to handle communication    
            
        while(true)
        {
            $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
            // read client input
            $input = socket_read($spawn, 1024) or die("Could not read input\n".socket_strerror(socket_last_error($socket)));
            // Convert JSON into array
            $input = json_decode($input);  // At 1st index always a message which indicates server is for which page.
            
            // Connection to DataBaase Starts
            $serverName = "localhost";
            $username = "root";
            $password = "";
            $dbname = "NM_Project";
            $conn = mysqli_connect( $serverName, $username,$password,$dbname );
            if($conn)
            {
                if($input[0] == 'create_table')
                {
                    $sql = "Create Table Department
                    (
                    DeptID varchar(10) primary key,
                    DeptName varchar(20),
                    DeptLocation varchar(20)
                    );";
            
                    $sql1 = "Create Table Batch
                    (
                    Batch varchar(10) primary key,
                    DeptID varchar(10),
                    FOREIGN KEY (DeptID) REFERENCES Department(DeptID)
                    );";
                    $sql2 = "Create Table Student
                    (
                    StdID varchar(10) primary key,
                    FirstName varchar(20),
                    LastName varchar(20),
                    FatherName varchar(20),
                    Age int,
                    Mobile_Number varchar(20),
                    City varchar(30),
                    Country varchar(20),
                    PostalCode int,
                    Std_Image varchar(100),
                    Institute varchar(10),
                    Batch varchar(10),
                    Section varchar(2),
                    DOB date,
                    DeptID varchar(10),
                    FOREIGN KEY (DeptID) REFERENCES Department(DeptID)
                    );";
    
                    $sql3 = "Create Table Faculty
                    (
                    FacID varchar(10) primary key,
                    FirstName varchar(20),
                    LastName varchar(20),
                    FatherName varchar(20),
                    Age int,
                    Mobile_Number varchar(20),
                    City varchar(30),
                    Country varchar(20),
                    PostalCode int,
                    Fac_Image varchar(100),
                    Institute varchar(10),
                    DOB date,
                    DeptID varchar(10),
                    FOREIGN KEY (DeptID) REFERENCES Department(DeptID)
                    );";
    
                    $sql4 = "Create Table Admin
                    (
                    AdID varchar(10) primary key,
                    FirstName varchar(20),
                    LastName varchar(20),
                    FatherName varchar(20),
                    Age int,
                    Mobile_Number varchar(20),
                    City varchar(30),
                    Country varchar(20),
                    PostalCode int,
                    Ad_Image varchar(100),
                    Institute varchar(10),
                    DOB date
                    );";
    
                    $sql5 = "Create Table Account
                    (
                    Email varchar(30) unique,
                    Password varchar(30) not NULL,
                    confirm varchar(30) not NULL,
                    Type varchar(20),
                    StdID varchar(10),
                    FacID varchar(10),
                    AdID varchar(10),
                    Foreign Key (FacID) references Faculty(FacID),
                    Foreign Key (StdID) references Student(StdID),
                    Foreign Key (AdID) references Admin(AdID)
                    );";
    
                    $sql6 = "Create Table Course
                    (
                    CrsID varchar(10) Primary Key,
                    CrsName varchar(20),
                    CreditHours int,
                    Pre_Req varchar(10),
                    Foreign Key (Pre_Req) references Course(CrsID)
                    );";
    
                    $sql7 = "Create Table Std_Crs
                    (
                    StdID varchar(10),
                    CrsID varchar(10),
                    Crs_Start_Date Date,
                    Crs_End_Date Date,
                    Foreign Key (StdID) references Student(StdID),
                    Foreign Key (CrsID) references Course(CrsID),
                    primary key(StdID,CrsID)
                    );";
    
                    $sql8 = "Create Table Fac_Crs
                    (
                    FacID varchar(10),
                    CrsID varchar(10),
                    Crs_Start_Date Date,
                    Crs_End_Date Date,
                    Foreign Key (FacID) references Faculty(FacID),
                    Foreign Key (CrsID) references Course(CrsID),
                    primary key(FacID,CrsID)
                    );";
    
                    $sql9 = "Create Table Section
                    (
                    Section char(1),
                    Batch varchar(10),
                    Foreign Key (Batch) references Batch(Batch),
                    primary key(batch,section)
                    );";
    
                    $sql10 = "Create Table Fac_Sec
                    (
                    ClassName varchar(10),
                    Batch varchar(10),
                    Section char(1),
                    FacID varchar(10),
                    Class_Start_Time time,
                    Class_End_Time time,
                    Foreign Key (Batch,Section) references Section(Batch,Section),
                    Foreign Key (FacID) references Faculty(FacID)
                    );";
                    
                    
                    $sql11 = "Create Table Messages
                    (
                    Sender_StdID varchar(10),
                    Sender_FacID varchar(10),
                    Sender_AdID varchar(10),
                    Messages varchar(80),
                    Receiver_StdID varchar(10),
                    Receiver_FacID varchar(10),
                    Receiver_AdID varchar(10),
                    Foreign Key (Sender_FacID) references Faculty(FacID),
                    Foreign Key (Sender_StdID) references Student(StdID),
                    Foreign Key (Sender_AdID) references Admin(AdID),
                    Foreign Key (Receiver_FacID) references Faculty(FacID),
                    Foreign Key (Receiver_StdID) references Student(StdID),
                    Foreign Key (Receiver_AdID) references Admin(AdID)
                    );";
                    $stmt = mysqli_query($conn,$sql);
                    $stmt1 = mysqli_query($conn,$sql1);
                    $stmt2 = mysqli_query($conn,$sql2);
                    $stmt3 = mysqli_query($conn,$sql3);
                    $stmt4 = mysqli_query($conn,$sql4);
                    $stmt5 = mysqli_query($conn,$sql5);
                    $stmt6 = mysqli_query($conn,$sql6);
                    $stmt7 = mysqli_query($conn,$sql7);
                    $stmt8 = mysqli_query($conn,$sql8);
                    $stmt9 = mysqli_query($conn,$sql9);
                    $stmt10 = mysqli_query($conn,$sql10);
                    $stmt11 = mysqli_query($conn,$sql11);

                    if($stmt && $stmt1 && $stmt2 && $stmt3 && $stmt4 && $stmt5 && $stmt6 && $stmt7 && $stmt8 && $stmt9 && $stmt10 && $stmt11)
                    {
                        $message = "Table Created Successfully";
                    }
                    else
                    {
                        $message = "Procedure,Tables,Triggers already created";
                    }
                }
                else if($input[0] == 'email_pass_validator')
                {
                    $email = $input[1];
                    $pass = $input[2];
                    $type = $input[3];
                    $sql = "Select count(*) from Account
                        where Email = '$email' AND Password = '$pass' AND Type = '$type'";
                    
                    $stmt = mysqli_query($conn,$sql);

                    $row = mysqli_fetch_row($stmt);

                    if(($row[0] == 1) or ($email == 'admin' and $pass == 'admin' and $type == 'Admin'))
                    {
                        $message = "true";
                    }
                    else
                    {
                        $message = "false";
                    }
                }
                else if($input[0] == 'Signup')
                {
                    $ID = $input[1];
                    $fname = $input[2];
                    $lname = $input[3];
                    $father_name = $input[4]; 
                    $age = $input[5];
                    $num = $input[6];
                    $city = $input[7];
                    $country = $input[8];
                    $postal_code = $input[9];
                    $institute = $input[10];
                    $type = $input[11];
                    $email = $input[12];
                    $pass = $input[13];
                    $confirm = $input[14];

                    if($type == 'Admin')
                    {
                        $sql = "insert into admin values('$ID','$fname','$lname','$father_name','$age','$num','$city','$country','$postal_code',NULL,'$institute',NULL);";
                        $sql1 = "insert into account values('$email','$pass','$confirm','$type',NULL,NULL,'$ID');";
                    }
                    else if($type == 'Student')
                    {
                        $sql = "insert into Student values('$ID','$fname','$lname','$father_name','$age','$num','$city','$country','$postal_code',NULL,'$institute',NULL,NULL,NULL,NULL);";
                        $sql1 = "insert into account values('$email','$pass','$confirm','$type','$ID',NULL,NULL);";
                    }
                    else if($type == 'Faculty')
                    {
                        $sql = "insert into Faculty values('$ID','$fname','$lname','$father_name','$age','$num','$city','$country','$postal_code',NULL,'$institute',NULL,NULL);";
                        $sql1 = "insert into account values('$email','$pass','$confirm','$type',NULL,'$ID',NULL);";
                    }
    
                    $stmt = mysqli_query($conn,$sql);
                    $stmt1 = mysqli_query($conn,$sql1);
                    if($stmt && $stmt1)
                    {
                        $message = "true";
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Count_Student_Record")
                {
                    $sql = "Select count(*) from Student";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);    
                    }
                }
                else if($input[0] == "Student_Record")
                {
                    $sql = "Select S.StdID,FirstName,LastName,FatherName,age,Mobile_Number,City,Country,PostalCode,Institute,DOB,Batch,Section,Email,S.DeptId from Student as S 
                    inner join Account as A
                    on S.StdID = A.StdID";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Count_Show_Student_Record")
                {
                    $search = $input[1];

                    $sql = "Select count(*) from Student as S 
                    inner join Account as A
                    on S.StdID = A.StdID
                    where 
                    S.StdID = '$search' OR 
                    FirstName = '$search' OR 
                    LastName = '$search' OR 
                    FatherName = '$search' OR  
                    Mobile_Number = '$search' OR 
                    City = '$search' OR 
                    Country = '$search' OR  
                    A.Email = '$search' OR 
                    Institute = '$search' OR 
                    Batch = '$search' OR 
                    Section = '$search' OR
                    Age = '$search' OR
                    PostalCode = '$search' OR
                    DOB = '$search';";
            
                    $stmt = mysqli_query($conn,$sql);

                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Show_Student_Record")
                {
                    $search = $input[1];

                    $sql = "Select S.StdID,FirstName,LastName,FatherName,age,Mobile_Number,City,Country,PostalCode,Institute,DOB,Batch,Section,Email,S.DeptID from Student as S 
                    inner join Account as A
                    on S.StdID = A.StdID
                    where 
                    S.StdID = '$search' OR 
                    FirstName = '$search' OR 
                    LastName = '$search' OR 
                    FatherName = '$search' OR  
                    Mobile_Number = '$search' OR 
                    City = '$search' OR 
                    Country = '$search' OR  
                    A.Email = '$search' OR 
                    Institute = '$search' OR 
                    Batch = '$search' OR 
                    Section = '$search' OR
                    Age = '$search' OR
                    PostalCode = '$search' OR
                    DOB = '$search';";
            
                    $stmt = mysqli_query($conn,$sql);

                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Count_Faculty_Record")
                {
                    $sql = "Select count(*) from Faculty";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);    
                    }
                }
                else if($input[0] == "Faculty_Record")
                {
                    $sql = "Select F.FacID,FirstName,LastName,FatherName,age,Mobile_Number,City,Country,PostalCode,Institute,DOB,Email,F.DeptID from Faculty as F
                    inner join Account as A
                    on F.FacID = A.FacID";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Count_Show_Faculty_Record")
                {
                    $search = $input[1];
                    $sql = "Select count(*) from Faculty as F
                    inner join Account as A
                    on F.FacID = A.FacID
                    where 
                    F.FacID = '$search' OR 
                    FirstName = '$search' OR 
                    LastName = '$search' OR 
                    FatherName = '$search' OR  
                    Mobile_Number = '$search' OR 
                    City = '$search' OR 
                    Country = '$search' OR  
                    A.Email = '$search' OR 
                    Institute = '$search' OR 
                    Age = '$search' OR
                    PostalCode = '$search' OR
                    DOB = '$search';";
            
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Show_Faculty_Record")
                {
                    $search = $input[1];
                    $sql = "Select F.FacID,FirstName,LastName,FatherName,age,Mobile_Number,City,Country,PostalCode,Institute,DOB,Email,F.DeptID from Faculty as F
                    inner join Account as A
                    on F.FacID = A.FacID
                    where 
                    F.FacID = '$search' OR 
                    FirstName = '$search' OR 
                    LastName = '$search' OR 
                    FatherName = '$search' OR  
                    Mobile_Number = '$search' OR 
                    City = '$search' OR 
                    Country = '$search' OR  
                    A.Email = '$search' OR 
                    Institute = '$search' OR 
                    Age = '$search' OR
                    PostalCode = '$search' OR
                    DOB = '$search';";
            
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Count_Admin_Record")
                {
                    $sql = "Select count(*) from Admin";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);    
                    }
                }
                else if($input[0] == "Admin_Record")
                {
                    $sql = "Select Ad.AdID,FirstName,LastName,FatherName,age,Mobile_Number,City,Country,PostalCode,Institute,DOB,Email from Admin as Ad
                    inner join Account as A
                    on Ad.AdID = A.AdID";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Count_Show_Admin_Record")
                {
                    $search = $input[1];

                    $sql = "Select count(*) from Admin as Ad
                    inner join Account as A
                    on Ad.AdID = A.AdID
                    where 
                    Ad.AdID = '$search' OR 
                    FirstName = '$search' OR 
                    LastName = '$search' OR 
                    FatherName = '$search' OR  
                    Mobile_Number = '$search' OR 
                    City = '$search' OR 
                    Country = '$search' OR  
                    A.Email = '$search' OR 
                    Institute = '$search' OR 
                    Age = '$search' OR
                    PostalCode = '$search' OR
                    DOB = '$search';";
            
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Show_Admin_Record")
                {
                    $search = $input[1];

                    $sql = "Select Ad.AdID,FirstName,LastName,FatherName,age,Mobile_Number,City,Country,PostalCode,Institute,DOB,Email from Admin as Ad
                    inner join Account as A
                    on Ad.AdID = A.AdID
                    where 
                    Ad.AdID = '$search' OR 
                    FirstName = '$search' OR 
                    LastName = '$search' OR 
                    FatherName = '$search' OR  
                    Mobile_Number = '$search' OR 
                    City = '$search' OR 
                    Country = '$search' OR  
                    A.Email = '$search' OR 
                    Institute = '$search' OR 
                    Age = '$search' OR
                    PostalCode = '$search' OR
                    DOB = '$search';";
            
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Delete_Account")
                {
                    $ID = $input[1];
                    $type = $input[2];
                    $email = $input[3];
                    $pass = $input[4];

                    if($type == 'Student')
                    {
                        $sql = "Delete from Account where StdID = '$ID' AND email = '$email' AND password = '$pass' AND type = '$type';";

                        $sql1 = "Delete from Student where StdID = '$ID';";
                    }
                    else if($type == 'Faculty')
                    {
                        $sql1 = "Delete from Account where FacID = '$ID' AND email = '$email' AND password = '$pass' AND type = '$type';";

                        $sql = "Delete from Faculty where FacID = '$ID';";
                    }
                    else if($type == 'Admin')
                    {
                        $sql = "Delete from Account where AdID = '$ID' AND email = '$email' AND password = '$pass' AND type = '$type';";

                        $sql1 = "Delete from Admin where AdID = '$ID';";
                    }
                    
                    $stmt = mysqli_query($conn,$sql);
                    $stmt1 = mysqli_query($conn,$sql1);
                    if($stmt and $stmt1)
                    {
                        $message = "true";
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Pre_Req")
                {
                    $sql = "Select distinct(CrsName) from Course ;";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = mysqli_fetch_array( $stmt, MYSQLI_NUM);
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Add_Course")
                {
                    $CrsID = $input[1];
                    $CrsName = $input[2];
                    $P_CrsName = $input[3];
                    $hours = $input[4];
                    if($P_CrsName!='NULL')
                    {
                        $sql = "Select CrsID from Course where CrsName = '$P_CrsName';";
                        $stmt = mysqli_query($conn,$sql);
                        $row = mysqli_fetch_row($stmt);

                        $sql1 = "insert into Course values('$CrsID','$CrsName',$hours,'$row[0]');";
                    }
                    else
                    {
                        $sql1 = "insert into Course values('$CrsID','$CrsName',$hours,NULL);";
                    }

                    $stmt1 = mysqli_query($conn,$sql1);
                    if($stmt1)
                    {
                        $message = 'true';
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Count_Course_Record")
                {
                    $sql = "Select count(*) from Course";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);    
                    }
                }
                else if($input[0] == 'Course_Record')
                {
                    $sql = "Select * from Course";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Count_Show_Course_Record")
                {
                    $search = $input[1];
                    $sql = "Select count(*) from Course
                    where 
                    CrsID = '$search' OR 
                    CrsName = '$search' OR 
                    CreditHours = $search OR 
                    Pre_Req = '$search';";
            
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }

                }
                else if($input[0] == "Show_Course_Record")
                {
                    $search = $input[1];

                    $sql = "Select * from Course
                    where 
                    CrsID = '$search' OR 
                    CrsName = '$search' OR 
                    CreditHours = $search OR 
                    Pre_Req = '$search';";
            
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Std_Crs_Enroll")
                {
                    $StdID = $input[1];
                    $CrsID = $input[2];
                    $start = $input[3];
                    $end = $input[4];

                    $sql = "insert into Std_Crs values('$StdID','$CrsID','$start','$end');";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = "true";
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == 'Count_Std_Crs_Record')
                {
                    $sql = "Select count(*) from Std_Crs as SC
                    inner join Student as S
                    on S.StdID = SC.StdID
                    inner join Course as C
                    on C.CrsID = SC.CrsID";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                    
                }
                else if($input[0] == 'Std_Crs_Record')
                {
                    $sql = "Select SC.StdID,S.FirstName,SC.CrsID,C.CrsName,SC.Crs_Start_Date,SC.Crs_End_Date
                    from Std_Crs as SC
                    inner join Student as S
                    on S.StdID = SC.StdID
                    inner join Course as C
                    on C.CrsID = SC.CrsID";
                    $stmt = mysqli_query($conn,$sql);
                    
                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == 'Count_Show_Std_Crs_Record')
                {
                    $search = $input[1];

                    $sql = "Select count(*) from Std_Crs as SC
                    inner join Student as S
                    on S.StdID = SC.StdID
                    inner join Course as C
                    on C.CrsID = SC.CrsID
                    where 
                    SC.StdID = '$search' OR
                    S.FirstName = '$search' OR
                    SC.CrsID = '$search' OR 
                    C.CrsName = '$search' OR 
                    SC.Crs_Start_Date = '$search' OR 
                    SC.Crs_End_Date = '$search';";
                    
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == 'Show_Std_Crs_Record')
                {
                    $search = $input[1];
                    
                    $sql = "Select SC.StdID,S.FirstName,SC.CrsID,C.CrsName,SC.Crs_Start_Date,SC.Crs_End_Date
                    from Std_Crs as SC
                    inner join Student as S
                    on S.StdID = SC.StdID
                    inner join Course as C
                    on C.CrsID = SC.CrsID
                    where 
                    SC.StdID = '$search' OR
                    S.FirstName = '$search' OR
                    SC.CrsID = '$search' OR 
                    C.CrsName = '$search' OR 
                    SC.Crs_Start_Date = '$search' OR 
                    SC.Crs_End_Date = '$search';";
            
                    $stmt = mysqli_query($conn,$sql);
                    
                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Add_Dept")
                {
                    $DID = $input[1];
                    $name = $input[2];
                    $location = $input[3];

                    $sql = "insert into Department values('$DID','$name','$location');";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt==true)
                    {
                        $message = "true";
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Add_Batch")
                {
                    $batch = $input[1];
                    $section = $input[2];
                    $DID = $input[3];

                    $sql = "insert into Batch values('$batch','$DID');";
                    $stmt = mysqli_query($conn,$sql);

                    $sql1 = "insert into Section values('$section','$batch');";
                    $stmt1 = mysqli_query($conn,$sql1);

                    if($stmt and $stmt1)
                    {
                        $message = "true";
                    }
                    else 
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Add_Section")
                {
                    $section = $input[1];
                    $batch = $input[2];

                    $sql = "insert into Section values('$section','$batch');";
                    $stmt = mysqli_query($conn,$sql);
                    if($stmt)
                    {
                        $message = "true";
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == 'Class_Crs_Assign_Faculty')
                {
                    $cname = $input[1];
                    $batch = $input[2];
                    $section = $input[3];
                    $FID = $input[4];
                    $start_time = $input[5];
                    $end_time = $input[6];
                    $CrsID = $input[7];
                    $start = $input[8];
                    $end = $input[9];

                    $sql = "insert into Fac_Sec values('$cname','$batch','$section','$FID','$start_time','$end_time');";
                    $sql1 = "insert into Fac_Crs values('$FID','$CrsID','$start','$end');";

                    $stmt = mysqli_query($conn,$sql);
                    $stmt1 = mysqli_query($conn,$sql1);

                    if($stmt and $stmt1)
                    {
                        $message = "true";
                    }
                    else 
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == 'Count_Fac_Sec_Record')
                {
                    $sql = "Select count(*) from Fac_Sec as FS
                    inner join Faculty as F
                    on F.FacID = FS.FacID
                    inner join Fac_Crs as FC
                    on FC.FacID = F.FacID
                    inner join Course as C
                    on C.CrsID = FC.CrsID";
                    $stmt = mysqli_query($conn,$sql);
    
                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == 'Fac_Sec_Record')
                {
                    $sql = "Select FS.ClassName,FS.Batch,FS.Section,FS.FacID,F.FirstName,C.CrsName,FS.Class_start_time,FS.Class_End_Time
                    from Fac_Sec as FS
                    inner join Faculty as F
                    on F.FacID = FS.FacID
                    inner join Fac_Crs as FC
                    on FC.FacID = F.FacID
                    inner join Course as C
                    on C.CrsID = FC.CrsID";
                    $stmt = mysqli_query($conn,$sql);

                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Count_Show_Fac_Sec_Record")
                {
                    $search = $input[1];

                    $sql = "Select count(*) from Fac_Sec as FS
                    inner join Faculty as F
                    on F.FacID = FS.FacID
                    inner join Fac_Crs as FC
                    on FC.FacID = F.FacID
                    inner join Course as C
                    on C.CrsID = FC.CrsID
                    where 
                    FS.ClassName = '$search' OR
                    FS.Batch = '$search' OR
                    FS.Section = '$search' OR 
                    FS.FacID = '$search' OR 
                    F.FirstName = '$search' OR 
                    C.CrsName = '$search' OR
                    FS.Class_start_time = '$search' OR
                    FS.Class_end_time = '$search';";
                    
                    $stmt = mysqli_query($conn,$sql);

                    if($stmt)
                    {
                        $message = mysqli_fetch_row( $stmt);
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == "Show_Fac_Sec_Record")
                {
                    $search = $input[1];

                    $sql = "Select FS.ClassName,FS.Batch,FS.Section,FS.FacID,F.FirstName,C.CrsName,FS.Class_start_time,FS.Class_End_Time
                    from Fac_Sec as FS
                    inner join Faculty as F
                    on F.FacID = FS.FacID
                    inner join Fac_Crs as FC
                    on FC.FacID = F.FacID
                    inner join Course as C
                    on C.CrsID = FC.CrsID
                    where 
                    FS.ClassName = '$search' OR
                    FS.Batch = '$search' OR
                    FS.Section = '$search' OR 
                    FS.FacID = '$search' OR 
                    F.FirstName = '$search' OR 
                    C.CrsName = '$search' OR
                    FS.Class_start_time = '$search' OR
                    FS.Class_end_time = '$search';";
                    
                    $stmt = mysqli_query($conn,$sql);

                    if($stmt)
                    {
                        $i = 0;
                        while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                        {
                            $message[$i] = $result;
                            $i++;
                        }
                    }
                    else
                    {
                        $message = mysqli_error($conn);
                    }
                }
                else if($input[0] == 'Admin_Dashboard')
                {
                    if($input[1] == 'name')
                    {
                        $email = $input[2];

                        $sql = "Select Ad.FirstName,Ad.LastName from Admin as Ad
                                where Ad.AdID = (Select A.AdID from Account as A
                                where A.Email = '$email' AND A.Type ='Admin');";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $message = mysqli_fetch_row( $stmt);
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                }
                else if($input[0] == 'Faculty_Dashboard')
                {
                    if($input[1] == 'name')
                    {
                        $email = $input[2];

                        $sql = "Select F.FirstName,F.LastName from Faculty as F
                                where F.FacID = (Select A.FacID from Account as A
                                where A.Email = '$email' AND A.Type ='Faculty');";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $message = mysqli_fetch_row( $stmt);
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    else if($input[1] == 'count_classes')
                    {
                        $email = $input[2];
                        $sql = "Select F.FacID from Faculty as F
                                inner join Account as A
                                on A.FacID = F.FacID
                                where A.Email = '$email' AND A.Type ='Faculty';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $FacID = mysqli_fetch_row( $stmt);
                            
                            $FacID = $FacID[0];

                            $sql = "Select count(*) from Fac_Sec as FS
                            inner join Fac_Crs as FC
                            on FS.FacID = FC.FacID
                            inner join Course as C
                            on C.CrsID = FC.CrsID
                            where FS.FacID = '$FacID';";
                            $stmt = mysqli_query($conn,$sql);

                            if($stmt)
                            {
                                $message = mysqli_fetch_row( $stmt);
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    else if($input[1] == 'classes')
                    {
                        $email = $input[2];
                        $sql = "Select F.FacID from Faculty as F
                                inner join Account as A
                                on A.FacID = F.FacID
                                where A.Email = '$email' AND A.Type ='Faculty';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $FacID = mysqli_fetch_row( $stmt);
                            
                            $FacID = $FacID[0];

                            $sql = "Select FS.Batch,FS.Section,C.CrsName,FS.ClassName,FS.Class_Start_Time,FS.Class_end_Time from Fac_Sec as FS
                            inner join Fac_Crs as FC
                            on FS.FacID = FC.FacID
                            inner join Course as C
                            on C.CrsID = FC.CrsID
                            where FS.FacID = '$FacID';";
                            $stmt = mysqli_query($conn,$sql);

                            if($stmt)
                            {
                                $i = 0;
                                while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                                {
                                    $message[$i] = $result;
                                    $i++;
                                }
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                }
                else if($input[0] == 'Student_Dashboard')
                {
                    if($input[1] == 'name')
                    {
                        $email = $input[2];

                        $sql = "Select S.FirstName,S.LastName from Student as S
                                where S.StdID = (Select A.StdID from Account as A
                                where A.Email = '$email' AND A.Type ='Student');";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $message = mysqli_fetch_row( $stmt);
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    else if($input[1] == 'count_classes')
                    {
                        $email = $input[2];
                        $sql = "Select S.StdID from Student as S
                                inner join Account as A
                                on A.StdID = S.StdID
                                where A.Email = '$email' AND A.Type ='Student';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $StdID = mysqli_fetch_row( $stmt);
                            
                            $StdID = $StdID[0];

                            $sql = "Select count(*) from Course as C
                            inner join Std_Crs SC
                            on SC.CrsID = C.CrsID
                            inner join Fac_Crs as FC
                            on C.CrsID = FC.CrsID
                            inner join Faculty as F
                            on F.FacID = FC.FacID
                            inner join Fac_Sec as FS
                            on FS.FacID = F.FacID
                            where SC.StdID = '$StdID';";
                            $stmt = mysqli_query($conn,$sql);

                            if($stmt)
                            {
                                $message = mysqli_fetch_row( $stmt);
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    else if($input[1] == 'classes')
                    {
                        $email = $input[2];
                        $sql = "Select S.StdID from Student as S
                                inner join Account as A
                                on A.StdID = S.StdID
                                where A.Email = '$email' AND A.Type ='Student';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $StdID = mysqli_fetch_row( $stmt);
                            
                            $StdID = $StdID[0];

                            $sql = "Select C.CrsName,C.CreditHours,F.FirstName,F.LastName,FS.ClassName,FS.Class_Start_Time,
                            FS.Class_end_Time from Course as C
                            inner join Std_Crs SC
                            on SC.CrsID = C.CrsID
                            inner join Fac_Crs as FC
                            on C.CrsID = FC.CrsID
                            inner join Faculty as F
                            on F.FacID = FC.FacID
                            inner join Fac_Sec as FS
                            on FS.FacID = F.FacID
                            where SC.StdID = '$StdID';";
                            $stmt = mysqli_query($conn,$sql);

                            if($stmt)
                            {
                                $i = 0;
                                while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                                {
                                    $message[$i] = $result;
                                    $i++;
                                }
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                }
                else if($input[0] == 'Chat_App')
                {
                    if($input[1] == "count_student_friends")
                    {
                        $email = $input[2];
                        $sql = "Select count(*) from Student as S
                                    inner join Account as A
                                    on A.StdID = S.StdID
                                    where A.email != '$email';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $message = mysqli_fetch_row( $stmt);
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    if($input[1] == "student_friends")
                    {
                        $email = $input[2];
                        $sql = "Select S.firstname,S.lastname from Student as S
                                    inner join Account as A
                                    on A.StdID = S.StdID
                                    where A.email != '$email';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $i = 0;
                            while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                            {
                                $message[$i] = $result;
                                $i++;
                            }
                            
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    if($input[1] == "count_faculty_friends")
                    {
                        $email = $input[2];
                        $sql = "Select count(*) from Faculty as F
                                    inner join Account as A
                                    on A.FacID = F.FacID
                                    where A.email != '$email';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $message = mysqli_fetch_row( $stmt);
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    if($input[1] == "faculty_friends")
                    {
                        $email = $input[2];
                        $sql = "Select F.firstname,F.lastname from Faculty as F
                                    inner join Account as A
                                    on A.FacID = F.FacID
                                    where A.email != '$email';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $i = 0;
                            while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                            {
                                $message[$i] = $result;
                                $i++;
                            }
                            
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    if($input[1] == "count_admin_friends")
                    {
                        $email = $input[2];
                        $sql = "Select count(*) from Admin as Ad
                                    inner join Account as A
                                    on A.AdID = Ad.AdID
                                    where A.email != '$email';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $message = mysqli_fetch_row( $stmt);
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    if($input[1] == "admin_friends")
                    {
                        $email = $input[2];
                        $sql = "Select Ad.firstname,Ad.lastname from Admin as Ad
                                    inner join Account as A
                                    on A.AdID = Ad.AdID
                                    where A.email != '$email';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $i = 0;
                            while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                            {
                                $message[$i] = $result;
                                $i++;
                            }
                            
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    else if($input[1] == "store_messages")
                    {
                        $name = $input[2];
                        $type = $input[3];
                        $msg = $input[4];
                        // $msg = strtoupper($msg);
                        $other_name = $input[5];
                        $other_type = $input[6];
                        $name = explode(" ",$name);
                        $other_name = explode(" ",$other_name);

                        if($type == 'Student')
                        {

                            $sql = "Select StdID from Student where firstname = '$name[0]' and lastname = '$name[1]';";
                            $stmt = mysqli_query($conn,$sql);

                            if($other_type == '(Student)')
                            {
                                $sql1 = "Select StdID from Student where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Faculty)')
                            {
                                $sql1 = "Select FacID from Faculty where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Admin)')
                            {
                                $sql1 = "Select AdID from Admin where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            $stmt1 = mysqli_query($conn,$sql1);

                            if($stmt and $stmt1)
                            {
                                $Sender_StdID = mysqli_fetch_row( $stmt);
                                $Sender_StdID = $Sender_StdID[0];
                                
                                if($other_type == '(Student)')
                                {
                                    $Receiver_StdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_StdID = $Receiver_StdID[0];
                                    
                                    $sql = "insert into messages values('$Sender_StdID',NULL,NULL,'$msg',
                                    '$Receiver_StdID',NULL,NULL)";
                                }
                                if($other_type == '(Faculty)')
                                {
                                    $Receiver_FacID = mysqli_fetch_row( $stmt1);
                                    $Receiver_FacID = $Receiver_FacID[0];
                                    
                                    $sql = "insert into messages values('$Sender_StdID',NULL,NULL,'$msg',
                                    NULL,'$Receiver_FacID',NULL)";
                                }
                                if($other_type == '(Admin)')
                                {
                                    $Receiver_AdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_AdID = $Receiver_AdID[0];
                                    
                                    $sql = "insert into messages values('$Sender_StdID',NULL,NULL,'$msg',
                                    NULL,NULL,'$Receiver_AdID')";
                                }

                                $stmt = mysqli_query($conn,$sql);
                                if($stmt)
                                {
                                    $message = "";
                                }
                                else
                                {
                                    $message = mysqli_error($conn);
                                }
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }
                        else if($type == 'Faculty')
                        {
                            $sql = "Select FacID from Faculty where firstname = '$name[0]' and lastname = '$name[1]';";
                            $stmt = mysqli_query($conn,$sql);

                            if($other_type == '(Student)')
                            {
                                $sql1 = "Select StdID from Student where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Faculty)')
                            {
                                $sql1 = "Select FacID from Faculty where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Admin)')
                            {
                                $sql1 = "Select AdID from Admin where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            $stmt1 = mysqli_query($conn,$sql1);

                            if($stmt and $stmt1)
                            {
                                $Sender_FacID = mysqli_fetch_row( $stmt);
                                $Sender_FacID = $Sender_FacID[0];
                                
                                if($other_type == '(Student)')
                                {
                                    $Receiver_StdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_StdID = $Receiver_StdID[0];
                                    
                                    $sql = "insert into messages values(NULL,'$Sender_FacID',NULL,'$msg',
                                    '$Receiver_StdID',NULL,NULL)";
                                }
                                if($other_type == '(Faculty)')
                                {
                                    $Receiver_FacID = mysqli_fetch_row( $stmt1);
                                    $Receiver_FacID = $Receiver_FacID[0];
                                    
                                    $sql = "insert into messages values(NULL,'$Sender_FacID',NULL,'$msg',
                                    NULL,'$Receiver_FacID',NULL)";
                                }
                                if($other_type == '(Admin)')
                                {
                                    $Receiver_AdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_AdID = $Receiver_AdID[0];
                                    
                                    $sql = "insert into messages values(NULL,'$Sender_FacID',NULL,'$msg',
                                    NULL,NULL,'$Receiver_AdID')";
                                }

                                $stmt = mysqli_query($conn,$sql);
                                if($stmt)
                                {
                                    $message = "";
                                }
                                else
                                {
                                    $message = mysqli_error($conn);
                                }
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                            
                        }
                        else if($type == 'Admin')
                        {
                            $sql = "Select AdID from Admin where firstname = '$name[0]' and lastname = '$name[1]';";
                            $stmt = mysqli_query($conn,$sql);

                            if($other_type == '(Student)')
                            {
                                $sql1 = "Select StdID from Student where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Faculty)')
                            {
                                $sql1 = "Select FacID from Faculty where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Admin)')
                            {
                                $sql1 = "Select AdID from Admin where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            $stmt1 = mysqli_query($conn,$sql1);

                            if($stmt and $stmt1)
                            {
                                $Sender_AdID = mysqli_fetch_row( $stmt);
                                $Sender_AdID = $Sender_AdID[0];

                                if($other_type == '(Student)')
                                {
                                    $Receiver_StdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_StdID = $Receiver_StdID[0];
                                    
                                    $sql = "insert into messages values(NULL,NULL,'$Sender_AdID','$msg',
                                    '$Receiver_StdID',NULL,NULL)";
                                }
                                if($other_type == '(Faculty)')
                                {
                                    $Receiver_FacID = mysqli_fetch_row( $stmt1);
                                    $Receiver_FacID = $Receiver_FacID[0];
                                    
                                    $sql = "insert into messages values(NULL,NULL,'$Sender_AdID','$msg',
                                    NULL,'$Receiver_FacID',NULL)";
                                }
                                if($other_type == '(Admin)')
                                {
                                    $Receiver_AdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_AdID = $Receiver_AdID[0];
                                    
                                    $sql = "insert into messages values(NULL,NULL,'$Sender_AdID','$msg',
                                    NULL,NULL,'$Receiver_AdID')";
                                }

                                $stmt = mysqli_query($conn,$sql);
                                if($stmt)
                                {
                                    $message = "";
                                }
                                else
                                {
                                    $message = mysqli_error($conn);
                                }
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }
                    }
                    else if($input[1] == "count_messages")
                    {
                        $name = $input[2];
                        $type = $input[3];
                        $other_name = $input[4];
                        $other_type = $input[5];
                        $name = explode(" ",$name);
                        $other_name = explode(" ",$other_name);

                        if($type == 'Student')
                        {
                            $sql = "Select StdID from Student where firstname = '$name[0]' and lastname = '$name[1]';";
                            
                            if($other_type == '(Student)')
                            {
                                $sql1 = "Select StdID from Student where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Faculty)')
                            {
                                $sql1 = "Select FacID from Faculty where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Admin)')
                            {
                                $sql1 = "Select AdID from Admin where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            
                            $stmt = mysqli_query($conn,$sql);
                            $stmt1 = mysqli_query($conn,$sql1);

                            if($stmt and $stmt1)
                            {
                                $Sender_StdID = mysqli_fetch_row( $stmt);
                                $Sender_StdID = $Sender_StdID[0];
                                
                                if($other_type == '(Student)')
                                {
                                    $Receiver_StdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_StdID = $Receiver_StdID[0];

                                    $sql = "Select count(*) from messages where (Sender_StdID = '$Sender_StdID' and Receiver_StdID = '$Receiver_StdID') or (Receiver_StdID = '$Sender_StdID' and Sender_StdID = '$Receiver_StdID');";
                                }
                                else if($other_type == '(Faculty)')
                                {
                                    $Receiver_FacID = mysqli_fetch_row( $stmt1);
                                    $Receiver_FacID = $Receiver_FacID[0];
                                    
                                    $sql = "Select count(*) from messages where (Sender_StdID = '$Sender_StdID' and Receiver_FacID = '$Receiver_FacID') or (Receiver_StdID = '$Sender_StdID' and Sender_FacID = '$Receiver_FacID');";
                                }
                                else if($other_type == '(Admin)')
                                {
                                    $Receiver_AdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_AdID = $Receiver_AdID[0];
                                    
                                    $sql = "Select count(*) from messages where (Sender_StdID = '$Sender_StdID' and Receiver_AdID = '$Receiver_AdID') or (Receiver_StdID = '$Sender_StdID' and Sender_AdID = '$Receiver_AdID');";
                                }
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }
                        else if($type == 'Faculty')
                        {
                            $sql = "Select FacID from Faculty where firstname = '$name[0]' and lastname = '$name[1]';";
                            $stmt = mysqli_query($conn,$sql);

                            if($other_type == '(Student)')
                            {
                                $sql1 = "Select StdID from Student where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Faculty)')
                            {
                                $sql1 = "Select FacID from Faculty where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Admin)')
                            {
                                $sql1 = "Select AdID from Admin where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            $stmt1 = mysqli_query($conn,$sql1);

                            if($stmt and $stmt1)
                            {
                                $Sender_FacID = mysqli_fetch_row( $stmt);
                                $Sender_FacID = $Sender_FacID[0];
                                
                                if($other_type == '(Student)')
                                {
                                    $Receiver_StdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_StdID = $Receiver_StdID[0];
                                    
                                    $sql = "Select count(*) from messages where (Sender_FacID = '$Sender_FacID' and Receiver_StdID = '$Receiver_StdID') or (Receiver_FacID = '$Sender_FacID' and Sender_StdID = '$Receiver_StdID');";
                                }
                                else if($other_type == '(Faculty)')
                                {
                                    $Receiver_FacID = mysqli_fetch_row( $stmt1);
                                    $Receiver_FacID = $Receiver_FacID[0];
                                    
                                    $sql = "Select count(*) from messages where (Sender_FacID = '$Sender_FacID' and Receiver_FacID = '$Receiver_FacID') or (Receiver_FacID = '$Sender_FacID' and Sender_FacID = '$Receiver_FacID');";
                                }
                                else if($other_type == '(Admin)')
                                {
                                    $Receiver_AdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_AdID = $Receiver_AdID[0];
                                    
                                    $sql = "Select count(*) from messages where (Sender_FacID = '$Sender_FacID' and Receiver_AdID = '$Receiver_AdID') or (Receiver_FacID = '$Sender_FacID' and Sender_AdID = '$Receiver_AdID');";
                                }

                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                            
                        }
                        else if($type == 'Admin')
                        {
                            $sql = "Select AdID from Admin where firstname = '$name[0]' and lastname = '$name[1]';";
                            
                            if($other_type == '(Student)')
                            {
                                $sql1 = "Select StdID from Student where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Faculty)')
                            {
                                $sql1 = "Select FacID from Faculty where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Admin)')
                            {
                                $sql1 = "Select AdID from Admin where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            
                            $stmt = mysqli_query($conn,$sql);
                            $stmt1 = mysqli_query($conn,$sql1);
                            if($stmt and $stmt1)
                            {
                                $Sender_AdID = mysqli_fetch_row($stmt);
                                $Sender_AdID = $Sender_AdID[0];

                                if($other_type == '(Student)')
                                {
                                    $Receiver_StdID = mysqli_fetch_row($stmt1);
                                    $Receiver_StdID = $Receiver_StdID[0];
                                    
                                    $sql = "Select count(*) from messages where (Sender_AdID = '$Sender_AdID' and Receiver_StdID = '$Receiver_StdID') or (Receiver_AdID = '$Sender_AdID' and Sender_StdID = '$Receiver_StdID');";
                                }
                                else if($other_type == '(Faculty)')
                                {
                                    $Receiver_FacID = mysqli_fetch_row( $stmt1);
                                    $Receiver_FacID = $Receiver_FacID[0];
                                    
                                    $sql = "Select count(*) from messages where (Sender_AdID = '$Sender_AdID' and Receiver_FacID = '$Receiver_FacID') or (Receiver_AdID = '$Sender_AdID' and Sender_FacID = '$Receiver_FacID');";
                                }
                                else if($other_type == '(Admin)')
                                {
                                    $Receiver_AdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_AdID = $Receiver_AdID[0];
                                    
                                    $sql = "Select count(*) from messages where (Sender_AdID = '$Sender_AdID' and Receiver_AdID = '$Receiver_AdID') or (Receiver_AdID = '$Sender_AdID' and Sender_AdID = '$Receiver_AdID');";
                                }
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }

                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $message = mysqli_fetch_row($stmt);
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    else if($input[1] == "messages")
                    {
                        $name = $input[2];
                        $type = $input[3];
                        $other_name = $input[4];
                        $other_type = $input[5];
                        $name = explode(" ",$name);
                        $other_name = explode(" ",$other_name);

                        if($type == 'Student')
                        {
                            $sql = "Select StdID from Student where firstname = '$name[0]' and lastname = '$name[1]';";
                            
                            if($other_type == '(Student)')
                            {
                                $sql1 = "Select StdID from Student where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Faculty)')
                            {
                                $sql1 = "Select FacID from Faculty where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Admin)')
                            {
                                $sql1 = "Select AdID from Admin where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            
                            $stmt = mysqli_query($conn,$sql);
                            $stmt1 = mysqli_query($conn,$sql1);

                            if($stmt and $stmt1)
                            {
                                $Sender_StdID = mysqli_fetch_row( $stmt);
                                $Sender_StdID = $Sender_StdID[0];
                                
                                if($other_type == '(Student)')
                                {
                                    $Receiver_StdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_StdID = $Receiver_StdID[0];

                                    $sql = "Select Sender_StdID,Receiver_StdID,messages from messages where (Sender_StdID = '$Sender_StdID' and Receiver_StdID = '$Receiver_StdID') or (Receiver_StdID = '$Sender_StdID' and Sender_StdID = '$Receiver_StdID');";
                                }
                                else if($other_type == '(Faculty)')
                                {
                                    $Receiver_FacID = mysqli_fetch_row( $stmt1);
                                    $Receiver_FacID = $Receiver_FacID[0];
                                    
                                    $sql = "Select Sender_StdID,Receiver_FacID,messages from messages where (Sender_StdID = '$Sender_StdID' and Receiver_FacID = '$Receiver_FacID') or (Receiver_StdID = '$Sender_StdID' and Sender_FacID = '$Receiver_FacID');";
                                }
                                else if($other_type == '(Admin)')
                                {
                                    $Receiver_AdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_AdID = $Receiver_AdID[0];
                                    
                                    $sql = "Select Sender_StdID,Receiver_AdID,messages from messages where (Sender_StdID = '$Sender_StdID' and Receiver_AdID = '$Receiver_AdID') or (Receiver_StdID = '$Sender_StdID' and Sender_AdID = '$Receiver_AdID');";
                                }
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }
                        else if($type == 'Faculty')
                        {
                            $sql = "Select FacID from Faculty where firstname = '$name[0]' and lastname = '$name[1]';";
                            $stmt = mysqli_query($conn,$sql);

                            if($other_type == '(Student)')
                            {
                                $sql1 = "Select StdID from Student where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Faculty)')
                            {
                                $sql1 = "Select FacID from Faculty where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Admin)')
                            {
                                $sql1 = "Select AdID from Admin where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            $stmt1 = mysqli_query($conn,$sql1);

                            if($stmt and $stmt1)
                            {
                                $Sender_FacID = mysqli_fetch_row( $stmt);
                                $Sender_FacID = $Sender_FacID[0];
                                
                                if($other_type == '(Student)')
                                {
                                    $Receiver_StdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_StdID = $Receiver_StdID[0];
                                    
                                    $sql = "Select Sender_FacID,Receiver_StdID,messages from messages where (Sender_FacID = '$Sender_FacID' and Receiver_StdID = '$Receiver_StdID') or (Receiver_FacID = '$Sender_FacID' and Sender_StdID = '$Receiver_StdID');";
                                }
                                else if($other_type == '(Faculty)')
                                {
                                    $Receiver_FacID = mysqli_fetch_row( $stmt1);
                                    $Receiver_FacID = $Receiver_FacID[0];
                                    
                                    $sql = "Select Sender_FacID,Receiver_FacID,messages from messages where (Sender_FacID = '$Sender_FacID' and Receiver_FacID = '$Receiver_FacID') or (Receiver_FacID = '$Sender_FacID' and Sender_FacID = '$Receiver_FacID');";
                                }
                                else if($other_type == '(Admin)')
                                {
                                    $Receiver_AdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_AdID = $Receiver_AdID[0];
                                    
                                    $sql = "Select Sender_FacID,Receiver_AdID,messages from messages where (Sender_FacID = '$Sender_FacID' and Receiver_AdID = '$Receiver_AdID') or (Receiver_FacID = '$Sender_FacID' and Sender_AdID = '$Receiver_AdID');";
                                }

                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                            
                        }
                        else if($type == 'Admin')
                        {
                            $sql = "Select AdID from Admin where firstname = '$name[0]' and lastname = '$name[1]';";
                            $stmt = mysqli_query($conn,$sql);

                            if($other_type == '(Student)')
                            {
                                $sql1 = "Select StdID from Student where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Faculty)')
                            {
                                $sql1 = "Select FacID from Faculty where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            else if($other_type == '(Admin)')
                            {
                                $sql1 = "Select AdID from Admin where firstname = '$other_name[0]' and lastname = '$other_name[1]';";
                            }
                            $stmt1 = mysqli_query($conn,$sql1);


                            if($stmt and $stmt1)
                            {
                                $Sender_AdID = mysqli_fetch_row($stmt);
                                $Sender_AdID = $Sender_AdID[0];

                                if($other_type == '(Student)')
                                {
                                    $Receiver_StdID = mysqli_fetch_row($stmt1);
                                    $Receiver_StdID = $Receiver_StdID[0];
                                    
                                    $sql = "Select Sender_AdId,Receiver_StdID,messages from messages where (Sender_AdID = '$Sender_AdID' and Receiver_StdID = '$Receiver_StdID') or (Receiver_AdID = '$Sender_AdID' and Sender_StdID = '$Receiver_StdID');";
                                }
                                else if($other_type == '(Faculty)')
                                {
                                    $Receiver_FacID = mysqli_fetch_row( $stmt1);
                                    $Receiver_FacID = $Receiver_FacID[0];
                                    
                                    $sql = "Select Sender_AdId,Receiver_FacID,messages from messages where (Sender_AdID = '$Sender_AdID' and Receiver_FacID = '$Receiver_FacID') or (Receiver_AdID = '$Sender_AdID' and Sender_FacID = '$Receiver_FacID');";
                                }
                                else if($other_type == '(Admin)')
                                {
                                    $Receiver_AdID = mysqli_fetch_row( $stmt1);
                                    $Receiver_AdID = $Receiver_AdID[0];
                                    
                                    $sql = "Select Sender_AdId,Receiver_AdID,messages from messages where (Sender_AdID = '$Sender_AdID' and Receiver_AdID = '$Receiver_AdID') or (Receiver_AdID = '$Sender_AdID' and Sender_AdID = '$Receiver_AdID');";
                                }
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }

                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $i = 0;
                            while($result = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                            {
                                $message[$i] = $result;
                                $i++;
                            }
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    else if($input[1] == "personal_id")
                    {
                        $email = $input[2];
                        $type = $input[3];

                        if($type == 'Student')
                        {
                            $sql = "Select StdID from Account where email = '$email' and type = '$type';";
                        }
                        else if($type == 'Faculty')
                        {
                            $sql = "Select FacID from Account where email = '$email' and type = '$type';";
                        }
                        else if($type == 'Admin')
                        {
                            $sql = "Select AdID from Account where email = '$email' and type = '$type';";
                        }
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $message = mysqli_fetch_row($stmt);
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                }
                else if($input[0] == "Admin_Edit")
                {
                    if($input[1] == "Admin_Values")
                    {
                        $email = $input[2];
                        $type = $input[3];
    
                        $sql = "Select FirstName,LastName,FatherName,Age,Mobile_Number,City,Country,PostalCode,Ad_Image,Institute,Ad.DOB,A.Email from Admin as Ad
                        inner join Account as A
                        on A.AdID = Ad.AdID
                        where email = '$email' and type = '$type';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $message = mysqli_fetch_row($stmt);
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    else if($input[1] == "Admin_Update")
                    {
                        $fname = $input[2];
                        $lname = $input[3];
                        $father_name = $input[4];
                        $age = $input[5];
                        $num = $input[6];
                        $city = $input[7];
                        $country = $input[8];
                        $postal_code = $input[9];
                        $Img = $input[10];
                        $institute = $input[11];
                        $DOB = $input[12];
                        $email_1 = $input[13];

                        $sql1 = "Select AdID from Admin where FirstName = '$fname';";
                        $stmt = mysqli_query($conn,$sql1);
                        if($stmt)
                        {
                            $AdID = mysqli_fetch_array($stmt);
                            $AdID = $AdID[0];

                            $sql = "update Admin
                            set FirstName = '$fname' , LastName = '$lname', FatherName='$father_name', Age= $age , Mobile_Number='$num', City='$city',Country='$country', PostalCode = $postal_code ,Ad_Image = '$Img' , Institute = '$institute',DOB = '$DOB' where AdID = '$AdID';";
                            
                            $sql1 = "Update Account set Email = '$email_1' where AdID = '$AdID';";
                            
                            $stmt = mysqli_query($conn,$sql);
                            $stmt1 = mysqli_query($conn,$sql1);

                            if($stmt and $stmt1)
                            {
                                $message = "true";
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                }
                else if($input[0] == 'Faculty_Edit')
                {
                    if($input[1] == 'Faculty_Values')
                    {
                        $email = $input[2];
                        $type = $input[3];

                        $sql = "Select FirstName,LastName,FatherName,Age,Mobile_Number,City,Country,    PostalCode,Fac_Image,Institute,DOB,DeptID,A.Email from Faculty as F
                        inner join Account as A
                        on A.FacID = F.FacID
                        where email = '$email' and type = '$type';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $message = mysqli_fetch_row($stmt);
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    else if($input[1] == "Faculty_Update")
                    {
                        $fname = $input[2];
                        $lname = $input[3];
                        $father_name = $input[4];
                        $age = $input[5];
                        $num = $input[6];
                        $city = $input[7];
                        $country = $input[8];
                        $postal_code = $input[9];
                        $Img = $input[10];
                        $institute = $input[11];
                        $DOB = $input[12];
                        $Dept_Id = $input[13];
                        $email_1 = $input[14];

                        $sql = "Select FacID from Faculty where FirstName = '$fname';";
                        $stmt = mysqli_query($conn,$sql);
                        
                        if($stmt)
                        {
                            $FacID = mysqli_fetch_row($stmt);
                            $FacID = $FacID[0];

                            $sql = "update Faculty
                            set FirstName = '$fname' , LastName = '$lname', FatherName='$father_name', Age= $age , Mobile_Number='$num', City='$city',Country='$country', PostalCode = $postal_code ,Fac_Image = '$Img' , Institute = '$institute',DOB = '$DOB', DeptID =  '$Dept_Id' where FacID = '$FacID';";

                            $sql1 = "Update Account set Email = '$email_1' where FacID = '$FacID';";
                            
                            $stmt = mysqli_query($conn,$sql);
                            $stmt1 = mysqli_query($conn,$sql1);

                            if($stmt and $stmt1)
                            {
                                $message = "true";
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                }
                else if($input[0] == "Student_Edit")
                {
                    if($input[1] == 'Student_Values')
                    {
                        $email = $input[2];
                        $type = $input[3];

                        $sql = "Select FirstName,LastName,FatherName,Age,Mobile_Number,City,Country,PostalCode,Std_Image,Institute,Batch,Section,S.DOB,DeptId,A.Email from Student as S
                        inner join Account as A
                        on A.StdID = S.StdID
                        where email = '$email' and type = '$type';";
                        $stmt = mysqli_query($conn,$sql);
                        if($stmt)
                        {
                            $message = mysqli_fetch_row($stmt);
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                    else if($input[1] == "Student_Update")
                    {
                        $fname = $input[2];
                        $lname = $input[3];
                        $father_name = $input[4];
                        $age = $input[5];
                        $num = $input[6];
                        $city = $input[7];
                        $country = $input[8];
                        $postal_code = $input[9];
                        $Img = $input[10];
                        $institute = $input[11];
                        $batch = $input[12];
                        $section = $input[13];
                        $DOB = $input[14];
                        $Dept_Id = $input[15];
                        $email_1 = $input[16];

                        $sql = "Select StdID from Student where FirstName = '$fname';";
                        $stmt = mysqli_query($conn,$sql);
                        
                        if($stmt)
                        {
                            $StdID = mysqli_fetch_row($stmt);
                            $StdID = $StdID[0];


                            $sql = "update Student
                            set FirstName = '$fname' , LastName = '$lname', FatherName='$father_name', Age= $age , Mobile_Number='$num', City='$city',Country='$country', PostalCode = $postal_code ,Std_Image = '$Img' , Institute = '$institute',Batch = '$batch' , Section = '$section' , DOB = '$DOB' , DeptID =  '$Dept_Id'     where StdID = '$StdID';";

                            $sql1 = "Update Account set Email = '$email_1' where StdID = '$StdID';";
                            
                            $stmt = mysqli_query($conn,$sql);
                            $stmt1 = mysqli_query($conn,$sql1);

                            if($stmt and $stmt1)
                            {
                                $message = "true";
                            }
                            else
                            {
                                $message = mysqli_error($conn);
                            }
                        }
                        else
                        {
                            $message = mysqli_error($conn);
                        }
                    }
                }
            }
            else
            {
                $message =  "Connection to Database unsuceesfull".mysqli_error($conn);
            }
            $output = $message;
            $output = json_encode($output);
            socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
        }
        
    ?>
    
</body>

</html>