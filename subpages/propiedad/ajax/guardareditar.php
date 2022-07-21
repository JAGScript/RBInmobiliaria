<?php
	date_default_timezone_set('America/Guayaquil');
	require_once('../../../class/private.db.php');
	
	$gbd = new DBConn();
	
	$hoy = date("y-m-d H:i:s");
	
	$id = $_POST['idPropiedad'];
	$propietario = $_POST['propietario'];
	$tipo = $_POST['tipo'];
	$barrio = $_POST['barrio'];
	$precio = $_POST['precio'];
	$foto = $_POST['foto'];
	$activo = $_POST['activo'];

	$caracteristicaId = $_POST['data'];
	$metros = $_POST['metros'];
	$plantas = $_POST['plantas'];
	$banios = $_POST['banios'];
	$habitacion = $_POST['habitacion'];
	$parqueadero = $_POST['parqueadero'];
	$servicios = $_POST['servicios'];
	$otros = $_POST['otros'];
	
	try{
		$update = "	UPDATE 	propiedad 
					SET 	pr_barrio_id = ?, 
							pr_tipo_id = ?, 
							pr_propietario_id = ?, 
							pr_precio = ?, 
							pr_foto_principal = ?, 
							pr_estado = ? 
					WHERE 	pr_id = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($barrio,$tipo,$propietario,$precio,$foto,$activo,$id));

		$update1 = "	UPDATE 	caracteristica 
					SET 	ca_metros = ?, 
							ca_plantas = ?, 
							ca_banios = ?, 
							ca_habitaciones = ?, 
							ca_parqueaderos = ?, 
							ca_servicios = ?, 
							ca_otos = ? 
					WHERE 	pr_id = ?";
		$upd1= $gbd -> prepare($update1);
		$upd1 -> execute(array($metros,$plantas,$banios,$habitacion,$parqueadero,$servicios,$otros,$caracteristicaId));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>