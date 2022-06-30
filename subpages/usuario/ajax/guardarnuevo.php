<?php
	date_default_timezone_set('America/Guayaquil');
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$hoy = date("y-m-d H:i:s");
	
	$nombre = $_POST['nombre'];
	$identificacion = $_POST['identificacion'];
	$email = $_POST['email'];
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	$pass = md5($pass);
	$perfil = $_POST['perfil'];
	
	try{
		$insert = "INSERT INTO usuario VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array('NULL',$perfil,$nombre,$identificacion,$email,$login,$pass,1));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>