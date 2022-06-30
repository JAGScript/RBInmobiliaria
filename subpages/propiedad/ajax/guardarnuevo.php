<?php
	date_default_timezone_set('America/Guayaquil');
	require_once('../../../class/private.db.php');
	include('../../../control/seguridad.php');
	
	$gbd = new DBConn();
	
	$hoy = date("y-m-d H:i:s");
	
	
	$propietario = $_POST['propietario'];
	$tipo = $_POST['tipo'];
	$barrio = $_POST['barrio'];
	$precio = $_POST['precio'];
	$foto = $_POST['foto'];
	
	$metros = $_POST['metros'];
	$plantas = $_POST['plantas'];
	$banios = $_POST['banios'];
	$habitacion = $_POST['habitacion'];
	$parqueadero = $_POST['parqueadero'];
	$servicios = $_POST['servicios'];
	$otros = $_POST['otros'];
	
	try{
		$insert1 = "INSERT INTO caracteristica VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$ins1 = $gbd -> prepare($insert1);
		$ins1 -> execute(array('NULL',$metros,$plantas,$banios,$habitacion,$parqueadero,$servicios,$otros));
		$idCaracteristica = $gbd -> lastInsertId();
		
		$insert = "INSERT INTO propiedad VALUES (?, ?, ?, ?, ?, ?, ?, ?, ? ,?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array('NULL',$idCaracteristica,$barrio,$tipo,$propietario,$_SESSION['id'],$precio,$hoy,$foto,1));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>