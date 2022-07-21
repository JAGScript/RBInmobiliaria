<?php
	include('control/seguridad.php');
	require_once('ajax/zebrapag.php');

	$select = "SELECT 	*
				FROM 	notificacion
				WHERE 	no_asesor_id = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($_SESSION['id']));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	$total_clientes = $stmt -> rowCount();
	$resultados = 10;
	
	$paginacion = new Zebra_Pagination();
	$paginacion->records($total_clientes);
	$paginacion->records_per_page($resultados);
	
	$paginacion->padding(false);

	$sql2 = "SELECT * 
			FROM 	notificacion
			JOIN	persona ON no_persona_id = pe_id_usuario
			JOIN	propiedad ON no_propiedad_id = pr_id
			JOIN	tipo_propiedad ON pr_tipo_id = tp_id
			WHERE 	no_asesor_id = ? LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ', ' . $resultados;
	$stmt2 = $gbd -> prepare($sql2);
	$stmt2 -> execute(array($_SESSION['id']));

	$select3 = "SELECT 	*
				FROM 	notificacion
				WHERE 	no_estado = ?";
	$stmt3 = $gbd -> prepare($select3);
	$stmt3 -> execute(array(1));
	$row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC);
	$pendientes = $stmt3 -> rowCount();
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-10 col-md-push-1" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<h4 class="pull-right" style="background-color:#eea236;">Pendientes por revisar: <?php echo $pendientes; ?></h4>
		</div>
		<div class="row">
			<div class="table-responsive">
				<table class="table table-striped">
					<tr style="text-align:center;">
						<td>
							<h4>Cliente</h4>
						</td>
						<td>
							<h4>Teléfono</h4>
						</td>
						<td>
							<h4>Tipo</h4>
						</td>
						<td>
							<h4>Precio</h4>
						</td>
						<td>
							<h4>Detalle</h4>
						</td>
					</tr>
					<?php 
					while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
						if($row2['no_estado'] == 1){
							$color = '#eea236';
						}else{
							$color = '';
						}
					echo '
					<tr style="text-align:center; background-color:'.$color.';">
						<td>
							'.$row2['pe_nombre'].'
						</td>
						<td>
							'.$row2['pe_celular'].'
						</td>
						<td>
							'.$row2['tp_nombre'].'
						</td>
						<td>
							$'.number_format($row2['pr_precio'], 2).'
						</td>
						<td>
							<button class="btn btn-primary" type="button" onclick="propiedad('.$row2['pr_id'].','.$row2['no_id'].')">Detalle</button>
						</td>
					</tr>
					';
					}
					?>
					<tr>
						<td colspan="5" style="text-align:center;">
							<?php $paginacion->render(); ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#titulopag').html('<div class="col-md-11">\
							<h2>\
								<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;\
								Notificaciones\
								<button class="btn btn-success pull-right" type="button" onclick="volver()">\
									<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>\
									Volver\
								</button>\
							</h2>\
						</div>');
});

function volver(){
	window.location = '?modulo=start';
}

function propiedad(data, sms){
	window.location = '?modulo=verpropiedad&data='+data+'&sms='+sms;
}
</script>