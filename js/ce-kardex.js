const Calificacion = {};

const getPrograma = async (programaId) => {
  try {
    return await $.ajax({
      type: 'POST',
      url: '../controllers/control-programa.php',
      dataType: 'json',
      data: {
        webService: 'consultarId',
        url: '',
        id: programaId,
      }
    })
  } catch (error) {
    console.log(error);
  }

} 

Calificacion.getCalificacionPorCiclo = async function () {
  const programaId =  document.getElementById('programa_id'); 
  const programa = await getPrograma(programaId.value);

	Calificacion.calificacionPromesa = $.ajax({
		type: 'POST',
		url: '../controllers/control-calificacion.php',
		dataType: 'json',
		data: {
			webService: 'consultarCalificacionPorAlumno',
			url: '',
			alumno_id: $('#alumno_id').val(),
      calificacion_aprobatoria: programa.data.calificacion_aprobatoria
		},
		success: function (data) {

      const creditosObtenidos = document.getElementById('creditos_obtenidos')
      creditosObtenidos.innerHTML = `${data.totalCreditos} de ${programa.data.creditos}`;

      const calificaciones = data.calificacionCiclo;
      
      let todasCalificaciones = [];

      for (const ciclo_escolar in calificaciones) {

        if (Object.hasOwnProperty.call(calificaciones, ciclo_escolar)) {

          const materias_ciclo = calificaciones[ciclo_escolar];

          materias_ciclo.sort((a, b) => {
            return a.consecutivo - b.consecutivo;
          })
          todasCalificaciones = todasCalificaciones.concat(materias_ciclo);
        }
      }

      Calificacion.tabla = $("#calificacionesKardex").DataTable({
        bDeferRender: true,
        sPaginationType: "full_numbers",
        data: todasCalificaciones,
        columns: [
          { data: "ciclo_escolar.nombre" },
          { data: "asignatura.clave" },
          { data: "asignatura.seriacion" },
          { data: "asignatura.nombre" },
          { data: "tipo_txt" },
          { data: "calificacion" },
          { data: "fecha_examen" },
        ],
        oLanguage: {
          sProcessing: "Procesando...",
          sLengthMenu:
            "Mostrar <select>" +
            '<option value="5">5</option>' +
            '<option value="10">10</option>' +
            '<option value="20">20</option>' +
            '<option value="30">30</option>' +
            '<option value="40">40</option>' +
            '<option value="-1">All</option>' +
            "</select> registros",
          sZeroRecords: "No se encontraron resultados",
          sEmptyTable: "Ningún dato disponible en esta tabla",
          sInfo:
            "Mostrando del (_START_ al _END_) de un total de _TOTAL_ registros",
          sInfoEmpty: "Mostrando del 0 al 0 de un total de 0 registros",
          sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
          sInfoPostFix: "",
          sSearch: "Filtrar:",
          sUrl: "",
          sInfoThousands: ",",
          sLoadingRecords: "Por favor espere - cargando...",
          oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior",
          },
          oAria: {
            sSortAscending:
              ": Activar para ordenar la columna de manera ascendente",
            sSortDescending:
              ": Activar para ordenar la columna de manera descendente",
          },
        },
      });

		},
		error: function (respuesta, errmsg, err) {
			console.log(respuesta.status + ': ' + respuesta.responseText);
		},
	});
};

$(document).ready(function ($) {
	Calificacion.getCalificacionPorCiclo();
	//Promesas que se deben de cumplir
	$.when(Calificacion.calificacionPromesa)
		//Si todas las promesas se realizaron
		.then(function () {
			//Se detiene el gif de cargando
			console.log('Las promesas de mis solicitudes :');
		})
		.done(function () {})
		//Si por lo menos una promesa falla
		.fail(function () {
			console.log('  Algo falló');
		});
});
