<?php
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$nombre = $_POST['nombre'];
	$codigo = $_POST['codigo'];
	
	try{
		$insert = "INSERT INTO provincia VALUES (?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array('NULL',$codigo,$nombre,1));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>