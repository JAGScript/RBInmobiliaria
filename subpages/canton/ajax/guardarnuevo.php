<?php
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$nombre = $_POST['nombre'];
	$provincia = $_POST['provincia'];
	$codigo = $_POST['codigo'];
	
	try{
		$insert = "INSERT INTO canton VALUES (?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array('NULL',$provincia,$codigo,$nombre,1));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>