<?php
    require_once("./clases/ProductoEnvasado.php");

    $producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : NULL;
    $getSinParametros = isset($_GET["sin_parametros"]) ? $_GET["sin_parametros"] : NULL;


    if($producto_json != null){
        $obj = json_decode($producto_json);
        $producto = new ProductoEnvasado($obj->id,$obj->codigoBarra,$obj->precio,$obj->pathFoto,$obj->nombre,$obj->origen);
        $rta_json = new stdClass();
        $rta_json->exito = false;
        $rta_json->mensaje = "Error. No se puedo Eliminar el Producto";
        
        
        if(ProductoEnvasado::Eliminar($obj->id))
        {
            $producto->GuardarEnArchivo();
            $rta_json->exito = true;
            $rta_json->mensaje = "El Producto se Elimino del Sistema";
        }
        echo json_encode($rta_json);
    }else{
        if($getSinParametros == null)
        {
        echo "<table>
            <tr>
                <td>
                    ID
                </td>
                <td>
                    NOMBRE
                </td>
                <td>
                    ORIGEN
                </td>
                <td>
                    CODIGO BARRA
                </td>
                <td>
                    PRECIO
                </td>
                <td>
                    FOTO
                </td>
                </tr>";
        
            if(!file_exists("./archivos/productos_envasados_borrados.txt"))
            {
                $archivo = fopen("./archivos/productos_envasados_borrados.txt", "w");
                fclose($archivo);
            }

            $archivo = fopen("./archivos/productos_envasados_borrados.txt", "r");
            
            do
            {
                $cadena = fgets($archivo);
                $cadena = is_string($cadena) ? trim($cadena) : false;
                if($cadena != false)
                {
                    $arr = explode(" - ", $cadena);
                    if($arr[0] != "" && $arr[0] != "\r\n")
                    {   
                        $producto = new ProductoEnvasado($arr[0],$arr[3],$arr[4],$arr[5],$arr[1],$arr[2]);
                        echo "<table>
                                <tr>
                                    <td>
                                        $producto->id
                                    </td>
                                    <td>
                                        $producto->nombre
                                    </td>
                                    <td>
                                        $producto->origen
                                    </td>
                                    <td>
                                        $producto->codigoBarra
                                    </td>
                                    <td>
                                        $producto->precio
                                    </td>
                                    <td>
                                        <img src=$producto->pathFoto alt=fotoProductoBorrada widht=100px height=100px/>
                                    </td>
                                </tr>";
                    }
                }                
            }while(!feof($archivo));

            fclose($archivo);
        }
    }
   
?>