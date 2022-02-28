<?php
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
