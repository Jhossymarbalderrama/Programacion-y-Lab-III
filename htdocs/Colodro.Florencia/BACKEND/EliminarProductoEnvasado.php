<?php

require_once('./clases/ProductoEnvasado.php');
$producto_json = isset($_POST["producto_json"]) ? json_decode($_POST["producto_json"]) : NULL;
$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo eliminar de la base de datos";

    if(ProductoEnvasado::Eliminar($producto_json->id)){
        $retornoJson->exito = true;
        $retornoJson->mensaje = "Se elimino con exito de la base de datos";
        $producto = new ProductoEnvasado($producto_json->nombre, $producto_json->origen,$producto_json->id);
        if($producto->GuardarJSON('./archivos/productos_eliminados.json')){
            $retornoJson->mensaje .= " y se guardo en el archivo correspondiente";
        }
        else{
            $retornoJson->mensaje .= ", pero ocurrio un error al guardar en el archivo.";
        }
    }
    else{
        echo "No existe el id ingresado en la base de datos";
    }

echo json_encode($retornoJson);
?>