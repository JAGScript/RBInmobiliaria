<?php 	
	function connect($db){
		try{
			$conn = new PDO("mysql:host={$db['host']};dbname={$db['db']}", $db['username'], $db['password']);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		}catch(PDOException $exception){
			exit($exception->getMessage());
		}
	}
	
	function getParams($input){
		$filterParams = [];
		foreach($input as $param => $value){
			$filterParams[] = "$param=:$param";
		}
		return implode(",", $filterParams);
	}
	
	function bindAllValues($statment, $params){
		foreach($params as $param => $value){
			$statment->bindValue(':'.$param, $value);
		}
		return $statment;
	}
?>