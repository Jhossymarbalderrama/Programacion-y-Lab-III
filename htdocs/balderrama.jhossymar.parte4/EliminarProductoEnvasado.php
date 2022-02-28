<?php
    require_once("./clases/Producto.php");
    require_once("./clases/ProductoEnvasado.php");

    $producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : NULL;
    
    $obj_producto = json_decode($producto_json);

    $rta_json = new stdClass();
    $rta_json->exito = false;
    $rta_json->mensaje = "Error. No se pudo Eliminar el Producto";

    $path = './archivos/productos_eliminados.json';

    if(ProductoEnvasado::Eliminar($obj_producto->id))
    {
        $new_producto = new Producto($obj_producto->nombre,$obj_producto->origen);
        $new_producto->GuardarJSON($path);
        $rta_json->exito = true;
        $rta_json->mensaje = "El Producto se Elimino";
    }

    echo json_encode($rta_json);
?>