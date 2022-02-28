<?php

require_once ("AccesoDatos.php");
require_once ("Usuarios.php");

$op = isset($_POST['op']) ? $_POST['op'] : NULL;

switch ($op) {
    
    case 'mostrarTodos':
        $cds = Usuario::TraerTodosLosUser();
        foreach ($cds as $cd) {
            
            print_r($cd->MostrarDatos());
            print("
                    ");
        }
        break;

    default:
        echo ":(";
        break;

}

?>
