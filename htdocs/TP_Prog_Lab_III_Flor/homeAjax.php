<?php
    require_once "./BackEnd/validarSesion.php";
    VerificarSesion("./login.html");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="./javascript/ajax.js"></script>
    <script src="./javascript/app.js"></script>
    <script src="./javascript/validaciones.js"></script>

</head>
<body>
    <div class="container">
        <table style="margin: 50px auto; border-collapse:collapse;">
            <tr>
                <td colspan="2" style="border:1px solid black;">
                    <h1 style="text-align:center;">Florencia Colodro</h1>
                </td>
            </tr>
             
            <tr>
                <td style="border:1px solid black;padding:20px;">
                    <div id="idAltaEmpleado"></div>
                </td>     
    
                <td style="border:1px solid black;padding:20px;">
                    <div id="idMostrarEmpleados"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border:1px solid black;padding:20px;text-align:left;font-size:20px;font-weight:bold;">
                    <a style="color:black;" href="./BackEnd/cerrarSesion.php">Cerrar Sesion</a>
                </td>
            </tr>
        </table>
    </div>



</body>
</html>