<?php 
	include "conection/config.php";
	include "conection/utils.php";
	
	$dbConn = connect($db);
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if (isset($_GET['IdCanton'])){
			$sql = $dbConn->prepare("SELECT * FROM canton WHERE ca_id=:IdCanton");
			$sql->bindValue(':IdCanton', $_GET['IdCanton']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		} else {
			$sql = $dbConn->prepare("SELECT * FROM canton");
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		}
	}
?>