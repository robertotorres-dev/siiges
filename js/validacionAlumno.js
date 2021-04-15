var ValidacionAlumno = {};

ValidacionAlumno.normalize = function () {
  var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
    to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
    mapping = {};

  for (var i = 0, j = from.length; i < j; i++)
    mapping[from.charAt(i)] = to.charAt(i);

  return function (str) {
    var ret = [];
    for (var i = 0, j = str.length; i < j; i++) {
      var c = str.charAt(i);
      if (mapping.hasOwnProperty(str.charAt(i))) ret.push(mapping[c]);
      else ret.push(c);
    }
    return ret.join( '' ).toUpperCase();
  };
};

$gmx(document).ready(function() {

  $('[data-toggle="tooltip"]').tooltip();

  $("#fecha_expedicion").datepicker({
    firstDay: 1,
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    dateFormat: 'yy-mm-dd'
  })
  $("#fecha_validacion").datepicker({
    firstDay: 1,
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    dateFormat: 'yy-mm-dd'
  })

  const images = [document.querySelector('#carta-validacion'), document.querySelector('#oficio-validacion'), document.querySelector('#cedula')];
  
  images.forEach(image => {
    image.addEventListener('mousemove', function (e) {
      let width = image.offsetWidth;
      let height = image.offsetHeight;
      let mouseX = e.offsetX;
      let mouseY = e.offsetY;
      
      let bgPosX = (mouseX / width * 100);
      let bgPosY = (mouseY / height * 100);
      
      image.style.backgroundPosition = `${bgPosX}% ${bgPosY}%`;
      });
  
      image.addEventListener('mouseleave', function () {
      image.style.backgroundPosition = "center";
    });
  });
  

});
