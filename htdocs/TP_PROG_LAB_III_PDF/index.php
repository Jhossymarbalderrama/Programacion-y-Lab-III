<?php
        require_once("./backend/validarSesion.php");
        require_once("./backend/fabrica.php");
        ValidarSession("./login.html");
        $dni_e = null;
        $apellido = null;
        $nombre = null;
        $sexo = null;
        $legajo = null;
        $sueldo = null;
        $turno = null;

        $dni = isset($_POST["dniHidden"]) ? $_POST["dniHidden"] : NULL;

        if(isset($_POST["dniHidden"])){
            $fabrica = new Fabrica("mod",7);
            $fabrica->TraerDeArchivo("./archivos/empleados.txt");
            foreach ($fabrica->GetEmpleados() as $value) {
                if($value->getDni() == $dni){
                         
                    $dni_e = $value->getDni();
                    $apellido = $value->getApellido();
                    $nombre = $value->getNombre();
                    $dni = $value->getDni();
                    $sexo = $value->GetSexo();

                    $legajo = $value->GetLegajo();
                    $sueldo = $value->GetSueldo();                    
                    $turno = $value->GetTurno();                    
                }
            }
        }
    ?>

<!DOCTYPE html>
<html lang="es">
<head>
     
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
   
    <?php
        if(isset($_POST["dniHidden"])){
            echo '<title>HTML 5 - Formulario Modificar Empleado</title>';
        }else{
            echo '<title>HTML 5 - Formulario Alta Empleados</title>';
        }        
    ?>
    <!--
    <script src="./javascript/login.js" ></script>
    <script src="./javascript/validaciones.js" ></script>
    -->
    <!--
        <script src="./javascript/funciones.js" ></script>
    -->
    <script src="./javascript/login.js" ></script>
    <script src="./javascript/validaciones.js" ></script>
    <script src="./javascript/ajax.js" ></script>
    <script src="./javascript/app.js" ></script>
   

</head>
<body>    
    <!--action="./backend/administracion.php"-->


    <form  method="POST" enctype="multipart/form-data" onsubmit="return AdministrarValidaciones()" id="frmAltaMod"> 
        <!--<div align="right" style="color: blue;"><a href="./backend/cerrarSesion.php">Desloguearse</a></div>-->
        
        <?php
            if(isset($_POST["dniHidden"])){
                echo '<h2 align="center" style="padding-right: 90px;">Modificar Empleado</h2>';
            }else{
                echo '<h2 align="center" style="padding-right: 90px;">Alta de Empleados</h2>';
            }        
        ?>
        <table align="center">            
            <tr>
                <td colspan="2" align="center" style="padding-right: 180px;"><h4>Datos Personales</h4></td>
            </tr>

            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>

            <tr>
                <td>DNI:</td>				
                <td  style="text-align:left;padding-left:15px">                    
                    <input type="number" name="dni" id="textDNI"  placeholder="Ingrese DNI" min="1000000" max="55000000" required
                    value="<?php echo $dni?>" <?php if($dni != null) echo "readonly"?>/>       
                     <span id="spanDni" style="display:none;color: red;">*</span>	                                                                               				
                </td>                    
            </tr>
            
            <tr>
                <td>Apellido:</td>					
                <td  style="text-align:left;padding-left:15px">
                    <input type="text" name="apellido" id="textApellido" placeholder="Ingrese su Apellido..." required
                    value="<?php echo $apellido?>"
                    /> 
                    <span id="spanApellido" style="display:none;color: red;">*</span>          				
                </td>
            </tr>

            <tr>
                <td>Nombre:</td>					
                <td  style="text-align:left;padding-left:15px">
                    <input type="text" name="nombre" id="textNombre" placeholder="Ingrese su Nombre..." required
                    value="<?php echo $nombre?>"/> 
                    <span id="spanNombre" style="display:none;color: red;">*</span>				
                </td>
            </tr>
            
            <tr>
                <td>Sexo:</td>
                <td align="left" style="padding-left: 15px;">
                    <select name="sexo" id="cboSexo" required>
                        <option value="" >Seleccione</option>
                        <option value="M"
                        <?php echo ($sexo == "M") ? "selected" : ""; ?>
                        >Masculino</option>
                        <option value="F"
                        <?php echo ($sexo == "F") ? "selected" : ""; ?>
                        >Femenino</option>
                    </select>
                    <span id="spanSexo" style="display:none;color: red;">*</span>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="left" ><h4>Datos Laborales</h4>
                    <hr>
                </td>                   
            </tr>


            <tr>
                <td>Legajo:</td>					
                <td  style="text-align:left;padding-left:15px">
                    <input type="number" name="legajo" id="textLegajo" placeholder="Ingrese su Legajo..." min="100" max="550" required 
                    value="<?php echo $legajo?>" <?php if($dni != null) echo "readonly"?>/> 
                    <span id="spanLegajo" style="display:none;color: red;">*</span>              				
                </td>
            </tr>
            
            <tr>
                <td>Sueldo:</td>					
                <td  style="text-align:left;padding-left:15px" colspan="2">
                    <input type="number" name="sueldo" id="textSueldo" placeholder="Ingrese su Sueldo..." min="8000" max="25000" step="500" required
                    value="<?php echo $sueldo?>"/> 
                    <span id="spanSueldo" style="display:none;color: red;">*</span>				
                </td>
            </tr>

            <tr>
                <td colspan="2" style="padding-top:10px;">Turno:</td>
            </tr>
            <tr>
                			
                <td style="padding-left:30px;">
                    <input type="radio" name="rdoTurno" value="Mañana"
                    <?php echo ($turno == "Manaña") ? "checked" : ""?>
                    checked
                    />Mañana				
                </td>                
                	
            </tr>
            <tr>			
                <td style="padding-left:30px;">
                    <input type="radio" name="rdoTurno" value="Tarde" 
                    <?php echo ($turno == "Tarde") ? "checked" : ""?>
                    />Tarde                						
                </td>
            </tr>
            <tr>			
                <td style="padding-left:30px;">
                    <input type="radio"  name="rdoTurno" value="Noche" 
                    <?php echo ($turno == "Noche") ? "checked" : ""?>	
                    />Noche                    				
                </td>
            </tr>				
            <tr>
                <td colspan="2" style="padding-top: 15px;">
                Foto: <input type="file" id="file" name="file" accept=".jpg , .jpeg , .gif , .png , .bmp" />
                <span id="spanFile" style="display:none;color: red;">*</span>               
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr /></td>
            </tr>
            <tr>
                <td align="right" style="padding-left: 80%">
                    <input type="reset" value="Limpiar" name="reset"/>
                </td>

            </tr>
            <tr>
                <td align="right" style="padding-left: 80%">                
                    <!--
                        <input type="button" onclick="AdministrarValidaciones()" value="Enviar" /> 
                    -->
                    <!--
                        <input type="submit" value="Enviar" /> 
                    -->
                    <input type="hidden" name="hdnModificar" id="hdnModificar" value=<?php echo (isset($_POST["dniHidden"])) ? "ok" : "no"?>>
                    <input type="submit" onclick="AdministrarValidaciones()" value=<?php echo (isset($_POST["dniHidden"])) ? "Modificar" : "Enviar";?> />                   
                </td>
            </tr>
            
        </table>

    </form>
</body>
</html>