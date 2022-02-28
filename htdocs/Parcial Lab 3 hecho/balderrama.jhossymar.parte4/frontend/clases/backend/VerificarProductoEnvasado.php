<?php
    require_once("./clases/ProductoEnvasado.php");

    $obj_producto = isset($_POST["obj_producto"]) ? $_POST["obj_producto"] : NULL;

    $obj = json_decode($obj_producto);
    $producto = new ProductoEnvasado(0,0,0,null,$obj->nombre, $obj->origen); 
    
    $array = ProductoEnvasado::Traer();

    if($producto->Exite($array))
    {

        foreach ($array as $item) {
            if($item->nombre == $obj->nombre && $item->origen == $obj->origen)
            {
                $aux =  new ProductoEnvasado($item->id,$item->codigoBarra,$item->precio,$item->pathFoto,$item->nombre,$item->origen);
                
                break;
            }
        }
        echo $aux->ToJSON();
    } else
    {
        echo "{}";
    }

?>