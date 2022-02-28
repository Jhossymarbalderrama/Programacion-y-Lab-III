<?php 
/*
Aplicación No 9 (Carga aleatoria)
Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
función rand). Mediante una estructura condicional, determinar si el promedio de los números
son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
resultado.
*/

function r()
{
	$randomNumber = rand(0,10);
	return $randomNumber;
}

$array = array(r(),r(),r(),r(),r());
var_dump($array);
$totalSuma = 0;
$promedio = 0;

for($i = 0;$i <= 4;$i++)
{
	$totalSuma = $totalSuma + $array[$i];
}

$promedio = $totalSuma / 5;

if($promedio == 6)
{
	echo "<br><b>El numero es $promedio es igual</b>";
}else if($promedio > 6 && $promedio <= 10)
{
	echo "<br><b>El numero es $promedio es mayores</b>";
}else{
	echo "<br><b>El numero es $promedio es menores</b>";	
}
	

?>