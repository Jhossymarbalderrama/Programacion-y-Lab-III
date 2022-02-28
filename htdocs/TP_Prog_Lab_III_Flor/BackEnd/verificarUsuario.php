<?php
    require_once("empleado.php");
    require_once("fabrica.php");

    //Usar traer archivo
    $dniPost =isset( $_POST["txtDni"]) ? $_POST["txtDni"] : NULL;
    $apellidoPost =isset( $_POST["txtApellido"]) ? $_POST["txtApellido"] : NULL;

    $nombreArchivo = "../archivos/empleados.txt";
    $empleadoExiste =false;
    if(file_exists($nombreArchivo))
    {
        $archivoAbierto = fopen($nombreArchivo,"r");
        if($archivoAbierto)
        {
            while(!feof($archivoAbierto))
            {
                 $empleado = fgets($archivoAbierto);                
                 $empleado = is_string($empleado) ? trim($empleado) : false;
                if($empleado)
                {
                    $arrayEmpleado = explode("-",$empleado);
                    if(count($arrayEmpleado)>0){
                        if($arrayEmpleado[0] != "" && $arrayEmpleado[0] != "\r\n"){
                            
                            $empleado = new Empleado($arrayEmpleado[0],
                                                    $arrayEmpleado[1],
                                                    $arrayEmpleado[2],
                                                    $arrayEmpleado[3],
                                                    $arrayEmpleado[4],
                                                    $arrayEmpleado[5],
                                                    $arrayEmpleado[6]);
                            
                            if($empleado->GetDni() == $dniPost && $empleado->GetApellido() == $apellidoPost)      
                            {
                                $empleadoExiste=true;
                                session_start();
                                $_SESSION["DNIEmpleado"] = $dniPost;
                                //header('Location: ./mostrar.php');
                                header('Location: ../homeAjax.php');
                                break;
                                
    
    
                            }                                                                
                        }                                   
                    }                                                        
                }
            }
            fclose($archivoAbierto);
            if($empleadoExiste== false)
            {
                echo("El empleado no se encuentra.<br><a href='../login.html'>Ir al Login</a><br>");
            }
        }
    }    




?>