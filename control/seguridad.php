<?php 
	@session_start();
	if($_SESSION["auth"] != md5('M45T3R')){
		echo "
			<script>
				alert('Debes iniciar sesion para acceder');
				window.location.href = '?modulo=login';
			</script>
		";
		exit();
	}
?>