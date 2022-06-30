<?php 
	date_default_timezone_set('America/Guayaquil');
	require_once('../../../class/private.db.php');
	include('../../../control/seguridad.php');
	
	$hoy = date("Y-m-d H:i:s");
	
	$gbd = new DBConn();
	
	$id = $_POST['data'];
	
	$select = "SELECT * FROM imagen WHERE im_id = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($id));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	echo $row['im_nombre'];
?>