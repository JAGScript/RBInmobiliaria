<?php
	include('control/seguridad.php');
	require_once('ajax/zebrapag.php');
	
	$sql1 = "SELECT * FROM usuario";
	$stmt1 = $gbd -> prepare($sql1);
	$stmt1 -> execute();
	$total_clientes = $stmt1 -> rowCount();
	$resultados = 20;
	
	$paginacion = new Zebra_Pagination();
	$paginacion->records($total_clientes);
	$paginacion->records_per_page($resultados);
	
	$paginacion->padding(false);

	$sql2 = "SELECT us_id, 
					us_nombre, 
					us_identificacion, 
					us_correo, 
					us_login, 
					us_estado, 
					ro_nombre
			FROM 	usuario
			JOIN 	rol ON us_rol_id = ro_id LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ', ' . $resultados;
	$stmt2 = $gbd -> prepare($sql2);
	$stmt2 -> execute();
?>
<div class="row" style="margin:25px 0px 75px 0px;">
	<div class="col-md-10 col-md-push-1" style="border:2px solid #ccc; border-radius:10px; padding:20px;">
		<div class="row">
			<div class="table-responsive">
				<table class="table table-striped">
					<tr style="text-align:center;">
						<td>
							<h4>Nombre</h4>
						</td>
						<td>
							<h4>Identificación</h4>
						</td>
						<td>
							<h4>Login</h4>
						</td>
						<td>
							<h4>Email</h4>
						</td>
						<td>
							<h4>Perfil</h4>
						</td>
						<td>
							<h4>Activo</h4>
						</td>
						<td>
							<h4>Editar</h4>
						</td>
					</tr>
					<?php 
					while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
						if($row2['us_estado'] == 1){
							$activo = '<span class="glyphicon glyphicon-check" aria-hidden="true"></span>';
						}else{
							$activo = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
						}
					echo '
					<tr>
						<td>
							'.$row2['us_nombre'].'
						</td>
						<td>
							'.$row2['us_identificacion'].'
						</td>
						<td>
							'.$row2['us_correo'].'
						</td>
						<td>
							'.$row2['us_login'].'
						</td>
						<td>
							'.$row2['ro_nombre'].'
						</td>
						<td style="text-align:center;">
							'.$activo.'
						</td>
						<td>
							<button class="btn btn-primary" type="button" onclick="editar('.$row2['us_id'].')">Editar</button>
						</td>
					</tr>
					';
					}
					?>
					<tr>
						<td colspan="8" style="text-align:center;">
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
								<span class="glyphicon glyphicon-list" aria-hidden="true"></span>&nbsp;\
								Lista de Usuarios\
								<button class="btn btn-success pull-right" type="button" onclick="nuevo()">Nuevo Usuario</button>\
							</h2>\
						</div>');
});

function nuevo(){
	window.location = '?modulo=nuevousuario';
}

function editar(data){
	window.location = '?modulo=editarusuario&data='+data;
}
</script>