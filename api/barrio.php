<?php 
	include "conection/config.php";
	include "conection/utils.php";
	
	$dbConn = connect($db);
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if (isset($_GET['IdBarrio'])){
			$sql = $dbConn->prepare("SELECT * FROM barrio WHERE ba_id=:IdBarrio");
			$sql->bindValue(':IdBarrio', $_GET['IdBarrio']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		} else {
			$sql = $dbConn->prepare("SELECT * FROM barrio");
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		}
	}
?>