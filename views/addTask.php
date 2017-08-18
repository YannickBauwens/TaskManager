<?php 
    session_start();
    if(empty($_SESSION['user'])){
        header("Location: home.php");
    }else{
        include_once '../classes/Db.class.php';
        include_once '../classes/User.class.php';
        include_once '../classes/Task.class.php';
        $userid = $_SESSION['user'];
    }


    if(!empty($_POST['addtask']))
    {
        try
        {  
            $task = new Task();
            $task->Taskname = $_POST['taskname'];
            $task->Userid = $_SESSION['user'];
            $task->Deadline = $_POST['deadline'];
            $task->Projectid = $_GET['project'];
		    $task->newtask();
            header("Location: home.php?project=" . $_GET['project'] ."");
        }
        catch(exception $e)
        {
            $error = $e->getMessage();
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
        <div class="content1">
            
            
            <div class="formAddProject">
                <form action="" method="post" id="registerform">
                   <h3 class="test">Add a task</h3>
                   <div class="lowerForm">
                       <input type="text" name="taskname" class="textfield" placeholder="Project name">
                       <input type="text" name="deadline" id="date2" alt="date" class="IP_calendar" title="Y-m-d" placeholder="Deadline">
                       <input type='submit' class='btn btn-primary' name='addtask' value='Add Task'/><br><br><br><br>
                       <a href="../views/home.php">Back</a>
                   </div>
               </form>
               
           </div>
        </div>
    </div>
</body>
</html>