<?php
	date_default_timezone_set('America/Guayaquil');
	require_once('../../../class/private.db.php');
	include('../../../control/seguridad.php');
	
	$hoy = date("Y-m-d H:i:s");
	
	$gbd = new DBConn();
	
	$propiedad = $_POST['data'];
	foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
	{
		if($_FILES["archivo"]["name"][$key]) {
			$filename = $_FILES["archivo"]["name"][$key];
			$source = $_FILES["archivo"]["tmp_name"][$key];
			
			$directorio = '../fotos';
			
			if(!file_exists($directorio)){
				mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
			}
			
			$dir=opendir($directorio);
			$target_path = $directorio.'/'.$filename;
			
			if(move_uploaded_file($source, $target_path)) {	
				$insert = "INSERT INTO imagen VALUES (?, ?, ?, ?)";
				$ins = $gbd -> prepare($insert);
				$ins -> execute(array('NULL',$propiedad,$filename,1));
			}
			closedir($dir);
		}
	}
	
	header("Location: ../../../?modulo=addFotos&data=".$propiedad);
?>