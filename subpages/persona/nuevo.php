<?php 
	include('control/seguridad.php');
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-8 col-md-push-2" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<div class="col-md-3">
				<h4>Tipo:</h4>
			</div>
			<div class="col-md-9">
				<select class="form-control" id="tipo">
					<option value="0">Seleccione...</option>
					<option value="1">Propietario</option>
					<option value="2">Cliente</option>
					<option value="3">Asesor</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Nombre:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="nombre" class="form-control" placeholder="Ingresar el Nombre" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Identificación:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="identificacion" class="form-control" placeholder="Ingresar la Identificación" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Dirección:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="direccion" class="form-control" placeholder="Ingresar la Dirección" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Email:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="mail" class="form-control" placeholder="Ingresar el Email" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Celular:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="celular" class="form-control" placeholder="0999999999" />
			</div>
		</div>
		<div class="row" style="margin-top:20px;">
			<div class="col-md-12" style="text-align:right;">
				<button type="button" class="btn btn-primary " onclick="guardar()" id="btnguardar">Guardar</button>				
				<img src="img/loading.gif" id="wait" style="display:none;"/>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#titulopag').html('<div class="col-md-11">\
							<h2>\
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;\
								Nueva Persona\
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

function guardar(){
	var tipo = $('#tipo').val();
	var nombre = $('#nombre').val();
	var identificacion = $('#identificacion').val();
	var email = $('#mail').val();
	var direccion = $('#direccion').val();
	var celular = $('#celular').val();
	if((tipo == 0 || nombre == '') || (identificacion == '') || (email == '') || (direccion == '') || (celular == '')){
		$('#blanco').modal('show');
	}else{
		$('#btnguardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/persona/ajax/guardarnuevo.php',{
			tipo : tipo, nombre : nombre, identificacion : identificacion, email : email, direccion : direccion, celular : celular
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>