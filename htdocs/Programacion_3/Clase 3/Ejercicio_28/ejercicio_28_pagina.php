

<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Ingreso de PATH</title>

	</head>
	<body>
		<form action="ejercicio_28.php" method="POST" >
			<table align="center" >
			<tr>
				<td colspan="2"><h4>Ingrese Dato a Encriptar:</h4></td>
			</tr>
			<tr>
				<td colspan="2"><hr /></td>
			</tr>
			<tr>
                <td>PATH DE ARCHIVO:</td>					
                <td  style="text-align:left;padding-left:15px">
                    <input type="text" id="textPath"  name="textPath" placeholder="Ingrese el Path..." /> 
                    <br>				
                </td>
    
            </tr>
            <tr>
                <td>Texto a Encriptar:</td>					
                <td  style="text-align:left;padding-left:15px">
                    <input type="text" id="textEncriptar"  name="textEncriptar" placeholder="Ingrese texto..." /> 
                    <br>				
                </td>
    
            </tr>
				<td colspan="2"><hr /></td>
			</tr>

			<tr>
				<td colspan="2" align="right">
					<input type="reset" value="Limpiar" />
				</td>
			</tr>

			<tr>
				<td colspan="2" align="right">
                    <input  type="submit" name="submit" value="Encriptar" />
					<!--<input  type="button" onclick="copiarArchivo()" value="Enviar path" />-->
				</td>
			</tr>
		</table>
	</form>
	</body>
</html>