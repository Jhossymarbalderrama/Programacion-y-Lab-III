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
    
   
    <script type="text/javascript" src="./javascript/app.js"></script>
    <script type="text/javascript" src="./javascript/ajax.js"></script>
    <script type="text/javascript" src="./javascript/login.js"></script>
    <script type="text/javascript" src="./javascript/validaciones.js"></script>
</head>
<body>

        <div class="container" style="width:auto; height:auto" align="center">
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
                      
                    </tbody>                                  
                </table>                                              
            </div>                  
        </div>
          

</body>
</html>
