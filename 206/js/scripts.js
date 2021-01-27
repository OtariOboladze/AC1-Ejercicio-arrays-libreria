//activar listener del boton de baja de todas las personas
document.querySelector('#baja').onclick = bajaPersonas;

//activar listener de los botones de modificación de persona
var botonesModi = document.querySelectorAll('.modificar');

botonesModi.forEach(function(item) {
	item.onclick = modificarPersonas;
})

function bajaPersonas() {
	if (confirm("Estás seguro?")) {
		//submit del formulario
		document.querySelector('#formularioBaja').submit();
	}
}

function modificarPersonas() {
	//situarnos en la etiqueta tr que corresponda a la fila donde se encuentra el botón
	let tr = this.closest('tr');

	//recuperar los datos de la persona
	let nif = tr.querySelector('.nif').innerText;
	let nombre = tr.querySelector('.nombre').innerText;
	let direccion = tr.querySelector('.direccion').innerText;

	//alert(nif+' '+nombre+' '+direccion);

	//trasladar los datos al formulario oculto
	document.querySelector('[name=nifModi]').value = nif
	document.querySelector('[name=nombreModi]').value = nombre
	document.querySelector('[name=direccionModi]').value = direccion

	//submit del formulario
	document.querySelector('#formularioModi').submit();
}