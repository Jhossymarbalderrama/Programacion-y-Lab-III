<?php
require_once('./clases/ProductoEnvasado.php');

$producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : NULL;


if($producto_json !=NULL)
{
    $retornoJson = new stdClass();
    $retornoJson->exito = false;
    $retornoJson->mensaje = "No se pudo modificar en la base de datos";
    $objDeco = json_decode($producto_json);
   
    //var_dump($objDeco);
    $arrayProductos = ProductoEnvasado ::Traer();

    foreach($arrayProductos as $productoE)
    {
        if($productoE->id == $objDeco->id)
        {
            //mantiene el id original
            $productoMod = new ProductoEnvasado($objDeco->nombre,
                                                 $objDeco->origen,
                                                 $productoE->id,
                                                  $objDeco->codigoBarra,
                                                  $objDeco->precio);
            if($productoMod->Modificar()){
                
                $retornoJson->exito = true;
                $retornoJson->mensaje = "Se ha modificado en la base de datos";
            }
        }
    }
}
echo json_encode($retornoJson);

?>