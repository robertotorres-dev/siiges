//Objeto guía
var CicloEscolar = {};

CicloEscolar.eliminarCicloEscolar = function (id, programa_id) {
	let btnConfirmar = document.getElementById('boton_confirmar');
	btnConfirmar.disabled = true;
	CicloEscolar.promesaEliminarCicloEscolar = $.ajax({
		type: 'POST',
		url: '../controllers/control-ciclo-escolar.php',
		dataType: 'json',
		data: {
			webService: 'eliminar',
			url: '',
			id,
		},
		success: function (respuesta) {
			window.location = `${window.location.pathname}?programa_id=${programa_id}&codigo=200`;
		},
		error: function (respuesta, errmsg, err) {
			console.log(respuesta);
		},
	});
};

CicloEscolar.modalEliminarCiclo = function (id, nombre_ciclo , programa_id) {
	CicloEscolar.promesaComprobarGrupos = $.ajax({
		type: 'POST',
		url: '../controllers/control-ciclo-escolar.php',
		dataType: 'json',
		data: {
			webService: 'comprobarGrupos',
			url: '',
			id: id,
		},
		success: function (respuesta) {
			$('#modalMensaje').modal();
			$('#tamanoModalMensaje').attr('style', 'margin-top:20px;');
			var mensajes = $('#mensajeGrupos');
			mensajes.addClass('alert alert-danger');

			if (respuesta.data.length > 0) {
				mensajes.html(
					`<p class='text-left'><strong>No es posible eliminar ciclos escolares con grupos activos.<br> 
          Favor de veririficar que no existan alumnos inscritos ni grupos activos dentro del ciclo escolar</strong></p>`
				);
			} else {
				mensajes.html(
					`<p class='text-left'><strong>¿Está seguro que desea eliminar el ciclo escolar ${nombre_ciclo} con id ${id}?</strong></p>`
				);

				var boton = $('<button/>', {
					id: 'boton_confirmar',
					type: 'button',
					class: 'btn btn-primary',
					text: 'SI',
					onclick: `CicloEscolar.eliminarCicloEscolar(${id}, ${programa_id})`,
				});

				let btnConfirmar = document.getElementById('boton_confirmar');
				if (btnConfirmar == null) {
					$('#mensaje-footer').append(boton);
				}
			}
		},
		error: function (respuesta, errmsg, err) {
			console.log(respuesta);
			console.log(err);
		},
	});
};
