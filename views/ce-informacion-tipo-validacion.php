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

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Validaci&oacute;n</title>
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
	<!-- Zoom CSS -->
<link rel="stylesheet" type="text/css" href="css/zoom.css">
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
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-validacion.php" enctype="multipart/form-data">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<!-- TÍTULO -->
					<h2 id="txtNombre">Tipo de documento para validaci&oacute;n</h2>
					<hr class="red">

					<!-- CONTENIDO -->
					<div class="row">
						<div class="col-sm-12">
							<h4>Carta de validaci&oacute;n</h4>
							<p>Esta carta es por alumno con firma de directivos en original o firma electr&oacute;nica con los siguientes requisitos.</p>
							<ul>
								<li>Hoja membretada</li>
								<li>Datos generales de la IES</li>
								<li>Datos del alumno a validar</li>
								<ul>
									<li>Nombre completo</li>
									<li>Carrera</li>
									<li>Generaci&oacute;n</li>
									<li>Folio</li>
								</ul>
							</ul>
						</div>
					</div>
					<div class="row">
						<p>
							<img src="../images/page.jpg" class="rounded mx-auto d-block" alt="...">
						</p>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<h4>Oficio de validaci&oacute;n</h4>
							<ul>
								<li>Hoja membretada</li>
								<li>N&uacute;mero de oficio</li>
								<li>Fecha de expedici&oacute;n</li>
								<li>Firma de directivos en original o firma electr&oacute;nica</li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<h4>C&eacute;dula profesional</h4>
							<p>Esta se debe presentar &uacute;nicamente para posgradoscon los siguientes requisitos.</p>
							<ul>
								<li>Copia cotejada de la c&eacute;dula profesional estatal o federal</li>
								<li>Firma de directivos en original o firma electr&oacute;nica</li>
							</ul>
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
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Zoom Js -->
<script src="js/zoom.js"></script>
<script>
</script>
<script src="../js/validacionAlumno.js"></script>
</body>
</html>
