<?php

require_once('./clases/Producto.php');
$origen =isset( $_GET["origen"]) ? $_GET["origen"] : NULL;
$nombre =isset( $_GET["nombre"]) ? $_GET["nombre"] : NULL;

if($nombre != null and $origen != null)
{
    $retornoJSON = new stdClass();
    $producto = new Producto($nombre,$origen);
    $retornoJ = json_decode(Producto::VerificarProductoJSON($producto));
    if($retornoJ->exito == true)
    {
        $cookie = "$producto->nombre"."_"."$producto->origen";
        if(isset($_COOKIE[$cookie]))
        {
            $retornoJSON->exito = true;
            $retornoJSON->mensaje = "Existe la cookie".$_COOKIE[$cookie];
        }
    }else{
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "No existe cookie.";
        //var_dump(json_encode($retornoJSON));
    }
    echo json_encode($retornoJSON);
}



?>