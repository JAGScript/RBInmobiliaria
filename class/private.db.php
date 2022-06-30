<?php 
	class DBConn extends PDO{
		public function __construct(){
			$host= 'localhost';
			$dbname = 'inmobiliaria';
			$user = 'root';
			$pass = '';

			parent::__construct('mysql: host='.$host.'; dbname='.$dbname, $user, $pass);
			$this -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}
	}
?>