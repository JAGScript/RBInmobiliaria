<?php 
	include "conection/config.php";
	include "conection/utils.php";
	
	$dbConn = connect($db);
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if (isset($_GET['IdUsuario'])){
			$sql = $dbConn->prepare("SELECT * FROM usuario WHERE us_id=:IdUsuario");
			$sql->bindValue(':IdUsuario', $_GET['IdUsuario']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		} else if (isset($_GET['UserName']) && isset($_GET['IdentificacionUsuario']) && isset($_GET['CorreoUsuario'])){
			$sql = $dbConn->prepare("SELECT * FROM usuario WHERE us_identificacion=:IdentificacionUsuario OR us_correo=:CorreoUsuario OR us_login=:UserName");
			$sql->bindValue(':IdentificacionUsuario', $_GET['IdentificacionUsuario']);
			$sql->bindValue(':CorreoUsuario', $_GET['CorreoUsuario']);
			$sql->bindValue(':UserName', $_GET['UserName']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		} else if (isset($_GET['UserName']) && isset($_GET['Pass'])){
			$sql = $dbConn->prepare("SELECT * FROM usuario WHERE us_login=:UserName AND us_contrasena=:Pass");
			$sql->bindValue(':UserName', $_GET['UserName']);
			$sql->bindValue(':Pass', $_GET['Pass']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		} else {
			$sql = $dbConn->prepare("SELECT * FROM usuario");
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 OK");
			echo json_encode( $sql->fetchAll() );
			exit();
		}
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$input = $_POST;
		$sql = "INSERT INTO usuario
		(us_id, us_rol_id, us_nombre, us_identificacion, us_correo, us_login, us_contrasena, us_estado)
		VALUES
		(:IdUsuario, :IdRol, :NombreUsuario, :IdentificacionUsuario, :CorreoUsuario, :UserName, :Pass, :Estado)";
		$statement = $dbConn->prepare($sql);
		bindAllValues($statement, $input);
		$statement->execute();
		$postCodigo = $dbConn->lastInsertId();

		if($postCodigo){
			$input['IdUsuario'] = $postCodigo;
			header("HTTP/1.1 200 OK");
			echo json_encode($input);
			exit();
		}
	}

	if($_SERVER['REQUEST_METHOD'] == 'PUT'){
		$input = $_GET;
		$postCodigo = $input['us_id'];
		$fields = getParams($input);
		$sql = "UPDATE usuario SET $fields WHERE us_id='$postCodigo'";
		$statement = $dbConn->prepare($sql);
		bindAllValues($statement, $input);
		$statement->execute();
		header("HTTP/1.1 200 OK");
		exit();
	}
?>