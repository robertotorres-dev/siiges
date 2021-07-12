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
						<li><a href="home.php">SIIGES</a></li>
						<li><a href="ce-programas.php">Programas de Estudios</a></li>
						<!-- <li><a href="ce-ciclos-escolares.php?programa_id=<?php echo $_GET["programa_id"]; ?>">Ciclos Escolares</a></li>
						<li><a href="ce-grados.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>">Grados</a></li>
						<li><a href="ce-grupos.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>">Grupos</a></li> -->
						<li class="active">Cat&aacutelogo Asignaturas</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-asignatura.php">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<!-- TÍTULO -->
					<h2 id="txtNombre">Cat&aacutelogo de Asignaturas</h2>
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
					<div class="row" style="padding-top: 20px;">
						<div class="col-sm-12">
						</div>
					</div>
					<!-- Contenido del formulario -->
					<div id="tabs" class="tab-content col-sm-12 col-md-12">


					</div>
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
											<td><select class="form-control" id="grado[]" name="grado[]" required placeholder="Seleccione una opcion">
													<option value="">Seleccione una opción</option>
													<optgroup label="Semestres">
														<option value="Primer semestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Primer semestre") {
																															echo "Selected";
																														} ?>>Primero</option>
														<option value="Segundo semestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Segundo semestre") {
																																echo "Selected";
																															} ?>>Segundo</option>
														<option value="Tercero semestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Tercero semestre") {
																																echo "Selected";
																															} ?>>Tercero</option>
														<option value="Cuarto semestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Cuarto semestre") {
																															echo "Selected";
																														} ?>>Cuarto</option>
														<option value="Quinto semestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Quinto semestre") {
																															echo "Selected";
																														} ?>>Quinto</option>
														<option value="Sexto semestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Sexto semestre") {
																															echo "Selected";
																														} ?>>Sexto</option>
														<option value="Septimo semestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Septimo semestre") {
																																echo "Selected";
																															} ?>>S&eacuteptimo</option>
														<option value="Octavo semestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Octavo semestre") {
																															echo "Selected";
																														} ?>>Octavo</option>
														<option value="Noveno semestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Noveno semestre") {
																															echo "Selected";
																														} ?>>Noveno</option>
														<option value="Decimo semestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Decimo semestre") {
																															echo "Selected";
																														} ?>>Decimo</option>
													</optgroup>
													<optgroup label="Cuatrimestres">
														<option value="Primer cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Primer cuatrimestre") {
																																	echo "Selected";
																																} ?>>Primero</option>
														<option value="Segundo cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Segundo cuatrimestre") {
																																		echo "Selected";
																																	} ?>>Segundo</option>
														<option value="Tercero cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Tercero cuatrimestre") {
																																		echo "Selected";
																																	} ?>>Tercero</option>
														<option value="Cuarto cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Cuarto cuatrimestre") {
																																	echo "Selected";
																																} ?>>Cuarto</option>
														<option value="Quinto cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Quinto cuatrimestre") {
																																	echo "Selected";
																																} ?>>Quinto</option>
														<option value="Sexto cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Sexto cuatrimestre") {
																																	echo "Selected";
																																} ?>>Sexto</option>
														<option value="Septimo cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Septimo cuatrimestre") {
																																		echo "Selected";
																																	} ?>>S&eacute;ptimo</option>
														<option value="Octavo cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Octavo cuatrimestre") {
																																	echo "Selected";
																																} ?>>Octavo</option>
														<option value="Noveno cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Noveno cuatrimestre") {
																																	echo "Selected";
																																} ?>>Noveno</option>
														<option value="Decimo cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Decimo cuatrimestre") {
																																	echo "Selected";
																																} ?>>D&eacute;cimo</option>
														<option value="Undecimo cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Undecimo cuatrimestre") {
																																		echo "Selected";
																																	} ?>>Und&eacute;cimo</option>
														<option value="Duodecimo cuatrimestre" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Duodecimo cuatrimestre") {
																																			echo "Selected";
																																		} ?>>Duod&eacute;cimo</option>
													</optgroup>
													<optgroup label="Curriculum Flexible">
														<option value="Flexible Cuatrimestral" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Flexible Cuatrimestral") {
																																			echo "Selected";
																																		} ?>>Listado Cuatrimestral</option>
														<option value="Flexible Semestral" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Flexible Semestral") {
																																	echo "Selected";
																																} ?>>Listado Semestral</option>
														<option value="Optativa" <?php if ($resultadoAsignatura["data"][$i]["grado"] === "Optativa") {
																												echo "Selected";
																											} ?>>Optativa</option>
													</optgroup>
												</select></td>
											<td><input type="text" id="nombre[]" name="nombre[]" value="<?php echo $resultadoAsignatura["data"][$i]["nombre"]; ?>" class="form-control" /></td>
											<td><input type="text" id="clave[]" name="clave[]" value="<?php echo $resultadoAsignatura["data"][$i]["clave"]; ?>" class="form-control" /> </td>
											<td><input type="text" id="seriacion[]" name="seriacion[]" value="<?php echo $resultadoAsignatura["data"][$i]["seriacion"]; ?>" class="form-control" /> </td>
											<td><input type="number" id="horas_docente[]" name="horas_docente[]" value="<?php echo $resultadoAsignatura["data"][$i]["horas_docente"]; ?>" class="form-control" /> </td>
											<td><input type="number" id="horas_independiente[]" name="horas_independiente[]" value="<?php echo $resultadoAsignatura["data"][$i]["horas_independiente"]; ?>" class="form-control" /> </td>
											<td><input type="number" id="creditos[]" name="creditos[]" value="<?php echo $resultadoAsignatura["data"][$i]["creditos"]; ?>" class="form-control" /> </td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<input type="submit" id="submit" name="submit" value="Enviar" class="btn btn-primary" />
								<input type="hidden" name="webService" value="guardarAsignaturaPrograma" />
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