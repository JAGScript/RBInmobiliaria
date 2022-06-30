<?php
	include('control/seguridad.php');
	require_once('ajax/zebrapag.php');
	
	$sql1 = "SELECT * FROM cliente";
	$stmt1 = $gbd -> prepare($sql1);
	$stmt1 -> execute();
	$total_clientes = $stmt1 -> rowCount();
	$resultados = 20;
	
	$paginacion = new Zebra_Pagination();
	$paginacion->records($total_clientes);
	$paginacion->records_per_page($resultados);
	
	$paginacion->padding(false);

	$sql2 = "SELECT * FROM cliente LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ', ' . $resultados;
	$stmt2 = $gbd -> prepare($sql2);
	$stmt2 -> execute();
?>
<div class="row">
	<div class="col-md-9" style="padding-left:10px; ppading-bottom:15px;">
		<h3>
			<span style="border-bottom:5px solid #5bc0de;">
				<span class="glyphicon glyphicon-list" aria-hidden="true"></span>&nbsp;
				Lista de Clientes
			</span>
		</h3>
	</div>
	<div class="col-md-2">
		<button class="btn btn-success pull-right" type="button" onclick="nuevo()">
			<span class="glyphicon glyphicon-copy" aria-hidden="true"></span>
			Nuevo Cliente
		</button>
	</div>
</div>
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
							<h4>Cédula</h4>
						</td>
						<td>
							<h4>Email</h4>
						</td>
						<td>
							<h4>Dirección</h4>
						</td>
						<td>
							<h4>Teléfono</h4>
						</td>
						<td>
							<h4>Celular</h4>
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
						if($row2['activo'] == 1){
							$activo = '<span class="glyphicon glyphicon-check" aria-hidden="true"></span>';
						}else{
							$activo = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
						}
					echo '
					<tr>
						<td>
							'.$row2['nombre'].' '.$row2['apellido'].'
						</td>
						<td>
							'.$row2['cedula'].'
						</td>
						<td>
							'.$row2['email'].'
						</td>
						<td>
							'.$row2['direccion'].'
						</td>
						<td>
							'.$row2['telefono'].'
						</td>
						<td>
							'.$row2['celular'].'
						</td>
						<td style="text-align:center;">
							'.$activo.'
						</td>
						<td>
							<button class="btn btn-primary" type="button" onclick="editar('.$row2['id'].')">Editar</button>
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
function nuevo(){
	window.location = '?modulo=cliente';
}

function editar(data){
	window.location = '?modulo=editarcliente&data='+data;
}
</script>