<?php 
/*
Aplicación No 6 (Calculadora)
Escribir un programa que use la variable $operador que pueda almacenar los símbolos
matemáticos: ‘+’, ‘-’, ‘/’ y ‘*’; y definir dos variables enteras $op1 y $op2. De acuerdo al
símbolo que tenga la variable $operador, deberá realizarse la operación indicada y mostrarse el
resultado por pantalla.
*/

$operador = "+";

$op1 = 6;
$op2 = 3;

$resultado = 0;

switch ($operador) {
	case '-':
		$resultado = $op1 - $op2;
		break;
	case '*':
		$resultado = $op1 * $op2;
		break;
	case '/':
		$resultado = $op1 / $op2;
		break;
	default:
		$resultado = $op1 + $op2;
		break;
}

echo "<br><b>El resultado de la operacion $operador es: $resultado</b>";

?>