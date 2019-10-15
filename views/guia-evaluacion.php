<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
Utileria::validarSesion( basename( __FILE__ ) );
//====================================================================================================
$resultado = "";
if(isset($_SESSION["resultado"])){
  $resultado = json_decode($_SESSION["resultado"]);
  unset($_SESSION["resultado"]);
}
if( $_SESSION["rol_id"] < 5  ){
  header( "Location: home.php?error=1" );
  exit( );
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Guía de evaluación</title>
    <!-- CSS GOB.MX -->
    <link href="../favicon.ico" rel="shortcut icon">
    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
    <!-- CSS DATATABLE -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <!-- CSS PROPIO -->
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
  </head>
  <body>
    <div id="cargando" class="loader">

    </div>
    <!-- HEADER Y MENÚ -->
    <?php require_once "menu.php"; ?>
    <div class="container">
      <section class="main row margin-section-formularios">
        <!-- BARRA DE INFORMACION -->
        <div class="row" style="padding-left: 15px; padding-right: 15px;">
          <div class="col-sm-12 col-md-12 col-lg-12">
            <!-- BARRA DE USUARIO -->
            <ol class="breadcrumb pull-right">
              <li><i class="icon icon-user"></i></li>
              <li><?php echo $_SESSION["nombre_rol"]; ?></li>
              <li class="active"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"]; ?></li>
            </ol>
            <!-- BARRA DE NAVEGACION -->
            <ol class="breadcrumb pull-left">
              <li><a href="home.php"><i class="icon icon-home"></i></a></li>
              <li><a href="home.php">SIIGES</a></li>
              <li><a href="evaluaciones-evaluador.php">Evaluaciones</a></li>
              <li class="active">Evaluación técnico curricular</li>
            </ol>
          </div>
        </div>
        <div id="mensaje">
          <?php if(isset($resultado) && isset($resultado->status) && $resultado->status != "200"): ?>
            <div class="alert alert-danger">
              <p><?= $resultado->message ?></p>
            </div>
            <?php  endif; ?>
        </div>
        <!-- Cuerpo PRINCIPAL  -->
        <div class=" form-group col-sm-12 col-md-12 col-lg-12">
          <!-- TÍTULO -->
            <div class="col-sm-12 col-md-12 col-lg-12">
              <h1 id="txtNombre">Evaluación técnico curricular</h2>
            </div>
            <ul id="menuApartados" class="nav nav-tabs col-sm-12 col-md-12">
            </ul>
            <!-- Formulario -->
            <form id="guia" class="form-horizontal" action="../controllers/control-programa-evaluacion.php"  method="post">
              <!-- Contenido del formulario -->
              <div id="tabs" class="tab-content col-sm-12 col-md-12">


              </div>
              <input type="hidden" id="evaluacion_id" name="evaluacion_id" value="">
              <input type="hidden" name="solicitud_id" id="solicitud" value="<?=$_GET["solicitud"]?>">
              <input type="hidden" id="opcion_evaluacion" name="opcion_evaluacion">

            </form>
        </div>
        <div class="form-group col-sm-6 col-md-4">
          <h4>Docu Evaluación</h4>
          <a target="_blank" href= <?= "dictamenes/carta-aceptacion.php?id=".$_GET["solicitud"] ?>>Carta de Aceptación</a><br>
          <a target="_blank" href= <?= "dictamenes/carta-asignacion-evaluador.php?id=".$_GET["solicitud"] ?>>Carta de Asignación de Evaluador</a><br>
          <a target="_blank" href= <?= "dictamenes/carta-imp-con.php?id=".$_GET["solicitud"] ?>>Carta de Imparcialidad y Confidencialidad</a><br>
        </div>
      </section>
      <!-- Modal para mensaje de errores -->
      <div class="modal fade" id="modalErrores"  tabindex="-1" role="dialog" aria-hidden="true">
          <div  id="tamanoModal" class="modal-dialog" >
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Error en llenado</h4>
              </div>
              <div class="modal-body">
                  <div id="mensajesError">

                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
            </div>

          </div>
        </div>
      <!-- Modal para confirmación -->
      <div class="modal fade" id="modalConfirmacion" role="dialog">
            <div id="tamanoModales" class="modal-dialog" >
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Confirmación</h4>
                </div>
                <div class="modal-body">
                    <div id="mensajesTerminar" class="alert alert-info">
                      <p class="text-justify">
                        Esta a punto de concluir el llenado de la solicitudes. Si usted lleno en su totalidad los campos solicitados de clic en "Concluir" para terminar la solicitud.
                      </p>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button  id="boton-terminar" type="button" class="btn btn-primary" onclick="Guia.terminar()">Concluir</button>
                </div>
              </div>
            </div>
          </div>
    <!-- Inputs para js -->
    <input type="hidden" id="opcion" value="1">
    </div>
    <!-- JS GOB.MX -->
    <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
    <!-- JS JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <!-- SECCION PARA SCRIPTS -->
    <script src="../js/guia.js"></script>
  </body>
</html>
