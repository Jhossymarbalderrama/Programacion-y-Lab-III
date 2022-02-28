
<?php

/*
    Aplicación No 26 (Copiar archivos)
    Generar una aplicación que sea capaz de copiar un archivo de texto 
    (su ubicación se ingresará por la página)
    
    hacia otro archivo que será creado y alojado en
    ./misArchivos/yyyy_mm_dd_hh_ii_ss.txt, dónde yyyy corresponde al año en curso, mm
    al mes, dd al día, hh hora, ii minutos y ss segundos.
*/

    //Obtener el paht mediante GET
    if(isset($_GET["submit"]) && !empty($_GET["submit"])){
        $ubicacion = $_GET["PathUbicacion"];
        //echo "<b>" . $ubicacion . "</b>";
    }

    //Obtener el paht mediante POST
    if(isset($_POST["submit"]) && !empty($_POST["submit"])){
        $ubicacion = $_POST["PathUbicacion"];
        //echo "<b>" . $ubicacion . "</b>";
    }

    
    if(isset($_POST["textArchivo"]) && !empty($_POST["textArchivo"])){
        $textoArchivo = $_POST["textArchivo"];
        //echo "<b>" . $ubicacion . "</b>";
    }
    


    $pathDestino = "./misArchivos/";
    //path del archivo que voy a crear o va ser nuevo
    $ubicacion = $ubicacion . ".txt";
    $indicador_arch = fopen(($ubicacion),"a"); // Creo el archivo o lo abro
    //fwrite($indicador_arch," Hola escribo desde PHP"); //Escribo el archivo
    fwrite($indicador_arch,$textoArchivo);
    fclose($indicador_arch);//Cierro el archivo

    $pathDestino .= armarNombreArhivo_Date();


    if(copy($ubicacion,$pathDestino)){
        echo "Se copio el archivo: <b>$ubicacion</b> al archivo  <b>$pathDestino<b/>";

        $indic_nueArchivo = fopen(($pathDestino),"a");
        fwrite($indic_nueArchivo,"\nHola escribo desde PHP"); //Escribo el archivo
        fclose($indic_nueArchivo);
    }

    function armarNombreArhivo_Date()
    {
        //$DateAndTime = date('m-d-Y h:i:s a', time());
        //$pathDestino = "./misArchivos/yyyy_mm_dd_hh_ii_ss.txt";

        return date("Y") . "_" . date("m") . "_" . date("d") . "_" . date("H") . "_" . date("i") . "_" . date("s") . "_.txt";
        //return parse_str($DateAndTime) . ".txt";
    }

?>