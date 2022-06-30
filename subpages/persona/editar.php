<?php 
	include('control/seguridad.php');
	
	$id = $_GET['data'];
	
	$select = "SELECT * FROM persona WHERE pe_id = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($id));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	$idTipo = $row['pe_tipo'];
	
	$selectTipo1 = '';
	$selectTipo2 = '';
	$selectTipo3 = '';
	
	if($idTipo == 1){
		$selectTipo1 = 'selected';
	} else if($idTipo == 2){
		$selectTipo2 = 'selected';
	} else if($idTipo == 3){
		$selectTipo3 = 'selected';
	}
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-8 col-md-push-2" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<div class="col-md-3">
				<h4>Tipo:</h4>
			</div>
			<div class="col-md-9">
				<select class="form-control" id="tipo">
					<option value="1" <?php echo $selectTipo1; ?>>Propietario</option>
					<option value="2" <?php echo $selectTipo2; ?>>Cliente</option>
					<option value="3" <?php echo $selectTipo3; ?>>Asesor</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Nombre:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="nombre" class="form-control" placeholder="Ingresar el Nombre" value="<?php echo $row['pe_nombre'];?>" />
				<input type="hidden" value="<?php echo $id;?>" id="id" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Identifiación:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="identificacion" class="form-control" placeholder="Ingresar la identificación" value="<?php echo $row['pe_identificacion'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Dirección:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="direccion" class="form-control" placeholder="Ingresar la Dirección" value="<?php echo $row['pe_direccion'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Email:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="mail" class="form-control" placeholder="Ingresar el Email"  value="<?php echo $row['pe_correo'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Celular:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="celular" class="form-control" placeholder="Ingresar Login" value="<?php echo $row['pe_celular'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Activo:</h4>
			</div>
			<div class="col-md-9">
				<?php if($row['pe_estado'] == 1){?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['pe_estado'];?>')">
					<span class="glyphicon glyphicon-check" id="tipoactivo" aria-hidden="true"></span>
				</button>
				<?php }else{?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['pe_estado'];?>')">
					<span class="glyphicon glyphicon-unchecked" id="tipoactivo" aria-hidden="true"></span>
				</button>
				<?php }?>
			</div>
		</div>
		<div class="row" style="margin-top:20px;">
			<div class="col-md-12" style="text-align:right;">
				<button type="button" class="btn btn-primary" onclick="guardar()" id="btnguardar">Guardar</button>				
				<img src="img/loading.gif" id="wait" style="display:none;"/>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#titulopag').html('<div class="col-md-11">\
							<h2>\
								<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;\
								Editar Persona\
								<button class="btn btn-success pull-right" type="button" onclick="volver()">\
									<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>\
									Volver\
								</button>\
							</h2>\
						</div>');
});

function volver(){
	window.location = '?modulo=listapersona';
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

function guardar(){
	var id = $('#id').val();
	var tipo = $('#tipo').val();
	var nombre = $('#nombre').val();
	var identificacion = $('#identificacion').val();
	var email = $('#mail').val();
	var direccion = $('#direccion').val();
	var celular = $('#celular').val();
	
	if($('.glyphicon-check').length){
		var activo = 1;
	}else{
		var activo = 0;
	}
	
	if((tipo == 0 || nombre == '') || (identificacion == '') || (email == '') || (direccion == '') || (celular == '')){
		$('#blanco').modal('show');
	}else{
		$('#btnguardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/persona/ajax/guardareditar.php',{
			id : id, tipo : tipo, nombre : nombre, identificacion : identificacion, email : email, direccion : direccion, celular : celular, activo : activo
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>