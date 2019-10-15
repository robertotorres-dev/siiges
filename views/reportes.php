<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Reportes SIIGES</title>

	<!-- CSS GOB.MX -->
	<link href="../favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<!-- CSS SIIGES -->
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body class="">
	<!-- HEADER Y BARRA DE NAVEGACION -->
	<?php require_once "menu.php"; ?>

	<!-- CUERPO DEL FORMULARIO -->
	<div class="container">
		<section class="main row margin_section_formularios">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li><a href="#"><i class="icon icon-home"></i></a></li>
					<li><a href="#">SIIGES</a></li>
					<li class="active">Reportes</li>
				</ol>

				<h2>Reportes</h2>
				<hr class="red">
			</div>

			<!-- FILTROS DEL REPORTE -->
			<div class="col-md-12">
				<form role="form" class="form">
					<div class="form-inline">
						<div class="form-group" style="width: 100%;">
							<span id="icoEmail" class="glyphicon glyphicon-filter col-sm-1 size_icon">Filtros</span>
							<select id="selRol" class="form-control">
								<option>Año</option>
								<option>2001</option>
								<option>2005</option>
							</select>
							<select id="selRol" class="form-control">
								<option>Institución</option>
								<option>U de G</option>
								<option>Univa</option>
							</select>
							<select id="selRol" class="form-control">
								<option>Status</option>
								<option>Terminado</option>
								<option>En proceso</option>
							</select>
						</div>

					</div>
				</form>
			</div>

			<!-- CUERPO DE GRAFICOS -->
			<div class="col-md-9">
				<button id="btnRegistrarseRegistro" type="submit" class="btn btn-primary btn-sm pull-right">
					<span class="glyphicon glyphicon-print"></span> Imprimir</button>
				</div>
			</section>
			<br><br>
		</div>

		<!-- JS DE GOB.MX -->
		<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
		<!-- JS JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!-- SECCION PARA SCRIPTS -->

	</body>
	</html>
