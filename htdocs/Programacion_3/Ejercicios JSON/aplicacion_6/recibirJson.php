<?php
    $producto = new stdClass();
    $producto->codigoBarra = 1452445214552522454522;
    $producto->nombre = "Yerba";
    $producto->precio = "$120";

    $producto2 = new stdClass();
    $producto2->codigoBarra = 14524452144744521122;
    $producto2->nombre = "Dulce de Leche";
    $producto2->precio = "$140";

    $producto3 = new stdClass();
    $producto3->codigoBarra = 145244411446221122;
    $producto3->nombre = "Azucar";
    $producto3->precio = "$90";


    $personaArray[0] =  $producto;
	$personaArray[1] = $producto2;
    $personaArray[2] = $producto3;

	$objJson = json_encode($personaArray);

	var_dump($personaArray);
?>