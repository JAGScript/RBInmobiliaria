<?php 
	include('control/seguridad.php');
	
	$select = "SELECT * FROM cliente";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute();
	
	$content = '<div style="display:none;">';
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
		$content .= '
		<div class="documentos"><input type="hidden" class="cedula" value="'.$row['cedula'].'" /></div>
		';
	}
	$content .= '</div>';
	
	echo $content;
?>
<div class="row">
	<div class="col-md-9" style="padding-left:10px; ppading-bottom:15px;">
		<h3>
			<span style="border-bottom:5px solid #5bc0de;">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;
				Nuevo Cliente
			</span>
		</h3>
	</div>
	<div class="col-md-2">
		<button class="btn btn-success pull-right" type="button" onclick="lista()">
			<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			Lista de Clientes
		</button>
	</div>
</div>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-8 col-md-push-2" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<div class="col-md-3">
				<h4>Cédula / R.U.C.:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="cedula" class="form-control" placeholder="Ingresar el Documento de Identidad" onchange="ValidarCedula(this.value,this)" onkeyup="cedularepetida(this.value,this)" onkeydown="justInt(event,this.value,this)" onkeyup="mayus(this.value,this)" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Nombre:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="nombre" class="form-control" placeholder="Ingresar el Nombre del Cliente" onkeydown="justText(event,this.value,this)" onkeyup="mayus(this.value,this)" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Apellido:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="apellido" class="form-control" placeholder="Ingresar el Apellido del Cliente" onkeydown="justText(event,this.value,this)" onkeyup="mayus(this.value,this)" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Email:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="mail" class="form-control" placeholder="example@dominio.com" onchange="validarMail(this.value,this)" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Dirección:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="direccion" class="form-control" placeholder="Ingresar la Dirección del Cliente" onkeyup="mayus(this.value,this)" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Teléfono:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="telefono" class="form-control" placeholder="022222222" maxlength="9" onkeydown="justInt(event,this.value,this)" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Celular:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="celular" class="form-control" placeholder="0999999999" maxlength="10" onkeydown="justInt(event,this.value,this)" />
			</div>
		</div>
		<div class="row" style="margin-top:20px;">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary pull-right" onclick="guardar()">Guardar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="cedularepetida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger" role="alert">
					<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;
					El número de documento de identificación ingresado ya existe.
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<script>
function lista(){
	window.location = '?modulo=listacliente';
}

function cedularepetida(value,t){
	$('.documentos').each(function(){
		var nueva = $(this).find('.cedula').val();
		if(value == nueva){
			$(t).val('');
			$('#cedularepetida').modal('show');
		}
	});
}

function guardar(){
	var cedula = $('#cedula').val();
	var nombre = $('#nombre').val();
	var apellido = $('#apellido').val();
	var email = $('#mail').val();
	var telefono = $('#telefono').val();
	var direccion = $('#direccion').val();
	var celular = $('#celular').val();
	
	if((cedula == '') || (nombre == '') || (apellido == '') || (direccion == '')){
		$('#blanco').modal('show');
	}else{
		$.post('subpages/clientes/ajax/guardarnuevo.php',{
			cedula : cedula, nombre : nombre, apellido : apellido, email : email, telefono : telefono, direccion : direccion, celular : celular
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>