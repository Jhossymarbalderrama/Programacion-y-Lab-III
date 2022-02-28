<?php

/*
    Aplicación No 25 (Contar letras)
    Se quiere realizar una aplicación que lea un archivo (../misArchivos/palabras.txt) y ofrezca
    estadísticas sobre cuantas palabras de 1, 2, 3, 4 y más de 4 letras hay en el texto. No tener en
    cuenta los espacios en blanco ni saltos de líneas como palabras.
    Los resultados mostrarlos en una tabla.
    

*/

/**
 * CON FUNCIONES
 */
/*
    function MostrarPalabras($indicador,$path)
    {

        $string = fgets($indicador, filesize($path));
        echo "Contenido de TXT: <br>";
        echo $string . "<br>" . filesize($path) . "<br>";

        
        StringACadena($string);
    }
    

    function StringACadena($String)
    {
        $contador = 0;
        $flag = false;
        for ($i=0; $i < strlen($String); $i++) { 

            $contador++;   
           if(ctype_space($String[$i]) == true)
           {               
               $flag = true;
           }else{
                echo $String[$i];
                if($i == strlen($String)-1)
                {
                    $flag = true;
                }
           } 

           if($flag){
               echo "    -  La cantidad de Letras es: ".($contador-1)." <br>";
               $flag = false;
               $contador = 0;
           }
           
        }    
    }
    

    
    $path = "./misArchivos/palabras.txt";
    $ar = fopen($path, "r");

  
    "<table> <tr><td>".MostrarPalabras($ar,$path)."</td></tr></table>";


    fclose($ar);
*/
    



/**
 * SIN FUNCIONES
 */
    //ARCHIVO
    $path = "./misArchivos/palabras.txt";
    $arch = fopen($path,"r");

    //Creo Array
    $statistics = array();

    //Ingreso al atributo Texto la cadena del TXT
    $texto = fread($arch,filesize($path));

    //STR REMPLACE VERIFICO LA SEPARACION DE LAS PALABRAS
    $texto = str_replace("?"," ",$texto);
    $texto = str_replace("¿"," ",$texto);
    

    //Convierte la codificación de caracteres de a de opcionalmente . Si es una matriz,todos sus valores de cadena se convertirán recursivamente.
    $texto = mb_convert_encoding($texto,"ASCII");
    $array = str_word_count($texto,1,"?");


    fclose($arch);

    
    foreach ($array as $key =>$value) {
      echo ($key+1)."- <b>".$value."</b> y los caracteres son: ".strlen($value)."<br>";
    }

?>