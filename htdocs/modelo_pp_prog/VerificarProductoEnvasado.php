<?php

    require_once("./clases/ProductoEnvasado.php");

    $obj_producto = isset($_POST["obj_producto"]) ? $_POST["obj_producto"] : NULL;

    $obj = json_decode($obj_producto);
    $producto = new ProductoEnvasado(0,0,0,null,$obj->nombre, $obj->origen);
    
    $array = ProductoEnvasado::Traer();

    if($producto->Exite($array))
    {
        echo $producto->ToJSON();
    } else
    {
        echo "{}";
    }

?>