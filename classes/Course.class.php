
<?php

require_once 'User.class.php';

class Course
	{
        private $m_sCoursename;
        
        public function __set($p_sProperty, $p_vValue)
        {
            switch($p_sProperty)
            {

                case 'Id':
                    $this->m_iId = $p_vValue;
                break;
                    
                case "Coursename":
                    if(!empty($p_vValue))
                    {
                        $this->m_sCoursename = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Coursename can't be empty!");
                    }
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
                case 'Coursename':
                    return($this->m_sCoursename);
                break;
                
                default: echo("Not existing property: " . $p_sProperty);
            }
        }
    
        public function newcourse()
        {
            
                $conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $data = $conn->query("INSERT INTO courses(coursename) VALUES(" . $conn->quote($this->m_sCoursename) . ")");
                
            
		}
    
        public function deletecourse($deleteid)
        {
            
                $conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $data = $conn->query("DELETE from courses WHERE courseid = $deleteid");
                header("Refresh:0");
            
		}
        
}

?>