<?php 
	include('control/seguridad.php');
	
	$id = $_GET['data'];
	
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
		
		$selected = '';
		
		if($row1['ba_id'] == $row['pr_barrio_id']){
			$selected = 'selected';
		}
		
		$content_barrio .= '<option value="'.$row1['ba_id'].'" '.$selected.'>'.$row1['ba_nombre'].'</option>';
	}
	
	$select2 = "SELECT * FROM tipo_propiedad WHERE tp_estado = 1";
	$stmt2 = $gbd -> prepare($select2);
	$stmt2 -> execute();
	$content_tipo = '';
	while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
		
		$selected = '';
		
		if($row2['tp_id'] == $row['pr_tipo_id']){
			$selected = 'selected';
		}
		
		$content_tipo .= '<option value="'.$row2['tp_id'].'" '.$selected.'>'.$row2['tp_nombre'].'</option>';
	}
	
	$select3 = "SELECT * FROM persona WHERE pe_tipo = 1 AND pe_estado = 1";
	$stmt3 = $gbd -> prepare($select3);
	$stmt3 -> execute();
	$content_persona = '';
	while($row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC)){
		
		$selected = '';
		
		if($row3['pe_id'] == $row['pr_propietario_id']){
			$selected = 'selected';
		}
		
		$content_persona .= '<option value="'.$row3['pe_id'].'" '.$selected.'>'.$row3['pe_nombre'].'</option>';
	}

	$select4 = "SELECT * FROM caracteristica WHERE ca_id = ?";
	$stmt4 = $gbd -> prepare($select4);
	$stmt4 -> execute(array($row['pr_caracteristica_id']));
	$row4 = $stmt4 -> fetch(PDO::FETCH_ASSOC);
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-8 col-md-push-2" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<div class="col-md-3">
				<h4>Propietario:</h4>
			</div>
			<div class="col-md-9">
				<input type="hidden" id="idProp" value="<?php echo $id; ?>" />
				<select class="form-control" id="propietario">
					<option value="0">Seleccione...</option>
					<?php echo $content_persona; ?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Tipo de Propiedad:</h4>
			</div>
			<div class="col-md-9">
				<select class="form-control" id="tipo">
					<option value="0">Seleccione...</option>
					<?php echo  $content_tipo; ?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Barrio:</h4>
			</div>
			<div class="col-md-9">
				<select class="form-control" id="barrio">
					<option value="0">Seleccione...</option>
					<?php $content_barrio; ?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Precio:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="precio" class="form-control" placeholder="$0.00" value="<?php echo $row['pr_precio'];?>" onkeydown="justDouble(event,this.value,this)" />
			</div>
		</div>
		<div class="row" style="padding:20px 0px;">
			<div class="col-md-3">
				<h4>Imagen Principal:</h4>
			</div>
			<div class="col-md-6">
				<div class="input-group">
					<input class="form-control" placeholder="Nombre de la Imagen" type="text" id="foto" value="<?php echo $row['pr_foto_principal'];?>" readonly="readonly" aria-describedby="basic-addon2">
					<span class="input-group-addon" id="basic-addon2">
						<div style="" id="upload">
							<img src="img/examina.png"  style="border:0; margin:-2px;" alt="">
						</div>
					</span>
				</div>
			</div>
			<div class="col-md-3">
				<div style="position:relative;" id="btnborrarimg">
					<img id="show_foto" style="width:150px" class="mapa" src="<?php echo "subpages/propiedad/fotos/". $row['pr_foto_principal'];?>" />
					<div style="position:absolute; top:0px; right:0;">
						<button type="button" class="btn btn-success" onclick="borrarimg()" title="Eliminar">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
					</div>
					<div class="imgeliminadas">
						
					</div>
				</div>
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
				<input type="text" id="metros" class="form-control" placeholder="M2" value="<?php echo number_format($row4['ca_metros'], 2); ?>" onkeydown="justDouble(event,this.value,this)"/>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Plantas:</h4>
			</div>
			<div class="col-md-9">
				<div class="input-group">
					<span class="input-group-addon" onclick="disminuirPlantas()">
						<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
					</span>
					<input type="text" id="plantas" class="form-control" placeholder="Número de plantas" readonly="readonly" value="<?php echo $row4['ca_plantas']; ?>" style="text-align:center;" />
					<span class="input-group-addon" onclick="aumentarPlantas()">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Baños:</h4>
			</div>
			<div class="col-md-9">
				<div class="input-group">
					<span class="input-group-addon" onclick="disminuirBanios()">
						<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
					</span>
					<input type="text" id="banios" class="form-control" placeholder="Número de baños" readonly="readonly" value="<?php echo $row4['ca_banios']; ?>" style="text-align:center;" />
					<span class="input-group-addon" onclick="aumentarBanios()">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Habitaciones:</h4>
			</div>
			<div class="col-md-9">
				<div class="input-group">
					<span class="input-group-addon" onclick="disminuirHabitacion()">
						<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
					</span>
					<input type="text" id="habitacion" class="form-control" placeholder="Número de habitaciones" readonly="readonly" value="<?php echo $row4['ca_habitaciones']; ?>" style="text-align:center;" />
					<span class="input-group-addon" onclick="aumentarHabitacion()">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Parqueaderos:</h4>
			</div>
			<div class="col-md-9">
				<div class="input-group">
					<span class="input-group-addon" onclick="disminuirParqueadero()">
						<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
					</span>
					<input type="text" id="parqueadero" class="form-control" placeholder="Número de parqueadero" readonly="readonly" value="<?php echo $row4['ca_parqueaderos']; ?>" style="text-align:center;" />
					<span class="input-group-addon" onclick="aumentarParqueadero()">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Servicios:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="servicios" class="form-control" value="<?php echo $row4['ca_servicios']; ?>" placeholder="Servicios básicos" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Otros:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="otros" class="form-control" value="<?php echo $row4['ca_otros']; ?>" placeholder="Otras caracteristicas adicionales" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Activo:</h4>
			</div>
			<div class="col-md-9">
				<?php if($row['pr_estado'] == 1){?>
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
				<button type="button" class="btn btn-primary " onclick="guardar(<?php echo $row['pr_caracteristica_id'];?>)" id="btnguardar">Guardar</button>				
				<img src="img/loading.gif" id="wait" style="display:none;"/>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#titulopag').html('<div class="col-md-11">\
							<h2>\
								<span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;\
								Editar Propiedad\
								<button class="btn btn-success pull-right" type="button" onclick="volver()">\
									<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>\
									Volver\
								</button>\
							</h2>\
						</div>');
});

function volver(){
	window.location = '?modulo=listapropiedad';
}

$(function(){
	var btnUpload=$('#upload');
	new AjaxUpload(btnUpload, {
		action: 'subpages/propiedad/ajax/procesa3.php',
		name: 'uploadfile',
		onSubmit: function(file, ext){
			 if (! (ext && /^(jpg|png|gif|bmp|jpeg|JPG|PNG|JPEG)$/.test(ext))){
				alert('Solo imagenes JPG,GIF,PNG,BMP,JPEG.');
				return false;
			}
		},
		onComplete: function(file, response){
			var mirsp = response;
			//reload ();
			document.getElementById('foto').value=mirsp;
			document.getElementById('show_foto').src='subpages/propiedad/fotos/'+mirsp;
			$('#btnborrarimg').fadeIn();
		}
	});
});

function borrarimg(){
	$('#btnborrarimg').fadeOut();
	var imgname = $('#foto').val();
	$('.imgeliminadas').append('<div class="eliminarimg"><input type="hidden" class="eliminadas" value="'+imgname+'" /><div>');
	$('#show_foto').prop('src','');
	$('#foto').val('');
	$.post('subpages/propiedad/ajax/eliminarimg.php',{
		imgname : imgname
	}).done(function(response){
		if($.trim(response) == 'ok'){
			alert('Imagen Eliminada');
		}
	});
}

function aumentarPlantas(){
	var valor = $('#plantas').val();
	valor = parseInt(valor) + parseInt(1);
	$('#plantas').val(valor);
}

function disminuirPlantas(){
	var valor = $('#plantas').val();
	if(valor == 0){
		$('#plantas').val(0);
	}else{
		valor = parseInt(valor) - parseInt(1);
		$('#plantas').val(valor);
	}
}

function aumentarBanios(){
	var valor = $('#banios').val();
	valor = parseInt(valor) + parseInt(1);
	$('#banios').val(valor);
}

function disminuirBanios(){
	var valor = $('#banios').val();
	if(valor == 0){
		$('#banios').val(0);
	}else{
		valor = parseInt(valor) - parseInt(1);
		$('#banios').val(valor);
	}
}

function aumentarHabitacion(){
	var valor = $('#habitacion').val();
	valor = parseInt(valor) + parseInt(1);
	$('#habitacion').val(valor);
}

function disminuirHabitacion(){
	var valor = $('#habitacion').val();
	if(valor == 0){
		$('#habitacion').val(0);
	}else{
		valor = parseInt(valor) - parseInt(1);
		$('#habitacion').val(valor);
	}
}

function aumentarParqueadero(){
	var valor = $('#parqueadero').val();
	valor = parseInt(valor) + parseInt(1);
	$('#parqueadero').val(valor);
}

function disminuirParqueadero(){
	var valor = $('#parqueadero').val();
	if(valor == 0){
		$('#parqueadero').val(0);
	}else{
		valor = parseInt(valor) - parseInt(1);
		$('#parqueadero').val(valor);
	}
}

function guardar(data){
	var idPropiedad = $('#idProp').val();
	var propietario = $('#propietario').val();
	var tipo = $('#tipo').val();
	var barrio = $('#barrio').val();
	var precio = $('#precio').val();
	var foto = $('#foto').val();
	var metros = $('#metros').val();
	var plantas = $('#plantas').val();
	var banios = $('#banios').val();
	var habitacion = $('#habitacion').val();
	var parqueadero = $('#parqueadero').val();
	var servicios = $('#servicios').val();
	var otros = $('#otros').val();
	if($('.glyphicon-check').length){
		var activo = 1;
	}else{
		var activo = 0;
	}
	
	if((propietario == 0) || (tipo == 0) || (barrio == 0) || (precio == '') || (foto == '')){
		$('#blanco').modal('show');
	}else{
		$('#btnguardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/propiedad/ajax/guardareditar.php',{
			idPropiedad : idPropiedad, propietario : propietario, tipo : tipo, barrio : barrio, precio : precio, foto : foto, metros : metros,
			plantas : plantas, banios : banios, habitacion : habitacion, parqueadero : parqueadero, servicios : servicios, otros : otros, 
			activo : activo, data : data
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>