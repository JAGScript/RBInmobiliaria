<?php
	date_default_timezone_set('America/Guayaquil');
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$hoy = date("y-m-d H:i:s");
	
	$tipo = $_POST['tipo'];
	$nombre = $_POST['nombre'];
	$identificacion = $_POST['identificacion'];
	$email = $_POST['email'];
	$direccion = $_POST['direccion'];
	$celular = $_POST['celular'];
	
	try{
		$insert = "INSERT INTO persona VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array('NULL',$tipo,$identificacion,$nombre,$direccion,$celular,$email,1));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>