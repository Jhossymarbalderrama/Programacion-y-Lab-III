<?php
    require_once("Fabrica.php");    
    require_once("Empleado.php");  

    if(file_exists("./archivos/empleados.txt"))
    {
        $path = "./archivos/empleados.txt";

        $indic_arch = fopen($path,"r");
        $nueva_Fabrica = new Fabrica("CA-VLB");
        $arrays_Empleado = array();

        //DESDE EL ARCHIVO TXT
        echo "<h4>Empleados desde el archivo $path</h4>";
        while(!feof($indic_arch))
        {
            $empleado = fgets($indic_arch);
            echo   $empleado . "<br>";

            if($empleado != ""){               
                array_push($arrays_Empleado,explode("-",$empleado));
            }            
        }
        //array_pop($arrays_Empleado);
        
        //print_r($arrays_Empleado);
        echo "<br>";

        //EMPELADOS EN LA CLASE
        if(count($arrays_Empleado) == 0){
            echo "
                    <tr>
                        <td>
                            No hay Empleados para Mostrar.
                        </td>
                    </tr>
                 ";
        }else{
            echo "<h4>Empleados desde Clase con ToString</h4>";
            for ($i=0; $i < count($arrays_Empleado); $i++) { 
                $cargaEmpleado = new Empleado($arrays_Empleado[$i][0],
                                            $arrays_Empleado[$i][1],
                                            $arrays_Empleado[$i][2],
                                            $arrays_Empleado[$i][3],
                                            $arrays_Empleado[$i][4],
                                            $arrays_Empleado[$i][5],
                                            $arrays_Empleado[$i][6]);

                echo $cargaEmpleado->__toString() . "<br>";
            }
        }
  
        fclose($indic_arch);
    }else{
        echo "<h4>El archivo txt de empleados no existe</4>";
    }

    echo "<br><a href='./index.html'>Cargar un Empleado</a>";
    


    //USAR EL EXPLODE()   
    //explode()//transforma un string indicandole un delimitador (por ejemplo un string las palabras estan separadas por un ", o -") 
    //despues, estos datos podemos meterlo dentro de un array
    //implode()//contrario de un explote. pasa de un array a una cadena


?>