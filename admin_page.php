<?php

include 'conn.php';

// session_start();

// if(!isset($_SESSION['admin_name'])){
//    header('location:login.php');
// }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">

</head>

<body>


    <div class="container">

        <div class="content">
            <h3>hi, <span>admin</span></h3>
            <p>this is an admin page</p>
            <a href=" login.php" class="btn">login</a>
            <a href="admin_employee.php" class="btn">Manage Staff</a>
            <a href="admin_facilities.php" class="btn">View Facilities</a>
            <a href="admin_equipment.php" class="btn">View Equipment</a>
            <a href="admin_project.php" class="btn">View Projects</a>
            <a href="admin_workorders.php" class="btn">View Workorders</a>
            <a href="login.php" class="btn">logout</a>
        </div>
    </div>
</body>

</html>