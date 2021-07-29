<?php

$resultado = "";
if (isset($_SESSION["resultado"])) {
  $resultado = json_decode($_SESSION["resultado"]);
  unset($_SESSION["resultado"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TITULACI&Oacute;N ELECTR&Oacute;NICA</title>
  <!-- CSS GOB.MX -->
  <link href="../favicon.ico" rel="shortcut icon">
  <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
  <!-- CSS DATATABLE -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <!-- CSS LIVESELECT -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-select.min.css">
  <!-- CSS CALENDAR -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- CSS PROPIO -->
  <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body>

  <!-- HEADER Y BARRA DE NAVEGACION -->

  <header>
    <meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    <div class="container">
      <nav class="navbar navbar-inverse sub-navbar navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#subenlaces">
              <span class="sr-only">Interruptor de Navegación</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a id="navImgJalisco" class="navbar-brand" href="home.php"><img src="../images/jalisco-logo.png" height="30"></a>
            <a id="navLetrasSiiga" class="navbar-brand" href="home.php">SIIGES</a>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <div class="container">
    <section class="main row margin-section-formularios">
      <div class="row" style="padding-left: 15px; padding-right: 15px;">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <!-- BARRA DE USUARIO -->
          <ol class="breadcrumb pull-right">
          </ol>
          <ol class="breadcrumb">
            <li><a href="../views/consulta_titulo_electronico.php"><i class="icon icon-home"></i></a></li>
            <li><a href="../views/consulta_titulo_electronico.php">Inicio</a></li>
            <li class="active">Consulta tu Constancia de T&iacute;tulo</li>
          </ol>
        </div>
      </div>
      <div id="mesage">
        <!-- <?php if ($resultado && isset($resultado->status) && $resultado->status != "200") : ?>
          <div class="alert alert-danger">
            <p><?= $resultado->message ?></p>
          </div>
        <?php
              elseif (isset($resultado->message)) : ?>
          <div class="alert alert-success">
            <p><?= $resultado->message ?></p>
          </div>
        <?php endif; ?> -->
      </div>


      <!-- CUERPO PRINCIPAL -->
      <h1>Consulta tu Constancia de T&iacute;tulo</h1>
      <div class="row tramite-content" style="min-height: 400px;">
        <div class="ember-view" isactive>
          <div class="col-md-12 hidden-xs">
            <ul class="wizard-steps">
              <li id="wizard-1" class="wizard-i completed">
                <h5>Paso 1</h5>
                <span>B&uacute;squeda</span>
              </li>
              <li id="wizard-2" class="wizard-i">
                <h5>Paso 2</h5>
                <span>Consulta de Constancia</span>
              </li>
              <li class="wizard-i">
                <i class="glyphicon glyphicon-ok-circle"></i>
              </li>
            </ul>
          </div>
        </div>
        <section class="buscar">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <form method="post" name="constanciaForm" id="constanciaForm" enctype="multipart/form-data">
                  <div id="contenedorBusqueda" class="row clearfix">
                    <h2 id="txtNombre">B&uacute;squeda</h2>
                    <hr class="red">
                    <div class="col-md-8">
                      <p>La consulta puede efectuarse indicando el folio de control dado por la Instituci&oacute;n a la que pertenece.</p>
                      <ul class="nav nav-tabs top-buffer">
                        <li class=""><a data-toggle="tab" href="#tab-01">Folio de control</a></li>
                      </ul>
                      <div class="tab-content">
                        <!-- Formulario de captura -->
                        <div class="tab-pane clearfix active" id="tab-01">
                          <!-- Contenedor de acordion -->
                          <div class="col-md-12">
                            <div class="form-group clearfix">
                              <div class="col-sm-12 col-md-12">
                                <label class="control-label" for="folioinput">Folio de control *:</label><br>
                                <input type="text" class="campos form-control ember-text-field ember-view" id="folioinput" name="folio" placeholder="Ingresa tu folio" required>
                                <small id="smallError" class="smallError form-text form-text-error hide" aria-live="polite">Este campo es obligatorio</small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="contenedorDatos" class="row clearfix hide">
                    <h2 id="txtNombre">Resultado de registro</h2>
                    <hr class="red">
                    <div class="col-md-10">
                      <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                          <h4 style="margin-bottom: 8px;">Datos de la Constancia</h4>
                        </div>
                        <div class="panel-body" style="padding: 24px;">
                          <table style="width: 100%;">
                            <tr style="border-bottom: 1px solid #ececec;">
                              <td style="font-weight: 700; width: 30%; padding-bottom: 8px;">Folio de control:</td>
                              <td id="filaFolio" style="text-transform: uppercase;"></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ececec;">
                              <td style="font-weight: 700; width: 30%; padding-top: 8px; padding-right: 8px; padding-bottom: 8px;">Nombre(s):</td>
                              <td id="filaNombre" style="text-transform: uppercase;"></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ececec;">
                              <td style="font-weight: 700; width: 30%; padding-top: 8px; padding-right: 8px; padding-bottom: 8px;">Primer apellido:</td>
                              <td id="filaPrimerApellido" style="text-transform: uppercase;"></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ececec;">
                              <td style="font-weight: 700; width: 30%; padding-top: 8px; padding-right: 8px; padding-bottom: 8px;">Segundo apellido:</td>
                              <td id="filaSegundoApellido" style="text-transform: uppercase;"></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ececec;">
                              <td style="font-weight: 700; width: 30%; padding-top: 8px; padding-right: 8px; padding-bottom: 8px;">Instituci&oacute;n:</td>
                              <td id="filaInstitucion" style="text-transform: uppercase;"></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ececec;">
                              <td style="font-weight: 700; width: 30%; padding-top: 8px; padding-right: 8px; padding-bottom: 8px;">Carrera:</td>
                              <td id="filaCarrera" style="text-transform: uppercase;"></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ececec;">
                              <td style="font-weight: 700; width: 30%; padding-top: 8px; padding-right: 8px; padding-bottom: 8px;">Fecha de inicio:</td>
                              <td id="filaFechaInicio" style="text-transform: uppercase;"></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ececec;">
                              <td style="font-weight: 700; width: 30%; padding-top: 8px; padding-right: 8px; padding-bottom: 8px;">Fecha de terminaci&oacute;n:</td>
                              <td id="filaFechaTerminacion" style="text-transform: uppercase;"></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ececec;">
                              <td style="font-weight: 700; width: 30%; padding-top: 8px; padding-right: 8px; padding-bottom: 8px;">Fecha de expedici&oacute;n:</td>
                              <td id="filaFechaExpedicion" style="text-transform: uppercase;"></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ececec;">
                              <td style="font-weight: 700; width: 30%; padding-top: 8px; padding-right: 8px; padding-bottom: 8px;">Estatus:</td>
                              <td id="filaEstatus" style="text-transform: uppercase;"></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Mensajes de error -->
                  <div class="" id="errorLog">
                  </div>
                  <div class="row">
                    <div class="col-md-8 col-md-offset-4">
                      <hr>
                    </div>
                    <!-- Controles formulario  -->
                    <div class="col-sm-12 col-md-12">
                      <!-- Filtrar informacion a cargar  -->
                      <input type="hidden" name="webService" id="webService" value="datosConstanciaFolio">
                      <input type="hidden" name="url" id="url" value="../views/resultado_consulta.php">
                      <?php
                      if (isset($_GET["folioControl"])) :
                      ?>
                        <input type="hidden" name="folioQR" id="folioQR" value="<?= $_GET["folioControl"] ?>">
                      <?php
                      endif;
                      ?>
                    </div>
                  </div>
                  <div class="form-group clearfix">
                    <div class="text-muted pull-left text-muted text-vertical-align-button">* Campos obligatorios</div>
                    <div class="pull-right">
                      <div id="searchButton" class="btn btn-primary pull-right" type="submit">
                        <span class="icon icon-search"></span> Buscar
                      </div>
                    </div>
                  </div>
                  <div class="form-group clearfix">
                    <div class="ember-view">
                      <div class="alert alert-info" aria-live="polite" style="word-wrap: break-word;">
                        <strong>¡Sugerencia!</strong> Para solicitar asistencia en el trámite, reportar datos incorrectos o en caso de algún problema, puedes comunicarte al Centro de Atención, de lunes a viernes, de 08:00 a 16:00 horas, a los números telefónicos:
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>
    </section>
  </div>


  <!-- JS GOB.MX -->
  <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
  <!-- JS JQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- JS LIVESELECT -->
  <script src="../js/bootstrap-select.min.js"></script>
  <!-- JS CALENDAR -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- JS PROPIOS -->
  <script src="../js/consultaTitulo.js"></script>

</body>

</html>