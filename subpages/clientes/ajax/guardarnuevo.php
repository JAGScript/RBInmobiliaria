<?php 
	date_default_timezone_set('America/Guayaquil');
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();

	$hoy = date("Y-m-d H:i:s");
	
	$cedula = $_POST['cedula'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$email = $_POST['email'];
	$direccion = $_POST['direccion'];
	$telefono = $_POST['telefono'];
	$celular = $_POST['celular'];
	
	try{
		$insert = "INSERT INTO cliente VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array('NULL',$cedula,$nombre,$apellido,$email,$direccion,$telefono,$celular,1,$hoy));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>