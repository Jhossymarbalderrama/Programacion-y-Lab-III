<?php

// Se recibirán por POST los siguientes valores: producto_json (id,
// codigoBarra, nombre, origen y precio, en formato de cadena JSON) y la foto (para modificar un producto
// envasado en la base de datos. Invocar al método Modificar.
// Nota: El valor del id, será el id del producto envasado 'original', mientras que el resto de los valores serán los del
// producto envasado a ser modificado.
// Si se pudo modificar en la base de datos, la foto original del registro modificado se moverá al subdirectorio
// “./productosModificados/”, con el nombre formado por el nombre punto origen punto 'modificado' punto hora,
// minutos y segundos de la modificación (Ejemplo: aceite.italia.modificado.105905.jpg).
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
require_once('./clases/ProductoEnvasado.php');

$producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : NULL;
$foto = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo modificar en la base de datos";


if($producto_json != NULL && $foto != NULL)
{
    $pDecodificado = json_decode($producto_json);
    $productos = ProductoEnvasado::Traer();
    $productoAModificar=NULL;
    $fotoOriginalBD =NULL;
    $extensionNueva = pathinfo($foto['name'],PATHINFO_EXTENSION);//FOTO POST
    foreach($productos as $productitoBD)
    {
        if($productitoBD->id == $pDecodificado->id)
        {
            $fotoOriginalBD = $productitoBD->pathFoto;//FOTO ORIGINAL
            $fotoNueva = "$pDecodificado->nombre."."$pDecodificado->origen.".date('Gis').".$extensionNueva";
            //Se instancia el obj a modificar, el id sera de la bd y los demas va a ser los del producto a modificar los del json
            $productoAModificar = new ProductoEnvasado($pDecodificado->nombre, $pDecodificado->origen, $productitoBD->id, $pDecodificado->codigoBarra, $pDecodificado->precio,$fotoNueva);
            break;
        }
    }

    if($productoAModificar!= NULL)
    {
        //Si lo encuentro lo modifico.
        if($productoAModificar->Modificar())
        {
            if($fotoOriginalBD != NULL)
            {
                $extensionOriginal = pathinfo($fotoOriginalBD,PATHINFO_EXTENSION);
                $fotoModificada= "$pDecodificado->nombre.$pDecodificado->origen.modificado".".".date('Gis').".$extensionOriginal";
                //Copio de productos/imagenes a productos modificados y elimino la foto de productos/imagenes
                copy("./productos/imagenes/".$fotoOriginalBD,"./productosModificados/$fotoModificada");
                unlink("./productos/imagenes/$fotoOriginalBD");
    
            }
           //Mover
           move_uploaded_file($foto["tmp_name"],"./productos/imagenes/$fotoNueva");//mueve del directorio temporal tmp name
           $retornoJson->exito = false;
           $retornoJson->mensaje = "Se pudo modificar en la base de datos";
        }

    }else{
        $retornoJson->exito = false;
        $retornoJson->mensaje = "No existe el producto";
    }

    
}
var_dump($retornoJson);




?>