<?php
    include_once("./backend/validarSesion.php");
    ValidarSession("./login.html");
?>

<!DOCTYPE html>
<html>
<head>
    <title>ABM</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!-- <script type="text/javascript" src="./javascript/ajax.js"></script>
    <script type="text/javascript" src="./javascript/app.js"></script> -->

    <link type="text/css" rel="stylesheet" href="css/estilos.css" />

    <script type="text/javascript" src="./javascript/app.js"></script>
    <script type="text/javascript" src="./javascript/ajax.js"></script>
    <script type="text/javascript" src="./javascript/login.js"></script>
    <script type="text/javascript" src="./javascript/validaciones.js"></script>
</head>
<body>
    <div id="contenedor-general">

        <div id="header" align="center">
            <h4 style="border:solid;width:100%;padding:10px; font-size: 25px;" align="left">Balderrama Jhossymar</h4>  
        </div>

        <div id="contenedor">            
            <div class="alta" id="divFrm" style="border-style:solid" align="center"></div>
            <div class="mostrar" id="divEmpleados" style="border-style:solid" align="center"></div> 
        </div>

        <div id="footer">      
            <div class="btnCerrarSesion">
                <!-- <input type='button' value="Cerrar Sesion" href="./backend/cerrarSesion.php"> -->
                <!-- Terminar esta wea -->
                <input type='button' value="Cerrar Sesion" onclick="('./backend/cerrarSesion.php')">
            </div>      
            <div class="btnAlta">
                <input type='button' value="Cambiar a Alta Empleado" onclick='window.onload()'>
            </div>           
        </div>
    </div>
       
       

        <!-- <div class="container" style="width:auto; height:auto" align="center">
            <div class="page-header">
            </div>
                <h4 style="border:solid;width:1400px;padding:10px; font-size: 25px;" align="left">Balderrama Jhossymar</h4>  
            <div>                            
                <table>
                    <tbody>
                        <tr>
                            <td>                                
                                <div id="divFrm" style="height:650px;width:400px;overflow:auto;border-style:solid">                           
                                </div>
                            </td>
                            <td>
                                <div id="divEmpleados"style="height:650px;width:1000px;overflow:auto;border-style:solid">                                
                                </div>  
                            </td>
                        </tr> 
                        <div>                
                                <td>
                                    <h6 style="display:block;border:solid;padding:10px;width:240px; font-size:20px" align="left">
                                        <a href="./backend/cerrarSesion.php">Cerrar sesion</a>                           
                                    </h6>    
                                </td>
                                <td>
                                    <h6 style="display:block;border:solid;padding:10px;width:240px; font-size:20px"align="left">
                                        <a onclick="window.onload()">Alta Empleado</a>                           
                                    </h6> 
                                </td>                         
                        </div>
                    </tbody>                                  
                </table>                                              
            </div>                  
        </div> -->
          

</body>
</html>
