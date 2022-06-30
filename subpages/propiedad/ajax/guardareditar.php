<?php
	date_default_timezone_set('America/Guayaquil');
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$hoy = date("y-m-d H:i:s");
	
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$identificacion = $_POST['identificacion'];
	$email = $_POST['email'];
	$login = $_POST['login'];
	$perfil = $_POST['perfil'];
	$activo = $_POST['activo'];
	
	try{
		$update = "UPDATE usuario SET us_rol_id = ?, us_login = ?, us_nombre = ?, us_identificacion = ?, us_correo = ?, us_estado = ? WHERE us_id = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($perfil,$login,$nombre,$identificacion,$email,$activo,$id));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>