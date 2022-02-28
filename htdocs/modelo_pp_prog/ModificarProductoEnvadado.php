<?php
    require_once("./clases/ProductoEnvasado.php");
    $producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : NULL;

    $obj = json_decode($producto_json);

    $new_producto = new ProductoEnvasado($obj->id,$obj->codigoBarra,$obj->precio,null,$obj->nombre,$obj->origen);

    $rta_json = new stdClass();
    $rta_json->exito = false;
    $rta_json->mensaje = "Error. No se pudo modificar el Producto";

    if($new_producto->Modificar())
    {
        $rta_json->exito = true;
        $rta_json->mensaje =  "El Producto ha sido modificado";
    }

    echo json_encode($rta_json);
?>