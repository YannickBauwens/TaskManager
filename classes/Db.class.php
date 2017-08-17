<?php

	class Db
	{
		public function connect()
		{
			try {
              
				$conn = new PDO('mysql:host=localhost;dbname=TaskManager', "root", "");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
				return $conn;

			} catch(PDOException $e) {
			    echo 'ERROR: ' . $e->getMessage();
			}
            
		}
	}

?>