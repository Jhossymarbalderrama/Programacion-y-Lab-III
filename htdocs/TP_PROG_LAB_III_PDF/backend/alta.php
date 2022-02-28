<?php
    require_once("empleado.php");
    require_once("fabrica.php");


    $dni = isset($_POST["dni"]) ? $_POST["dni"] : NULL;
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : NULL;
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
    $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : NULL;
    $legajo = isset($_POST["legajo"]) ? $_POST["legajo"] : NULL;
    $sueldo = isset($_POST["sueldo"]) ? $_POST["sueldo"] : NULL;
    $turno = isset($_POST["rdoTurno"]) ? $_POST["rdoTurno"] : NULL;

    $empl_Modificar = isset($_POST["hdnModificar"]) ? $_POST["hdnModificar"] : NULL;
    $empleado_modificar = NULL;
    $proceso = "Alta";
    $pathDestinoModificar = "";
    $pathOld = "";
    $uploadOk = TRUE;
    $path = "../archivos/empleados.txt";
    $tamañoFabrica = 7;
    $_new_fabrica = new Fabrica("SA",$tamañoFabrica);
    $empleando_nuevo = new Empleado($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno);
    
    if($empl_Modificar == "ok"){
        $fabrica_auxMod = new Fabrica("AUX_Mod",$tamañoFabrica);
        $fabrica_auxMod->TraerDeArchivo($path);

        foreach ($fabrica_auxMod->GetEmpleados() as $value) {
            if($value->getDni() == $dni){
                $empleado_modificar = $value;                
            }
        }

        if(pathinfo("../fotos/" . $_FILES["file"]["name"], PATHINFO_EXTENSION) == ""){
            $len = count(explode(".",$empleado_modificar->GetPathFoto()));
            $pathDestinoModificar = "../fotos/" . $dni . "-" . $apellido . "." . explode(".",$empleado_modificar->GetPathFoto())[$len-1];        
            $pathOld = $empleado_modificar->GetPathFoto();
            rename($pathOld,$pathDestinoModificar);
            $fabrica_auxMod->EliminarEmpleado($empleado_modificar); 
            $proceso = "Modificar";
        }else{
            unlink($empleado_modificar->GetPathFoto());
            $fabrica_auxMod->EliminarEmpleado($empleado_modificar);   
            $proceso = "Alta";         
        }
    }       

    if($proceso == "Modificar"){
        $empleando_nuevo->SetPathFoto($pathDestinoModificar);        
    }

    //SI NO ES OK, DOY DE ALTA NORMAL
    if($proceso == "Alta"){        
        $pathDestino = "../fotos/" . $_FILES["file"]["name"];
        $tipoArchivo = pathinfo($pathDestino, PATHINFO_EXTENSION);
        $pathDestino = "../fotos/". $dni . "-" . $apellido . "." .$tipoArchivo;
        $esImagen = getimagesize($_FILES["file"]["tmp_name"]);    
    
        if (file_exists($pathDestino)) {        
            echo "El archivo ya existe. Verifique!!!";
            $uploadOk = FALSE;
        }else{
            if($esImagen === TRUE) 
            {
                if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && 
                $tipoArchivo != "gif" && $tipoArchivo != "png" && $tipoArchivo != "bmp") 
                {
                    echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
                    $uploadOk = FALSE;
                }        
            }
            if ($_FILES["file"]["size"] > 1000000) {
                echo "El archivo es demasiado grande. Verifique!!!";
                $uploadOk = FALSE;
            }
            if ($uploadOk === FALSE) {
                echo "<br/>NO SE PUDO SUBIR EL ARCHIVO.";
            }else {            
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $pathDestino)) {
                    $empleando_nuevo->SetPathFoto($pathDestino);                                                                                                                                                                                            
                } else {
                    echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
                }                                          
            }
        }
    }

    if($empleando_nuevo != NULL){
        $_new_fabrica->TraerDeArchivo($path);
        if($_new_fabrica->AgregarEmpelado($empleando_nuevo)){
            $_new_fabrica->GuardarEnArchivo($path);
            /* echo "<br><a href='./mostrar.php'>Mostrar Empleados</a>";  */
            
            
        }else{
            /* echo "<h4>No se pudo Agregar el Empleado<h4>$empleando_nuevo"; */
            /* echo "<br><a href='../index.html'>Ir a Pagina Principal</a>"; */
        }
    }                      
    
?>

