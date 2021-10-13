<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
Utileria::validarSesion(basename(__FILE__));

//====================================================================================================

require_once "../models/modelo-programa.php";
require_once "../models/modelo-asignatura.php";

$programa = new Programa();
$programa->setAttributes(array("id" => $_GET["programa_id"]));
$resultadoPrograma = $programa->consultarId();

if ($_GET["proceso"] == "alta") {
  $titulo = "Alta de Asignatura";
}

if ($_GET["proceso"] == "consulta") {
  $titulo = "Consulta de Asignatura";

  $asignatura = new Asignatura();
  $asignatura->setAttributes(array("id" => $_GET["asignatura_id"]));
  $resultadoAsignatura = $asignatura->consultarId();
}

if ($_GET["proceso"] == "edicion") {
  $titulo = "Edici&oacute;n de Asignatura";

  $asignatura = new Asignatura();
  $asignatura->setAttributes(array("id" => $_GET["asignatura_id"]));
  $resultadoAsignatura = $asignatura->consultarId();
}

?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Asignaturas</title>
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
  <!-- HEADER Y MENÚ -->
  <?php require_once "menu.php"; ?>
  <!-- CUERPO DE PANTALLA -->
  <div class="container">
    <section class="main row margin-section-formularios">

      <!-- BARRA DE INFORMACION -->
      <div class="row" style="padding-left: 15px; padding-right: 15px;">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <!-- BARRA DE USUARIO -->
          <ol class="breadcrumb pull-right">
            <li><i class="icon icon-user"></i></li>
            <li><?php echo $_SESSION["nombre_rol"]; ?></li>
            <li class="active"><?php echo $_SESSION["nombre"] . " " . $_SESSION["apellido_paterno"] . " " . $_SESSION["apellido_materno"]; ?></li>
          </ol>
          <!-- BARRA DE NAVEGACION -->
          <ol class="breadcrumb pull-left">
            <li><i class="icon icon-home"></i></li>
            <li><a href="home.php">SIIGES</a></li>
            <li><a href="ce-catalogo-asignaturas.php<?php echo "?programa_id=" . $resultadoPrograma["data"]["id"]; ?>">Cat&aacute;logo de Asignaturas</a></li>
            <li class="active"><?php echo $titulo; ?></li>
          </ol>
        </div>
      </div>

      <!-- CUERPO PRINCIPAL -->
      <form name="form1" method="post" action="../controllers/control-asignatura.php">
        <div class="col-sm-12 col-md-12 col-lg-12">

          <!-- TÍTULO -->
          <h2 id="txtNombre"><?php echo $titulo; ?></h2>
          <hr class="red">
          <div class="row">
            <div class="col-sm-12">
              <legend><?php echo $resultadoPrograma["data"]["nombre"]; ?></legend>
            </div>
          </div>

          <!-- CONTENIDO -->
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="id">Id</label>
                <input type="text" id="id" name="id" value="<?php echo (isset($resultadoAsignatura)) ? $resultadoAsignatura["data"]["id"] : "";
                                                            ?>" maxlength="11" class="form-control" readonly />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="programa_id">Programa Id</label>
                <input type="text" id="programa_id" name="programa_id" value="<?php echo $resultadoPrograma["data"]["id"]; ?>" maxlength="11" class="form-control" required readonly />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="consecutivo">N&uacute;mero consecutivo *</label>
                <input type="number" id="consecutivo" name="consecutivo" value="<?php echo (isset($resultadoAsignatura)) ? $resultadoAsignatura["data"]["consecutivo"] : ""; ?>" maxlength="11" class="form-control" required />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-md-3">
              <div class="form-group">
                <label class="control-label" for="consecutivo">Grado *</label>
                <select class="form-control" id="grado" name="grado">
                  <option value="">Seleccione una opción</option>
                  <optgroup label="Semestres">
                    <option value="Primer semestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Primer semestre") ? "selected" : "";
                                                    ?>>Primero</option>
                    <option value="Segundo semestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Segundo semestre") ? "selected" : "";
                                                      ?>>Segundo</option>
                    <option value="Tercero semestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Tercero semestre") ? "selected" : "";
                                                      ?>>Tercero</option>
                    <option value="Cuarto semestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Cuarto semestre") ? "selected" : "";
                                                    ?>>Cuarto</option>
                    <option value="Quinto semestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Quinto semestre") ? "selected" : "";
                                                    ?>>Quinto</option>
                    <option value="Sexto semestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Sexto semestre") ? "selected" : "";
                                                    ?>>Sexto</option>
                    <option value="Septimo semestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Septimo semestre") ? "selected" : "";
                                                      ?>>Septimo</option>
                    <option value="Octavo semestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Octavo semestre") ? "selected" : "";
                                                    ?>>Octavo</option>
                    <option value="Noveno semestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Noveno semestre") ? "selected" : "";
                                                    ?>>Noveno</option>
                    <option value="Decimo semestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Decimo semestre") ? "selected" : "";
                                                    ?>>Decimo</option>
                  </optgroup>
                  <optgroup label="Cuatrimestres">
                    <option value="Primer cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Primer cuatrimestre") ? "selected" : "";
                                                        ?>>Primero</option>
                    <option value="Segundo cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Segundo cuatrimestre") ? "selected" : "";
                                                          ?>>Segundo</option>
                    <option value="Tercero cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Tercero cuatrimestre") ? "selected" : "";
                                                          ?>>Tercero</option>
                    <option value="Cuarto cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Cuarto cuatrimestre") ? "selected" : "";
                                                        ?>>Cuarto</option>
                    <option value="Quinto cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Quinto cuatrimestre") ? "selected" : "";
                                                        ?>>Quinto</option>
                    <option value="Sexto cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Sexto cuatrimestre") ? "selected" : "";
                                                        ?>>Sexto</option>
                    <option value="Septimo cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Septimo cuatrimestre") ? "selected" : "";
                                                          ?>>Septimo</option>
                    <option value="Octavo cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Octavo cuatrimestre") ? "selected" : "";
                                                        ?>>Octavo</option>
                    <option value="Noveno cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Noveno cuatrimestre") ? "selected" : "";
                                                        ?>>Noveno</option>
                    <option value="Decimo cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Decimo cuatrimestre") ? "selected" : "";
                                                        ?>>Decimo</option>
                    <option value="Undecimo cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Undecimo cuatrimestre") ? "selected" : "";
                                                          ?>>Undecimo</option>
                    <option value="Duodecimo cuatrimestre" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Duodecimo cuatrimestre") ? "selected" : "";
                                                            ?>>Duodecimo</option>
                  </optgroup>
                  <optgroup label="Curriculum Flexible">
                    <option value="Flexible Cuatrimestral" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Flexible Cuatrimestral") ? "selected" : "";
                                                            ?>>Listado Cuatrimestral</option>
                    <option value="Flexible Semestral" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["grado"] == "Flexible Semestral") ? "selected" : "";
                                                        ?>>Listado Semestral</option>
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-3">
              <div class="form-group">
                <label class="control-label" for="nombre">Nombre *</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo (isset($resultadoAsignatura)) ? $resultadoAsignatura["data"]["nombre"] : "";
                                                                    ?>" class="form-control" required />
              </div>
            </div>
            <div class="col-sm-12 col-md-3">
              <div class="form-group">
                <label class="control-label" for="clave">Clave *</label>
                <input type="text" id="clave" name="clave" value="<?php echo (isset($resultadoAsignatura)) ? $resultadoAsignatura["data"]["clave"] : "";
                                                                  ?>" class="form-control" />
              </div>
            </div>
            <div class="col-sm-12 col-md-3">
              <div class="form-group">
                <label class="control-label" for="seriacion">Seriaci&oacute;n *</label>
                <input type="text" id="seriacion" name="seriacion" value="<?php echo (isset($resultadoAsignatura)) ? $resultadoAsignatura["data"]["seriacion"] : "";
                                                                          ?>" class="form-control" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-md-4">
              <div class="form-group">
                <label class="control-label" for="tipo">Tipo *</label>
                <select class="form-control" id="tipo" name="tipo">
                  <option value="">Seleccione una opción</option>
                  <option value="1" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["tipo"] == 1) ? "selected" : "";
                                    ?>>Asignatura</option>
                  <option value="2" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["tipo"] == 2) ? "selected" : "";
                                    ?>>Optativa</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="form-group">
                <label class="control-label" for="area">&Aacute;rea *</label>
                <select class="form-control" id="area" name="area">
                  <option value="">Seleccione una opción</option>
                  <optgroup id="groupAsignatura" label="Asignatura">
                    <option value="1" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["area"] == 1) ? "selected" : "";
                                      ?>>Formación General</option>
                    <option value="2" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["area"] == 2) ? "selected" : "";
                                      ?>>Formación Integral</option>
                    <option value="3" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["area"] == 3) ? "selected" : "";
                                      ?>>Profesionalizante</option>
                  </optgroup>
                  <optgroup id="groupOptativa" label="Optativa">
                    <option value="4" <?php echo (isset($resultadoAsignatura) && $resultadoAsignatura["data"]["area"] == 4) ? "selected" : "";
                                      ?>>Optativa Especializante</option>
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="form-group">
                <label class="control-label" for="academia">Academia *</label>
                <input type="text" id="academia" name="academia" value="<?php echo (isset($resultadoAsignatura)) ? $resultadoAsignatura["data"]["academia"] : "";
                                                                        ?>" class="form-control" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-md-4">
              <div class="form-group">
                <label class="control-label" for="horas_docente">Horas docente *</label>
                <input type="number" id="horas_docente" name="horas_docente" value="<?php echo (isset($resultadoAsignatura)) ? $resultadoAsignatura["data"]["horas_docente"] : "";
                                                                                    ?>" maxlength="11" class="form-control" />
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="form-group">
                <label class="control-label" for="horas_independiente">Horas independientes *</label>
                <input type="number" id="horas_independiente" name="horas_independiente" value="<?php echo (isset($resultadoAsignatura)) ? $resultadoAsignatura["data"]["horas_independiente"] : "";
                                                                                                ?>" maxlength="11" class="form-control" required />
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="form-group">
                <label class="control-label" for="creditos">Cr&eacute;ditos *</label>
                <input type="number" id="creditos" name="creditos" value="<?php echo (isset($resultadoAsignatura)) ? $resultadoAsignatura["data"]["creditos"] : "";
                                                                          ?>" maxlength="11" class="form-control" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <input type="submit" id="submit" name="submit" value="Enviar" class="btn btn-primary" />
                <input type="hidden" name="webService" value="guardar" />
                <input type="hidden" name="url" value="../views/ce-catalogo-asignaturas.php?programa_id=<?php echo $_GET["programa_id"]; ?>&codigo=200" />
                <input type="hidden" id="programa_id" name="programa_id" value="<?php echo $_GET["programa_id"]; ?>" />
              </div>
            </div>
          </div>
        </div>
      </form>
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
  <script type="text/javascript"></script>
  <!-- SECCION PARA SCRIPTS -->
  <script src="../js/catalogoAsignaturas.js"></script>
</body>



</html>