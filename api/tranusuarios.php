<?php 
	include "conection/config.php";
	include "conection/utils.php";
	
	$dbConn = connect($db);

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        if (isset($_GET['IdUsuario'])){
			$sql = $dbConn->prepare("SELECT * FROM codigo_recuperacion WHERE cr_usuario_id=:IdUsuario AND cr_estado = 1");
			$sql->bindValue(':IdUsuario', $_GET['IdUsuario']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		}  
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$input = $_POST;
		$sql = "INSERT INTO codigo_recuperacion
		(cr_id, cr_usuario_id, cr_codigo, cr_fecha, cr_estado)
		VALUES
		(:IdSec, :IdUsuario, :Codigo, :Fecha, :Estado)";
		$statement = $dbConn->prepare($sql);
		bindAllValues($statement, $input);
		$statement->execute();
		$postCodigo = $dbConn->lastInsertId();
		if($postCodigo){
			$input['codigo'] = $postCodigo;
			header("HTTP/1.1 200 OK");
			echo json_encode($input);
			exit();
		}
	}

	if($_SERVER['REQUEST_METHOD'] == 'PUT'){
		$input = $_GET;
		$postCodigo = $input['cr_id'];
		$fields = getParams($input);
		$sql = "UPDATE codigo_recuperacion SET $fields WHERE cr_id='$postCodigo'";
		$statement = $dbConn->prepare($sql);
		bindAllValues($statement, $input);
		$statement->execute();
		header("HTTP/1.1 200 OK");
		exit();
	}
?>