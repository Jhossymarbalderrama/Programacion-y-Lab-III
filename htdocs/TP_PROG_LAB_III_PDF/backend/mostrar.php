<?php
    require_once("validarSesion.php");
    ValidarSession("../login.html");
?>

<html>
    <head>
        <!--
    <style>
        .xd
        {
            margin: 0 auto;
            width: 950px;
            padding: 1em;
            border: 1px solid rgb(112, 112, 112);
            border-radius: 1em;
        }
    
        h2.posicionTitulo 
        {
            margin-left: 330px;
        }    
    </style>-->
        <link type="text/css" rel="stylesheet" href="css/estilos.css" />

        <script src="../javascript/validaciones.js"></script>
        <script src="../javascript/app.js"></script>
        <script src="../javascript/ajax.js"></script> 
    </head>
    <title>HTML 5 - Listado de Emleados</title>
    <?php
        
        require_once("validarSesion.php");
        require_once("fabrica.php");
        //require_once("./empleado.php");
        ValidarSession("../login.html");
    ?>

    <form method="POST" class="xd">
        <!--<div align="right" style="color: blue;"><a href="./cerrarSesion.php">Desloguearse</a></div>-->
        <table align="center">
            <tr>
                <td>
                    <h2>Listado de Empleados</h2>  
                </td>
                <td align="right" colspan="4">                    
                    <strong><input type='button' value='Descargar Lista de Empleados' style="height: 40px;color:blue;" onclick="window.open('backend/PDF_ListaEmpleador.php');"></strong>                
                </td>
            </tr>
            <tr>        
                <td colspan="4">  
                    <?php
                        $path = "../archivos/empleados.txt";
                        if(file_exists($path))
                        {
                            $fabrica = new Fabrica("SA",7);
                            $fabrica->TraerDeArchivo($path);
                            $array_Empleados = $fabrica->GetEmpleados();
                        }
                    ?>
                    <h4>Info : <?php echo "empleados : ". count($array_Empleados)."/7"?></h4> 
                    <hr>                                     
                    <?php                       
                        if(file_exists("../archivos/empleados.txt"))
                        {
                            $path = "../archivos/empleados.txt"; 
                            $fabrica = new Fabrica("SA",7);
                            $fabrica->TraerDeArchivo($path);
                            $array_Empleados = $fabrica->GetEmpleados();

                            if(count($array_Empleados) == 0)
                            {
                                echo 
                                "
                                    <tr>
                                        <td  style='color: red;'>
                                            <b>Error. No hay empleados para Mostrar.<b>
                                        <td/>
                                    </tr>
                                ";
                            }else{
                                echo "<br>";
                                foreach ($array_Empleados as $value) {
                                    $aux_Legajo = $value->GetLegajo();                                                                
                                    $aux_PathIMG = $value->GetPathFoto();
                                    $aux_DNI = $value->getDni();
                                    
                                    echo "<tr>
                                            <td>
                                                <div align='left'>".
                                                    $aux_DNI . " - " . 
                                                    $value->getNombre() . " - " .  
                                                    $value->getApellido() . " - " .
                                                    $value->GetSexo() . " - " .
                                                    $value->GetLegajo() . " - " .
                                                    $value->GetSueldo() . " - " .
                                                    $value->GetTurno() . " - ".
                                                    $value->GetPathFoto() . 
                                                    "<td><img src='".substr($aux_PathIMG,1)."' width='90px' height='55px'/></td>" .                                                     
                                                "</div>
                                            </td>
                                            <td>
                                                <input type='button' value=Eliminar class=MiBotonUTN id=btnEliminar onclick='DeleteEmployee($aux_Legajo)'>
                                            </td>                                        
                                            <td>
                                                <input type='button' onclick='ModificarEmployee($aux_DNI)' value='Modificar'>
                                            </td>                                                                          
                                        </tr>";   
                                                                             
                                }
                            } 
                        }else{
                            echo "<h4>El archivo txt de empleados no existe</4>";
                        }  
                                                                                         
                    ?>                                               
                    </td>                    
            </tr>
            <tr>
                <td colspan="4">
                    <hr>
                    <?php
                    /* echo "<a href='../index.php'>Alta de Empleados</a>"; */
                    ?>
                </td>
            </tr>
        </table>
    </form>
    <form action='../index.php' method='POST' id='modificarForm' >
            <input type='hidden' id='dniHidden' name='dniHidden' />
    </form>
</html>


<!--
    Viejo Boton Modificar-> 
                            <td>
                                <input type='button' onclick='AdministrarModificar(".$aux_DNI.")' value='Modificar'>
                            </td>   
    Viejo Boton Eliminar-> 
                            <td>
                                <a href='./eliminar.php?legajo=$aux_Legajo'>Eliminar</a>
                                <a href='./eliminar.php?legajo=$aux_Legajo'>Eliminar</a>
                            </td>                         

-->