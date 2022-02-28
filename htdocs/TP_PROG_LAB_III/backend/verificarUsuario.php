<?php
    require_once("fabrica.php");
    require_once("empleado.php");

    $dni = isset($_POST["dni"]) ? $_POST["dni"] : NULL;
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : NULL;
    $path = "../archivos/empleados.txt";
    $flag = false;


        if(file_exists($path)){
            $archivo = fopen($path,"r");
            while(!feof($archivo))
            {
                $empleado = fgets($archivo);                
                $empleado = is_string($empleado) ? trim($empleado) : false;
                $datos = explode(" - ",$empleado);
                
                for ($i=0; $i < count($datos); $i++) { 
                    if($i == 1 || $i == 2){
                        $apellido_A = $datos[1];
                        $dni_A = $datos[2];
                    }
                }                

                if($apellido_A === $apellido && $dni_A === $dni){
                    $flag = true;
                    break;
                }                            
            }   
            
            if($flag){                     
                session_start();
                $_SESSION["DNIEmpleado"] = $dni;                 
                header("Location: ../ajax.php");
            }else{               
                echo 
                "<table align='center'>
                    <tr>
                        <td  style='color: red;'>
                            <b>Error. El usuario ingresado no se encuentra en el sistema.<b>
                            <br><a href='../login.html'>Volver a Login</a>
                        <td/>
                    </tr>
                </table>";
            }


            
        }else{
            echo "El archivo no existe...";
        }
    //echo "DNI : ". $dni . " -  Apellido" . $apellido;

?>