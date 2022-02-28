<?php

require_once('./clases/ProductoEnvasado.php');

$producto_json = isset($_POST["producto_json"]) ? json_decode($_POST["producto_json"]) : null;

$producto = new ProductoEnvasado($producto_json->nombre, $producto_json->origen, null, $producto_json->codigoBarra, $producto_json->precio, null);

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo agregar  a la bd";

if($producto->Agregar()){
    $retornoJson->exito = true;
    $retornoJson->mensaje = "Se agrego con exito a la bd";
}

echo json_encode($retornoJson);
?>