<?php
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$data = $_POST['data'];
	$codigo = $_POST['codigo'];
	$nombre = $_POST['nombre'];
	$activo = $_POST['activo'];
	
	try{
		$update = "UPDATE provincia SET pv_codigo = ?, pv_nombre = ?, pv_estado = ? WHERE pv_id = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($codigo,$nombre,$activo,$data));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>