<?php 
	include('control/seguridad.php');
	
	$id = $_GET['data'];
	
	$select = "SELECT * FROM barrio WHERE ba_id = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($id));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	$idParroquia = $row['ba_parroquia_id'];
	
	$sql3 = "SELECT * FROM parroquia WHERE pq_estado = ?";
	$stmt3 = $gbd -> prepare($sql3);
	$stmt3 -> execute(array(1));
	$content_parroquia = '';
	while($row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC)){
		
		$selected = '';
		
		if($row3['pq_id'] == $idParroquia){
			$selected = 'selected';
		}
		
		$content_parroquia .= '<option value="'.$row3['pq_id'].'" '.$selected.'>'.$row3['pq_nombre'].'</option>';
	}
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-8 col-md-push-2" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<div class="col-md-3">
				<h4>Parroquia:</h4>
			</div>
			<div class="col-md-9">
				<select class="form-control input-sm" id="parroquia">
					<option value="0">Seleccione...</option>
					<?php echo $content_parroquia; ?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Nombre:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="nombre" class="form-control" placeholder="Nombre Barrio" value="<?php echo $row['ba_nombre'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Activo:</h4>
			</div>
			<div class="col-md-9">
				<?php if($row['ba_estado'] == 1){?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['ba_estado'];?>')">
					<span class="glyphicon glyphicon-check" id="tipoactivo" aria-hidden="true"></span>
				</button>
				<?php }else{?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['ba_estado'];?>')">
					<span class="glyphicon glyphicon-unchecked" id="tipoactivo" aria-hidden="true"></span>
				</button>
				<?php }?>
			</div>
		</div>
		<div class="row" style="margin-top:20px;">
			<div class="col-md-12" style="text-align:right;">
				<button type="button" class="btn btn-primary" onclick="guardar(<?php echo $id;?>)" id="btnguardar">Guardar</button>
				<img src="img/loading.gif" id="wait" style="display:none;"/>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#titulopag').html('<div class="col-md-11">\
							<h2>\
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;\
								Editar Barrio\
								<button class="btn btn-success pull-right" type="button" onclick="volver()">\
									<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>\
									Volver\
								</button>\
							</h2>\
						</div>');
});

function volver(){
	window.location = '?modulo=listabarrio';
}

function activacion(data){
	if($('.glyphicon-check').length){
		$('#tipoactivo').removeClass('glyphicon-check');
		$('#tipoactivo').addClass('glyphicon-unchecked');
	}else{
		$('#tipoactivo').removeClass('glyphicon-unchecked');
		$('#tipoactivo').addClass('glyphicon-check');
	}
}

function guardar(data){
	var parroquia = $('#parroquia').val();
	var nombre = $('#nombre').val();
	if($('.glyphicon-check').length){
		var activo = 1;
	}else{
		var activo = 0;
	}
	if(parroquia == 0 || nombre == ''){
		$('#blanco').modal('show');
	}else{
		$('#btnguardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/barrio/ajax/guardareditar.php',{
			parroquia: parroquia, nombre : nombre, activo : activo, data : data
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>