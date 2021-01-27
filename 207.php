<?php

session_start();

//INICIALISACION VARIABLES
$mensaje = $precio = $titulo = $isbn = null;

//array para guardar los libros
$array_libros = [];

//assign data to arrray libros from session 
if (isset($_SESSION['libros'])) {
	$array_libros = $_SESSION['libros'];
}

if (isset($_POST['alta'])) {
	//RECUPERAR DATOS
	$titulo = trim($_POST['titulo']);
	$precio = trim($_POST['precio']);
	$isbn = trim($_POST['isbn']);

	try {

		//VALIDAR DATOS
		if (empty($titulo)) {
			throw new Exception("El titulo es obligatorio", 10);
		}
		if (empty($precio)) {
			throw new Exception("El precio es obligatorio", 11);
		}
		if (empty($isbn)) {
			throw new Exception("El ISBN numero es obligatorio", 12);
		}
		if (array_key_exists($isbn, $array_libros)) {
			throw new Exception("El ISBN ya existe en base de datos", 13);
		}

		//GUARDAR DATOS EN EL ARRAY LIBROS
		$array_libros[$isbn]['titulo'] = $titulo;
		$array_libros[$isbn]['precio'] = $precio;

		//MENSAJE: SUCCESS
		$mensaje = 'Alta efectuada';

		//LIMPIAR EL FORMULARIO
		$precio = $titulo = $isbn = null;
	} catch (Exception $e) {
		$mensaje = $e->getMessage() . ' ' . $e->getCode();
	}
}

//CONSULTA DE LIBROS

foreach ($array_libros as $key => $value){
	$table_libros .= "<tr>";
	$table_libros .= "<td>$key</td>";
	$table_libros .= "<td>$value[titulo]</td>";
	$table_libros .= "<td>$value[precio]</td>";
	$table_libros .= "<td></td>";
	$table_libros .= "<tr>";
}


//guardar los datos en el session_abort
$_SESSION['libros'] = $array_libros;


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style type="text/css">
		div.container {
			margin: auto;
			width: 920px;
			text-align: center;
		}

		table {
			border: 5px ridge blue;
			width: 800px;
		}

		th,
		td {
			background: white;
			width: auto;
			border: 2px solid green;
			text-align: left;
		}

		input[type=text] {
			width: 330px;
		}
	</style>
</head>

<body>
	<div class="container">
		<h2 style="text-align:center">EJERCICIO LIBRERIA</h2>
		<!-- este span es para mostrar los mensajes-->
		<span><?= $mensaje; ?></span><br><br>
		<form name="formularioalta" method="post" action="#">
			<table border='2'>
				<tr>
					<th>ISBN</th>
					<th>Título</th>
					<th>Precio</th>
					<th colspan='2' style='width:150px'>Opción</th>
				</tr>
				<tr>
					<td><input type='number' size='50' maxlenght='100' name='isbn' value="<?= $isbn ?>"></td>
					<td><input type='text' size='50' maxlenght='100' name='titulo' value="<?= $titulo ?>"></td>
					<td><input type='number' maxlenght='5' name='precio' step='0.1' value="<?= $precio ?>"></td>
					<td colspan='2'><input type='submit' name='alta' value='Agregar' /></td>
				</tr>
			</table>
		</form><br>
		<div>
			<table><?=$table_libros?></table>
		</div>
	</div>
	<form name=" formulario" id="formulario" method="post" action="#">
		<!--estos input hidden sirven para guardar la id del libro a modificar-->
		<input type="hidden" name="id" id="id">
		<input type="hidden" name="titulo" id="titulo">
		<input type="hidden" name="precio" id="precio">
		<input type="hidden" name="modificacion">
	</form>
</body>

<?= ("<pre>" . print_r($array_libros, true) . "</pre>") ?>;


</html>