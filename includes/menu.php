<?php
        try {
            $conn = Db::connect();
            $userdata = $conn->query("SELECT * FROM users WHERE id = $userid;");
            $projects = $conn->query("SELECT name, projectid, course FROM projects WHERE userid = $userid;");
            //userid wordt in alle paginas herkent omdat deze in de session zit en binnengelezen wordt ergens anders
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
                    <input type='text' name='course' class='textfield' placeholder='course'><br>
                    <input type='submit' class='btn btn-primary' name='courseform' value='Add Course'/>
                </form>
                
                <form action='' method='post'>
                    <select name="courses" >
                        <option value="empty">--</option>
                        <option value="webtechnologie">Webtechnologie</option>
                        <option value="cms">CMS</option>
                    </select><br>
                    <input type='submit' class='btn btn-primary' name='courseform' value='Delete Course'/>
                </form>
                
                <form action='' method='post'>
                    <select name="persons" >
                        <option value="empty">--</option>
                        <option value="frans">Frans</option>
                        <option value="louis">Louis</option>
                        <option value="jefke">Jefke</option>
                        <option value="ben">Ben</option>
                    </select><br>
                    <input type='submit' class='btn btn-primary' name='courseform' value='Make admin'/>
                </form>
            <?php } ?>
        </div>
</aside>