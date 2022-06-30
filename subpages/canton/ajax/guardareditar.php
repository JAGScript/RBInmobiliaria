<?php
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$data = $_POST['data'];
	$provincia = $_POST['provincia'];
	$codigo = $_POST['codigo'];
	$nombre = $_POST['nombre'];
	$activo = $_POST['activo'];
	
	try{
		$update = "UPDATE canton SET ca_provincia_id = ?, ca_codigo = ?, ca_nombre = ?, ca_estado = ? WHERE ca_id = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($provincia,$codigo,$nombre,$activo,$data));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>