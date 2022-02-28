<?php

    /* AgregarProductoSinFoto.php:
     Se recibe por POST el parámetro producto_json (codigoBarra, nombre, origen y precio), en formato de cadena JSON.
     Se invocará al método Agregar. 
    Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido */
    require_once("./clases/AccesoDatos.php");
    require_once("./clases/ProductoEnvasado.php");

    $producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : NULL;

    $obj_json = json_decode($producto_json);

    $new_producto = new ProductoEnvasado(0,$obj_json->codigoBarra,$obj_json->precio,null,$obj_json->nombre,$obj_json->origen);

    $rta_JSON = new stdClass();
    $rta_JSON->exito = false;
    $rta_JSON->mensaje = "Error. Al agregar un Nuevo ProductoEnvasado";

    if($new_producto->Agregar())
    {
        $rta_JSON->exito = true;
        $rta_JSON->mensaje = "Se Agrego el Nuevo ProductoEnvasado";
    }

    echo json_encode($rta_JSON);
?>