<?php
function VerificarSesion($ruta)
{
    session_start();
    if(!isset($_SESSION['DNIEmpleado']))
    {
        header("Location: $ruta");
    }

}
?>