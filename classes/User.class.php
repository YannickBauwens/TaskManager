<?php
class User
	{
        private $m_iId;
        private $m_sUsername;
		private $m_sFirstname;
        private $m_sLastname;
		private $m_sEmail;
		private $m_sPassword;
        private $m_aErrors;
        private $m_sConfirm_password;
        private $m_sProfileImg;
        private $m_iAdmin;
        

        public function __set( $p_sProperty, $p_vValue )
        {
            switch($p_sProperty)
            {

                case 'Id':
                    $this->m_iId = $p_vValue;
                break;
                    
                case "Firstname":
                    if(!empty($p_vValue))
                    {
                        $this->m_sFirstname = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("First name can't be empty!");
                    }
                break;
                case 'Lastname':
                    if(!empty($p_vValue))
                    {
                        $this->m_sLastname = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Last name can't be empty!");
                    }
                break;
                case 'Username':
                    if(!empty($p_vValue))
                    {
                        $this->m_sUsername = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Username can't be empty!");
                    }
                break;
                case 'Email':
                    if(!empty($p_vValue))
                    {
                        $this->m_sEmail = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Email can't be empty!");
                    }
                break;
                case 'Password':
                    if(!empty($p_vValue))
                    {
                        $this->m_sPassword = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Password can't be empty!");
                    }
                break;
                case 'ConfirmPassword':
                    if(!empty($p_vValue))
                    {
                        $this->m_sConfirm_password = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("password can't be empty!");
                    }
				break;
                case "ProfileImg":
                    $this->m_sProfileImg = $p_vValue;
                break;
                case "Admin":
                    $this->m_iAdmin = $p_vValue;
                break;
                default: echo("Not existing property: " . $p_sProperty);
            } 
        }

        public function __get($p_sProperty)
        {
            switch($p_sProperty)
            {
                case 'Id':
                    return($this->m_iId);
                break;
                case 'Firstname':
                    return($this->m_sFirstname);
                break;
                case 'Lastname':
                    return($this->m_sLastname);
                break;
                case 'Username':
                    return($this->m_sUsername);
                break;
                case 'Email':
                    return($this->m_sEmail);
                break;
                case 'Password':
                    return($this->m_sPassword);
                break;
                case 'Errors':
                    return($this->m_aErrors);
                break;
                case 'ConfirmPassword':
                    return($this->m_sConfirm_password);
                break; 
                case "ProfileImg":
                    return($this->m_sProfileImg);
                break;
                case 'Admin':
                    return($this->m_iAdmin);
                break; 
                default: echo("Not existing property: " . $p_sProperty);
            }
        }

		public function register()
        {
            if($this->m_sPassword != $this->m_sConfirm_password || !$this->checkEmail())
            {
                throw new Exception("Please fill in all fields and two correct passwords");
            } 
            else
            {
                $conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $hashedPw = password_hash($this->m_sPassword, PASSWORD_DEFAULT);

                $data = $conn->query("INSERT INTO users(firstname, lastname, username, email, password, profile_img, Admin) VALUES(" . $conn->quote($this->m_sFirstname) . ", ". $conn->quote($this->m_sLastname) .",". $conn->quote($this->m_sUsername) .",". $conn->quote($this->m_sEmail) .",". $conn->quote($hashedPw) . ",". $conn->quote($this->m_sProfileImg) . ",". $conn->quote($this->m_iAdmin) .")");
                header("Location: login.php");
            }
		}
        
        function checkEmail()
        {
            $email = $this->m_sEmail;
            
            $conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $query = $conn->query("SELECT email FROM users WHERE email = '". $email ."'");
                
            $count = $query->rowCount();
        
            if($count == 0)
            {
                return true;
            }
            else
            {
                throw new Exception("The email you entered is already in use");
                return false;
            }
        }
        
        public function canLogin($p_sEmail, $p_sPassword)
        {
            if (!empty($p_sEmail) && !empty($p_sPassword))
            {
                $conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
                $query = $conn->prepare('SELECT * FROM users WHERE email = :email');
                $query->bindParam(':email', $p_sEmail);
                $query->execute();
                $result = $query -> fetch(PDO::FETCH_ASSOC);

                if (password_verify($p_sPassword, $result['password']))
                {
                    $_SESSION['user'] = $result['id'];

                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        function getDataFromDatabase()
        {
            $conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $conn->query("SELECT * FROM users WHERE id = '".$this->Id."'"); 
            
            foreach ($data as $row) {
                
                $this->Firstname = $row['firstname'];
                $this->Lastname = $row['lastname'];
                $this->Username = $row['username'];
                $this->Email = $row['email'];

                
            } 
        }

        public function checkInDatabase($column, $data){
            $conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $conn->query("SELECT ".$column." FROM users"); 

            $result = $data->fetch(PDO::FETCH_NUM);

            if(in_array($data, $result)){
                return false;
            }else{
                return true;
            }
        }

        // Show errors in a HTML list
        public function showFeedback(){

            if(count($this->Errors) > 0){
                $output = '<div class="alert alert-danger" role="alert"><p>There were some errors while changing your account information:</p><ul>';

                for($i = 0; $i < count($this->Errors); $i++){
                    $output .= "<li>".$this->Errors[$i]."</li>";
                }

                $output .= "</ul></div>";

                
            }else{
                
                $output = '<div class="alert alert-success" role="alert">Your changes are successfully saved.</div>';

            }

            return $output;

        }
    
        public static function getUser($userid){
            $sql = "select * from users WHERE id=$userid";
            $query = mysql_query($sql);
            if($query)
            {
                if(mysql_num_rows($query) == 1){
                    return mysql_fetch_object($query);
                }
            }
            return null;
        }   
    
        public function makeadmin($useradminid)
        {
            
                $conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $data = $conn->query("UPDATE users SET Admin = 1 WHERE id=$useradminid");
                header("Refresh:0");
            
		}
    
        public function deleteadmin($usernotadminid)
        {
            
                $conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $data = $conn->query("UPDATE users SET Admin = 0 WHERE id=$usernotadminid");
                header("Refresh:0");
            
		}
        
}
?>