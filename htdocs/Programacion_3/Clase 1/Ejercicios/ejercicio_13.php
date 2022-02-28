<?php
/*
Aplicación No 13 (Arrays asociativos II)
Cargar los tres arrays con los siguientes valores y luego ‘juntarlos’ en uno. Luego mostrarlo por
pantalla.

“Perro”, “Gato”, “Ratón”, “Araña”, “Mosca”
“1986”, “1996”, “2015”, “78”, “86”
“php”, “mysql”, “html5”, “typescript”, “ajax”

Para cargar los arrays utilizar la función array_push. Para juntarlos, utilizar la función
array_merge.
*/

//CREO
$animal  = array();
array_push($animal,"Perro");
array_push($animal,"Gato");
array_push($animal,"Ratón");
array_push($animal,"Araña");
array_push($animal,"Mosca");

//CREO
$año  = array();
array_push($año,"“1986”");
array_push($año,"“1996”");
array_push($año,"“2015”");
array_push($año,"“78”");
array_push($año,"“86”");

//CREO
$lenguaje = array();
array_push($lenguaje,"“php”");
array_push($lenguaje,"“mysql”");
array_push($lenguaje,"“html5”");
array_push($lenguaje,"“typescript”");
array_push($lenguaje,"“ajax”");

//LOS JUNTO
$array_result = array_merge($animal,$año,$lenguaje);

//MUESTRO
echo "<h2>13 - Vector Asociativo - FOREACH</h2>";
foreach ($array_result as $value) {
	echo "<li><b>Valor:</b> ".$value . "<br>";
}


?>