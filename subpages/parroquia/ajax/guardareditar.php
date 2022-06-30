<?php
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$data = $_POST['data'];
	$canton = $_POST['canton'];
	$codigo = $_POST['codigo'];
	$nombre = $_POST['nombre'];
	$activo = $_POST['activo'];
	
	try{
		$update = "UPDATE parroquia SET pq_canton = ?, pq_codigo = ?, pq_nombre = ?, pq_estado = ? WHERE pq_id = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($canton,$codigo,$nombre,$activo,$data));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>