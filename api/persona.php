<?php 
	include "conection/config.php";
	include "conection/utils.php";
	
	$dbConn = connect($db);
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if (isset($_GET['IdUsuario'])){
			$sql = $dbConn->prepare("SELECT * FROM persona WHERE pe_id_usuario=:IdUsuario");
			$sql->bindValue(':IdUsuario', $_GET['IdUsuario']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		} else if (isset($_GET['IdPersona'])){
			$sql = $dbConn->prepare("SELECT * FROM persona WHERE pe_id=:IdPersona");
			$sql->bindValue(':IdPersona', $_GET['IdPersona']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		} else {
			$sql = $dbConn->prepare("SELECT * FROM persona");
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		}
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$input = $_POST;
		$sql = "INSERT INTO persona
		(pe_id, pe_tipo, pe_identificacion, pe_nombre, pe_direccion, pe_celular, pe_correo, pe_id_usuario, pe_estado)
		VALUES
		(:IdPersona, :Tipo, :Identificacion, :Nombre, :Direccion, :Telefono, :Correo, :IdUsuario, :Estado)";
		$statement = $dbConn->prepare($sql);
		bindAllValues($statement, $input);
		$statement->execute();
		$postCodigo = $dbConn->lastInsertId();
		if($postCodigo){
			$input['IdPersona'] = $postCodigo;
			header("HTTP/1.1 200 OK");
			echo json_encode($input);
			exit();
		}
	}
?>