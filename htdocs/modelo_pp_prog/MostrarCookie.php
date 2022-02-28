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
            //echo json_encode($retornoJSONCookie);
        }
    }
    else
    {
        $retornoJSONCookie->exito = true;
        $retornoJSONCookie->mensaje = "No existe la cookie";
        //echo json_encode($retornoJSONCookie);
    }
    echo json_encode($retornoJSONCookie);

    /**
     * JHOSSY
     */

    /* $nombre = isset($_GET['nombre']) ? $_GET['nombre']: NULL;
    $origen = isset($_GET['origen']) ? $_GET['origen']: NULL;

    $retornoJSON = new stdClass();
    $retornoJSON->exito = false;
    $retornoJSON->mensaje = "ERROR";

    if(isset($_GET['nombre']) && isset($_GET['origen']) ){            
        if(isset($_COOKIE[$nombre]))
        {
            $retornoJSON->exito = true;
            $retornoJSON->mensaje = $_COOKIE[$nombre];
        }       
    }

    return json_encode($retornoJSON); */
?>