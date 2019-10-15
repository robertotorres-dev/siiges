<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
Utileria::validarSesion( basename( __FILE__ ) );
//====================================================================================================
if(isset($_SESSION["resultado"])){
  $resultado = json_decode($_SESSION["resultado"]);
  unset($_SESSION["resultado"]);
}
if( $_SESSION["rol_id"] != 6  ){
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
		<title>Inspecciones</title>
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
              <li class="active">Solicitudes</li>
            </ol>
          </div>
        </div>
        <!-- Cuerpo PRINCIPAL  -->
        <div class=" form-group col-sm-12 col-md-12 col-lg-12">
          <!-- TÍTULO -->
            <div class="col-sm-12 col-md-12 col-lg-12">
              <h1 id="txtNombre">Inspecciones</h2>
                <hr class="red">
            </div>
            <!-- Tabla de mis Solicitudes -->
            <div class="col-sm-12 col-md-12">
              <table id="inspecciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      <th>Folio</th>
                      <th>Plan de estudios</th>
                      <th>Estatus</th>
                      <th>Inspección</th>
                      <th>Asignación</th>
                      <th>Plantel</th>
                      <th>Institución</th>
                      <th>Acciones</th>
                  </tr>
                </thead>
              </table>
            </div>
        </div>
      </section>

      <!-- Modal para el acta de inspección  -->
      <div id="modalActaInspeccion" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Acta de inspección</h4>
                  </div>
                  <div class="modal-body">
                    <form id="form-actaInspeccion" class="form-group" target="_blank" action="oficios/acta-inspeccion.php" method="post">
                      <label>Respuesta del particular:</label>
                      <textarea class="form-control" id="respuesta_particular" name="respuesta_particular" rows="8" cols="80" placeholder="Solicite al particular introduzca su respuesta a la inspección"></textarea>
                      <input type="hidden" name="id" id="solicitud">
                      <br>
                      <label>Nombre del testigo 1:</label>
                      <input class="form-control" type="text" name="testigo1" placeholder="Nombre completo del testigo">
                      <br>
                      <label>INE del testigo 1:</label>
                      <input class="form-control" type="text" name="ine1" placeholder="INE del testigo">
                      <br>
                      <label>Nombre del testigo 2:</label>
                      <input class="form-control" type="text" name="testigo2" placeholder="Nombre completo del testigo">
                      <br>
                      <label>INE del testigo 1:</label>
                      <input class="form-control" type="text" name="ine2" placeholder="INE del testigo">
                    </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button id="eliminar" value=""  onclick="Inspeccion.generarActaInspeccion()"type="button" class="btn btn-primary" data-dismiss="modal">Generar acta de inspección</button>
                  </div>
              </div>
          </div>
      </div>

      <!-- Modal para el acta de cierre  -->
      <div id="modalActaCierre" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Acta de cierre</h4>
                  </div>
                  <div class="modal-body">
                    <form id="form-actaCierre"  target="_blank" class="form-group" action="oficios/acta-cierre.php" method="post" enctype="multipart/form-data">
                      <label>Observaciones:</label>
                      <textarea class="form-control" id="observaciones" name="observaciones" rows="8" cols="80" placeholder="Introduzca las observaciones encontradas en la inspección"></textarea>
                      <input type="hidden" name="id" id="solicitudCierre">
                      <!-- <div class="form-group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button id="eliminar" type="submit"   class="btn btn-primary" >Generar acta de cierre</button>
                      </div> -->
                    </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button id="eliminar" type="submit"  onclick="Inspeccion.generarActaCierre()"type="button" class="btn btn-primary" data-dismiss="modal">Generar acta de cierre</button>
                  </div>
              </div>
          </div>
      </div>


      <!-- datos para cargar info -->
      <input id="usuario_id" type="hidden"  value="<?=$_SESSION["id"]?>">
      <input id="persona_id" type="hidden"  value="<?=$_SESSION["persona_id"]?>">
      <input type="hidden" id="rol_id" value="<?=$_SESSION["rol_id"]?>">
      <input type="hidden" id="opcion" value="1">

    </div>
    <!-- JS GOB.MX -->
		<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
		<!-- JS JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
		<!-- SECCION PARA SCRIPTS -->
		<script src="../js/inspecciones.js"></script>
	</body>
</html>
