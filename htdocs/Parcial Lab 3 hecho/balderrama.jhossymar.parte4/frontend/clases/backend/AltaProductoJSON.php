<?php
    require_once("./clases/Producto.php");

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
    $origen = isset($_POST['origen']) ? $_POST['origen'] : NULL;

    if($nombre != "" && $origen != ""){
        $producto = new Producto($nombre,$origen);

        $rta = $producto->GuardarJSON('./archivos/productos.json');
        echo $rta;
    }
    
?>