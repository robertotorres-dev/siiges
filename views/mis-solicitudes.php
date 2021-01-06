<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	require_once "../models/modelo-rol.php";
	Utileria::validarSesion( basename( __FILE__ ) );
	//====================================================================================================
	$resultado = "";
	if(isset($_SESSION["resultado"])){
	  $resultado = json_decode($_SESSION["resultado"]);
	  unset($_SESSION["resultado"]);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Menu RVOE (IESI)</title>
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
				<div id="mensaje">
					<?php if(isset($resultado) && isset($resultado->status) && $resultado->status != "200"): ?>
						<div class="alert alert-danger">
							<p><?= $resultado->message ?></p>
						</div>
						<?php  endif; ?>
				</div>
				<!-- CUERPO PRINCIPAL -->
				<div class=" form-group col-sm-12 col-md-12 col-lg-12">
					<!-- TÍTULO -->
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h1 id="txtNombre">Mis Solicitudes</h2>
								<hr class="red">
						</div>
						<div id="cargando" class="loader">

						</div>
						<input type="hidden" id="opcionesCargar" value="1">
						<?php if(Rol::ROL_REPRESENTANTE_LEGAL == $_SESSION["rol_id"]): ?>
						<div class="form-group col-sm-12 col-md-12">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<label class="control-label" for="">Tipo de solicitud:</label><br>
								<!-- Fin de convocatoria 2019 -->
								<!-- <select id="tipo_solicitud" class="form-control"  onchange="Solicitud.opciones()"  >
									<option value="">Selecione una opcion</option>
								</select> -->
								<br>
								<!-- <p class="text-muted small">
									<strong>¡Aviso importante! </strong>
									Le recordamos que la convocatoria para la solicitud de RVOE 2019 con vigencia el día 17 de enero de 2019 ha cerrado. Estar atento a la próxima fecha de convocatoria 2020.
								</p> -->
							</div>
							<div id="opcion-modalidad" class="col-sm-12 col-md-12 col-lg-12" style="display:none">
								<label class="control-label" for="">Modalidad:</label><br>
								<select id="modalidad_cargar" class="form-control">
									<option value="">Selecione una opcion</option>
								</select>
								<br>
							</div>
							<div id="plantelregistrado" class="col-sm-12 col-md-12" style="display:none">
									<label class="control-label">Plantel <sup>1</sup> :</label>
									<select class="form-control" id="planteles" >
										<option value="">Seleccione una opción</option>
									</select>
									<br>
									<p class="small"> <sup>1</sup> En caso de contar con un plantel previamente registrado</p>
									<hr class="division">
							</div>

							<div id="div-programas" class="col-sm-12 col-md-12" style="display:none">
								<label class="control-label" for="">Programa *: </label><br>
								<select class="form-control" id="programas_ids" onchange="Solicitud.borrar()">
									<option value="">Seleccione una opción</option>
								</select>
								<br>
								<p class="small">En caso de ya tener uno registrado previamente en la plataforma.</p>
								<hr class="division"><br>
							</div>

							<div class="col-sm-12 col-md-12 col-lg-12">
								<a id="enlace-solicitud" href="" class="btn btn-primary pull-right" onclick="Solicitud.redirigir()" >Aceptar y continuar</a>
								<br><br><br>
							</div>
						</div>
					<?php endif;?>

					<!-- Tabla de mis Solicitudes -->
					<div class="col-sm-12 col-md-12">
						<table id="solicitudes" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
										<th>Folio de captura</th>
										<th>Plan de estudios</th>
										<th>Fecha de alta</th>
										<th>Estatus</th>
										<th>Plantel</th>
										<th>Acciones</th>
								</tr>
							</thead>
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
			                <h4 class="modal-title">¿Estás seguro?</h4>
			            </div>
			            <div class="modal-body">
			                <p>Esta apunto de borrar la solicitud con folio: <span id="informacion-solicitud"></span></p>
			                <p class="text-warning"><small>Nota: Si borras la solicitud, se cancelará el trámite.</small></p>
									</div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			                <button id="eliminar" value=""  onclick="Solicitud.borrarRegistro()"type="button" class="btn btn-danger" data-dismiss="modal">Eliminar</button>
			            </div>
			        </div>
			    </div>
			</div>
			<!-- usuario_id -->
			<input id="usuario_id" type="hidden"  value="<?=$_SESSION["id"]?>">
			<input type="hidden" id="rol_id" value="<?=$_SESSION["rol_id"]?>">
		</div>
		<!-- JS GOB.MX -->
		<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
		<!-- JS JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
		<!-- SECCION PARA SCRIPTS -->
		<script src="../js/funciones.js"></script>

		<script src="../js/solicitudes.js"></script>
	</body>

</html>
