
<?php

require_once 'User.class.php';

class Task
	{
        private $m_sTaskname;
        private $m_iUserid;
        private $m_iProjectid;
        private $m_sDeadline;
        
        public function __set($p_sProperty, $p_vValue)
        {
            switch($p_sProperty)
            {

                case 'Id':
                    $this->m_iId = $p_vValue;
                break;
                    
                case "Taskname":
                    if(!empty($p_vValue))
                    {
                        $this->m_sTaskname = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Taskname can't be empty!");
                    }
                break;
                case "Userid":
                    $this->m_iUserid = $p_vValue;
                break;
                case "Projectid":
                    $this->m_iProjectid = $p_vValue;
                break;
                case "Deadline":
                    $this->m_sDeadline = $p_vValue;
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
                case 'Taskname':
                    return($this->m_sTaskname);
                break;
                case 'Userid':
                    return($this->m_iUserid);
                break;
                case 'Projectid':
                    return($this->m_iProjectid);
                break;
                case 'Deadline':
                    return($this->m_sDeadline);
                break;
                
                default: echo("Not existing property: " . $p_sProperty);
            }
        }
    
        public function newtask()
        {
            
                $conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $data = $conn->query("INSERT INTO tasks(name, deadline, userid, projectid) VALUES(" . $conn->quote($this->m_sTaskname) . ", ". $conn->quote($this->m_sDeadline) . ", ". $conn->quote($this->m_iUserid) . ", ". $conn->quote($this->m_iProjectid) .")");
                header("Location: home.php");
            
		}
    
    
        
}

?>