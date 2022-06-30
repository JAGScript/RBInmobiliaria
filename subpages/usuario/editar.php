<?php 
	include('control/seguridad.php');
	
	$id = $_GET['data'];
	
	$select = "SELECT 	us_id, 
						us_nombre, 
						us_identificacion, 
						us_correo, 
						us_login, 
						us_estado, 
						ro_nombre
				FROM 	usuario
				JOIN 	rol ON us_rol_id = ro_id 
				WHERE 	us_id = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($id));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	$sql2 = "SELECT * FROM rol WHERE ro_estado = ?";
	$stmt2 = $gbd -> prepare($sql2);
	$stmt2 -> execute(array(1));
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-8 col-md-push-2" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<div class="col-md-3">
				<h4>Nombre:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="nombre" class="form-control" placeholder="Ingresar el Nombre del Usuario" value="<?php echo $row['us_nombre'];?>" />
				<input type="hidden" value="<?php echo $id;?>" id="id" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Identifiación:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="identificacion" class="form-control" placeholder="Ingresar la identificación del Usuario" value="<?php echo $row['us_identificacion'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Email:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="mail" class="form-control" placeholder="Ingresar el Email del Usuario"  value="<?php echo $row['us_correo'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Login:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="login" class="form-control" placeholder="Ingresar Login del Usuario" value="<?php echo $row['us_login'];?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Perfil:</h4>
			</div>
			<div class="col-md-9">
				<select class="form-control" id="perfil">
				<?php 
				while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
					$selected = "";
					if($row2['ro_id'] == $row['us_rol_id']){
						$selected = "selected";
					}
					echo '<option value="'.$row2['ro_id'].'">'.$row2['ro_nombre'].'</option> ';
				}
				?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Activo:</h4>
			</div>
			<div class="col-md-9">
				<?php if($row['us_estado'] == 1){?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['us_estado'];?>')">
					<span class="glyphicon glyphicon-check" id="tipoactivo" aria-hidden="true"></span>
				</button>
				<?php }else{?>
				<button type="button" class="btn btn-default" onclick="activacion('<?php echo $row['us_estado'];?>')">
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
								<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;\
								Editar Usuario\
								<button class="btn btn-success pull-right" type="button" onclick="volver()">\
									<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>\
									Volver\
								</button>\
							</h2>\
						</div>');
});

function volver(){
	window.location = '?modulo=listausuario';
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
	var nombre = $('#nombre').val();
	var identificacion = $('#identificacion').val();
	var email = $('#mail').val();
	var login = $('#login').val();
	var perfil = $('#perfil').val();
	if($('.glyphicon-check').length){
		var activo = 1;
	}else{
		var activo = 0;
	}
	if((nombre == '') || (identificacion == '') || (login == '') || (perfil == 0)){
		$('#blanco').modal('show');
	}else{
		$('#btnguardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/usuario/ajax/guardareditar.php',{
			id : id, nombre : nombre, identificacion : identificacion, email : email, login : login, perfil : perfil, activo : activo
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>