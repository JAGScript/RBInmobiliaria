<?php
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$data = $_POST['data'];
	$nombre = $_POST['nombre'];
	$activo = $_POST['activo'];
	
	try{
		$update = "UPDATE tipo_propiedad SET tp_nombre = ?, tp_estado = ? WHERE tp_id = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($nombre,$activo,$data));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>