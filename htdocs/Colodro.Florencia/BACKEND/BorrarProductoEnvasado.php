<?php

// BorrarProductoEnvasado.php: Se recibe el parámetro producto_json (id, codigoBarra, nombre, origen, precio y
// pathFoto en formato de cadena JSON) por POST. Se deberá borrar el producto envasado (invocando al método
// Eliminar).
// Si se pudo borrar en la base de datos, invocar al método GuardarEnArchivo.
// Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
// Si se invoca por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todos los productos
// envasados borrados y sus respectivas imagenes.
require_once('./clases/ProductoEnvasado.php');

$producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : NULL;
//var_dump($producto_json);

if($producto_json != NULL)
{
    $productoDec = json_decode($producto_json);//Decodifico el obj que me llega como json
    //var_dump($productoDec);
    $retornoJson = new stdClass();
    $retornoJson->exito = false;
    $retornoJson->mensaje = "No se pudo eliminar en la base de datos";
    
    if(ProductoEnvasado::Eliminar($productoDec->id));//Borro el producto que me pasaron por post y guardo 
    {
        $productoABorrar = new ProductoEnvasado($productoDec->nombre, $productoDec->origen, $productoDec->id,$productoDec->codigoBarra,$productoDec->precio,$productoDec->foto); 
        $productoABorrar->GuardarEnArchivo();//Guarda la instancia en el archivo
        $retornoJson->exito = true;
        $retornoJson->mensaje = " se pudo eliminar en la base de datos";
    }
    echo json_encode($retornoJson);
}else{//Muestro (leo) los productos ya eliminados.
    $path = './archivos/productos_envasados_borrados.txt';

    if(!file_exists($path))//Si NO existe el archivo:
    {
        $archivoAbierto = fopen($path, 'w');//lo creo
        fclose($archivoAbierto);
    }

    echo "<table>
    <tr>
        <td>
            id
        </td>
        <td>
            nombre
        </td>
        <td>
            origen
        </td>
        <td>
            codigo barra
        </td>
        <td>
            precio
        </td>
        <td>
            foto
        </td>
        </tr>";

    $archivoAbierto= fopen($path,'r'); 
    if($archivoAbierto)
    {
        while(!feof($archivoAbierto))
        {
            $productoCadena = fgets($archivoAbierto);//lee linea por linea
            $productoCadena = is_string($productoCadena) ? trim($productoCadena) : false;
            $arrayProducto = explode("-",$productoCadena);
            if($arrayProducto[0] != "" && $arrayProducto[0] != "\r\n")
            {   
                $producto = new ProductoEnvasado($arrayProducto[1],$arrayProducto[2],$arrayProducto[0],$arrayProducto[3],$arrayProducto[4],$arrayProducto[5]);
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
                            <img src=$producto->pathFoto widht=100px height=100px/>
                        </td>
                    </tr>";
            }  
        }
        fclose($archivoAbierto);
    }

}





?>