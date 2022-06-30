<?php 
	include('control/seguridad.php');
	
	$id = $_GET['data'];
	
	$select = "SELECT * FROM imagen WHERE im_propiedad_id = ? AND im_estado = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($id,1));
	$content = '';
	
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
		$content .= '
			<div class="col-xs-6 col-md-3">
				<a class="thumbnail" style="height:200px !important; overflow:hidden;">
					<button type="button" class="btn btn-danger" style="position:absolute; right:20px;" onclick="deleteimg('.$row['im_id'].')">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
					<img src="subpages/propiedad/fotos/'.$row['im_nombre'].'" style="cursor:pointer;" onclick="viewfoto('.$row['im_id'].')">
				</a>
			</div>
		';
	}
?>
<div class="row" style="margin:50px 0px;">		
	<div class="col-md-6 col-md-push-3">
		<div class="row">
			<form name="form1" id="form1" method="post" action="subpages/propiedad/ajax/subiralbum.php" enctype="multipart/form-data">
				<h4 class="text-center">Seleccionar fotos</h4>
				
				<div class="form-group">
					<div class="col-sm-10">
						<input type="file" class="form-control" id="archivo[]" name="archivo[]" multiple="">
						<input type="hidden" id="data" name="data" value="<?php echo $id; ?>">
					</div>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
						Cargar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="row" id="imagenes_content">
	<?php echo $content; ?>
</div>
<div class="modal fade bs-example-modal-lg" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"></h4>
			</div>
			<div class="modal-body" style="text-align:center;">
				<img id="foto_show" style="width:100%;"/>
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
								<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>&nbsp;\
								Albúm de Fotos\
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

function deleteimg(data){
	var propiedad = $('#data').val();
	$.post('subpages/propiedad/ajax/deletefoto.php',{
		data : data, propiedad : propiedad
	}).done(function(response){
		$('#imagenes_content').html(response);
	});
}

function viewfoto(data){
	$.post('subpages/propiedad/ajax/viewfoto.php',{
		data : data
	}).done(function(response){
		$('#foto_show').prop('src','subpages/propiedad/fotos/'+response);
		$('#show').modal('show');
	});
}
</script>