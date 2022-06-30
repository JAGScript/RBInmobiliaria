<?php
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$nombre = $_POST['nombre'];
	
	try{
		$insert = "INSERT INTO tipo_propiedad VALUES (?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array('NULL',$nombre,1));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>