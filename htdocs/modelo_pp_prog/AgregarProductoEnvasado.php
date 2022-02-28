<?php
    require_once("./clases/ProductoEnvasado.php");

    $codigoBarra = isset($_POST['codigoBarra']) ? $_POST['codigoBarra'] : NULL;
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
    $origen = isset($_POST['origen']) ? $_POST['origen'] : NULL;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : NULL;

    $producto = new ProductoEnvasado(0,$codigoBarra,$precio,null,$nombre,$origen);
    $array = ProductoEnvasado::Traer();
    $rta_JSON = new stdClass();

    if($producto->Exite($array))
    {
        $rta_JSON->exito = false;
        $rta_JSON->mensaje = "El producto ya existe en la base de datos";
    } else
    {
        $pathDestino = "./productos/imagenes/" . $foto["name"];
        $flag = false;
        if(getimagesize($foto["tmp_name"]) != FALSE)
        {
            $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
            $nombreArchivo = $producto->nombre . "." . $producto->origen . "." . date("G") . date("i") . date("s");
            $pathDestino = "./productos/imagenes/" . $nombreArchivo . "." . $tipoDeArchivo;
            
    
            if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
            {
                if($foto["size"] <= 1000000)
                {
                    move_uploaded_file($foto["tmp_name"],$pathDestino);
                    $pathDestino = "./productos/imagenes/" . $nombreArchivo . "." . $tipoDeArchivo;
                    $producto->pathFoto = $pathDestino;
                    $flag = true;
                }
            }
        }
    
        if($flag)
        {
            if($producto->Agregar())
            {
                $rta_JSON->exito = true;
                $rta_JSON->mensaje = "El producto fue agregado correctamente a la base de datos";
            }
        }
        else
        {
            $rta_JSON->exito = false;
            $rta_JSON->mensaje = "La imagen no es correcta";
        }
    }


    echo json_encode($rta_JSON); 
?>