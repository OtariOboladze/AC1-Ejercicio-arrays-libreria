//BAJA TODOS LOS LIBROS

document.querySelector("#button_baja").onclick = baja_libros;

function baja_libros() {
  if (confirm("estas seguro?")) {
    document.querySelector("#form_baja").submit();
  }
}


//ACTIVAR LISTENER DE LOS BOTONES DE MODIFICATION DE LIBROS

var botonesMod = document.querySelectorAll('.modificar');

botonesMod.forEach(function(item) {
  item.onclick = modificar_libros;
})

function modificar_libros(){

  let tr = this.closest('tr');

  let isbn = tr.querySelector('.isbn').innerText;
  let titulo = tr.querySelector('.titulo').innerText;
  let precio = tr.querySelector('.precio').innerText;

  document.querySelector('[name=isbn_mod]').value = isbn;
  document.querySelector('[name=titulo_mod]').value = titulo;
  document.querySelector('[name=precio_mod]').value = precio;

  document.querySelector('#formulario_mod').submit();

}
