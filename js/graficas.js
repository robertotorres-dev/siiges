var Grafica = {};

Grafica.getInstituciones = function(){
  Grafica.InstitucionesPromesa = $.ajax({
    type: "POST",
    dataType: "json",
    url: "../controllers/control-institucion.php",
    data: {webService:"consultarTodos",url:""},
    success: function(respuesta){
        if(respuesta.data.length>0)
        {
          var instituciones = respuesta.data;
          var slc = $("#instituciones");
          for (var m = 0; m < instituciones.length; m++) {
            slc.append('<option value ="'+instituciones[m].id+'">'+instituciones[m].nombre+'</option>');
          }
        }
      },
    error : function(respuesta,errmsg,err) {
       console.log(respuesta.status + ": " + respuesta.responseText);
     }
  });
};

Grafica.lib = google.charts.load('current', {'packages':['corechart']});

Grafica.construir = function(grafica){
  google.charts.setOnLoadCallback(grafica);
};

Grafica.opcionesConsulta = function(){
  var opcion = $("#opcionGrafica").val();
  if(opcion==2)
  {
    $("#informacionInstitucion").attr("style","display:block");
  }
  if(opcion==1 || opcion==3)
  {
    $("#informacionInstitucion").attr("style","display:none");
  }
};

Grafica.solicitar = function(){
  var opcion = $("#opcionGrafica").val();
  var idinstitucion = $("#instituciones").val();
  var opcionInstitucion = $("#institucionesOpciones").val();

  if(opcion==1)
  {
    Grafica.solicitudesEstatus();
  }
  if( opcion == 2 && idinstitucion >= 1 && opcionInstitucion >= 1)
  {
    Grafica.solicitudesInstitucion(idinstitucion,opcionInstitucion);
  }
  if(opcion==3)
  {
    Grafica.optionSolicitudes();
  }

};


Grafica.solicitudes = function(){
  $.ajax({
        url: '../controllers/control-solicitud.php',
        type: 'POST',
        data: {webService:"numeroSolicitudes",url:""},
        dataType: 'JSON',
        success: function(respuesta) {
          var solicitudes = respuesta.data;
          var nproceso = 0;
          var nterminadas = 0;
          var nrechazadas = 0;
          if(solicitudes.proceso!=null){nproceso = solicitudes.proceso;}
          if(solicitudes.terminadas!=null){nterminadas = solicitudes.terminadas;}
          if(solicitudes.rechazadas!=null){nrechazadas = solicitudes.rechazadas;}
          console.log(nproceso);
          var data = google.visualization.arrayToDataTable([
            ['Equiteta', 'Cantidad'],
            ['En proceso',nproceso],
            ['Completadas',nterminadas],
            ['Rechazadas',nrechazadas]
          ]);
          var options = {
              width: 800,
              height: 600,
              // legend: 'none',
              fontSize: "20",
              chartArea:{left:20,top:20,width:'100%',height:'100%'},
              slices: {0: {color: 'YellowGreen'}, 1: {color: "SeaGreen"},2: {color: "#FF6347"}}
          };
          var chart = new google.visualization.PieChart(document.getElementById('areaGraficas'));
          chart.draw(data, options);
        }
    });

};

Grafica.optionSolicitudes = function(){
  $.ajax({
        url: '../controllers/control-solicitud.php',
        type: 'POST',
        data: {webService:"numeroSolicitudes",url:""},
        dataType: 'JSON',
        success: function(respuesta) {
          var solicitudes = respuesta.data;
          var nproceso = 0;
          var nterminadas = 0;
          var nrechazadas = 0;
          if(solicitudes.proceso!=null){nproceso = solicitudes.proceso;}
          if(solicitudes.terminadas!=null){nterminadas = solicitudes.terminadas;}
          if(solicitudes.rechazadas!=null){nrechazadas = solicitudes.rechazadas;}
          $("#tituloGrafica").html("Solicitudes al momento");
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Estatus');
          data.addColumn('number', 'Solicitudes');
          data.addRows([["Proceso", nproceso]]);
          data.addRows([["Completadas", nterminadas]]);
          data.addRows([["Rechazadas", nrechazadas]]);

          var options = {
              width: 800,
              height: 600,
              // legend: 'none',
              fontSize: "22",
              chartArea:{left:20,top:20,width:'100%',height:'100%'},
              slices: {0: {color: 'YellowGreen'}, 1: {color: "SeaGreen"},2: {color: "#FF6347"}}
          };
          var chart = new google.visualization.PieChart(document.getElementById('areaGraficas'));
          chart.draw(data, options);
        }
    });

};

Grafica.solicitudesEstatus = function(){
  $.ajax({
        url: '../controllers/control-solicitud.php',
        type: 'POST',
        data: {webService:"numeroSolicitudesEstatus"},
        dataType: 'JSON',
        success: function(respuesta) {
          $("#tituloGrafica").html("Solicitudes por estatus");
          var jsonData = respuesta.data;
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Estatus');
          data.addColumn('number', 'Solicitudes');
          $.each(jsonData, function(i, jsonData){
              var estatus = jsonData.estatus;
              var cantidad = parseInt(jsonData.cantidad);
              data.addRows([[estatus, cantidad]]);
          });
          var options = {
            width: 800,
            height: 600,
            fontSize: "20",
            chartArea:{width:'100%',height:'100%'}
          };
          var chart = new google.visualization.PieChart(document.getElementById('areaGraficas'));
          chart.draw(data, options);
        }
    });
};

Grafica.solicitudesInstitucion=function(institucion,opcion){
  $.ajax({
        url: '../controllers/control-institucion.php',
        type: 'POST',
        data: {webService:"solictiudesInstitucion",url:"",id:institucion,filtro:opcion},
        dataType: 'JSON',
        success: function(respuesta) {
          console.log(respuesta);
          $("#tituloGrafica").html("Solicitudes de "+ respuesta.institucion);
          var jsonData = respuesta.data;
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Estatus');
          data.addColumn('number', 'Solicitudes');
          $.each(jsonData, function(i, jsonData){
              var estatus = jsonData.estatus;
              var cantidad = parseInt(jsonData.cantidad);
              data.addRows([[estatus, cantidad]]);
          });
          var options = {
            width: 800,
            height: 600,
            fontSize: "20",
            // legend: 'none',
            chartArea:{width:'100%',height:'100%'}
          };
          var chart = new google.visualization.PieChart(document.getElementById('areaGraficas'));
          chart.draw(data, options);
        }
    });
};

$(document).ready( function ($) {
  Grafica.getInstituciones();
  Grafica.InstitucionesPromesa.done(function(){
    document.getElementById("cargando").style.display = "none";
  });
  Grafica.lib;
  Grafica.construir(Grafica.solicitudes);
});
