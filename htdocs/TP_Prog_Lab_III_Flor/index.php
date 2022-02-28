<?php
require_once("./BackEnd/fabrica.php");
require_once("./BackEnd/validarSesion.php");
VerificarSesion("./login.html");
/**En index.php se deberá recuperar del archivo de texto al empleado que coincida con el DNI recibido por POST. 
Los datos recuperados serán mostrados en cada uno de los elementos del formulario de ingreso. */
$dniPost =isset( $_POST["hiddenModificar"]) ? $_POST["hiddenModificar"] : NULL;
$apellidoMod= null;
$nombreMod = null;
$sexoMod = null;
$legajoMod = null;
$sueldoMod = null;
$turnoMod = null;
if(isset( $_POST["hiddenModificar"]) )
{
    if($dniPost != NULL)//-
    {
        $fabrica = new Fabrica("Fabrica modificar",7);
        $fabrica->TraerDeArchivo("./archivos/empleados.txt");
        foreach ($fabrica->GetEmpleados() as $empleado) 
        {
            if($empleado->GetDni()== $dniPost)
            {
                
                $apellidoMod= $empleado->GetApellido();
                $nombreMod = $empleado->GetNombre();
                $sexoMod = $empleado->GetSexo();
                $legajoMod = $empleado->GetLegajo();
                $sueldoMod = $empleado->GetSueldo();
                $turnoMod = $empleado->GetTurno();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
        if(isset( $_POST["hiddenModificar"]))
        {
            echo "<title>Modificar Empleado</title>";
        }else{
            echo "<title>Alta Empleado</title>";
        }
    ?>
    <script src="./javascript/validacionesLogin.js"></script>
    <script src="./javascript/validaciones.js"></script>
    <script src="./javascript/app.js"></script>
    <script src="./javascript/ajax.js"></script>
    <!-- <script src="./javascript/funciones.js"></script> -->
</head>

<body>
    <?php
        if(isset( $_POST["hiddenModificar"]))
        {
            echo "<h2 style=' text- align:center;padding-left: 70px; padding-top: 40px;' >Modificar Empleados</h2>";
        }else{
            echo "<h2 style='text- align:center;padding-left: 70px; padding-top: 40px;' >Alta de Empleados</h2>";
        }
    ?>

    <form name="miForm"  method="POST" enctype="multipart/form-data">
        <table align="center">
            <tr>
                <td colspan="2"><hr/></td>
            </tr>
            <tr>
            <tr>
                <td style = "padding: 0px "><h4>Datos personales:</h4></td>
            </tr>
            <!-- <tr>
                <td colspan="2"><hr/></td>
            </tr> -->
            <tr>
                <td><label for="dni">DNI:</label></td>
                <td><input id="txtDni" name="txtDni" type="number" min="1000000" max="55000000" placeholder="Ingrese dni..." required value=<?php echo $dniPost ?> <?php if(isset($dniPost)){echo "readonly"; }?> />
                  
                    <span id="spanDni" style="display:none;">*</span>
                </td>					
            </tr>
            <tr>
                <td><label for="apellido">Apellido:</label></td>
                <td><input id="txtApellido" name="txtApellido"type="apellido" placeholder="Ingrese apellido..." required 
                    value="<?php
                    echo $apellidoMod ?>"/> 
                    <span id="spanApellido" style="display:none;">*</span>
                </td>					
            </tr>
            <tr>
                <td><label for="nombre">Nombre:</label></td>
                <td><input id="txtNombre" name="txtNombre"type="text" placeholder="Ingrese nombre..." required value="<?php
                    echo $nombreMod ?>">
                    <span id="spanNombre" style="display:none;">*</span>
                </td>					
            </tr>
            <tr>
                <td><label for="sexo">Sexo:</label></td>
                <td>
                    <select name="cboSexo" id="cboSexo">
                        <option value="---" disabled selected hidden>---</option>
                        <option value="femenino" <?php echo ($sexoMod == "femenino") ? "selected" : "";?>>Feminino</option>
                        <option value="masculino" <?php echo ($sexoMod == "masculino") ? "selected" : "";?>>Masculino</option>
                      </select>	
                      <span id="spanSexo" style="display:none;">*</span>
                </td>			
            	
            </tr>

            <tr>
                <td colspan="2"><hr/></td>
            </tr>
            <tr>
            <tr>
                <td style = "padding: 0px; "><h4>Datos Laborales:</h4></td>
            </tr>
         
                <td><label for="legajo">Legajo:</label></td>
                <td><input id="txtLegajo" name="txtLegajo" type="number" min="100" max="550"  placeholder="Ingrese legajo..." required value="<?php
                    echo $legajoMod?>"<?php if(isset($dniPost)){echo "readonly"; }?> >
                    <span id="spanLegajo" style="display:none;">*</span>
                </td>					
            </tr>
            <tr>
                <td><label for="sueldo">Sueldo:</label></td>
                <td><input id="txtSueldo" name="txtSueldo"type="number" min="8000" step="500"  max="250000" placeholder="Ingrese apellido..." required value="<?php
                    echo $sueldoMod?>"> 
                    <span id="spanSueldo" style="display:none;">*</span>
                </td>					
            </tr>
            <tr>
                <td rowspan="1">Turno:</td>
            </tr>

            <tr>
                <td  style="text-align:right; padding-right:20px">
                    <input type="radio" name="rdoTurno"  id="rdoTurno" value="maniana" <?php echo ($turnoMod == "maniana") ? "checked" : "";?> checked="checked" />Ma&ntilde;ana:					
                </td>
            </tr>
            <tr>
                <td  style="text-align:right; padding-right:35px">
                    <input type="radio" name="rdoTurno" id="rdoTurno" value="tarde" <?php echo ($turnoMod == "tarde") ? "checked" : "";?> checked="checked" />Tarde:					
                </td>
            </tr>
            <tr>
                <td  style="text-align:right; padding-right: 29.5px;">
                    <input type="radio" name="rdoTurno" id="rdoTurno" value="noche" <?php echo ($turnoMod == "noche") ? "checked" : "";?> checked="checked" />Noche:					
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr/></td>
            </tr>
            <tr>
                <!-- CAMPO PARA LA FOTO -->
                <td><label for="pathFoto">Foto:</label></td>
                <td style="text-align:left;padding-left:10px">
                    <input type="file" name="pathFoto" id="pathFoto" >
                    <span style="display:none;" id="spanFoto"  >*</span>
                </td>
            </tr>
            <tr>
                <td align="right" style="padding-left: 80%">
                    <input type="reset" value="Limpiar" name="reset" />
                </td>
            </tr>
            <tr>
                <td align="right" style="padding-left: 82%">
                    <input type="hidden" id="hdnModificar" name="hdnModificar" value=<?php echo (isset($_POST["hiddenModificar"])) ? "modificar" : "alta"?>>
                    <!-- <input type="submit" onclick="AdministrarValidaciones()" value=<?php if(isset($dniPost)){ echo "Modificar"; }else{echo "Enviar";}?>>  -->
                    <input type="submit" onclick="AltaEmployee()" value=<?php if(isset($dniPost)){ echo "Modificar"; }else{echo "Enviar";}?>>
                </td>
             
            </tr>
            <!-- <tr>
                <td>
                <a href='/BackEnd/cerrarSesion.php'>Cerrar Sesion</a>
                </td>
            </tr> -->
        </table>
    </form>
</body> 
</html>


