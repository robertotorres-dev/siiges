function cargarOpcionesSelect(id_div,nombre_select) {
  var contenedor = document.getElementById(id_div);
  var select = document.getElementById(nombre_select);
  var municipiosOrdenados = [];
  var respuesta = $.ajax({
      type: "POST",
      url:"../controllers/control-municipio.php",
      dataType: "json",
      data:{webService:"consultarMunicipios",url:"",id_estado:14},
  });
  respuesta.done(function(municipios){
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
  });
  respuesta.fail(function(xhr, textStatus, err) {
  var jsonError = {
    error: textStatus + ' ' + xhr.status
  };
  console.log(jsonError);
  });

}
/*function coordenadas() {
    var direccion = $('#calle').val()+" "+ $('#numero_exterior').val()+" "+('#colonia')+" "+$('#codigo_postal').val();
    L.esri.Geocoding.geocode().text(direccion).run(function(err, results, response){
    if(results.results[0].latlng){
      console.log(results.results[0].latlng);
      var latitud = results.results[0].latlng.lat;
      var longitud = results.results[0].latlng.lng;
      $('#latitud').val(latitud);
      $('#longitud').val(longitud);
    }
    });
}*/
}


//Se cambio al final del archivo para mermitir cargar municipios
var gestores = $.ajax({
  type: "POST",
  url: "../controllers/control-usuario.php",
  dataType : "json",
  data : {webService:"gestoresPorAsignar",url:"",usuario_id:$('#id_usuario').val()},
  success:function(respuesta){
    var select = document.getElementById('gestor');
    /*if(respuesta.data != 'No se han registrado gestores'){
      for (var i = 0; i < respuesta.data.length; i++) {
        var option = document.createElement('option');
        option.text = respuesta.data[i].persona[0].nombre+" "+respuesta.data[i].persona[0].apellido_paterno+" "+respuesta.data[i].persona[0].apellido_materno;
        option.value = respuesta.data[i].persona_id;
        select.add(option);
      }
    }else {*/
      $('#textoInicial').html("Agregue gestores");
      $('#textoInicial').val("");
      $('#textoInicial').attr("disabled", true);
    //}
    cargarOpcionesSelect('municipios','municipio');
  },
  error: function(respuesta,errmsg,err){
    console.log(respuesta.status + ": " + respuesta.responseText);
  }

});
