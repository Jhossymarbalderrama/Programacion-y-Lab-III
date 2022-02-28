<?php
// FiltrarProductos.php: Se recibe por POST el origen, se mostrarán en una tabla (HTML) los productos envasados
// cuyo origen coincidan con el pasado por parámetro.
// Si se recibe por POST el nombre, se mostrarán en una tabla (HTML) los productos envasados cuyo nombre
// coincida con el pasado por parámetro.
// Si se recibe por POST el nombre y el origen, se mostrarán en una tabla (HTML) los productos envasados cuyo
// nombre y origen coincidan con los pasados por parámetro.

require_once('./clases/ProductoEnvasado.php');

$origen = isset($_POST["origen"]) ? $_POST["origen"] : null;
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;


    $productosBD = ProductoEnvasado::Traer();

    if($productosBD != NULL)
    {
        $lista = array();
        if( $origen != NULL && $nombre !=NULL)
        {
            foreach ($productosBD as $productoBD) 
            {
                if($productoBD->nombre == $nombre && $productoBD->origen == $origen)
                {
                    array_push($lista,$productoBD);
                }
            }
        }
        else if($origen !=NULL)
        {
            foreach ($productosBD as $productoBD) 
            {
                if($productoBD->origen == $origen)
                {
                    array_push($lista,$productoBD);
                }
            }
        }else if($nombre != NULL)
        {
            foreach ($productosBD as $productoBD) 
            {
                if($productoBD->nombre == $nombre)
                {
                    array_push($lista,$productoBD);
                }
            }
        }
        //var_dump($lista);
        echo "<table style='border:2px solid black;border-collapse:collapse;'>
    <tr>
        <th style='border:1px solid black;padding:15px;'>Nombre</th>
        <th style='border:1px solid black;padding:15px;'>Origen</th>
        <th style='border:1px solid black;padding:15px;'>Codigo de barras</th>
        <th style='border:1px solid black;padding:15px;'>Precio</th>
        <th style='border:1px solid black;padding:15px;'>Foto</th>
    </tr>";
    foreach($lista as $producto){
        echo "<tr>
            <td style='border:1px solid black;padding:15px;'>$producto->nombre</td>
            <td style='border:1px solid black;padding:15px;'>$producto->origen</td>
            <td style='border:1px solid black;padding:15px;'>$producto->codigoBarra</td>
            <td style='border:1px solid black;padding:15px;'>$producto->precio</td>
            <td style='border:1px solid black;padding:15px;'><img width=50 height=50 src'$producto->pathFoto /></td>
        </tr>";
    }
    echo "</table>";

    }



?>