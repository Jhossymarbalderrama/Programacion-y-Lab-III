<?php
    //include "Empleado.php";
    //include "Fabrica.php";
    require_once("empleado.php");
    require_once("fabrica.php");
    

    $dni = isset($_POST["dni"]) ? $_POST["dni"] : NULL;
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : NULL;
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
    $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : NULL;
    $legajo = isset($_POST["legajo"]) ? $_POST["legajo"] : NULL;
    $sueldo = isset($_POST["sueldo"]) ? $_POST["sueldo"] : NULL;
    $turno = isset($_POST["rdoTurno"]) ? $_POST["rdoTurno"] : NULL;

    $empleando_nuevo = new Empleado($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno);

    $path = "./archivos/empleados.txt";

    $indicador_arch = fopen(($path),"a"); // Creo el archivo o lo abro
    if(fwrite($indicador_arch,$empleando_nuevo->__toString())){
        fclose($indicador_arch);//Cierro el archivo
        echo "Se Guardo Empleado";
        echo "<br><a href='./mostrar.php'>Mostrar Empleados</a>";
    }else{
        fclose($indicador_arch);//Cierro el archivo
        echo "<br><a href='./index.html'>Cargar Otro Empleado</a>";
    }

    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
       <div>
            <?php
            
                /*
                 $dni = isset($_POST["dni"]) ? $_POST["dni"] : 0;
                 $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : NULL;
                 $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
                 $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : NULL;
                 $legajo = isset($_POST["legajo"]) ? $_POST["legajo"] : 0;
                 $sueldo = isset($_POST["sueldo"]) ? $_POST["sueldo"] : 0;
                 $turno = isset($_POST["rdoTurno"]) ? $_POST["rdoTurno"] : NULL;

                 echo "El dni es: " . $dni;
                 echo "<br>El apellido es: " . $apellido;
                 echo "<br>El nombre es: " . $nombre;
                 echo "<br>El sexo es: " . $sexo;
                 echo "<br>El legajo es: " . $legajo;
                 echo "<br>El sueldo es: " . $sueldo;
                 echo "<br>El turno es: " . $turno;
                 */
            ?>
       </div>
    
</body>
</html>