<?php
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style type="text/css">
		div.container {margin: auto; width:920px; text-align:center;}
		table {border: 5px ridge blue;width: 800px;}
		th, td {background:white; width:auto; border: 2px solid green; text-align: left;}
		input[type=text] {width: 330px;}
	</style>
</head>
<body>
	<div class="container">
		<h2 style="text-align:center">EJERCICIO LIBRERIA</h2>
		<!-- este span es para mostrar los mensajes-->
		<span></span><br><br>
		<form name="formularioalta" method="post" action="#">
			<table border='2'>
				<tr><th>Título</th><th>Precio</th><th colspan='2' style='width:150px'>Opción</th></tr>
				<tr>
				<td><input type='text' size='50' maxlenght='100' name='titulo'></td>
				<td><input type='number' maxlenght='5' name='precio' step = '0.1'></td>
				<td colspan='2'><input type='submit' name='alta' value='Agregar' /></td>
				</tr>
			</table>
		</form><br>
		<div>
			<table></table>
		</div>
	</div>
	<form name="formulario" id="formulario" method="post" action="#"> 
		<!--estos input hidden sirven para guardar la id del libro a modificar-->
		<input type="hidden" name="id" id="id">
		<input type="hidden" name="titulo" id="titulo">
		<input type="hidden" name="precio" id="precio">
		<input type="hidden" name="modificacion">
	</form>
</body>
</html>