
<?php
    require_once("empleado.php");
    require_once("fabrica.php");

    $modoForm =isset( $_POST["hdnModificar"]) ? $_POST["hdnModificar"] : NULL;
    
    $dni =isset( $_POST["txtDni"]) ? $_POST["txtDni"] : NULL;
    $apellido =isset( $_POST["txtApellido"]) ? $_POST["txtApellido"] : NULL;
    $nombre =isset( $_POST["txtNombre"]) ? $_POST["txtNombre"] : NULL;
    $legajo =isset( $_POST["txtLegajo"]) ? $_POST["txtLegajo"] : NULL;
    $sueldo =isset( $_POST["txtSueldo"]) ? $_POST["txtSueldo"] : NULL;
    $turno =isset( $_POST["rdoTurno"]) ? $_POST["rdoTurno"] : NULL;
    $sexo =isset( $_POST["cboSexo"]) ? $_POST["cboSexo"] : NULL;
    $pathFoto =isset($_FILES["pathFoto"]) ? $_FILES["pathFoto"] : NULL;

    $empleadoAModificar=NULL;
    $empleado = new Empleado($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno);
    $fabrica = new Fabrica("Fabrica administracion",7);
    $path="../archivos/empleados.txt";   
    $proceso = "alta";

    if($modoForm=="modificar")
    {
        $fabrica = new Fabrica("Fabrica Modificar",7);
        $fabrica->TraerDeArchivo("../archivos/empleados.txt");
        foreach ($fabrica->GetEmpleados() as $value) 
        {
            if($dni == $value->GetDni())
            {
                $empleadoAModificar= $value;
                break;
            }
        }

        //Si hay foto y la quiere cambiar
        if( pathinfo("../fotos/" . $pathFoto["name"], PATHINFO_EXTENSION)== "")//Si tiene foto:
        {
            //No quiere modificar la foto 
            $tam = count(explode(".",$empleadoAModificar->GetPathFoto()));
            $pathModificado = "../fotos/". $dni . "_". $apellido . ".".explode(".",$empleadoAModificar->GetPathFoto())[$tam-1];
            $pathViejo= $empleadoAModificar->GetPathFoto();
            rename($pathViejo,$pathModificado);
            $fabrica->EliminarEmpleado($empleadoAModificar);
            $proceso= "modificar";

        }else{          
            //Se elima el empleado, se elimina la foto, se guardan los cambios y se da de alta normal
            unlink($empleadoAModificar->GetPathFoto());
            $fabrica->EliminarEmpleado($empleadoAModificar);
            $proceso="alta";
        }
    }

    if($proceso=="modificar")
    {
        //Al nuevo empleado se le pasa el path nuevo
        $empleado->SetPathFoto($pathModificado);
    }

    if($proceso=="alta")
    {

        $uploadOk=true;
        //INDICO CUAL SERA EL DESTINO DEL ARCHIVO SUBIDO
        $destino = "../fotos/" .  $pathFoto["name"];
    
        if( $dni != NULL && $apellido != NULL && $nombre != NULL && 
        $legajo != NULL && $sueldo != NULL && $sexo != NULL)
        {
            $tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);//Verificar el tipo de archivo
            $destino = "../fotos/". $dni ."_". $apellido .".". $tipoArchivo;
    
            $esImagen = getimagesize($pathFoto["tmp_name"]);//Verifica si es una imagen
            
            //VERIFICO QUE EL ARCHIVO NO EXISTA
            if (file_exists($destino)) {
                echo "El archivo ya existe. Verifique!!!";
                $uploadOk = FALSE;
            }else{
     
                //SOLO PERMITO CIERTAS EXTENSIONES
                if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif"
                && $tipoArchivo != "png" && $tipoArchivo != "bmp")
                 {
                    echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG , BMP o GIF.";
                    $uploadOk = FALSE;
                }
                //VERIFICO EL TAMAÑO MAXIMO QUE PERMITO SUBIR
                if ($pathFoto["size"] > 1000000) {
                    echo "El archivo es demasiado grande. Verifique!!!";
                    $uploadOk = FALSE;
                }
            }
    
            //VERIFICO SI HUBO ALGUN ERROR, CHEQUEANDO $uploadOk
            if ($uploadOk === FALSE) {
    
                echo "<br/>NO SE PUDO SUBIR EL ARCHIVO.";
    
            } else {
                //MUEVO EL ARCHIVO DEL TEMPORAL AL DESTINO FINAL
                if (move_uploaded_file($pathFoto["tmp_name"], $destino)) {
                    echo "<br/>El archivo ". basename( $pathFoto["name"]). " ha sido subido exitosamente.";
                    //----------------------------
                   
                    $empleado->SetPathFoto($destino);
                     
                } else {
                    echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
                }
            }
        }
    }

    if($empleado != NULL)
    {
        $fabrica->TraerDeArchivo($path);
        if($fabrica->AgregarEmpleado($empleado))
        {
            $fabrica->GuardarEnArchivo($path);
            echo "<a href='./mostrar.php'>Ir a Mostrar empleados</a>";
        }
          else{
                echo "<br>No se pudo agregar el empleado<br>";
                echo "<a href='../index.html'>Agregar empleado</a>";
         }
    }
    

    // //PARTE 2 DEL TP.
    // $path= "./archivos/empleados.txt";
    // $archivoEmpleados = fopen($path,"a");//Da un salto de linea y no pisa el dato
    // if(fwrite($archivoEmpleados,$empleado->__toString()))
    // {
    //     echo "<a href='./mostrar.php'>Ir a mostrar empleados</a>";
    // }else{
    //     echo "<a href='./TP2/javascript/index.html'>Agregar empleado</a>";
    // }
    // fclose($archivoEmpleados);
?>
