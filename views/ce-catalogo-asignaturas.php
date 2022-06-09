<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
Utileria::validarSesion(basename(__FILE__));

//====================================================================================================

require_once "../models/modelo-programa.php";
require_once "../models/modelo-plantel.php";
require_once "../models/modelo-asignatura.php";
require_once "../models/modelo-institucion.php";

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
						<li><a href="ce-programas-plantel.php
						<?php
						if (isset($resultadoInstitucion["data"][0])) {
							$resultadoInstitucion["data"] = $resultadoInstitucion["data"][0];
						}

						echo "?institucion_id=" . $resultadoInstitucion["data"]["id"] . "&plantel_id=" . $resultadoPlantel["data"]["id"];

						?>">Programas de Estudios</a></li>
						<li class="active">Cat&aacute;logo Asignaturas</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-asignatura.php">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<!-- TÍTULO -->
					<h2 id="txtNombre">Cat&aacute;logo de Asignaturas</h2>
					<hr class="red">
					<div class="row">
						<div class="col-sm-12">
							<legend><?php echo $resultadoPrograma["data"]["nombre"]; ?></legend>
						</div>
					</div>
					<!-- NOTIFICACIÓN -->
					<?php if (isset($_GET["codigo"]) && $_GET["codigo"] == 200) { ?>
						<div class="alert alert-success">
							<p>Registro guardado.</p>
						</div>
					<?php } ?>

					<!-- CONTENIDO -->
					<div class="row">
						<?php
						if (
							Rol::ROL_ADMIN == $_SESSION["rol_id"]
							|| Rol::ROL_CONTROL_ESCOLAR_SICYT == $_SESSION["rol_id"]
							|| Rol::ROL_SICYT_EDITAR == $_SESSION["rol_id"]
						) {
						?>
							<div class="col-sm-12">
								<a href="ce-editar-asignatura.php<?php echo "?programa_id=" . $resultadoPrograma["data"]["id"]; ?>&proceso=alta" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-plus"></i> Alta de Asignatura</a>
							</div>
					</div>
				<?php
						}
				?>
				<div class="row" style="padding-top: 20px;">
					<div class="col-sm-12">
					</div>
				</div>
				<!-- Contenido del formulario -->
				<div class="row">
					<div class="col-sm-12">
						<table id="tabla-reporte1" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th width="15%">Grado</th>
									<th width="35%">Asignatura</th>
									<th width="10%">Clave</th>
									<th width="10%">Seriaci&oacute;n</th>
									<th width="10%">Docente</th>
									<th width="10%">Independiente</th>
									<th width="10%">Cr&eacute;ditos</th>
									<th width="10%">Consecutivo</th>
									<th width="10%">Acciones</th>
								</tr>
							</thead>
							<tbody>
								<?php

								$parametros3["programa_id"] = $_GET["programa_id"];
								$parametros3["grado"] = "Primer cuatrimestre";

								$parametros4["programa_id"] = $_GET["programa_id"];
								$parametros4["grado"] = "Optativa";

								$asignatura = new Asignatura();
								$asignatura->setAttributes($parametros3);
								$resultadoAsignatura = $asignatura->consultarPor('asignaturas', array("programa_id" => $_GET['programa_id'], "deleted_at"), '*');

								$max = count($resultadoAsignatura["data"]);

								for ($i = 0; $i < $max; $i++) {

								?>
									<input type="hidden" id="id[]" name="id[]" value="<?php echo $resultadoAsignatura["data"][$i]["id"] ?>" />
									<tr>
										<td><?php echo $resultadoAsignatura["data"][$i]["grado"]; ?></td>
										<td><?php echo $resultadoAsignatura["data"][$i]["nombre"]; ?></td>
										<td><?php echo $resultadoAsignatura["data"][$i]["clave"]; ?></td>
										<td><?php echo $resultadoAsignatura["data"][$i]["seriacion"]; ?></td>
										<td><?php echo $resultadoAsignatura["data"][$i]["horas_docente"]; ?></td>
										<td><?php echo $resultadoAsignatura["data"][$i]["horas_independiente"]; ?></td>
										<td><?php echo $resultadoAsignatura["data"][$i]["creditos"]; ?></td>
										<td><?php echo $resultadoAsignatura["data"][$i]["consecutivo"]; ?></td>
										<td>
											<?php
											if (
												Rol::ROL_ADMIN == $_SESSION["rol_id"]
												|| Rol::ROL_CONTROL_ESCOLAR_SICYT == $_SESSION["rol_id"]
												|| Rol::ROL_SICYT_EDITAR == $_SESSION["rol_id"]
											) {
											?>
												<a href="../views/ce-editar-asignatura.php<?php echo "?programa_id=" . $resultadoPrograma["data"]["id"] . "&asignatura_id=" . $resultadoAsignatura["data"][$i]["id"] . "&proceso=edicion"; ?>"><span class='glyphicon glyphicon-edit'></span></a>
												<a href="../views/ce-editar-asignatura.php<?php echo "?programa_id=" . $resultadoPrograma["data"]["id"] . "&asignatura_id=" . $resultadoAsignatura["data"][$i]["id"] . "&proceso=consulta"; ?>"><span class='glyphicon glyphicon-eye-open'></span></a>
												<a href="#" onclick="Asignaturas.modalEliminarAsignatura('<?php echo $resultadoAsignatura['data'][$i]['id'] ?>', '<?php echo $resultadoAsignatura['data'][$i]['nombre'] ?>', '<?php echo $resultadoAsignatura['data'][$i]['clave'] ?>', '<?php echo $resultadoPrograma['data']['id'] ?>')"><span class='glyphicon glyphicon-trash'></span></a>
											<?php } else { ?>
												<a href="../views/ce-editar-asignatura-institucion.php<?php echo "?programa_id=" . $resultadoPrograma["data"]["id"] . "&asignatura_id=" . $resultadoAsignatura["data"][$i]["id"] . "&proceso=edicion"; ?>"><span class='glyphicon glyphicon-edit'></span></a>
												<a href="../views/ce-editar-asignatura-institucion.php<?php echo "?programa_id=" . $resultadoPrograma["data"]["id"] . "&asignatura_id=" . $resultadoAsignatura["data"][$i]["id"] . "&proceso=consulta"; ?>"><span class='glyphicon glyphicon-eye-open'></span></a>
											<?php } ?>
										</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
				</div>
			</form>
		</section>
		<div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-hidden="true">
			<div id="tamanoModalMensaje" class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Eliminar asignatura</h4>
					</div>
					<div class="modal-body">
						<div id="mensajeAsignatura"></div>
					</div>
					<div id="mensaje-footer" class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- JS GOB.MX -->
	<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
	<!-- JS JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- JS DATATABLE -->
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

	<!-- JS LIVESELECT -->
	<script src="../js/bootstrap-select.min.js"></script>
	<!-- JS CALENDAR -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript"></script>
	<!-- SECCION PARA SCRIPTS -->
	<script src="../js/catalogoAsignaturas.js"></script>
</body>

</html>