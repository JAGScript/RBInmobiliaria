<?php 
	date_default_timezone_set('America/Guayaquil');
	require_once('../../../class/private.db.php');
	include('../../../control/seguridad.php');
	
	$hoy = date("Y-m-d H:i:s");
	
	$gbd = new DBConn();
	
	$id = $_POST['data'];
	$propiedad = $_POST['propiedad'];
	
	$update = "UPDATE imagen SET im_estado = ? WHERE im_id = ?";
	$upd = $gbd -> prepare($update);
	$upd -> execute(array(0,$id));
	
	$select = "SELECT * FROM imagen WHERE im_propiedad = ? AND im_estado = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($propiedad,1));
	$content = '';
	
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
		$content .= '
			<div class="col-xs-6 col-md-3">
				<a class="thumbnail" style="height:200px !important; overflow:hidden;">
					<button type="button" class="btn btn-danger" style="position:absolute; right:20px;" onclick="deleteimg('.$row['im_id'].')">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
					<img src="subpages/propiedad/fotos/'.$row['im_nombre'].'" style=" cursor:pointer;" onclick="viewfoto('.$row['im_id'].')">
				</a>
			</div>
		';
	}
	
	echo $content;
?>