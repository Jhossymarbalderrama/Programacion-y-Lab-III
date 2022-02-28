<?php
require_once('./clases/ProductoEnvasado.php');
//mandar con nombre y origen
$obj_json = isset($_POST["obj_producto"]) ? json_decode($_POST["obj_producto"]) : NULL;

$retorno = '{}';

$listado = ProductoEnvasado::Traer();
if($listado !== null && count($listado) !== 0){
    if($obj_json !== null){
        $productoAux = new ProductoEnvasado($obj_json->nombre, $obj_json->origen);
        foreach($listado as $item){
            if($item->nombre == $obj_json->nombre && $item->origen == $obj_json->origen){
                $retorno = $item->ToJSON();
                break;
            }
        }
    }
    echo $retorno;
}
else{
    echo "El listado esta vacio";
}

?>