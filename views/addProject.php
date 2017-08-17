<?php 
    session_start();
    if(empty($_SESSION['user'])){
        header("Location: index.php");
    }else{
        include_once '../classes/Db.class.php';
        include_once '../classes/User.class.php';
        include_once '../classes/Project.class.php';
        $userid = $_SESSION['user'];
    }


    if(!empty($_POST))
    {
        try
        {  
            $project1 = new Project();
            $project1->Projectname = $_POST['projectname'];
            $project1->Userid = $_SESSION['user'];
            $project1->Course = $_POST['course'];
            
		    $project1->newproject();
            
            $conn = Db::connect();
            $projects = $conn->query("SELECT projectid FROM projects ORDER BY projectid DESC LIMIT 1;");
            foreach ($projects as $row) {
                $activeproject = $row['projectid'];
            }   
            header("Location: home.php?project=" . $activeproject ."");
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
                    <h3 class="test">Add a project</h3>
                    <div class="lowerForm">
                       <input type="text" name="projectname" class="textfield" placeholder="Project name"><br>
                       <select name="course" >
                           <option value="webtechnologie">Webtechnologie</option>
                           <option value="cms">CMS</option>
                       </select><br>
                       <button class="btn btn-primary">Add project</button><br><br>
                       <a href="../views/home.php">terug</a>
                   </div>
               </form>
           </div>
        </div>
    </div>
</body>
</html>