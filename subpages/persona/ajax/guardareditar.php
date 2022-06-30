<?php
	date_default_timezone_set('America/Guayaquil');
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$hoy = date("y-m-d H:i:s");
	
	$id = $_POST['id'];
	$tipo = $_POST['tipo'];
	$nombre = $_POST['nombre'];
	$identificacion = $_POST['identificacion'];
	$email = $_POST['email'];
	$direccion = $_POST['direccion'];
	$celular = $_POST['celular'];
	$activo = $_POST['activo'];
	
	try{
	$update = "UPDATE persona SET pe_tipo = ?, pe_identificacion = ?, pe_nombre = ?, pe_direccion = ?, pe_celular = ?, pe_correo = ?, pe_estado = ? WHERE pe_id = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($tipo,$identificacion,$nombre,$direccion,$celular,$email,$activo,$id));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>