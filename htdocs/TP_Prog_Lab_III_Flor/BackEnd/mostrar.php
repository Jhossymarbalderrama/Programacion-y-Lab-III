<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Empleados</title>
    <script src="../javascript/validaciones.js"></script>
    <script src="../javascript/app.js"></script>
   
</head>
<body>
    <h2 style="padding-left: 50px; ">Empleados:</h2>
    
    <?php
        require_once ("./validarSesion.php");
        VerificarSesion("../login.html");
    ?>
    <table align="center">
        <tr>
            <td>
                <h2>Info:</h2>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr/></td>
        </tr>
    
        <tr>
            <td>
                <?php
                        require_once("empleado.php");
                        require_once ("fabrica.php");

                        //PARTE 3
                        $nombreArchivo="../archivos/empleados.txt";
                        if(file_exists($nombreArchivo))
                        {
                           
                            $fabrica = new Fabrica("Fabrica mostrar xd",7);
                            $fabrica->TraerDeArchivo($nombreArchivo);
                            foreach ($fabrica->GetEmpleados() as $empleado) 
                            {
                                $empleadoLegajo = $empleado->GetLegajo();
                                $empleadoPathFoto = substr($empleado->GetPathFoto(),1);
                                $dni= $empleado->GetDni();
                                
                                    echo "<tr>
                                    <td>
                                        <div align='left'>".
                                            $empleado->GetDni() . " - " . 
                                            $empleado->GetNombre() . " - " .  
                                            $empleado->GetApellido() . " - " .
                                            $empleado->GetSexo() . " - " .
                                            $empleadoLegajo . " - " .
                                            $empleado->GetSueldo() . " - " .
                                            $empleado->GetTurno() . " - ".
                                            $empleado->GetPathFoto() . " | ".
                                        "</div>
                                    </td>
                                    <td>
                                    <img src=$empleadoPathFoto height= 55px width=55px>
                                    </td>
                                    <td>
                                        <input type='button' onclick='Main.EliminarEmpleado(".$empleadoLegajo.")' value='Eliminar'>
                                    </td> 
                                    <td>
                                        <input type='button' onclick='Main.ModificarEmpleado(".$dni.")' value='Modificar'>
                                    </td>                                                
                                </tr>
                                 <br>";                  
                            }
                        }else{
                            echo "<h4>El archivo txt de empleados no existe</4>";
                        }        
                    ?>
            </td>
        </tr>
            <!-- <tr>
                <td colspan="2">
                    <hr>
                    <?php 
                    echo "<br><a href='../index.php'>Alta de Empleados</a>";
                    echo '<a href="../BackEnd/cerrarSesion.php"><br><br>Cerrar sesion</a>';
                    ?>
                </td>
            </tr> -->
            <tr>
            <td>
                    <!-- <h3>Form y hidden xd</h3> -->
                    <form action='../index.php' method='POST' id='frmModificar'>
                    <input type='hidden' id='hiddenModificar' name='hiddenModificar'>
                    <!-- envio el id al typeascropt -->
                    <!-- AdministrarModificar agarra el id hidden  -->
                    </form>

                </td>
            </tr>
    </table>

</body>
</html>
