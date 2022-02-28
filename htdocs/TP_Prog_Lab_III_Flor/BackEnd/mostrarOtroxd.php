<html>
    <head>
    <style>
        form
        {
            margin: 0 auto;
            width: 550px;
            padding: 1em;
            border: 1px solid rgb(112, 112, 112);
            border-radius: 1em;
        }
    
        h2.posicionTitulo 
        {
            margin-left: 330px;
        }
    
    </style>
    </head>
    <title>HTML 5 - Listado de Emleados</title>
    <form>
        <table align="center">
            <tr>
                <td>
                    <h2>Listado de Empleados</h2>  
                </td>
            </tr>
            <tr>        
                <td colspan="2">  
                    <h4>Info</h4> 
                    <hr>                 
                    <?php
                        require_once("fabrica.php");    
                        require_once("empleado.php");  
                        
                        if(file_exists("../archivos/empleados.txt"))
                        {
                            $path = "../archivos/empleados.txt";    
                            $archivo = fopen($path,"r");

                            //echo "<h4>Empleados desde el archivo $path</h4>";
                            while(!feof($archivo))
                            {
                                $empleado = fgets($archivo);                
                                $empleado = is_string($empleado) ? trim($empleado) : false;
                                $array_aux = explode("-",$empleado);
                            

                                if(count($array_aux)>0){
                                    if($array_aux[0] != "" && $array_aux[0] != "\r\n"){                                

                                        
                                        $cargaEmpleado = new Empleado($array_aux[0],
                                                                    $array_aux[1],
                                                                    $array_aux[2],
                                                                    $array_aux[3],
                                                                    $array_aux[4],
                                                                    $array_aux[5],
                                                                    $array_aux[6]);                                            
                                            $legajoEmpleado =  $cargaEmpleado->GetLegajo();                                                                                 
                                            echo "<tr>
                                                    <td>
                                                        <div align='left'>".
                                                            $cargaEmpleado->getDni() . " - " . 
                                                            $cargaEmpleado->getNombre() . " - " .  
                                                            $cargaEmpleado->getApellido() . " - " .
                                                            $cargaEmpleado->GetSexo() . " - " .
                                                            $legajoEmpleado . " - " .
                                                            $cargaEmpleado->GetSueldo() . " - " .
                                                            $cargaEmpleado->GetTurno() . " | ".
                                                        "</div>
                                                    </td>
                                                    <td>
                                                        <a href='./eliminar.php?legajo=$legajoEmpleado'>Eliminar</a>
                                                    </td>                                                
                                                </tr>
                                            <br>";                                                                                             
                                    }                                   
                                }else{
                                    echo 
                                    "<tr>
                                        <td>
                                            <b>No se encontraror Empleados...</b> 
                                        </td>
                                    </tr>";
                                }
                                            
                            }
                                                    
                            fclose($archivo);
                        }else{
                            echo "<h4>El archivo txt de empleados no existe</4>";
                        }                    
                    ?>             
                    </td>               
            </tr>
            <tr>
                <td colspan="2">
                    <hr>
                    <?php
                    echo "<br><a href='../index.html'>Alta de Empleados</a>";
                    ?>
                </td>
            </tr>
        </table>
    </form>
</html>


