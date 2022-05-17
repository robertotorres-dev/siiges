seleccionarListaAsignaturas = function () {
  if (checkBox.checked == true) {
    let checkBoxAsignaturas = document.querySelectorAll(
      'input[name="asignaturas_grado[]"]'
    );
    for (let asignatura of checkBoxAsignaturas) {
      asignatura.checked = true;
    }
  } else if (checkBox.checked == false) {
    let checkBoxAsignaturas = document.querySelectorAll(
      'input[name="asignaturas_grado[]"]'
    );
    for (let asignatura of checkBoxAsignaturas) {
      asignatura.checked = false;
    }
  }
};

$gmx(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();

  $("#generacion_fecha_inicio").datepicker({
    firstDay: 1,
    monthNames: [
      "Enero",
      "Febrero",
      "Marzo",
      "Abril",
      "Mayo",
      "Junio",
      "Julio",
      "Agosto",
      "Septiembre",
      "Octubre",
      "Noviembre",
      "Diciembre",
    ],
    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
    dateFormat: "yy-mm-dd",
  });

  $("#generacion_fecha_fin").datepicker({
    firstDay: 1,
    monthNames: [
      "Enero",
      "Febrero",
      "Marzo",
      "Abril",
      "Mayo",
      "Junio",
      "Julio",
      "Agosto",
      "Septiembre",
      "Octubre",
      "Noviembre",
      "Diciembre",
    ],
    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
    dateFormat: "yy-mm-dd",
  });
});

let checkBox = document.getElementById("checkbox_all");
checkBox.onclick = seleccionarListaAsignaturas;

function confirmarBaja() {
  if (
    confirm(
      "¿Desea eliminar el registro seleccionado?\nSe eliminarán asignaturas y calificaciones del alumno."
    )
  ) {
    return true;
  } else {
    return false;
  }
}
