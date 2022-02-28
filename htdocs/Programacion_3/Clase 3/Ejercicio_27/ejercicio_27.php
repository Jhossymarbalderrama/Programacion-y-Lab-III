
<?php

/*
        Aplicación No 27 (Copiar archivos invirtiendo su contenido)
        Modificar el ejercicio anterior para que el contenido del archivo se copie de manera invertida,
        es decir, si el archivo origen posee ‘Hola mundo’ en el archivo destino quede ‘odnum aloH’.
*/


    $string_archivo = file_get_contents("./archivo_texto.txt");
    $string_rever = strrev($string_archivo);

    $archivo_path = fopen("archivo.txt","w+");
    fwrite($archivo_path,$string_rever);
    fclose($archivo_path);

?>