<?php
/*
Aplicación No 14 (Arrays de Arrays)
Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
Arrays de Arrays.
*/

/**CARGA DE ARRAY ASOCIATIVO*/
	$array_principal = array();
	$array_animales = array();
	$array_año = array();
	$array_lenguaje = array();

	/**CREO LOS ARRAYS*/
	//CARGO ANIMALES - ARRAY
	$array_animales['animal'][0] = "Perro";
	$array_animales['animal'][1] = "Gato";
	$array_animales['animal'][2] = "Raton";

	//print_r($array_animales);

	//CARGO AÑO - ARRAY
	$array_año['año'][0] = 1986;
	$array_año['año'][1] = 1996;
	$array_año['año'][2] = 2015;

	//print_r($array_año);

	//CARGO LENGUAJES - ARRAY
	$array_lenguaje['lenguaje'][0] = "php";
	$array_lenguaje['lenguaje'][1] = "mysql";
	$array_lenguaje['lenguaje'][2] = "html5";

	//print_r($array_lenguaje);

	/**CARGO LOS ARRAYS AL PRINCIPAL*/

	array_push($array_principal,$array_animales);
	array_push($array_principal,$array_año);
	array_push($array_principal,$array_lenguaje);


	//print_r($array_principal);

	echo "<h2>14 - Vector Asociativo - FOREACH</h2>";
	foreach ($array_principal as $a => $value) {
		echo "<br><li><b>Elemento Nro " . $a+1 . "</b>";
		foreach($value as $b => $conten)
		{		
			foreach($conten as $c => $ed)
			{
				echo "<br>" . $c . " - " . $ed;
			}
		}
	}

/**CARGA DE ARRAY INDEXADO*/

	$animal  = array();
	array_push($animal,"Perro");
	array_push($animal,"Gato");
	array_push($animal,"Ratón");

	//CREO
	$año  = array();
	array_push($año,"“1986”");
	array_push($año,"“1996”");
	array_push($año,"“2015”");

	//CREO
	$lenguaje = array();
	array_push($lenguaje,"“php”");
	array_push($lenguaje,"“mysql”");
	array_push($lenguaje,"“html5”");

	$array_principal_index = array($animal,$año,$lenguaje);

	echo "<h2>14 - Vector INDEXADO - FOREACH</h2>";
	foreach ($array_principal_index as $key => $value) {
		echo "<li>Indice Principal = " . $key . "<br>";
		foreach($value as  $key_2 => $conten)
		{
			echo $key_2 . " : ".$conten . "<br>";
		}
	}

?>