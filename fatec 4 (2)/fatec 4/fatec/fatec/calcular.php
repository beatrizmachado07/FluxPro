<?php

    $data=$_REQUEST;

    extract($data);
	$base 	= $base;
    $alt 	= $altura;

	$resultado = $base * $altura / 2;
	
	echo json_encode($resultado);
?>