<?php

$producto = new stdClass();

$producto->codigoBarra = 1452445214552522454522;
$producto->nombre = "Yerba";
$producto->precio = "$120";

$objJson = json_encode($producto);

echo $objJson;

?>