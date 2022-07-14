<?php 
	include "conection/config.php";
	include "conection/utils.php";
	
	$dbConn = connect($db);
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if (isset($_GET['IdPropiedad'])){
			$sql = $dbConn->prepare("SELECT * FROM propiedad WHERE pr_id=:IdPropiedad");
			$sql->bindValue(':IdPropiedad', $_GET['IdPropiedad']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		} else {
			$sql = $dbConn->prepare("SELECT propiedad.*, tipo_propiedad.tp_nombre FROM propiedad JOIN tipo_propiedad ON propiedad.pr_tipo_id = tipo_propiedad.tp_id WHERE propiedad.pr_estado = 1");
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		}
	}
?>