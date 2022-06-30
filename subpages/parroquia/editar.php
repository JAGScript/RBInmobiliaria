<?php 
	include('control/seguridad.php');
	
	$id = $_GET['data'];
	
	$select = "SELECT * FROM parroquia WHERE pq_id = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($id));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	$idCanton = $row['pq_canton'];
	
	$sql3 = "SELECT * FROM canton WHERE ca_estado = ?";
	$stmt3 = $gbd -> prepare($sql3);
	$stmt3 -> execute(array(1));
	$content_canton = '';
	while($row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC)){
		
		$selected = '';
		
		if($row3['ca_id'] == $idCanton){
			$selected = 'selected';
		}
		
		$content_canton .= '<option value="'.$row3['ca_id'].'" '.$selected.'>'.$row3['ca_nombre'].'</option>';
	}
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-8 col-md-push-2" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<div class="col-md-3">
				<h4>Cantón:</h4>
			</div>
			<div class="col-md-9">
				<select class="form-control input-sm" id="canton">
					<option value="0">Seleccione...</option>
					<?php echo $content_canton; ?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Código:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="codigo" class="form-control" placeholder="Código Parroquia" value="<?php echo $row['pq_codigo'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Nombre:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="nombre" class="form-control" placeholder="Nombre Parroquia" value="<?php echo $row['pq_nombre'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Activo:</h4>
			</div>
			<div class="col-md-9">
				<?php if($row['pq_estado'] == 1){?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['pq_estado'];?>')">
					<span class="glyphicon glyphicon-check" id="tipoactivo" aria-hidden="true"></span>
				</button>
				<?php }else{?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['pq_estado'];?>')">
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
								Editar Parroquia\
								<button class="btn btn-success pull-right" type="button" onclick="volver()">\
									<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>\
									Volver\
								</button>\
							</h2>\
						</div>');
});

function volver(){
	window.location = '?modulo=listaparroquia';
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
	var codigo = $('#codigo').val();
	var canton = $('#canton').val();
	var nombre = $('#nombre').val();
	if($('.glyphicon-check').length){
		var activo = 1;
	}else{
		var activo = 0;
	}
	if(canton == 0 || nombre == '' || codigo == ''){
		$('#blanco').modal('show');
	}else{
		$('#btnguardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/parroquia/ajax/guardareditar.php',{
			canton: canton, codigo : codigo, nombre : nombre, activo : activo, data : data
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>