<?php 
    session_start();
    if(empty($_SESSION['user'])){
        header("Location: login.php");
    }else{
        include_once '../classes/Db.class.php';
        include_once '../classes/User.class.php';
        $userid = $_SESSION['user'];
        $projectid = $_GET['project'];
        
        try {
            $conn = Db::connect();
            $tasks = $conn->query("SELECT name, deadline, userid, taskid FROM tasks WHERE projectid = $projectid ORDER BY deadline ASC;");
             
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TaskManager</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="http://services.iperfect.net/js/IP_generalLib.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>
</head>


<body>
    <div class="home_page">
       <?php
            include '../includes/menu.php';
        ?>
        <div class="content">
            <div class="header">
                <?php
                    echo "<a href='addTask.php?project=". $projectid ."' class='btn btn-primary'>+ Add task</a>";
                ?>
            </div>
            <ul class="task_list">
               
               
                <?php
                    while ($row = $tasks->fetch(PDO::FETCH_NUM)) {
                        $task['name'] = $row[0];
                        $task['deadline'] = $row[1];
                        $usertask = $task['userid'] = $row[2];
                        $task['taskid'] = $row[3];
                        $users = $conn->query("SELECT * FROM users WHERE id = $usertask;"); 
                        foreach ($users as $row) {
                            $taskCreator = $row['username'];
                        }   
                        echo "<li><a href='home.php?task=" . $task['taskid'] . "'>" . $task['name'] . "</a><h4>Deadline due " . $task['deadline'] . "</h4><h4>By " . $taskCreator . "</h4></li>";
                    }  
                ?>
                <!--
                <li>
                    <a href="">Wireframes maken</a>
                    <h4>Deadline 4th October</h4>
                </li>
                <li>
                    <a href="">Weerapp</a>
                    <h4>Deadline 9th September</h4>
                </li>-->
            </ul>   
        </div>
    </div>
    
</body>
</html>