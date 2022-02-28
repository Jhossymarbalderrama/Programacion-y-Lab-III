<?php

require_once ("fabrica.php");
require_once("empleado.php");
$legajo = isset($_GET["txtLegajo"]) ? $_GET["txtLegajo"] : NULL;
//echo "El legajo del empleado a eliminar es: ". $legajo;
$estado='';
//Abrir el archivo
$nombreArchivo= "../archivos/empleados.txt";
if(file_exists($nombreArchivo))
{
    $flag= false;
    $fabrica = new Fabrica("Fabrica",7);
    

    $fabrica->TraerDeArchivo($nombreArchivo);
    foreach ($fabrica->GetEmpleados() as $empleado) {
        if($empleado->GetLegajo() == $legajo)
        {
            if($fabrica->EliminarEmpleado($empleado))
            {
                unlink($empleado->GetPathFoto());
                $fabrica->GuardarEnArchivo($nombreArchivo);
                $estado= 'true';
                //echo "<br><a href='./mostrar.php'>Mostrar Empleados</a>";
                // echo "<br><a href='../index.html'>Ir a Carga de Empleados</a>";
            }else{
                $estado='No se pudo eliminar el empleado.';
                
            }  
            break;
        }else{
            $estado='No se encuentra el legajo.';
        }
    }
    echo $estado;
}

?>