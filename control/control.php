<?php 
	session_start();
	require_once('../class/private.db.php');
	
	$gbd = new DBConn();
	
	$user = $_POST['login'];
	$pass = $_POST['pass'];
	$pass = md5($pass);
	
	$sql = "SELECT 	us_id, 
					us_nombre,
					us_identificacion,
					us_correo, 
					us_login, 
					ro_nombre, 
					ro_id
			FROM 	usuario
			JOIN 	rol ON us_rol_id = ro_id
			WHERE 	us_login = ? AND us_contrasena = ? AND us_estado = ?";
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute(array($user,$pass,1));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	$datosok = $stmt -> rowCount();
	if($datosok > 0){
		$perfil = $row['ro_id'];
		$_SESSION['auth'] = md5('M45T3R');
		$_SESSION['autentica'] = md5('Inmo2022');
		$_SESSION['id'] = $row['us_id'];
		$_SESSION['nombre'] = $row['us_nombre'];
		$_SESSION['identificacion'] = $row['us_identificacion'];
		$_SESSION['correo'] = $row['us_correo'];
		$_SESSION['perfil'] = $row['ro_nombre'];
		if($perfil == 1){
			$_SESSION['EsAdmin'] = md5('Admin2022');
		}
		echo 'ok';
	}else{
		echo 'error';
	}
?>