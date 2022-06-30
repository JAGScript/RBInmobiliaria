<?php 
	include('control/seguridad.php');
	
	$sql3 = "SELECT * FROM parroquia WHERE pq_estado = ?";
	$stmt3 = $gbd -> prepare($sql3);
	$stmt3 -> execute(array(1));
	$content_parroquia = '';
	while($row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC)){
		$content_parroquia .= '<option value="'.$row3['pq_id'].'">'.$row3['pq_nombre'].'</option>';
	}
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-8 col-md-push-2" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<div class="col-md-3">
				<h4>Parroquia:</h4>
			</div>
			<div class="col-md-9">
				<select class="form-control input-sm" id="parroquia">
					<option value="0">Seleccione...</option>
					<?php echo $content_parroquia; ?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Nombre:</h4>
			</div>
			<div class="col-md-9">
				<input type="text" id="nombre" class="form-control" placeholder="Nombre Barrio" />
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
								Nuevo Barrio\
								<button class="btn btn-success pull-right" type="button" onclick="volver()">\
									<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>\
									Volver\
								</button>\
							</h2>\
						</div>');
});

function volver(){
	window.location = '?modulo=listabarrio';
}

function guardar(){
	var parroquia = $('#parroquia').val();
	var nombre = $('#nombre').val();
	if(parroquia == 0 || nombre == ''){
		$('#blanco').modal('show');
	}else{
		$('#btnguardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/barrio/ajax/guardarnuevo.php',{
			parroquia : parroquia, nombre : nombre
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#guardado').modal('show');
			}
		});
	}
}
</script>