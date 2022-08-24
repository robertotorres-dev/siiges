<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
Utileria::validarSesion(basename(__FILE__));

//====================================================================================================

require_once "../models/modelo-programa.php";
require_once "../models/modelo-institucion.php";
require_once "../models/modelo-vdetalles-alumno.php";
require_once "../models/modelo-validacion.php";

$programa = new Programa();
$programa->setAttributes(array("id" => $_GET["programa_id"]));
$resultadoPrograma = $programa->consultarId();

$plantel = new Plantel();
$plantel->setAttributes(array("id" => $resultadoPrograma["data"]["plantel_id"]));
$resultadoPlantel = $plantel->consultarId();

$institucion = new Institucion();
$institucion->setAttributes(array("id" => $resultadoPlantel["data"]["institucion_id"]));
$resultadoInstitucion = $institucion->consultarId();
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Validación</title>
  <!-- CSS GOB.MX -->
  <link href="../favicon.ico" rel="shortcut icon">
  <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
  <!-- CSS DATATABLE -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <!-- CSS PROPIO -->
  <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body>
  <!-- HEADER Y BARRA DE NAVEGACION -->
  <?php
  require_once "menu.php";
  ?>
  <div class="container">
    <section class="main row margin-section-formularios">
      <div class="row" style="padding-left: 15px; padding-right: 15px;">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <!-- BARRA DE USUARIO -->
          <ol class="breadcrumb pull-right">
            <li><i class="icon icon-user"></i></li>
            <li><?php echo $_SESSION["nombre_rol"]; ?></li>
            <li class="active"><?php echo $_SESSION["nombre"] . " " . $_SESSION["apellido_paterno"] . " " . $_SESSION["apellido_materno"]; ?></li>
          </ol>
          <ol class="breadcrumb">
            <li><a href="home.php"><i class="icon icon-home"></i></a></li>
            <?php if (Rol::ROL_CONTROL_ESCOLAR_SICYT == $_SESSION["rol_id"] || (Rol::ROL_ADMIN == $_SESSION["rol_id"])) : ?>
              <li><a href="ce-planteles-validacion.php?institucion_id=<?php echo $resultadoInstitucion["data"]["id"]; ?>">Planteles</a></li>
              <li><a href="ce-programas-plantel-validacion.php?institucion_id=<?php echo $resultadoInstitucion["data"]["id"] ?>&plantel_id=<?php echo $resultadoPlantel["data"]["id"] ?>">Programas de Estudios</a></li>
              <li class="active">Alumnos</li>
            <?php endif; ?>
          </ol>
        </div>
      </div>
      <div id="mesage">

      </div>
      <!-- CUERPO PRINCIPAL -->
      <div class=" form-group col-sm-12 col-md-12 col-lg-12">
        <!-- TÍTULO -->
        <div class="row">
          <input id="usuario_id" type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
          <div id="cargar-todos"></div>
          <h2>Alumnos</h2>
          <hr class="red">
        </div>
        <!-- NOTIFICACIÓN -->
        <?php if (isset($_GET["codigo"]) && $_GET["codigo"] == 200) { ?>
          <div class="alert alert-success">
            <p>Registro guardado.</p>
          </div>
        <?php } ?>
        <?php if (isset($_GET["codigo"]) && $_GET["codigo"] == 201) { ?>
          <div class="alert alert-success">
            <p>Registro habilitado para captura.</p>
          </div>
        <?php } ?>
        <!-- Tabla de los usuarios-->
        <div class="col-sm-12 col-md-12 table respons">
          <table id="alumnos" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th width="5%">Id</th>
                <th width="5%">Matr&iacute;cula</th>
                <th width="20%">Apellido Paterno</th>
                <th width="20%">Apellido Materno</th>
                <th width="20%">Nombre</th>
                <th width="10%">Estatus</th>
                <th width="10%">Acciones</th>
                <th width="10%">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $parametros["programa_id"] = $_GET["programa_id"];

              $detallesAlumnos = new VDetallesAlumno();
              $detallesAlumnos->setAttributes($parametros);
              $resultadoDetallesAlumnos = $detallesAlumnos->consultarAlumnosPrograma();
              

              $max = count($resultadoDetallesAlumnos["data"]);
              for ($i = 0; $i < $max; $i++) {
                $alumnoDetalle = $resultadoDetallesAlumnos["data"][$i];
                $validacion = new Validacion();
              $res_validacion = $validacion->consultarPor('validaciones', array("alumno_id" => $alumnoDetalle["id"], "deleted_at"), '*');
              ?>
                <tr>
                  <td><?php echo $alumnoDetalle["id"]; ?></td>
                  <td><?php echo $alumnoDetalle["matricula"]; ?></td>
                  <td><?php echo $alumnoDetalle["apellido_paterno"]; ?></td>
                  <td><?php echo $alumnoDetalle["apellido_materno"]; ?></td>
                  <td><?php echo $alumnoDetalle["nombre"]; ?></td>

                  <!-- Situacion general -->
                  <td><?php
                      echo isset($alumnoDetalle["situacion_validacion"]) ? $alumnoDetalle["situacion_validacion"] : "Sin validar";
                      ?>
                  </td>
                  <td>
                    <a href="ce-catalogo-alumno.php?programa_id=<?php echo $resultadoPrograma["data"]["id"]; ?>&alumno_id=<?php echo $alumnoDetalle["id"]; ?>&proceso=consulta"><span id="" title="Consultar" class="glyphicon glyphicon-eye-open col-sm-1 size_icon"></span></a>
                  </td>
                  <td>
                    <?php if (Rol::ROL_CONTROL_ESCOLAR_SICYT == $_SESSION["rol_id"] || (Rol::ROL_ADMIN == $_SESSION["rol_id"])) : ?>
                      <a href="ce-validacion-alumno.php?programa_id=<?php echo $resultadoPrograma["data"]["id"]; ?>&alumno_id=<?php echo $alumnoDetalle["id"]; ?>&proceso=edicion">Validar</a>
                    <?php endif; ?>
                    <div><a href="../uploads/<?php echo $res_validacion["data"] ? "Institucion" . $resultadoInstitucion["data"]["id"] . "/PLANTEL" . $resultadoPlantel["data"]["id"] . "/validaciones/" . $res_validacion["data"][0]["archivo_validacion"] : ""; ?>" target="_blank"><?php echo isset($res_validacion["data"][0]["archivo_validacion"]) ? "Oficio de validación" : ""; ?></a></div>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
  <!-- JS GOB.MX -->
  <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
  <!-- JS JQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#alumnos").DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }
      });
    });
  </script>
  <!-- JS PROPIOS -->
</body>

</html>