<?php 
	include('control/seguridad.php');
	
	$id = $_GET['data'];
	
	$select = "SELECT * FROM canton WHERE ca_id = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($id));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	$idProvincia = $row['ca_provincia_id'];
	
	$sql3 = "SELECT * FROM provincia WHERE pv_estado = ?";
	$stmt3 = $gbd -> prepare($sql3);
	$stmt3 -> execute(array(1));
	$content_provincia = '';
	while($row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC)){
		
		$selected = '';
		
		if($row3['pv_id'] == $idProvincia){
			$selected = 'selected';
		}
		
		$content_provincia .= '<option value="'.$row3['pv_id'].'" '.$selected.'>'.$row3['pv_nombre'].'</option>';
	}
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-8 col-md-push-2" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<div class="col-md-3">
				<h4>Provincia:</h4>
			</div>
			<div class="col-md-9">
				<select class="form-control input-sm" id="provincia">
					<option value="0">Seleccione...</option>
					<?php echo $content_provincia; ?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Código:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="codigo" class="form-control" placeholder="Código Cantón" value="<?php echo $row['ca_codigo'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Nombre:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="nombre" class="form-control" placeholder="Nombre Cantón" value="<?php echo $row['ca_nombre'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Activo:</h4>
			</div>
			<div class="col-md-9">
				<?php if($row['ca_estado'] == 1){?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['ca_estado'];?>')">
					<span class="glyphicon glyphicon-check" id="tipoactivo" aria-hidden="true"></span>
				</button>
				<?php }else{?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['ca_estado'];?>')">
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
								Editar Catón\
								<button class="btn btn-success pull-right" type="button" onclick="volver()">\
									<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>\
									Volver\
								</button>\
							</h2>\
						</div>');
});

function volver(){
	window.location = '?modulo=listacanton';
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
	var provincia = $('#provincia').val();
	var nombre = $('#nombre').val();
	if($('.glyphicon-check').length){
		var activo = 1;
	}else{
		var activo = 0;
	}
	if(provincia == 0 || nombre == '' || codigo == ''){
		$('#blanco').modal('show');
	}else{
		$('#btnguardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/canton/ajax/guardareditar.php',{
			provincia: provincia, codigo : codigo, nombre : nombre, activo : activo, data : data
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>