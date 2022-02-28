
<?php 
/*
Aplicación No 4 (Sumar números)
Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no
supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
se sumaron.
*/

//$valor_1 : 1000;
//$contador = 0;

/*
for($i = 1; $i <= 999;$i++)
{
	for($k = 1; $k <= 999; $k++)
	{
		$suma = $i+$k;
		if($suma <= 1000)
		{
			$contador++;
			echo "$contador - Primer valor: " . $i;
			echo " - Segundo valor: " . $k;
			echo " - Resultado $i + $k: " . $suma . "<br>";					
		}
	}
}
*/

$suma = 0;
$contador = 0;

for($i = 1; $i < 1000;$i++)
{
	if(($suma + $i) <= 1000)
	{
		$contador++;
		
		echo "$contador - ";
		echo " - Resultado $i + $suma =  ";	
		$suma = $suma + $i;				
		echo $suma . "<br>";
	}
}


?>