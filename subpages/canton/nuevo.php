<?php 
	include('control/seguridad.php');
	
	$sql3 = "SELECT * FROM provincia WHERE pv_estado = ?";
	$stmt3 = $gbd -> prepare($sql3);
	$stmt3 -> execute(array(1));
	$content_provincia = '';
	while($row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC)){
		$content_provincia .= '<option value="'.$row3['pv_id'].'">'.$row3['pv_nombre'].'</option>';
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
				<input type="text" id="codigo" class="form-control" placeholder="Código Cantón" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Nombre:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="nombre" class="form-control" placeholder="Nombre Cantón" />
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
	$('#titulopag').html('<div class="col-md-12">\
							<h2>\
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;\
								Nuevo Cantón\
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

function guardar(){
	var provincia = $('#provincia').val();
	var codigo = $('#codigo').val();
	var nombre = $('#nombre').val();
	if(provincia == 0 || nombre == '' || codigo == ''){
		$('#blanco').modal('show');
	}else{
		$('#btnguardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/canton/ajax/guardarnuevo.php',{
			provincia : provincia, nombre : nombre, codigo : codigo
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>