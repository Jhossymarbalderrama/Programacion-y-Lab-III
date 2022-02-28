<?php

require_once('./clases/Producto.php');
$listadoProductos = Producto::TraerJson("./archivos/productos.json");
if(isset($listadoProductos))
{
    echo json_encode($listadoProductos);
}


?>