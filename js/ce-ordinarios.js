updateValueFloat = function (e) {
  const enteros = [1, 2, 3, 4, 5, 6, 7, 8, 9];
  enteros.map(function (entero) {
    if (entero === parseFloat(e.target.value)) {
      e.target.value = parseFloat(e.target.value).toFixed(1);
    }
  });
}

updateValueInt = function (e) {
  e.target.value = parseFloat(e.target.value).toFixed(0);
}

$gmx(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();

  let checkBox = document.getElementById("checkbox");
  checkBox.onclick = function () {
    if (checkBox.checked == true) {
      let inputsFecha = document.querySelectorAll(
        'input[name="fecha_examen[]"]'
      );
      let primerFecha = inputsFecha[0].value;
      for (let fecha of inputsFecha) {
        fecha.value = primerFecha;
      }
    }
  };

  const inputs = document.querySelectorAll("#calificaciones");
  const input = [];

  for (let i = 0; i < inputs.length; i++) {
    input.push(inputs[i].children[0]);
    if (input[i].step === "0.1") {
      input[i].addEventListener("change", updateValueFloat);
    } else {
      input[i].addEventListener("change", updateValueInt);
    }
  }
});
