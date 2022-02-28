<?php
    include_once("./clases/Producto.php");

    $nombre = isset($_GET["nombre"]) ? $_GET["nombre"] : NULL;
    $origen = isset($_GET["origen"]) ? $_GET["origen"] : NULL;

    $producto = new Producto($nombre, $origen);
    $retornoJSON = json_decode(Producto::VerificarProductoJSON($producto));
    $retornoJSONCookie = new stdClass();

    if($retornoJSON->existe == true)
    {
        $valorCookie = "{$producto->nombre}_{$producto->origen}";
        if(isset($_COOKIE[$valorCookie]))
        {
            $retornoJSONCookie->exito = true;
            $retornoJSONCookie->mensaje = $_COOKIE[$valorCookie];
        }
    }
    else
    {
        $retornoJSONCookie->exito = true;
        $retornoJSONCookie->mensaje = "No existe la COOKIE";
    }
    echo json_encode($retornoJSONCookie);
?>