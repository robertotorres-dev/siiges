<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
Utileria::validarSesion( basename( __FILE__ ) );
Utileria::validarAccesoModulo( basename( __FILE__ ) );

$resultado = "";
if(isset($_SESSION["resultado"])){
  $resultado = json_decode($_SESSION["resultado"]);
  unset($_SESSION["resultado"]);
}
if(isset($resultado->status) && $resultado->status != "200"){
    $_SESSION["resultado"] = json_encode($resultado);
    header( "Location: edicion-usuarios.php" );
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>Usuarios</title>
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
              <li class="active"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"]; ?></li>
            </ol>
            <ol class="breadcrumb">
      				<li><a href="home.php"><i class="icon icon-home"></i></a></li>
      				<li><a href="home.php">SIIGES</a></li>
      				<li class="active">Usuarios</li>
      			</ol>
          </div>
        </div>
        <div id="mesage">
          <?php if($resultado && isset($resultado->status) && $resultado->status != "200"): ?>
            <div class="alert alert-danger">
            <p><?= $resultado->message ?></p>
            </div>
          <?php
                elseif(isset($resultado->message)):?>
                <div class="alert alert-success">
                <p><?= $resultado->message ?></p>
                </div>
            <?php  endif; ?>
        </div>
        <!-- CUERPO PRINCIPAL -->
        <div class=" form-group col-sm-12 col-md-12 col-lg-12">
          <!-- TÍTULO -->
          <div class="col-sm-12 col-md-12 col-lg-12">
            <input id="usuario_id" type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>" >
      			<div id="cargar-todos"></div>
      			<h2>Usuarios</h2>
      			<hr class="red">
          </div>

          <div class="col-md-8 col-md-offset-4">
             <a href="edicion-usuarios.php" class="btn btn-primary pull-right menu"><i class="icon-user" aria-hidden="true"></i>&nbsp;&nbsp;Dar de alta usuario</a>
             <br><br><br>
          </div>
          <!-- Agregar separacion entre tabla y boton de nuevo usuario-->
          <div class="col-md-8 col-md-offset-2"></div>
          <!-- Tabla de los usuarios-->
          <div class="col-sm-12 col-md-12 table respons">
            <table id="usuarios" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                <thead>
                <tr>
                    <th style="width: 130px; overflow: auto;">Nombre</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Fecha Creado</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
          </div>
        </div>
      </section>
      <!-- Modal eliminar-->
      <div id="modalEliminar" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">¿Está seguro?</h4>
                  </div>
                  <div class="modal-body">
                      <p>Está apunto de borrar el usuario : <span id="modal-usuario"></span> ¿Está completamente seguro de eliminarlo? </p>
      						</div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button id="modal-eliminar" type="button" class="btn btn-danger" data-dismiss="modal">Eliminar</button>
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
    <script src="../js/usuarios.js"></script>
  </body>
</html>
