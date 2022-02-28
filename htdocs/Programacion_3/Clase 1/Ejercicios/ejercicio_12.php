<?php
/*
Aplicación No 12 (Arrays asociativos)
Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’. Crear, cargar y mostrar tres
lapiceras.
*/

 //ARRAY Asociativo - se utilizan cuando trabajas con BD

/*
//harcodeo
$lapicera = array(
	array('color' => "rojo",'marca' => "Bic",'trazo' => "fino",'precio' => 17.00),
	array('color' => "azul",'marca' => "Faber-Castell",'trazo' => "grueso",'precio' => 22.00),
	array('color' => "verde",'marca' => "Prisma",'trazo' => "fino",'precio' => 15.50),);


foreach ($lapicera as $lapis => $value) {
	echo "<strong>" . $lapis+1 . " - Lapis: "."</strong><br>";
	foreach($value as $key => $conten)
	{
		echo "<li>".$key." = ".$conten . "<br>";
	}
}

*/

//CREO
$lapicera = array();

$lapis_1  = array('color' => "rojo",'marca' => "Bic",'trazo' => "fino",'precio' => 17.00);
$lapis_2  = array('color' => "azul",'marca' => "Faber-Castell",'trazo' => "grueso",'precio' => 22.00);
$lapis_3  = array('color' => "verde",'marca' => "Prisma",'trazo' => "fino",'precio' => 15.50);

//CARGO
array_push($lapicera, $lapis_1);
array_push($lapicera, $lapis_2);
array_push($lapicera, $lapis_3);


//MUESTRO
echo "<h2>12 - Vector Asociativo - FOREACH</h2>";
echo "<h3>Cartuchera</h3>";
foreach ($lapicera as $lapis => $value) {
	echo "<strong>" . $lapis+1 . " - Lapis: "."</strong><br>";
	foreach($value as $key => $conten)
	{
		echo "<li>".$key." = ".$conten . "<br>";
	}
}


//print_r($lapicera);
//var_dump($lapicera);

?>