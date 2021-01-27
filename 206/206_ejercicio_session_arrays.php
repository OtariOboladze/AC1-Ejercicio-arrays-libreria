<?php
	session_start();

	//inicialización de variables
	$mensajes = $nif = $nombre = $direccion = $filasTabla = null;

	//array para guardar las personas
	$arrayPersonas = [];

	//si existe la variable de sesión substituyo el contenido del array
	if (isset($_SESSION['personas'])) {
		$arrayPersonas = $_SESSION['personas'];
	}

	//ALTA DE PERSONA
	if (isset($_POST['alta'])) {
		//recuperar los datos sin espacios en blanco -trim()-
		$nif 		= trim($_POST['nif']);
		$nombre 	= trim($_POST['nombre']);
		$direccion 	= trim($_POST['direccion']);

		try {
			//validar datos obligatorios
			validarDatos($nif, $nombre, $direccion);

			//validar que el nif no exista en la base de datos
			if (array_key_exists($nif, $arrayPersonas)) {
				throw new Exception("El nif ya está asociado a otra persona", 13);
			}

			//guardar la persona en el array
			$arrayPersonas[$nif]['nombre'] = $nombre;
			$arrayPersonas[$nif]['direccion'] = $direccion;

			//mensaje de alta efectuada
			$mensajes = 'Alta efectuada';

			//limpiar el formulario
			$nif = $nombre = $direccion = null;
		} catch (Exception $e) {
			$mensajes = $e->getCode().' '.$e->getMessage();
		}
	}

	//BAJA DE TODAS LAS PERSONAS
	if (isset($_POST['baja'])) {
		//inicializar el array
		$arrayPersonas = [];
	}

	//BAJA DE LA PERSONA SELECCIONADA EN LA TABLA
	if (isset($_POST['bajaPersona'])) {
		//recuperar el nif
		$nifBaja = $_POST['nif'];

		try {
			//validar nif informado
			if (empty($nifBaja)) {
				throw new Exception("Nif obligatorio", 10);
			}

			//borrar la fila del array
			unset($arrayPersonas[$nifBaja]);

			//mensaje de baja efectuada
			$mensajes = 'Baja efectuada';
		} catch (Exception $e) {
			$mensajes = $e->getCode().' '.$e->getMessage();
		}
		
	}

	//MODIFICACION DE LA PERSONA SELECCIONADA
	if (isset($_POST['modificar'])) {
		//recuperar los datos sin espacios en blanco -trim()-
		$nifModi		= trim($_POST['nifModi']);

		//Con el filtro FILTER_SANITIZE_SPECIAL_CHARS se escapan caracteres HTML '"<>& y caracteres con valores ASCII menores que 32 (los espacios en blanco del innerText de la etiqueta <td> vienen codificados con la entidad html &nbsp)
		$nombreModi		= trim(filter_input(INPUT_POST, 'nombreModi', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH));
		$direccionModi		= trim(filter_input(INPUT_POST, 'direccionModi', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH));

		//echo "datos: $nifModi / $nombreModi / $direccionModi";

		try {
			//validar datos
			validarDatos($nifModi, $nombreModi, $direccionModi);

			//validar que el nif no exista en la base de datos
			if (!array_key_exists($nifModi, $arrayPersonas)) {
				throw new Exception("El nif no existe en la base de datos", 14);
			}

			//modificar la persona en el array
			$arrayPersonas[$nifModi]['nombre'] = $nombreModi;
			$arrayPersonas[$nifModi]['direccion'] = $direccionModi;

			//mensaje de modificación efectuada
			$mensajes = 'Modificación efectuada';

		} catch (Exception $e) {
			$mensajes = $e->getCode().' '.$e->getMessage();
		}
	}

	//CONSULTA DE PERSONAS
	foreach ($arrayPersonas as $nifArray => $columnasArray) {
		$filasTabla .= "<tr>";
		$filasTabla .= "<td class='nif'>$nifArray</td>";
		$filasTabla .= "<td contenteditable class='nombre'>$columnasArray[nombre]</td>";
		$filasTabla .= "<td contenteditable class='direccion'>$columnasArray[direccion]</td>";
		$filasTabla .= "<td>";
		$filasTabla .= "<form method='post' action='#'>";
		$filasTabla .= "<input type='hidden' name='nif' value='$nifArray'>";
		$filasTabla .= "<input type='submit' name='bajaPersona' value='Baja'>";
		$filasTabla .= "</form>";
		$filasTabla .= "&nbsp&nbsp<input type='button' value='Modificar' class='modificar'>";
		$filasTabla .= "</td>";
		$filasTabla .= "</tr>";
	}

	//FUNCION DE VALIDACION DE DATOS COMUNES
	function validarDatos($nif, $nombre, $direccion) {
		try {
			//validar datos obligatorios
			if (empty($nif)) {
				throw new Exception("Nif obligatorio", 10);
			}
			if (empty($nombre)) {
				throw new Exception("Nombre obligatorio", 11);
			}
			if (empty($direccion)) {
				throw new Exception("Dirección obligatoria", 12);
			}
		} catch (Exception $e) {
			//relanzar la excepción
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	//volcar el contenido del array en la variable de sesión
	$_SESSION['personas'] = $arrayPersonas;

?>
<html>
<head>
	<title></title>
	<meta charset='UTF-8'>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>
	<div class='wraper'>
		<form method='post' action='#'>
			<label>NIF</label>
			<input type='text' name='nif' value="<?=$nif?>"><br>
			<label>Nombre</label>
			<input type='text' name='nombre' value="<?=$nombre?>"><br>
			<label>Dirección</label>
			<input type='text' name="direccion" value='<?=$direccion?>'><br>
			<input type='submit' name='alta' value='alta persona'>
			<span><?=$mensajes?></span>
		</form><br><br>
		<table>
			<tr><th>NIF</th><th>Nombre</th><th>Dirección</th><th></th></tr>
			<?=$filasTabla?>
		</table><br>
		<form method='post' action='#' id='formularioBaja'>
			<input type='hidden' name='baja'></input>
			<input type='button' value='baja personas' id='baja'>
		</form>
		<!--FORMULARIO OCULTO PARA LA MODIFICACION-->
		<form method='post' action='#' id='formularioModi'>
			<input type='hidden' name='nifModi'>
			<input type='hidden' name='nombreModi'>
			<input type='hidden' name="direccionModi">
			<input type='hidden' name='modificar'>
		</form>
	</div>
	<script type="text/javascript" src='js/scripts.js'></script>
</body>
</html>
<?php echo("<pre>".print_r($arrayPersonas,true)."</pre>"); ?>