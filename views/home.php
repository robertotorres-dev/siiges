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
	<title>SIIGES</title>
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
						<li class="active">SIIGES</li>
					</ol>
				</div>
			</div>

			<div id="message">
        <?php if($resultado && isset($resultado->status) && $resultado->status != "200"): ?>
          <div class="alert alert-danger">
          	<p><?= $resultado->message ?></p>
          </div>
          <?php  endif; ?>
      </div>

			<!-- CUERPO PRINCIPAL -->
			<div class="col-sm-12 col-md-12 col-lg-9">
				<!-- TÍTULO -->
				<h2 id="txtNombre">Bienvenido</h2>
				<hr class="red">
				<!-- CONTENIDO -->
				<div class="row">
          <div class="col-sm-12">
						<p class="text-justify">Bienvenida/o al Sistema Integral de Información para la Gestión de la Educación Superior, aquí las instituciones con reconocimiento de validez oficial de estudios (RVOE) podrán realizar sus trámites de manera digital de los procesos y trámites ante la dirección general de educación superior, investigación y posgrado de la Secretaria de Innovación, Ciencia y Tecnología.
						En esta plataforma obtendrás de manera digital y sencilla una administración dinámica de información segura convirtiéndose en un poderoso portal para tu institución educativa. En este portal, los procesos estratégicos y/o módulos tienen una disponibilidad 24/7 otorgando accesibilidad y velocidad en la entrega de contenido al usuario, eliminando los antiguos y complejos procesos de alto uso de papeleo y trámites para lograr la  innovación en procesos de las instituciones educativas ante la Secretaria de Innovación, Ciencia y Tecnología del Gobierno del Estado de Jalisco.</p>
          </div>
        </div>
			</div>

			<!-- CARD USUARIO LATERAL -->
			<?php require_once "aside-usuario.php"; ?>

		</section>
	</div>

	<!-- JS GOB.MX -->
	<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
	<!-- JS JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
	<!-- SECCION PARA SCRIPTS -->
	<script src="../js/home.js"></script>
</body>
</html>
