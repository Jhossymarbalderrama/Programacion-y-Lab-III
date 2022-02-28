<?php
    include_once("./clases/ProductoEnvasado.php");

    $arrayFotos = ProductoEnvasado::MostrarModificados();
    
    foreach($arrayFotos as $foto)
    {
        echo "
        <table align='center'>
            <tr>
                <td>
                <img src= ./productosModificados/$foto alt=fotoProd width=50px height=50px>
                </td>
            </tr>
        </table>
        ";
    }
?>