<?php
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$nombre = $_POST['nombre'];
	$parroquia = $_POST['parroquia'];
	
	try{
		$insert = "INSERT INTO barrio VALUES (?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array('NULL',$parroquia,$nombre,1));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>