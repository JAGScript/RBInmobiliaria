<?php 
	include('control/seguridad.php');
	
	$select1 = "SELECT * FROM cliente";
	$stmt1 = $gbd -> prepare($select1);
	$stmt1 -> execute();
	
	$content = '<div style="display:none;">';
	while($row1 = $stmt1 -> fetch(PDO::FETCH_ASSOC)){
		$content .= '
		<div class="documentos"><input type="hidden" class="cedula" value="'.$row1['cedula'].'" /></div>
		';
	}
	$content .= '</div>';
	
	echo $content;
	
	$id = $_GET['data'];
	
	$select = "SELECT * FROM cliente WHERE id = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($id));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
?>
<div class="row">
	<div class="col-md-9" style="padding-left:10px; ppading-bottom:15px;">
		<h3>
			<span style="border-bottom:5px solid #5bc0de;">
				<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;
				Editar Cliente
			</span>
		</h3>
	</div>
	<div class="col-md-2">
		<button class="btn btn-success pull-right" type="button" onclick="volver()">
			<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
			Volver
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
				<input type="text" id="cedula" class="form-control" placeholder="Ingresar el Documento de Identidad" onchange="ValidarCedula(this.value,this)" onkeyup="cedularepetida(this.value,this)" onkeydown="justInt(event,this.value,this)" value="<?php echo $row['cedula'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Nombre:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="nombre" class="form-control" placeholder="Ingresar el Nombre del Cliente" onkeydown="justText(event,this.value,this)" value="<?php echo $row['nombre'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Apellido:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="apellido" class="form-control" placeholder="Ingresar el Apellido del Cliente" onkeydown="justText(event,this.value,this)" value="<?php echo $row['apellido'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Email:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="mail" class="form-control" placeholder="example@dominio.com" onchange="validarMail(this.value,this)" value="<?php echo $row['email'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Dirección:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="direccion" class="form-control" placeholder="Ingresar la Dirección del Cliente" value="<?php echo $row['direccion'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Teléfono:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="telefono" class="form-control" placeholder="022222222" maxlength="9" onkeydown="justInt(event,this.value,this)" value="<?php echo $row['telefono'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Celular:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="celular" class="form-control" placeholder="0999999999" maxlength="10" onkeydown="justInt(event,this.value,this)" value="<?php echo $row['celular'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Activo:</h4>
			</div>
			<div class="col-md-9">
				<?php if($row['activo'] == 1){?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['activo'];?>')">
					<span class="glyphicon glyphicon-check" id="tipoactivo" aria-hidden="true"></span>
				</button>
				<?php }else{?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['activo'];?>')">
					<span class="glyphicon glyphicon-unchecked" id="tipoactivo" aria-hidden="true"></span>
				</button>
				<?php }?>
			</div>
		</div>
		<div class="row" style="margin-top:20px;">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary pull-right" onclick="guardar(<?php echo $id;?>)">Guardar</button>
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
function volver(){
	window.location = '?modulo=listacliente';
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

function cedularepetida(value,t){
	$('.documentos').each(function(){
		var nueva = $(this).find('.cedula').val();
		if(value == nueva){
			$(t).val('');
			$('#cedularepetida').modal('show');
		}
	});
}

function guardar(data){
	var cedula = $('#cedula').val();
	var nombre = $('#nombre').val();
	var apellido = $('#apellido').val();
	var email = $('#mail').val();
	var telefono = $('#telefono').val();
	var direccion = $('#direccion').val();
	var celular = $('#celular').val();
	if($('.glyphicon-check').length){
		var activo = 1;
	}else{
		var activo = 0;
	}
	
	if((cedula == '') || (nombre == '') || (apellido == '') || (direccion == '')){
		$('#blanco').modal('show');
	}else{
		$.post('subpages/clientes/ajax/guardareditar.php',{
			cedula : cedula, nombre : nombre, apellido : apellido, email : email, telefono : telefono, direccion : direccion, celular : celular, data : data, activo : activo
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>