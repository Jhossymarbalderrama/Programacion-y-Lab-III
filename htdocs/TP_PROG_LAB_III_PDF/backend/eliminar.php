<?php
    require_once("fabrica.php");
    require_once("empleado.php");  

    $nroLegajo = isset($_GET["legajo"]) ? $_GET["legajo"] : NULL;
    //echo "<b>El legajo del Empleado es " . $nroLegajo . "</b><br>";
    
    
    if(file_exists("../archivos/empleados.txt"))
    {        
        $path = "../archivos/empleados.txt";    
        $archivo = fopen($path,"r");   

        $fabrica = new Fabrica("SA",7);
        $fabrica->TraerDeArchivo($path);         

        foreach ($fabrica->GetEmpleados() as $empleado) {
            if($empleado->GetLegajo() == $nroLegajo)
            {
                if($fabrica->EliminarEmpleado($empleado))
                {
                    unlink($empleado->GetPathFoto());
                    //$fabrica->GuardarEnArchivo(($path));                    
                    echo "<br><b>El empleado con el legajo $nroLegajo se elimino de la lista";
            
                    echo "<br><a href='./mostrar.php'>Mostrar Empleados</a>";
                    echo "<br><a href='../index.html'>Ir a Carga de Empleados</a>";
                    
                    break;
                }else{
                    echo "No se encontro a un Empleado con el Legajo $nroLegajo en el Archivo";
                    break;
                }
            }
        }
                                  
        fclose($archivo);
    }else{
        echo "<h4>El archivo txt de empleados no existe</4>";
    }  
?>