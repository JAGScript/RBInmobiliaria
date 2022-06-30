<?php 
	include('control/seguridad.php');
	
	$select = "SELECT * FROM rol WHERE ro_estado = 1";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute();
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-8 col-md-push-2" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<div class="col-md-3">
				<h4>Nombre:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="nombre" class="form-control" placeholder="Ingresar el Nombre del Usuario" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Identificación:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="identificacion" class="form-control" placeholder="Ingresar la Identificación del Usuario" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Email:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="mail" class="form-control" placeholder="Ingresar el Email del Usuario" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Login:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="login" class="form-control" placeholder="Ingresar Login del Usuario" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Contraseña:</h4>
			</div>
			<div class="col-md-9">
				<input type="password" id="pass" class="form-control" placeholder="**********" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Repita la Contraseña:</h4>
			</div>
			<div class="col-md-9">
				<input type="password" id="pass1" class="form-control" onchange="validarpass(this.value)" placeholder="**********" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Perfil:</h4>
			</div>
			<div class="col-md-9">
				<select class="form-control" id="perfil">
					<option value="0">Seleccione...</option>
				<?php
				while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
					echo '
					<option value="'.$row['ro_id'].'">'.$row['ro_nombre'].'</option>
					';
				}
				?>
				</select>
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
<div class="modal fade" id="errorpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location='';"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger" role="alert">
					<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;
					Las contraseñas no coinciden.
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#titulopag').html('<div class="col-md-11">\
							<h2>\
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;\
								Nuevo Usuario\
								<button class="btn btn-success pull-right" type="button" onclick="volver()">\
									<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>\
									Volver\
								</button>\
							</h2>\
						</div>');
});

function validarpass(value){
	var pass = $('#pass').val();
	if(value != pass){
		$('#pass1').val('');
		$('#errorpass').modal('show');
	}
}

function volver(){
	window.location = '?modulo=listausuario';
}

function guardar(){
	var nombre = $('#nombre').val();
	var identificacion = $('#identificacion').val();
	var email = $('#mail').val();
	var login = $('#login').val();
	var pass = $('#pass').val();
	var perfil = $('#perfil').val();
	if((nombre == '') || (identificacion == '') || (login == '') || (pass == '') || (perfil == 0)){
		$('#blanco').modal('show');
	}else{
		$('#btnguardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/usuario/ajax/guardarnuevo.php',{
			nombre : nombre, identificacion : identificacion, email : email, login : login, pass : pass, perfil : perfil
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>