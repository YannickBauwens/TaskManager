
<?php

require_once 'User.class.php';

class Project
	{
        private $m_sProjectname;
        private $m_iUserid;
        private $m_sCourse;
        
        public function __set($p_sProperty, $p_vValue)
        {
            switch($p_sProperty)
            {

                case 'Id':
                    $this->m_iId = $p_vValue;
                break;
                    
                case "Projectname":
                    if(!empty($p_vValue))
                    {
                        $this->m_sProjectname = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Projectname can't be empty!");
                    }
                break;
                case "Userid":
                    $this->m_iUserid = $p_vValue;
                break;
                case "Course":
                    $this->m_sCourse = $p_vValue;
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
                case 'Projectname':
                    return($this->m_sProjectname);
                break;
                case 'Userid':
                    return($this->m_iUserid);
                break;
                case 'Course':
                    return($this->m_sCourse);
                break;
                
                default: echo("Not existing property: " . $p_sProperty);
            }
        }
    
        public function newproject()
        {
            
                $conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $data = $conn->query("INSERT INTO projects(name, course, userid) VALUES(" . $conn->quote($this->m_sProjectname) . ", ". $conn->quote($this->m_sCourse) . ", ". $conn->quote($this->m_iUserid) .")");
                
            
		}
        
}

?>