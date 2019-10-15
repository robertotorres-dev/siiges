var Grafica = {};

Grafica.lib = google.charts.load('current', {'packages':['corechart']});

Grafica.construir = function(grafica){
  google.charts.setOnLoadCallback(grafica);
};


Grafica.solicitudes = function(){
  $.ajax({
        url: '../controllers/control-institucion.php',
        type: 'POST',
        data: {webService:"numeroSolicitudesInstitucion",url:""},
        dataType: 'JSON',
        success: function(respuesta) {
          console.log(respuesta);
          var solicitudes = respuesta.data;
          var nproceso = 0;
          var nterminadas = 0;
          var nrechazadas = 0;
          if(solicitudes.proceso!=null){nproceso = solicitudes.proceso;}
          if(solicitudes.terminadas!=null){nterminadas = solicitudes.terminadas;}
          if(solicitudes.rechazadas!=null){nrechazadas = solicitudes.rechazadas;}
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

Grafica.solicitar = function(){
  var opcion = $("#opcionGrafica").val();
  if(opcion!="")
  {
    Grafica.solicitudesInstitucion(opcion);
  }
};

Grafica.solicitudesInstitucion=function(opcion){
  $.ajax({
        url: '../controllers/control-institucion.php',
        type: 'POST',
        data: {webService:"solictiudesPorInstitucion",url:"",filtro:opcion},
        dataType: 'JSON',
        success: function(respuesta) {
          console.log(respuesta);
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
  Grafica.lib;
  Grafica.construir(Grafica.solicitudes);
});
