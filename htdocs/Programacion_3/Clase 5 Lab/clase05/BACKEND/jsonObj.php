<?php
	header("charset: ISO-8859-1");
	/*
	echo '[{"nombre": "Susana","Edad":36,"Peso": null },
		  {"nombre": "Andrea","Edad":25,"Peso": 72 }] ';
	*/
	$personaArray = array();

	$persona = new stdClass();
	$persona->nombre = "Juan";
	$persona->edad = 66;

	$persona2 = new stdClass();
	$persona2->nombre = "Ramiro";
	$persona2->edad = 15;

	$personaArray[0] =  $persona;
	$personaArray[1] = $persona2;

	$objJson = json_encode($personaArray);

	var_dump($personaArray);

?>
<br/>
<a href="../Json/index.html"  class="btn btn-info">Volver</a>