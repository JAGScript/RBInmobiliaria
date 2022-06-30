<?php
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$data = $_POST['data'];
	$parroquia = $_POST['parroquia'];
	$nombre = $_POST['nombre'];
	$activo = $_POST['activo'];
	
	try{
		$update = "UPDATE barrio SET ba_parroquia_id = ?, ba_nombre = ?, ba_estado = ? WHERE ba_id = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($parroquia,$nombre,$activo,$data));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>