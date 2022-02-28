

<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Ingreso de PATH</title>
	</head>
	<body>
		<form action="ejercicio_26.php" method="POST" >
			<table align="center" >
			<tr>
				<td colspan="2"><h4>Ingrese Path:</h4></td>
			</tr>
			<tr>
				<td colspan="2"><hr /></td>
			</tr>
            <tr>
                <td>nombre ARCHIVO:</td>					
                <td  style="text-align:left;padding-left:15px">
                    <input type="text" id="PathUbicacion"  name="PathUbicacion" placeholder="Ingrese ubicacion..." /> 
                    <br>				
                </td>
            </tr>
				<td colspan="2"><hr /></td>
			</tr>

            <tr>
                <td>Texto En archivo:</td>					
                <td  style="text-align:left;padding-left:15px">
                    <input type="text" id="textArchivo"  name="textArchivo" placeholder="Ingrese texto..." /> 
                    <br>				
                </td>
            </tr>
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
                    <input  type="submit" name="submit" value="Enviar path" />
					<!--<input  type="button" onclick="copiarArchivo()" value="Enviar path" />-->
				</td>
			</tr>
		</table>
	</form>
	</body>
</html>