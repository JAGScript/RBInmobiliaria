<?php
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$nombre = $_POST['nombre'];
	$canton = $_POST['canton'];
	$codigo = $_POST['codigo'];
	
	try{
		$insert = "INSERT INTO parroquia VALUES (?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array('NULL',$canton,$codigo,$nombre,1));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>