<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
Utileria::validarSesion(basename(__FILE__));

//====================================================================================================

require_once "../models/modelo-programa.php";
require_once "../models/modelo-grupo.php";
require_once "../models/modelo-turno.php";
require_once "../models/modelo-asignatura.php";
require_once "../models/modelo-alumno-grupo.php";
require_once "../models/modelo-alumno.php";
require_once "../models/modelo-persona.php";

$programa = new Programa();
$programa->setAttributes(array("id" => $_GET["programa_id"]));
$resultadoPrograma = $programa->consultarId();

$grupo = new Grupo();
$grupo->setAttributes(array("id" => $_GET["grupo_id"]));
$resultadoGrupo = $grupo->consultarId();

$tramiteEquiv = "";

if (isset($_GET["tramite"])) :
	if ($_GET["tramite"] = "equiv") :
		$tramiteEquiv = "equiv";
	endif;
endif;
?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SIIGES</title>
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
						<?php
						if (
							Rol::ROL_REVALIDACION_EQUIVALENCIA == $_SESSION["rol_id"] ||
							(Rol::ROL_REPRESENTANTE_LEGAL == $_SESSION["rol_id"] && $tramiteEquiv == "equiv") ||
							(Rol::ROL_CONTROL_ESCOLAR_IES == $_SESSION["rol_id"] && $tramiteEquiv == "equiv")
						) {
						?>
							<li><a href="ce-ciclos-escolares-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>">Ciclos Escolares</a></li>
							<li><a href="ce-grados-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>">Grados</a></li>
							<li><a href="ce-grupos-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>">Grupos</a></li>
						<?php	} else { ?>
							<li><a href="ce-ciclos-escolares.php?programa_id=<?php echo $_GET["programa_id"]; ?>">Ciclos Escolares</a></li>
							<li><a href="ce-grados.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>">Grados</a></li>
							<li><a href="ce-grupos.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>">Grupos</a></li>
						<?php } ?>

						<li class="active">Asignaturas</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre">Asignaturas</h2>
				<hr class="red">
				<div class="row">
					<div class="col-sm-12">
						<legend><?php echo $resultadoPrograma["data"]["nombre"]; ?></legend>
					</div>
				</div>
				<!-- CONTENIDO -->
				<div class="row" style="padding-top: 20px;">
					<div class="col-sm-12">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<table id="tabla-reporte1" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th width="15%">Grado</th>
									<th width="10%">Grupo</th>
									<?php
									if (!(Rol::ROL_REVALIDACION_EQUIVALENCIA == $_SESSION["rol_id"] ||
										(Rol::ROL_REPRESENTANTE_LEGAL == $_SESSION["rol_id"] && $tramiteEquiv == "equiv") ||
										(Rol::ROL_CONTROL_ESCOLAR_IES == $_SESSION["rol_id"] && $tramiteEquiv == "equiv"))) :
									?>
										<th width="10%">Turno</th>
									<?php
									endif; ?>
									<th width="10%">Clave</th>
									<th width="45%">Asignatura</th>
									<th width="10%">Acciones</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$parametros["id"] = $_GET["grupo_id"];

								$grupo = new Grupo();
								$grupo->setAttributes($parametros);
								$resultadoGrupo = $grupo->consultarId();

								$parametros2["id"] = $resultadoGrupo["data"]["turno_id"];

								$turno = new Turno();
								$turno->setAttributes($parametros2);
								$resultadoTurno = $turno->consultarId();

								$parametros3["programa_id"] = $_GET["programa_id"];
								$parametros3["grado"] = $_GET["grado"];

								$parametros4["programa_id"] = $_GET["programa_id"];
								$parametros4["grado"] = "Optativa";

								$asignatura = new Asignatura();
								$asignatura->setAttributes($parametros3);
								$resultadoAsignatura = $asignatura->consultarAsignaturasGrado();

								$asignaturaOptativa = new Asignatura();
								$asignaturaOptativa->setAttributes($parametros4);
								$resultadoAsignaturaOptativa = $asignaturaOptativa->consultarAsignaturasGrado();

								$maxOpt = count($resultadoAsignaturaOptativa["data"]);

								for ($j = 0; $j < $maxOpt; $j++) {
									array_push($resultadoAsignatura["data"], $resultadoAsignaturaOptativa["data"][$j]);
								}

								$max = count($resultadoAsignatura["data"]);

								for ($i = 0; $i < $max; $i++) {

								?>
									<tr>
										<td><?php echo $resultadoAsignatura["data"][$i]["grado"]; ?></td>
										<td><?php echo $resultadoGrupo["data"]["grupo"]; ?></td>
										<?php
										if (!(Rol::ROL_REVALIDACION_EQUIVALENCIA == $_SESSION["rol_id"] ||
											(Rol::ROL_REPRESENTANTE_LEGAL == $_SESSION["rol_id"] && $tramiteEquiv == "equiv") ||
											(Rol::ROL_CONTROL_ESCOLAR_IES == $_SESSION["rol_id"] && $tramiteEquiv == "equiv"))) :
										?>
											<td><?php echo $resultadoTurno["data"]["nombre"]; ?></td>
										<?php
										endif; ?>
										<td><?php echo $resultadoAsignatura["data"][$i]["clave"]; ?></td>
										<td><?php echo $resultadoAsignatura["data"][$i]["nombre"]; ?></td>
										<?php isset($tramiteEquiv) ? $tramite = $tramiteEquiv : $tramite = ''; ?>
										<td>
											<a href="ce-ordinarios.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>&grupo_id=<?php echo $_GET["grupo_id"]; ?>&asignatura_id=<?php echo $resultadoAsignatura["data"][$i]["id"] ?>&tramite=<?php echo $tramite ?>">Ordinarios</a>
											<a href="ce-extraordinarios.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>&grupo_id=<?php echo $_GET["grupo_id"]; ?>&asignatura_id=<?php echo $resultadoAsignatura["data"][$i]["id"] ?>&tramite=<?php echo $tramite ?>">Extraordinarios</a>
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

		</section>
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
	<script>
		$(document).ready(function() {
			$("#generacion_fecha_inicio").datepicker({
				firstDay: 1,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
				dateFormat: 'yy-mm-dd'
			});

			$("#generacion_fecha_fin").datepicker({
				firstDay: 1,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
				dateFormat: 'yy-mm-dd'
			});
		});
	</script>
</body>

</html>