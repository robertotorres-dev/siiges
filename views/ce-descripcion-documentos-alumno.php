<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
Utileria::validarSesion(basename(__FILE__));

//====================================================================================================
$resultado = "";
if (isset($_SESSION["resultado"])) {
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
	<title>Documentos</title>
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
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="" enctype="multipart/form-data">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<!-- TÍTULO -->
					<h2 id="txtNombre">Tipo de documento de preinscripci&oacute;n de alumno</h2>
					<hr class="red">

					<!-- CONTENIDO -->
					<div class="row">
						<div class="col-sm-12">
							<h4>Preincripci&oacute;n</h4>
							<p>La IES deberá registrar en SIIGES las matrículas respetando las fechas establecidas en el calendario autorizado.</p>
							<ul>
								<li>La documentación de cada matrícula se deberá cargar al SIIGES tomando en cuenta el formato que se menciona en el manual de usuarios de control escolar.</li>
								<li>Se deberá escanear del original y a color para el caso de documentos que contengan firmas autógrafas.</li>
								<li>En el caso de documentos con QR y firma electrónica, se deberá cargar el documento que al escanear el código se descargue, excepto aquellos que requieren firma y sello.</li>
							</ul>
							<p><strong>No se aceptarán documentos incompletos o ilegibles ni fotografías, por lo que es imprescindible que si el documento contiene información en la parte de atrás, debe escanearse también.</strong></p>
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<h4>Posgrado</h4>
							<ol>
								<li>Antecedente académico: cédula profesional federal o estatal, Título, Grado.</li>
								<li>En caso de que sea extranjero o haya cursado la licenciatura en otro país, deberá cargar como antecedente académico la Revalidación de Estudios</li>
								<li>Acta de nacimiento</li>
								<li>CURP (formato actualizado)</li>
							</ol>
						</div>
					</div><br><br>
					<div class="row">
						<div class="col-sm-12">
							<p>Para matrículas que se inscriben al posgrado como opción de modalidad de titulación de la licenciatura, deberán cargar en el apartado de antecedente académico en un solo archivo la siguiente documentación escaneada:
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<ol>
								<li>Certificado total de estudios de licenciatura</li>
								<li>Carta de autorización de la institución de procedencia.</li>
								<li>Carta de aceptación dirigida al alumno que haga mención del artículo en el que el reglamento autorizado señala dicha modalidad (hoja membretada, firmada y sellada)</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<h4>Cédula federal (Formato físico)</h4>
						</div>
					</div>
					<div class="row">
						<div class="image-wrap">
							<div id="cedula_1" class="image"></div>
						</div>
					</div>
					<br><br>
					<div class="row">
						<div class="image-wrap">
							<div id="cedula_2" class="image"></div>
						</div>
					</div>
					<br><br>
					<div class="row">
						<div class="col-sm-12">
							<h4>Cédula federal (Formato electrónico)</h4>
						</div>
					</div>
					<div class="row">
						<div class="image-wrap">
							<div id="cedula_3" class="image"></div>
						</div>
					</div>
					<br><br>
					<div class="row">
						<div class="col-sm-12">
							<h4>Cédula estatal (Formato físico)</h4>
						</div>
					</div>
					<div class="row">
						<div class="image-wrap">
							<div id="cedula_4" class="image"></div>
						</div>
					</div>
					<br><br>
					<div class="row">
						<div class="col-sm-12">
							<h4>Cédula estatal (Formato electrónico)</h4>
						</div>
					</div>
					<div class="row">
						<div class="image-wrap">
							<div id="cedula_5" class="image"></div>
						</div>
					</div>
					<br><br>
					<div class="row">
						<div class="col-sm-12">
							<h4>Título (Formato físico)</h4>
						</div>
					</div>
					<div class="row">
						<div class="image-wrap">
							<div id="titulo_fisico" class="image"></div>
						</div>
					</div>
					<br><br>
					<div class="row">
						<div class="col-sm-12">
							<h4>Título (Formato electrónico)</h4>
						</div>
					</div>
					<div class="row">
						<div class="image-wrap">
							<div id="titulo_electronico" class="image"></div>
						</div>
					</div>
					<br><br>
					<div class="row">
						<div class="col-sm-12">
							<h4>Alumnos inscritos por modalidad de titulación estudios de posgrado</h4>
							<h5 style="text-align: center;">Carta de autorización</h5>
						</div>
					</div>
					<div class="row">
						<div class="image-wrap">
							<div id="carta_autorizacion" class="image"></div>
						</div>
					</div>
					<br><br>
					<div class="row">
						<div class="col-sm-12">
							<h5 style="text-align: center;">Carta de aceptación</h5>
						</div>
					</div>
					<div class="row">
						<div class="image-wrap">
							<div id="carta_aceptacion" class="image"></div>
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
	<!-- JS PROPIOS -->
	<script>
		$gmx(document).ready(function() {
			const images = [
				document.querySelector('#cedula_1'),
				document.querySelector('#cedula_2'),
				document.querySelector('#cedula_3'),
				document.querySelector('#cedula_4'),
				document.querySelector('#cedula_5'),
				document.querySelector('#titulo_fisico'),
				document.querySelector('#titulo_electronico'),
				document.querySelector('#carta_autorizacion'),
				document.querySelector('#carta_aceptacion')
			];
			if (images[0]) {
				images.forEach(image => {
					image.addEventListener('mousemove', function(e) {
						let width = image.offsetWidth;
						let height = image.offsetHeight;
						let mouseX = e.offsetX;
						let mouseY = e.offsetY;

						let bgPosX = (mouseX / width * 100);
						let bgPosY = (mouseY / height * 100);

						image.style.backgroundPosition = `${bgPosX}% ${bgPosY}%`;
					});

					image.addEventListener('mouseleave', function() {
						image.style.backgroundPosition = "center";
					});
				});
			}
		})
	</script>
</body>

</html>