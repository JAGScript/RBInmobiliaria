<?php 
	include('control/seguridad.php');
	
	$id = $_GET['data'];
	$smsId = $_GET['sms'];
	
	$upd = "UPDATE notificacion SET no_estado = ? WHERE no_id = ?";
	$update = $gbd -> prepare($upd);
	$update -> execute(array(0, $smsId));

	$select = "SELECT 	*
				FROM 	propiedad
				WHERE 	pr_id = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($id));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	$select1 = "SELECT * FROM barrio WHERE ba_estado = 1";
	$stmt1 = $gbd -> prepare($select1);
	$stmt1 -> execute();
	$content_barrio = '';
	while($row1 = $stmt1 -> fetch(PDO::FETCH_ASSOC)){
		if($row1['ba_id'] == $row['pr_barrio_id'])
			$content_barrio .= $row1['ba_nombre'];
	}
	
	$select2 = "SELECT * FROM tipo_propiedad WHERE tp_estado = 1";
	$stmt2 = $gbd -> prepare($select2);
	$stmt2 -> execute();
	$content_tipo = '';
	while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
		if($row2['tp_id'] == $row['pr_tipo_id'])
			$content_tipo = $row2['tp_nombre'];
	}
	
	$select3 = "SELECT * FROM persona WHERE pe_tipo = 1 AND pe_estado = 1";
	$stmt3 = $gbd -> prepare($select3);
	$stmt3 -> execute();
	$content_persona = '';
	while($row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC)){
		if($row3['pe_id'] == $row['pr_propietario_id'])
			$content_persona = $row3['pe_nombre'];
	}

	$select4 = "SELECT * FROM caracteristica WHERE ca_id = ?";
	$stmt4 = $gbd -> prepare($select4);
	$stmt4 -> execute(array($row['pr_caracteristica_id']));
	$row4 = $stmt4 -> fetch(PDO::FETCH_ASSOC);
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-8 col-md-push-2" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row" style="padding:20px 0px;">
			<div class="col-md-12" style="text-align:center;">
				<img id="show_foto" style="width:250px; border:1px solid #000;" class="mapa" src="<?php echo "subpages/propiedad/fotos/". $row['pr_foto_principal'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Propietario:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="precio" class="form-control" readonly="readonly" value="<?php echo $content_persona;?>" onkeydown="justDouble(event,this.value,this)" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Tipo de Propiedad:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="precio" class="form-control" readonly="readonly" value="<?php echo $content_tipo;?>" onkeydown="justDouble(event,this.value,this)" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Barrio:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="precio" class="form-control" readonly="readonly" value="<?php echo $content_barrio;?>" onkeydown="justDouble(event,this.value,this)" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Precio:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="precio" class="form-control" readonly="readonly" value="<?php echo number_format($row['pr_precio'], 2);?>" onkeydown="justDouble(event,this.value,this)" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3>Características:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Metros Cuadrados:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="metros" class="form-control" readonly="readonly" value="<?php echo number_format($row4['ca_metros'], 2); ?>" onkeydown="justDouble(event,this.value,this)"/>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Plantas:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="plantas" class="form-control" readonly="readonly" value="<?php echo $row4['ca_plantas']; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Baños:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="banios" class="form-control" readonly="readonly" value="<?php echo $row4['ca_banios']; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Habitaciones:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="habitacion" class="form-control" readonly="readonly" value="<?php echo $row4['ca_habitaciones']; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Parqueaderos:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="parqueadero" class="form-control" readonly="readonly" value="<?php echo $row4['ca_parqueaderos']; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Servicios:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="servicios" class="form-control" value="<?php echo $row4['ca_servicios']; ?>" readonly="readonly" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Otros:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="otros" class="form-control" value="<?php echo $row4['ca_otros']; ?>" readonly="readonly" />
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#titulopag').html('<div class="col-md-11">\
							<h2>\
								<span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;\
								Ver Propiedad\
								<button class="btn btn-success pull-right" type="button" onclick="volver()">\
									<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>\
									Volver\
								</button>\
							</h2>\
						</div>');
});

function volver(){
	window.location = '?modulo=listanotificacion';
}
</script>