
<?php

/*
     Aplicación No 28 (Encriptar / Desencriptar archivos)
    -Crear una página web que permita encriptar mensajes 
    -y que se guarden en un archivo de texto
    y que sólo si se lee el archivo desde la página se podrá acceder a su texto claro, es decir se
    desencriptará.
    
    Crear la clase Enigma, la cual tendrá la funcionalidad de encriptar/desencriptar los mensajes.

    

    Su método estático Encriptar, recibirá un mensaje y a cada número del código ASCII de cada
    carácter del string le sumará 200. 
    
    Una vez que cambie todos los caracteres, lo guardará en un
    archivo de texto (el path también se recibirá por parámetro). 
    
    Retornará TRUE si pudo guardar correctamente el archivo encriptado, FALSE, caso contrario.

    El método estático Desencriptar, recibirá sólo el path de dónde se leerá el archivo. 
    
    Realizar el proceso inverso para restarle a cada número del código ASCII de cada carácter leído 200, para
    poder retornar el mensaje y ser mostrado desesncriptado.
*/



    class  Enigma
    {

        public static function Encriptar($msj_No_Encript){
            $cadenaEncript = "";

            for ($i=0; $i < strlen($msj_No_Encript); $i++) { 
               $cadenaEncript .= ord($msj_No_Encript[$i]) +200;
            }
            return $cadenaEncript;
         }



        public static function DesEncriptar($path_Encriptado){
            $path_string_Encriptado = file_get_contents($path_Encriptado);  //La cantidad de letras que hay en el txt(incluye los vacios)
            $array_letras = array();  //instancio un array 
            $CadenaMensaje_DesEncript = ""; //variable que sera de contenedor del desencriptamiento (texto original RETURN)
            $cadenaDeNumeros = " "; //variable usada para guardar los numeros de 3 digitos del archivo, segun una condicion y luego pusharlo dentro de un array 

            //Recorre el string de Numeros encriptado (ASCII), y meto los script de 3 digitos en un array
            for ($i=0; $i < strlen($path_string_Encriptado); $i++) 
            {    
                if(($i+1)%3 == 0){
                    array_push($array_letras,intval(($cadenaDeNumeros . $path_string_Encriptado[$i]))-200);
                    $cadenaDeNumeros = " ";
                }else{
                    $cadenaDeNumeros .= $path_string_Encriptado[$i];
                }
            }

            /*
            echo "<br>";
            var_dump($array_letras);
            */

            //Recorro el array creado en el otro for, y por cada indice desencripto el numero, luego lo concateno en una variable
            for ($i=0; $i < sizeof($array_letras); $i++) { 
                $CadenaMensaje_DesEncript .= chr($array_letras[$i]);              
               //echo "<br>" . $CadenaMensaje_DesEncript;
            }

            return $CadenaMensaje_DesEncript;
        }
    }
    

    if(isset($_POST["submit"]) && !empty($_POST["submit"])){
        $path_Ingreso = $_POST["textPath"];
    }
    
    if(isset($_POST["submit"]) && !empty($_POST["submit"])){
        $textoAencriptar = $_POST["textEncriptar"];
    }
    
    $path_Ingreso .= ".txt";
    $archivo_path = fopen($path_Ingreso,"w");

    echo "<br><br><b>Funcion Encriptacion </b><br>";
    echo $textoAencriptar . "<br>";

    $enigma = new Enigma();
    $cadenaEncript = $enigma->Encriptar($textoAencriptar);
    echo $cadenaEncript;
    fwrite($archivo_path,$cadenaEncript);

    echo "<br><br><b>Funcion DesEncriptacion </b>";

    $CadenaDesEncriptada = $enigma->DesEncriptar($path_Ingreso);
    echo "<br>" ;
    echo $CadenaDesEncriptada;

    fclose($archivo_path);
    







    //ENCRIPTACION CON METODO MD5
    /*

    if(isset($_POST["submit"]) && !empty($_POST["submit"])){
        $texto = $_POST["textEncriptar"];
    }
    
    if(isset($_POST["submit"]) && !empty($_POST["submit"])){
        $textoLeer = $_POST["textLeer"];
    }


    //$text_encriptado = password_hash($texto,PASSWORD_DEFAULT);

    $text_encriptado =   md5($texto);
    //Creo el archivo con el texto que le llega desde el form
    $archivo_path = fopen("archivo.txt","w+");
    //fwrite($archivo_path,$texto);
    fwrite($archivo_path,$text_encriptado);

  
   if(!empty($textoLeer)){
    if(md5($texto) != fopen("archivo.txt","r")){
        echo "El Escript es: $textoLeer";
    }
   }else{
        echo "El Escript es: $text_encriptado";
   }

   fclose($archivo_path);
   */

?>