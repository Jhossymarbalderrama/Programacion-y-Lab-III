<?php
/*
Aplicación No 11 (Carga aleatoria)
Imprima los valores del vector asociativo siguiente usando la estructura de control foreach:
$v[1]=90; $v[30]=7; $v['e']=99; $v['hola']= 'mundo';
*/

$v[1]=90; 
$v[30]=7; 
$v['e']=99; 
$v['hola']= 'mundo';

//var_dump($v);

echo "<h2>11 - Vector Asociativo - FOREACH</h2>";
foreach ($v as $value) {
	echo "<li><b>Valor:</b> ".$value . "<br>";
}


?>