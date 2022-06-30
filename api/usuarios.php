<?php 
	include "conection/config.php";
	include "conection/utils.php";
	
	$dbConn = connect($db);
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if (isset($_GET['IdUsuario'])){
			$sql = $dbConn->prepare("SELECT * FROM usuario WHERE us_id=:IdUsuario");
			$sql->bindValue(':IdUsuario', $_GET['IdUsuario']);
			$sql->execute();
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetch(PDO::FETCH_ASSOC) );
			exit();
		}else {
			$sql = $dbConn->prepare("SELECT * FROM usuario");
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		}
	}
?>