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
	$id = isset($_GET["id"])?$_GET["id"]:null;
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SIIGES - Gestion de accesos</title>
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
						<li class="active"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"]; ?></li>
					</ol>
					<!-- BARRA DE NAVEGACION -->
					<ol class="breadcrumb pull-left">
						<li><i class="icon icon-home"></i></li>
						<li><a href="home.php">SIIGES</a></li>
						<li class="active">Alta de Accesos</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-modulo-rol.php">
				<input type="hidden" name="id" id="modulo-rol-id" value="<?= $id ?>">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre">Gestión de Accesos</h2>
				<hr class="red">
				<div id="mensaje">
					<?php if($resultado && isset($resultado->status) && $resultado->status != "200"): ?>
						<div class="alert alert-danger">
							<p><?= $resultado->message ?></p>
						</div>
					<?php
								elseif(isset($resultado->message) && $resultado->message != "OK"):?>
								<div class="alert alert-success">
									<p><?= $resultado->message ?></p>
								</div>
						<?php  endif; ?>
				</div>
				<div class="row">
          <div class="col-sm-12">
						<legend>Acceso del rol a modulos</legend>
					</div>
				</div>
				<!-- CONTENIDO -->
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="rol_id">Rol</label>
							<select class="form-control" id="acceso-roles" name="rol_id" required placeholder="Seleccione una opcion">
								<option></option>
							</select>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="modulo_id">Módulo</label>
							<select class="form-control" id="acceso-modulos" name="modulo_id" required placeholder="Seleccione una opcion">
								<option></option>
							</select>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="accion">Acción</label>
							<select class="form-control" id="accion" name="accion" required placeholder="Seleccione una opcion">
								<option>Seleccione una opción</option>
								<option value="2">Ver Todo</option>
								<option value="1">Ver Propios</option>
								<option value="3">Ver detalles</option>
								<option value="4">Crear</option>
								<option value="5">Editar</option>
								<option value="6">Eliminar</option>
							</select>
						</div>
          </div>
					<div class="col-sm-12">
            <div class="form-group">
							<input type="submit" id="submit" name="submit" value="Guardar" class="btn btn-primary pull-right" />
							<input type="hidden"  name="webService" value="guardar" />
							<input type="hidden"  name="url" value="../views/alta-modulos-roles.php" />
						</div>
          </div>
        </div>
			</div>
			</form>
		</section>

		<table id="accesos-tabla" class="table table-striped table-bordered" cellspacing="0">
				<thead>
				<tr>
						<th>Rol</th>
						<th>Módulo</th>
						<th>Acción</th>
						<th>Acciones</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
		</table>
	</div>

	<!-- Modal eliminar-->
	<div id="modalEliminar" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title">¿Está seguro?</h4>
	            </div>
	            <div class="modal-body">
	                <p>Está apunto de borrar el registro de acceso con los siguientes valores:
										Rol <b><span id="modal-rol"></span></b>,
										Módulo<b> <span id="modal-modulo"></span></b>,
										Acción<b> <span id="modal-accion"></span></b>.
											¿Está completamente seguro de eliminarlo? </p>
							</div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	                <button id="modal-eliminar" type="button" class="btn btn-danger" data-dismiss="modal">Eliminar</button>
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
<script src="../js/modulos-roles.js"></script>
</body>
</html>
