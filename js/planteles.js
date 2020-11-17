var Planteles = {};

Planteles.getMunicipios = function(){
    Planteles.promesaMunicipios = $.ajax({
        type: "POST",
        url:"../controllers/control-municipio.php",
        dataType: "json",
        data:{webService:"consultarMunicipios",url:"",id_estado:"14"},
        success:function(municipios){
          var contenedor = document.getElementById("municipios");
          var select = document.getElementById("municipio");
          var municipiosOrdenados = [];
          for (var i = 0; i < municipios.data.length; i++) {
            municipiosOrdenados[i] = municipios.data[i].municipio;
          }
          municipiosOrdenados.sort();

          for (var j = 0; j < municipiosOrdenados.length; j++) {
            //console.log(municipiosOrdenados[i].municipio);
            var option = document.createElement('option');
            option.text = municipiosOrdenados[j];
            option.value = municipiosOrdenados[j];
            select.add(option);
          }
          contenedor.appendChild(select);
        },
        error:function(xhr, textStatus, err) {
            var jsonError = {error: textStatus + ' ' + xhr.status};
            console.log(jsonError);
        }
      });
};

Planteles.cargarGestores =function(){
    Planteles.promesaGestores =   $.ajax({
        type: "POST",
        url: "../controllers/control-usuario.php",
        dataType : "json",
        data : {webService:"gestoresPorAsignar",url:"",usuario_id:$('#id_usuario').val()},
        success:function(respuesta){
          var select = document.getElementById('gestor');
          if(respuesta.data != 'No se han registrado gestores'){

            for (var i = 0; i < respuesta.data.length; i++) {
              var option = document.createElement('option');
              option.text = respuesta.data[i].persona[0].nombre+" "+respuesta.data[i].persona[0].apellido_paterno+" "+respuesta.data[i].persona[0].apellido_materno;
              option.value = respuesta.data[i].persona_id;
              select.add(option);
            }
          }else{
            $('#textoInicial').html("Agrege gestores");
            $('#textoInicial').val("");
            $("#gestor").attr("disabled",true);
          }
        },
        error: function(respuesta,errmsg,err){
          console.log(respuesta.status + ": " + respuesta.responseText);
        }
      });
};

Planteles.getInformacion = function(){
    Planteles.promesaInformacion =   $.ajax({
        type: "POST",
        url: "../controllers/control-plantel.php",
        dataType : "json",
        data : {webService:"consultarId",url:"",id:$('#id').val()},
        success:function(respuesta){
          if(respuesta.status==404){
            window.location.replace("http://localhost/siiga/views/institucion-planteles.php");
          }else {
            var domicilio = respuesta.data.domicilio.data[0];
            $("#domicilio_id").val(domicilio.id);
            $("#numero_exterior").val(domicilio.numero_exterior);
            $("#calle").val(domicilio.calle);
            $("#numero_interior").val(domicilio.numero_interior);
            $("#colonia").val(domicilio.colonia);
            $("#codigo_postal").val(domicilio.codigo_postal);
            $("#municipio option[value='"+domicilio.municipio+"']").attr("selected",true);
            $("#coordenadas").val(domicilio.latitud+","+domicilio.longitud);
            $("#longitud").val(domicilio.longitud);
            $("#latitud").val(domicilio.latitud);
            console.log($("#coordenadas").val(domicilio.latitud+","+domicilio.longitud));
            var plantel = respuesta.data;
            $("#plantel_id").val(plantel.id);
            $("#clave_centro_trabajo").val(plantel.clave_centro_trabajo);
            $("#email1").val(plantel.email1);
            $("#email2").val(plantel.email2);
            $("#email3").val(plantel.email3);
            $("#telefono1").val(plantel.telefono1);
            $("#telefono2").val(plantel.telefono2);
            $("#telefono3").val(plantel.telefono3);
            $("#redes_sociales").val(plantel.redes_sociales);
            $("#paginaweb").val(plantel.paginaweb);
            if ( respuesta.data.rector ) {
              var rector = respuesta.data.rector.data[0];
              $("#rector_id").val(rector.id);
              $("#nombre_rector").val(rector.nombre);
              $("#apellido_materno_rector").val(rector.apellido_materno);
              $("#apellido_paterno_rector").val(rector.apellido_paterno);
            }
            var director = respuesta.data.director.data[0];
            $("#director_id").val(director.id);
            $("#nombre").val(director.nombre);
            $("#apellido_materno").val(director.apellido_materno);
            $("#apellido_paterno").val(director.apellido_paterno);
          }
        },
        error: function(respuesta,errmsg,err){
          console.log(respuesta.status + ": " + respuesta.responseText);
        }
      });
};

$(document).ready(function ($) {
  Planteles.getMunicipios();
  Planteles.getInformacion();
  $.when(Planteles.promesaMunicipios,Planteles.promesaInformacion)
  .then(function(){
    console.log( ' Promesas completadas para alta solicitud' );

  })
  .done(function(){
    console.log('Todo listo para cargar la informacion necesaria');
    document.getElementById("cargando").style.display = "none";

  })
  .fail(function(){
      console.log("Pero algo fallo");
    });
});


// function coordenadas() {
//     var direccion = $('#calle').val()+" "+ $('#numero_exterior').val()+" "+$('#colonia').val()+" "+$('#codigo_postal').val();
//     console.log(direccion);
//     L.esri.Geocoding.geocode().text(direccion).run(function(err, results, response){
//     if(results.results[0].latlng){
//       console.log(results.results[0].latlng);
//       var latitud = results.results[0].latlng.lat;
//       var longitud = results.results[0].latlng.lng;
//       $('#latitud').val(latitud);
//       $('#longitud').val(longitud);
//       $('#coordenadas').val(longitud+", "+latitud);
//     }
//     });
// }
