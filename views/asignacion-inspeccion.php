<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
Utileria::validarSesion( basename( __FILE__ ) );
//====================================================================================================
if(isset($_SESSION["resultado"])){
  $resultado = json_decode($_SESSION["resultado"]);
  unset($_SESSION["resultado"]);
}
if( $_SESSION["rol_id"] != 2 &&  $_SESSION["rol_id"] < 9  ){ //Revisar esto
  header( "Location: home.php?error=1" );
  exit( );
}
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Asginacion de inspecciones</title>
  <!-- CSS GOB.MX -->
  <link href="../favicon.ico" rel="shortcut icon">
  <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
  <!-- CSS DATATABLE -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <!-- CSS PROPIO -->
  <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
  <body>
    <!-- HEADER Y MENÚ -->
    <?php require_once "menu.php"; ?>
    <div id="cargando" class="loader">

    </div>
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
              <li><a href="solicitudes.php">Solicitudes</a></li>
              <li class="active">Evaluación técnico curricular</li>
            </ol>
          </div>
        </div>
        <!-- TÍTULO -->
          <div class="col-sm-12 col-md-12 col-lg-12">
            <h1 id="txtNombre">Asignacion de inspecciones</h2>
              <hr class="red">
              <form class="col-12">
                <!-- Programa de estudios -->
                <div id="programa-estudios" class="form-group col-sm-12">
                  <h4>Programa de estudios</h4>
                  <div class="col-sm-12 col-md-4">
                    <label class="control-label" for="">Nivel</label><br>
                    <input type="text" id="nivel" class="form-control" disabled><br>
                  </div>
                  <div class="col-sm-12 col-md-8">
                    <label class="control-label" for="">Nombre</label><br>
                    <input type="text" id="programa" class="form-control" disabled><br>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <label class="control-label" for="">Modalidad</label><br>
                    <input class="form-control" id="modalidad" disabled><br>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <label class="control-label" for="">Periodo</label><br>
                    <input class="form-control" id="ciclo" disabled><br>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <label class="control-label" for="">Institución</label><br>
                    <input type="text" id="nombre_plantel" class="form-control" disabled>
                  </div>
                  <div class="col-sm-12 col-md-8">
                    <label class="control-label" for="">Domicilio</label><br>
                    <input type="text" id="domicilio" class="form-control" disabled>
                  </div>
                </div>
                <div class="col-sm-12 col-md-9">
                  <h4>Inspectores</h4>
                  <table id="inspectores" class="table table-striped table-bordered" cellspacing="0" width="100%">
      							<thead>
      								<tr>
      										<th>Nombre</th>
                          <th>Inspecciones activas</th>
                          <th>Inspecciones realizadas</th>
      										<th>Acciones</th>
      								</tr>
      							</thead>
      						</table>
      					</div>
              </form>
          </div>
      </section>
      <input type="hidden" id="opcion" value="2">
      <input type="hidden" id="solicitud" value="<?=$_GET["solicitud"]?>">
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
                    <p  id="textoConfirmacion" class="text-justify"></p>
                  </div>
                  <div class="col-sm-12 col-md-12">
                    <label class="control-label" for="">Fecha de inspección</label><br>
                    <input type="date" id="fecha_inspeccion" class="form-control">
                    <br>
                  </div>
                  <div class="col-sm-12 col-md-12">
                    <label class="control-label" for="">Folio</label><br>
                    <input type="text" id="folio_inspeccion" class="form-control">
                    <br>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button  id="boton-terminar" type="button" class="btn btn-primary" onclick="Inspeccion.asignar()">Asignar inspección</button>
              </div>
            </div>
          </div>
        </div>
      <!-- Modal que muestra mensaje -->
      <div class="modal fade" id="modalMensaje" role="dialog">
            <div id="tamanoModal" class="modal-dialog" >
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Mensaje</h4>
                </div>
                <div class="modal-body">
                    <div id="mensajesTerminar" class="alert alert-success">
                      <p class="text-justify">Inspección asginada</p>
                    </div>
                </div>
                <div class="modal-footer">
                  <button  id="boton-terminar" type="button" class="btn btn-primary" onclick="Inspeccion.listo()">Listo</button>
                </div>
              </div>
            </div>
          </div>
    </div>
    <!-- JS GOB.MX -->
    <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
    <!-- JS JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <!-- JS PROPIOS -->
    <script src="../js/inspecciones.js"></script>
  </body>
</html>
