//BAJA TODOS LOS LIBROS

document.querySelector("#button_baja").onclick = baja_libros;

function baja_libros() {
  if (confirm("estas seguro?")) {
    document.querySelector("#form_baja").submit();
  }
}
