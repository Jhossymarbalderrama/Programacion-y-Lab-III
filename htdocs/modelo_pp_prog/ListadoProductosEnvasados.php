<?php

    /*
    ListadoProductosEnvasados.php:
     (GET) Se mostrará el listado completo de los productos envasados (obtenidos 
    de la base de datos) en una tabla (HTML con cabecera). Invocar al método Traer. 
    
    Nota: Si se recibe el parámetro tabla con el valor mostrar, retornará los datos en una tabla (HTML con cabecera), 
    preparar la tabla para que muestre la imagen, si es que la tiene. 

    Si el parámetro no es pasado o no contiene el valor mostrar, retornará el array de objetos con formato JSON
    */

    require_once("./clases/AccesoDatos.php");
    require_once("./clases/ProductoEnvasado.php");

    $tabla = isset($_GET['tabla']) ? $_GET['tabla'] : NULL;

    if($tabla == "mostrar")
    {
        $datos_array = ProductoEnvasado::Traer();

        echo "<table align='center'>                
                <tr>
                    <td>
                        |
                    </td>
                    <td>
                       <b>ID</b> -
                    </td>
                    <td>
                        <b>NOMBRE</b> -
                    </td>
                    <td>
                        <b>CODIGO BARRA</b> -
                    </td>
                    <td>
                        <b>NOMBREORIGEN</b> -
                    </td>
                    <td>
                        <b>PRECIO</b> - 
                    </td>
                    <td>
                        <b>FOTO</b>
                    </td>
                    <td>
                        |
                    </td>
                </tr>";

        foreach($datos_array as $item)
        {
            echo "<tr>
                    <td>
                        |
                    </td>
                    <td>
                        $item->id
                    </td>
                    <td>
                        $item->nombre
                    </td>
                    <td>
                        $item->codigoBarra
                    </td>
                    <td>
                        $item->origen
                    </td>
                    <td>
                        $item->precio
                    </td>
                    <td>
                        $item->pathFoto
                    </td>
                    <td>
                        |
                    </td>
                  </tr>";
        }
    }else{
        echo json_encode(ProductoEnvasado::Traer());
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <table>
            <th>
                
            </th>
        </table>
</body>
</html>