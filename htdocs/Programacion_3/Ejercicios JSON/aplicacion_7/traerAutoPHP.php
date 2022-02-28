<?php
    $a = fopen("./archivo/auto.json","r");

    $linea = '';
    while(!feof($a)){
    
        $linea .= fgets($a);
    }
    
    fclose($a);
    $equipos = json_decode($linea);

    var_dump($equipos);
?>