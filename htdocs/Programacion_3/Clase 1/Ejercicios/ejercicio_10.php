<?php 
/*
Aplicación No 10 (Mostrar impares)
Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números utilizando
las estructuras while y foreach.
*/

$array = array(1,3,5,7,9,11,13,15,17,19);

echo "<h2>Primeros 10 Numeros Impares con FOR</h2>";
for($i=0; $i <= 9 ; $i++) { 
	echo "<li><b>Numero:</b> ".$array[$i] . "<br>";
}


$i = 0;
echo "<h2>Primeros 10 Numeros Impares con WHILE</h2>";
while($i !== 10)
{
	echo "<li><b>Numero:</b> ".$array[$i] . "<br>";
	$i++;
}

echo "<h2>Primeros 10 Numeros Impares con FOREACH</h2>";
foreach ($array as $value) {
	echo "<li><b>Numero:</b> ".$value . "<br>";
}


?>