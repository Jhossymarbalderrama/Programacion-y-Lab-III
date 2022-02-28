<?php
require_once('./clases/ProductoEnvasado.php');


$codigoBarra = isset($_POST["codigoBarra"]) ? $_POST["codigoBarra"] : null;
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
$origen = isset($_POST["origen"]) ? $_POST["origen"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null;
$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

$lista = ProductoEnvasado::Traer();
if($lista !== null & count($lista) !== 0){
    
    $retornoJson = new stdClass();
    $retornoJson->exito = false;
    $retornoJson->mensaje = "Error al guardar en la base de datos";

    $pathFoto = "$nombre.$origen." . date('Gis') . ".". pathinfo($foto, PATHINFO_EXTENSION);
    $productoAux = new ProductoEnvasado($nombre, $origen, null, $codigoBarra, $precio, $pathFoto);
    
    if($productoAux->Existe($lista)){
        $retornoJson->mensaje = "El producto ya existe";
    }
    else{
        if($productoAux->Agregar()){
            $retornoJson->exito = true;
            $retornoJson->mensaje = "Se agrego a la base de datos";
            if(move_uploaded_file($_FILES["foto"]["tmp_name"],"./productos/imagenes/". $pathFoto)){
                $retornoJson->mensaje .= ",con la foto";
            }
            else{
                $retornoJson->mensaje .= ",error al guardar la foto";
            }
        }
    }

    echo json_encode($retornoJson);
}

?>