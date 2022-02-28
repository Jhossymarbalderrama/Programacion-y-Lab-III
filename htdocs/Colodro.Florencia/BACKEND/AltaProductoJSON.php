
<?php
require_once('./clases/Producto.php');
$origen =isset( $_POST["origen"]) ? $_POST["origen"] : NULL;
$nombre =isset( $_POST["nombre"]) ? $_POST["nombre"] : NULL;

$retornoJson = new stdClass();
$retornoJson->exito = false;
$retornoJson->mensaje = "No se pudo dar de alta";
if($nombre != NULL && $origen != NULL)
{
    $producto = new Producto($nombre, $origen);
    $retornoGuardar = $producto->GuardarJSON("./archivos/productos.json");
    if($retornoGuardar)
    {
        $retornoJson->exito = true;
        $retornoJson->mensaje = json_decode($retornoGuardar)->mensaje;
    }

}
echo json_encode($retornoJson);




?>