<?php
    require_once("./clases/Producto.php");

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
    $origen = isset($_POST['origen']) ? $_POST['origen'] : NULL;

    $retornoJSON = new stdClass();

    if(isset($_POST['nombre']) && isset($_POST['origen'])){
        $producto = new Producto($nombre,$origen);

        $retornoJSON = json_decode(Producto::VerificarProductoJSON($producto));

        if($retornoJSON->existe == true)
        {
            $valorCookie = "{$producto->nombre}_{$producto->origen}";
            if(!isset($_COOKIE[$valorCookie]))
            {
                $fechaActual = date("Gis");
                setcookie($valorCookie, $fechaActual);
                $retornoJSON->exitoCokkie = true;
                $retornoJSON->mensajeCokkie = "cookie agregada con exito";
            }
        }
    }
    echo json_encode($retornoJSON) 
?>