<?php
	include('control/seguridad.php');
	require_once('ajax/zebrapag.php');
	
	$sql1 = "SELECT * FROM propiedad";
	$stmt1 = $gbd -> prepare($sql1);
	$stmt1 -> execute();
	$total_clientes = $stmt1 -> rowCount();
	$resultados = 20;
	
	$paginacion = new Zebra_Pagination();
	$paginacion->records($total_clientes);
	$paginacion->records_per_page($resultados);
	
	$paginacion->padding(false);

	$sql2 = "SELECT *
			FROM 	propiedad
			JOIN 	persona ON pr_propietario_id = pe_id AND pe_tipo = 1 
			JOIN	barrio ON pr_barrio_id = ba_id LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ', ' . $resultados;
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
							<h4>Propietario</h4>
						</td>
						<td>
							<h4>Barrio</h4>
						</td>
						<td>
							<h4>Precio</h4>
						</td>
						<td>
							<h4>Foto</h4>
						</td>
						<td>
							<h4>Activo</h4>
						</td>
						<td>
							<h4>Editar</h4>
						</td>
						<td>
							<h4>Albúm</h4>
						</td>
					</tr>
					<?php 
					while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
						if($row2['pr_estado'] == 1){
							$activo = '<span class="glyphicon glyphicon-check" aria-hidden="true"></span>';
						}else{
							$activo = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
						}
		
						if($row2['pr_foto_principal'] == ''){
							$foto = 'user.png';
						}else{
							$foto = $row2['pr_foto_principal'];
						}
						
						$precio = number_format($row2['pr_precio'],2);
					echo '
					<tr style="text-align:center;">
						<td>
							'.$row2['pe_nombre'].'
						</td>
						<td>
							'.$row2['ba_nombre'].'
						</td>
						<td>
							$'.$precio.'
						</td>
						<td>
							<img src="subpages/propiedad/fotos/'.$foto.'" style="width:100px; cursor:pointer;" onclick="abrirImagen('.$row2['pr_id'].')"/></br>
							<input type="hidden" id="img'.$row2['pr_id'].'" value="'.$foto.'" />
						</td>
						<td>
							'.$activo.'
						</td>
						<td>
							<button class="btn btn-primary" type="button" onclick="editar('.$row2['pr_id'].')">Editar</button>
						</td>
						<td>
							<button class="btn btn-warning" type="button" onclick="album('.$row2['pr_id'].')">Albúm</button>
						</td>
					</tr>
					';
					}
					?>
					<tr>
						<td colspan="7" style="text-align:center;">
							<?php $paginacion->render(); ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bs-example-modal-lg" id="imgLarge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12" style="text-align:center;">
						<img id="imgGrande" style="width:100%;"/>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cerrar
				</button>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#titulopag').html('<div class="col-md-11">\
							<h2>\
								<span class="glyphicon glyphicon-list" aria-hidden="true"></span>&nbsp;\
								Lista de Propiedades\
								<button class="btn btn-success pull-right" type="button" onclick="nuevo()">Nueva</button>\
							</h2>\
						</div>');
});

function abrirImagen(data){
	var foto = $('#img'+data).val();
	$('#imgGrande').prop('src','subpages/propiedad/fotos/'+foto);
	$('#imgLarge').modal('show');
}

function nuevo(){
	window.location = '?modulo=nuevopropiedad';
}

function editar(data){
	window.location = '?modulo=editarpropiedad&data='+data;
}

function album(data){
	window.location = '?modulo=addFotos&data='+data;
}
</script>