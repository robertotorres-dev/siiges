<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
Utileria::validarSesion(basename(__FILE__));

//====================================================================================================

require_once "../models/modelo-programa.php";
require_once "../models/modelo-alumno.php";
require_once "../models/modelo-persona.php";
require_once "../models/modelo-tipo-tramite.php";

$programa = new Programa();
$programa->setAttributes(array("id" => $_GET["programa_id"]));
$resultadoPrograma = $programa->consultarId();

$alumno = new Alumno();
$alumno->setAttributes(array("id" => $_GET["alumno_id"]));
$resultadoAlumno = $alumno->consultarId();

$persona = new Persona();
$persona->setAttributes(array("id" => $resultadoAlumno["data"]["persona_id"]));
$resultadoPersona = $persona->consultarId();

if ($resultadoPrograma["data"]["nivel_id"] == 2 || $resultadoPrograma["data"]["nivel_id"] == 3) {
	$titulo_certificado1 = "Archivo Certificado de Bachillerato o equivalente (PDF)";
	$titulo_certificado2 = "Acreditación Certificado de Bachillerato";
}

if ($resultadoPrograma["data"]["nivel_id"] >= 4 && $resultadoPrograma["data"]["nivel_id"] <= 7) {
	$titulo_certificado1 = "Archivo C&eacute;dula Profesional, T&iacute;tulo o equivalente (PDF)";
	$titulo_certificado2 = "Acreditación C&eacute;dula Profesional, T&iacute;tulo o equivalente";
}
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
						<li><a href="ce-alumnos.php?programa_id=<?php echo $_GET["programa_id"]; ?>">Alumnos</a></li>
						<li class="active">Documentos</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-alumno.php" enctype="multipart/form-data">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<!-- TÍTULO -->
					<h2 id="txtNombre">Documentos</h2>
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
					<?php if (isset($_GET["codigo"]) && $_GET["codigo"] == 404) { ?>
						<div class="alert alert-danger">
							<p>Error en el archivo adjunto.</p>
						</div>
					<?php } ?>
					<!-- CONTENIDO -->
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="id">Id</label>
								<input type="text" id="id" name="id" value="<?php echo $resultadoAlumno["data"]["id"]; ?>" maxlength="11" class="form-control" readonly />
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="persona_id">Persona Id</label>
								<input type="text" id="persona_id" name="persona_id" value="<?php echo $resultadoAlumno["data"]["persona_id"]; ?>" maxlength="11" class="form-control" readonly />
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="programa_id">Programa Id</label>
								<input type="text" id="programa_id" name="programa_id" value="<?php echo $_GET["programa_id"]; ?>" maxlength="11" class="form-control" required readonly />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="nombre">Nombre</label>
								<input type="text" id="nombre" name="nombre" value="<?php echo $resultadoPersona["data"]["nombre"]; ?>" maxlength="255" class="form-control" required readonly />
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="apellido_paterno">Apellido Paterno</label>
								<input type="text" id="apellido_paterno" name="apellido_paterno" value="<?php echo $resultadoPersona["data"]["apellido_paterno"]; ?>" maxlength="255" class="form-control" required readonly />
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="apellido_materno">Apellido Materno</label>
								<input type="text" id="apellido_materno" name="apellido_materno" value="<?php echo $resultadoPersona["data"]["apellido_materno"]; ?>" maxlength="255" class="form-control" required readonly />
							</div>
						</div>
					</div>
					<?php
					if ($resultadoAlumno["data"]["tipo_tramite_id"] == 1) :
						$tipoTramite = new TipoTramite();
						$tipoTramite->setAttributes(array("id" => $resultadoAlumno["data"]["tipo_tramite_id"]));
						$resultadoTipoTramite = $tipoTramite->consultarId();
					?>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label" for="tipo_tramite">Tipo de tr&aacute;mite</label>
									<input type="text" name="tipo_tramite" value="<?php echo $resultadoTipoTramite["data"]["nombre"]; ?>" maxlength="255" class="form-control" readonly />
								</div>
							</div>
						</div>
					<?php endif; ?>
					<br><br>
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label class="control-label" for="archivo_certificado"><?php echo $titulo_certificado1; ?>
									<a class="questionmark" href="./ce-descripcion-documentos-alumno.php" target="_blank">
										<span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Da clic para ver los datalles de cada documento"></span>
									</a>
								</label>
								<input type="file" id="archivo_certificado" name="archivo_certificado" accept="application/pdf" class="form-control" />
								<div><a href="../uploads/certificados/<?php echo $resultadoAlumno["data"]["archivo_certificado"]; ?>" target="_blank"><?php echo $resultadoAlumno["data"]["archivo_certificado"]; ?></a></div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="estatus_certificado"><?php echo $titulo_certificado2; ?></label>
								<input type="checkbox" id="estatus_certificado" name="estatus_certificado" value="1" class="form-control" <?php if ($resultadoAlumno["data"]["estatus_certificado"] == "1") {
																																																														echo "checked";
																																																													} ?> <?php if ($_SESSION["rol_id"] != 13) {
																																																																	echo "disabled";
																																																																} ?> />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label class="control-label" for="archivo_nacimiento">Archivo Acta de Nacimiento (PDF)</label>
								<input type="file" id="archivo_nacimiento" name="archivo_nacimiento" accept="application/pdf" class="form-control" />
								<div><a href="../uploads/certificados/<?php echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?>" target="_blank"><?php echo $resultadoAlumno["data"]["archivo_nacimiento"]; ?></a></div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="estatus_nacimiento">Acreditaci&oacute;n Acta de Nacimiento</label>
								<input type="checkbox" id="estatus_nacimiento" name="estatus_nacimiento" value="1" class="form-control" <?php if ($resultadoAlumno["data"]["estatus_nacimiento"] == "1") {
																																																													echo "checked";
																																																												} ?> <?php if ($_SESSION["rol_id"] != 13) {
																																																																echo "disabled";
																																																															} ?> />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label class="control-label" for="archivo_curp">Archivo CURP (PDF)</label>
								<input type="file" id="archivo_curp" name="archivo_curp" accept="application/pdf" class="form-control" />
								<div><a href="../uploads/certificados/<?php echo $resultadoAlumno["data"]["archivo_curp"]; ?>" target="_blank"><?php echo $resultadoAlumno["data"]["archivo_curp"]; ?></a></div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="estatus_curp">Acreditaci&oacute;n CURP</label>
								<input type="checkbox" id="estatus_curp" name="estatus_curp" value="1" class="form-control" <?php if ($resultadoAlumno["data"]["estatus_curp"] == "1") {
																																																							echo "checked";
																																																						} ?> <?php if ($_SESSION["rol_id"] != 13) {
																																																										echo "disabled";
																																																									} ?> />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label" for="observaciones1">Observaciones IESI</label>
								<textarea id="observaciones1" name="observaciones1" rows="6" class="form-control" <?php if ($_SESSION["rol_id"] == 13) {
																																																		echo "disabled";
																																																	} ?>><?php echo $resultadoAlumno["data"]["observaciones1"]; ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label" for="observaciones2">Observaciones SICYT</label>
								<textarea id="observaciones2" name="observaciones2" rows="6" class="form-control" <?php if ($_SESSION["rol_id"] != 13) {
																																																		echo "disabled";
																																																	} ?>><?php echo $resultadoAlumno["data"]["observaciones2"]; ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<input type="submit" id="submit" name="submit" value="Enviar" class="btn btn-primary" />
								<input type="hidden" name="webService" value="guardarAlumnoCertificado" />
								<input type="hidden" name="url" value="../views/ce-documentos.php?programa_id=<?php echo $_GET["programa_id"]; ?>&alumno_id=<?php echo $_GET["alumno_id"]; ?>&codigo=200" />
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
	<script>
		$gmx(document).ready(function() {

			$('[data-toggle="tooltip"]').tooltip();

			$("#fecha_nacimiento").datepicker({
				firstDay: 1,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
				dateFormat: 'yy-mm-dd'
			});
		});
	</script>
</body>

</html>