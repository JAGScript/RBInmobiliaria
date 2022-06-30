<?php
	$jag=time();
	$uploaddir = '../fotos/';
	$uploadfile = $uploaddir.$jag;
	$uploadfile2 = $jag.basename($_FILES['uploadfile']['name']);
	$uploadfile = $uploaddir.$uploadfile2;
	
	// Lo mueve a la carpeta elegida
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
		echo $uploadfile2;
	} else {
		echo "no se pudo subir";
	}
?>
