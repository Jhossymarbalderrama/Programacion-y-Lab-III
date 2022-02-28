<?php
/*
Aplicación No 5 (Obtener el valor del medio)
Dadas tres variables numéricas de tipo entero $a, $b y $c, realizar una aplicación que muestre
el contenido de aquella variable que contenga el valor que se encuentre en el medio de las tres
variables. De no existir dicho valor, mostrar un mensaje que indique lo sucedido.
Ejemplo 1: $a = 6; $b = 9; $c = 8; => se muestra 8.
Ejemplo 2: $a = 5; $b = 1; $c = 5; => se muestra un mensaje “No hay valor del medio”
*/

$a = 6;
$b = 9;
$c = 5;

/*
$a = 5;
$b = 1;
$c = 5;
*/

$vec = array($a,$b,$c);

sort($vec);

if($a !== $b && $a !== $c && $b !== $c)
{
	echo "<br><b>El valor Intermedio es:</b> " . $vec[1];
}else{
	echo "<br><b>No hay valor del Medio. </b>";	
}


?>