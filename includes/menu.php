<?php
        try {
            $conn = Db::connect();
            $userdata = $conn->query("SELECT * FROM users WHERE id = $userid;");
            $projects = $conn->query("SELECT name, projectid, course FROM projects WHERE userid = $userid;");
            //userid wordt in alle paginas herkent omdat deze in de session zit en binnengelezen wordt ergens anders
            $users = $conn->query("SELECT username,profile_img, id FROM users;");
            $admins = $conn->query("SELECT username,id FROM users WHERE Admin = 0;");
            $notadmins = $conn->query("SELECT username,id FROM users WHERE Admin = 1;");
            $coursedelete = $conn->query("SELECT * FROM courses;");
            include_once '../classes/Course.class.php';
            foreach ($userdata as $row) {
                $loggedinuser = $row['username'];
                $profileloc = $row['profile_img'];
                $adminornot = $row['Admin'];
            }  
            
            if(!empty($_POST['coursename']))
            {
                try
                {  
                    $course = new Course();
                    $course->Coursename = $_POST['course'];
                    $course->newcourse();
                }
                catch(exception $e)
                {
                    $error = $e->getMessage();
                }
            }
            if(!empty($_POST['coursedelete']))
            {
                try
                {  
                    $coursedel = new Course();
                    $deleteid = $_POST['course1'];
                    
                    $coursedel->deletecourse($deleteid);
                    
                }
                catch(exception $e)
                {
                    $error = $e->getMessage();
                }
            }
            
            if(!empty($_POST['usermakeadmin']))
            {
                try
                {  
                    $makeadmin = new User();
                    $useradminid = $_POST['admins'];
                    
                    $makeadmin->makeadmin($useradminid);
                    
                }
                catch(exception $e)
                {
                    $error = $e->getMessage();
                }
            }
            
            if(!empty($_POST['userdeleteadmin']))
            {
                try
                {  
                    $deleteadmin = new User();
                    $usernotadminid = $_POST['notadmins'];
                    
                    $deleteadmin->deleteadmin($usernotadminid);
                    
                }
                catch(exception $e)
                {
                    $error = $e->getMessage();
                }
            }
        } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
?>
 
   
   <aside>
    <div class="profile_info">
        <?php
            echo "<div class='loggedinimg'><img src='$profileloc' alt='avatar logged in user'></div>";
            echo "<div class='loggedinname'><h5>$loggedinuser</h5></div>";
        ?>
        <a href="../views/logout.php">Log out</a>
    </div>
        <a href="../views/addProject.php" class="btn btn-primary btnMenu">+ Add Project</a>
        <ul class="project_list">
            <?php
            while ($row = $projects->fetch(PDO::FETCH_NUM)) {
                $project['name'] = $row[0];
                $project['projectid'] = $row[1];
                $project['course'] = $row[2];
                echo "<li><a href='home.php?project=" . $project['projectid'] . "'>" . $project['name'] . "</a><h4>" . $project['course'] . "</h4></li>";
            }  
            ?>
        </ul>
        
        <div class="adminMenu">
            <?php if($adminornot == 1){ ?>
                <h3>Admin Menu</h3>

                <form action='' method='post'>
                    <input type='text' name='course' class='textfield' placeholder='Course name'><br>
                    <input type='submit' class='btn btn-primary' name='coursename' value='Add Course'/>
                </form>
                
                <form action='' method='post'>
                    <select name='course1' >
                       <option value="empty">-- Select course</option>
                       <?php 
                            while ($row = $coursedelete->fetch(PDO::FETCH_NUM)){
                            $row['courseid'] = $row[0];
                            $row['coursename'] = $row[1];
                            echo "<option value=". $row['courseid'] .">" . $row['coursename'] . "</option>'";
                            }
                       ?>
                    </select><br>
                    <input type='submit' class='btn btn-primary' name='coursedelete' value='Delete Course'/>
                </form>
                
                <form action='' method='post'>
                    <select name='admins' >
                       <option value="empty">-- Select user</option>
                       <?php 
                            while ($row = $admins->fetch(PDO::FETCH_NUM)){
                            $row['id'] = $row[1];
                            $row['username'] = $row[0];
                            echo "<option value=". $row['id'] .">" . $row['username'] . "</option>'";
                            }
                       ?>
                    </select><br>
                    <input type='submit' class='btn btn-primary' name='usermakeadmin' value='Make admin'/>
                </form>
                
                <form action='' method='post'>
                    <select name='notadmins' >
                       <option value="empty">-- Select user</option>
                       <?php 
                            while ($row = $notadmins->fetch(PDO::FETCH_NUM)){
                            $row['id'] = $row[1];
                            $row['username'] = $row[0];
                            echo "<option value=". $row['id'] .">" . $row['username'] . "</option>'";
                            }
                       ?>
                    </select><br>
                    <input type='submit' class='btn btn-primary' name='userdeleteadmin' value='Delete admin'/>
                </form>
            <?php } ?>
        </div>
</aside>