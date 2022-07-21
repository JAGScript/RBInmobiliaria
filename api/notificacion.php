<?php 
	include "conection/config.php";
	include "conection/utils.php";
	
	$dbConn = connect($db);

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$input = $_POST;
		$sql = "INSERT INTO notificacion
		(no_id, no_asesor_id, no_propiedad_id, no_persona_id, no_fecha, no_estado)
		VALUES
		(:Id, :IdAsesor, :IdPropiedad, :IdPersona, :Fecha, :Estado)";
		$statement = $dbConn->prepare($sql);
		bindAllValues($statement, $input);
		$statement->execute();
		$postCodigo = $dbConn->lastInsertId();
		if($postCodigo){
			$input['codigo'] = $postCodigo;
			header("HTTP/1.1 200 OK");
			echo json_encode($input);
			exit();
		}
	}
?>