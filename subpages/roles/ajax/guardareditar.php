<?php
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$data = $_POST['data'];
	$nombre = $_POST['nombre'];
	$activo = $_POST['activo'];
	
	try{
		$update = "UPDATE rol SET ro_nombre = ?, ro_estado = ? WHERE ro_id = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($nombre,$activo,$data));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>