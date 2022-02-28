<?php
    session_start();
    
    function ValidarSession($path)
    {
        if($_SESSION["DNIEmpleado"] == false)
        {
            header("Location: $path");
        }
    }


?>