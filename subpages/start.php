<?php 
	include('control/seguridad.php');

	$select = "SELECT 	*
				FROM 	notificacion
				WHERE 	no_estado = ?
				AND		no_asesor_id = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array(1, $_SESSION['id']));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

	$mensajes = $stmt -> rowCount();
?>
<div class="row">
	<div class="col-md-10" style="border:0px solid #000; padding-left:10px;">
		<h4>
			<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>&nbsp;
			Inicio
		</h4>
	</div>
	<div class="col-md-1">
		<button class="btn btn-primary" type="button" onclick="abrir()">
			Notificaciones <span class="badge"><?php echo $mensajes; ?></span>
		</button>
	</div>
</div>
<div class="row" style="padding-left:10px; padding-top:15px;">
	<h1>Bienvenido! <?php echo $_SESSION['nombre'];?></h1>
	<p>Sistema administrativo para la empresa Inmobiliaria RB.</p>
</div>
<script>
	function abrir(){
		window.location = '?modulo=listanotificacion';
	}
</script>