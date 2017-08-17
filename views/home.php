<?php 
    session_start();
    if(empty($_SESSION['user'])){
        header("Location: index.php");
    }else{
        include_once '../classes/Db.class.php';
        include_once '../classes/User.class.php';
        $userid = $_SESSION['user'];
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TaskManager</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script type="text/javascript" src="../js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="http://services.iperfect.net/js/IP_generalLib.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>
</head>

<?php
        try {
            $conn = Db::connect();
            $userdata = $conn->query("SELECT * FROM users WHERE id = $userid;");
            $users = $conn->query("SELECT username,profile_img FROM users;");
            $usersadmin = $conn->query("SELECT username,id FROM users;");
            foreach ($userdata as $row) {
                $loggedinuser = $row['username'];
                $profileloc = $row['profile_img'];
                $adminornot = $row['Admin'];
            }         
        } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
?>


<body>
    <div class="homeLeft">
        <div class="center">
            <?php
                echo "<div class='loggedinimg'><img src='$profileloc' alt='avatar logged in user'></div>";
                echo "<div><h5>$loggedinuser</h5></div>";
            ?> 
            <a href="logout.php">Log out</a>
        </div>
    </div>
    
    <div class="homeRight">
        <div class="homeRightTop">
            <a href="#" class="btn btn-primary btn-primary1">+ Add task</a>
        </div>

        <div class="homeRightBot">
            <div class="taskBlock">
                <h4>hallo</h4>
                <p>fezgreh</p>
            </div>
            <div class="taskBlock">
                <h4>holla</h4>
                <p>fezgreh</p>
            </div>
        </div>
    </div>
    
</body>
</html>