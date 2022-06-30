<?php 
	date_default_timezone_set('America/Guayaquil');
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();

	$hoy = date("Y-m-d H:i:s");
	
	$id = $_POST['data'];
	$cedula = $_POST['cedula'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$email = $_POST['email'];
	$direccion = $_POST['direccion'];
	$telefono = $_POST['telefono'];
	$celular = $_POST['celular'];
	$activo = $_POST['activo'];
	
	try{
		$update = "UPDATE cliente SET cedula = ?, nombre = ?, apellido = ?, email = ?, direccion = ?, telefono = ?, celular = ?, activo = ? WHERE id = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($cedula,$nombre,$apellido,$email,$direccion,$telefono,$celular,$activo,$id));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>