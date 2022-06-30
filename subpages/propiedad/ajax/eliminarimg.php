<?php 
	$imgname = $_POST['imgname'];
	unlink('../fotos/'.$imgname);
	
	echo 'ok';
?>