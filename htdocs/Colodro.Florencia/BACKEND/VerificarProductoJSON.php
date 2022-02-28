<?php
require_once('clases/Producto.php');

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
$origen = isset($_POST['origen']) ? $_POST['origen'] : NULL;

$retornoJSON = new stdClass();

   if(isset($_POST['nombre']) && isset($_POST['origen']))
   {

       $producto = new Producto($nombre,$origen);
       $retornoJSON = json_decode(Producto::VerificarProductoJSON($producto));

       if($retornoJSON->exito == true)
       {
           $valor = $nombre."_".$origen;
           
           if(!isset($_COOKIE[$valor]))
           {
               $fecha = date("Y-m-d-H-i-s");
               setcookie($valor, $fecha);
               //echo ($valor);
               $retornoJSON->exito = true;
               $retornoJSON->mensaje = "cookie agregada";
           }else{
               $retornoJSON->exito = false;
               $retornoJSON->mensaje = "cookie no fue agregada";
           }
       }
   }
echo json_encode($retornoJSON);


// require_once('./clases/Producto.php');

// $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
// $origen = isset($_POST['origen']) ? $_POST['origen'] : NULL;

// $retornoJSON = new stdClass();
// $retornoJSON->exito = false;
// $retornoJSON->mensaje = "cookie no fue agregada";

//    if(isset($_POST['nombre']) && isset($_POST['origen']))
//    {
//        $producto = new Producto($nombre,$origen);
//        $retornoJSON = json_decode(Producto::VerificarProductoJSON($producto));

//        if($retornoJSON->exito == true)
//        {
//            $valor = $nombre."_".$origen;
           
//                $fecha = date("Y-m-d-H-i-s");
//                setcookie($valor, $fecha);
//                echo ($valor);
//                $retornoJSON->exito = true;
//                $retornoJSON->mensaje = "cookie agregada";
//        }
//    }
// echo json_encode($retornoJSON);
?>