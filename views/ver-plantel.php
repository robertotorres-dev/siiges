<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Alta de plantel</title>
	<!-- CSS GOB.MX -->
	<link href="../favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<!-- CSS SIIGES -->
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">

</head>

<body class="">
	<!-- HEADER Y BARRA DE NAVEGACION -->
	<?php require_once "menu.php"; ?>
	<div id="cargando" class="loader">

	</div>
	<!-- CUERPO DEL FORMULARIO -->
	<div class="container">
		<section class="main row margin-section-formularios">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- BARRA DE USUARIO -->
				<ol class="breadcrumb pull-right">
					<li><i class="icon icon-user"></i></li>
						<li><?php echo $_SESSION["nombre_rol"]; ?></li>
					<li class="active"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"]; ?></li>
				</ol>
				<ol class="breadcrumb">
					<li><a href="home.php"><i class="icon icon-home"></i></a></li>
					<li><a href="home.php">SIIGES</a></li>
					<li><a href="institucion-planteles.php">Planteles</a></li>
					<li class="active">Editar plantel</li>
				</ol>

				<h2>Editar plantel</h2>
					<hr class="red">

					<!-- INICIA FORMULARIO -->
					<form id="form-alta-plantel" role="form" class="form" >
						<div class="form-group">
							 <div class="form-group col-sm-12 col-md-12">
								<legend>Domicilio</legend>
							</div>
								<div class="form-group col-sm-6 col-md-12">
									<input type="hidden" id="domicilio_id" name="domicilio_id" value="">
									<label class="control-label" for="">Calle</label><br>
									<input type="text" readonly id="calle" name="calle" class="form-control" value="" placeholder="Nombre de la calle, avenida" required>
								</div>
								<div class="form-group col-sm-6 col-md-6">
									<label class="control-label" for="">Número exterior</label><br>
									<input type="text" readonly id="numero_exterior" name="numero_exterior" class="form-control" value="" placeholder="Número exterior" required>
								</div>
								<div class="form-group col-sm-6 col-md-6">
									<label class="control-label" for="">Número interior</label><br>
									<input type="text" readonly id="numero_interior" name="numero_interior" class="form-control" value="" placeholder="Número interior en caso de tener">
								</div>
								<div class="form-group col-sm-6 col-md-6">
									<label class="control-label" for="">Colonia</label><br>
									<input type="text" readonly id="colonia" name="colonia" class="form-control" value="" placeholder="Nombre de la colonia" required>
								</div>
								<div class="form-group col-sm-6 col-md-6">
									<label class="control-label" for="">CP</label><br>
									<input type="text" readonly id="codigo_postal" name="codigo_postal" class="form-control" value="" placeholder="Código postal" required>
								</div>
								<div class="form-group col-sm-6 col-md-12">
									<label class="control-label" for="">Municipio</label><br>
									<div id="municipios">
										<select class="form-control" readonly id="municipio" name="municipio"  onchange="coordenadas()" required>
											<option value="">Seleccione municipio</option>
										</select>
									</div>
									<br>
								</div>
								<div class="col-sm-12 col-md-12">
									<label class="control-label">Mapa </label><br>
									<div id="map" class="col-sm-12 col-md-12" style="height: 500px">

									</div>
							</div>
							<div class="col-sm-6 col-md-8">
								<label class="control-label" for="">Coordenadas</label><br>
								<input class="form-control" id="coordenadas" name="PLANTEL-coordenadas" placeholder="125.154, 103.45" readonly>
								<br>
								<input type="hidden" id="longitud" name="longitud" value="">
								<input type="hidden" id="latitud" name="latitud" value="">
							</div>
								<div class="form-group col-sm-12 col-md-12">
									<legend>Datos generales</legend>
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<input type="hidden" id="plantel_id" name="plantel_id" value="">
									<label class="control-label" for="">Clave de centro de trabajo:</label><br>
									<input id="clave_centro_trabajo" type="text" readonly name="clave_centro_trabajo" class="form-control" value="" placeholder="En caso de contar">
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Correo(s) electrónico(s)<sub>(1 correo por dominio institucional y 2 sin dominio)</sub>:</label><br>
									<input type="email" readonly  id="email1" name="email1" class="form-control" value="" placeholder="correo@dominio.com">
									<br>
									<input type="email" readonly  id="email1" name="email2" class="form-control" value="" placeholder="correo@dominio.com">
									<br>
									<input type="email" readonly  id="email1" name="email3" class="form-control" value="" placeholder="correo@dominio.com">
									<br>
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Teléfono(s):</label><br>
									<div class="form-group col-sm-6 col-md-4">
										<input type="tel" readonly id="telefono1" name="telefono1" class="form-control" value="" placeholder="33-45-58-25-54">
										<br>
									</div>
									<div class="form-group col-sm-6 col-md-4">
										<input type="tel" readonly id="telefono2" name="telefono2" class="form-control" value="" placeholder="33-45-58-25-54">
										<br>
									</div>
									<div class="form-group col-sm-6 col-md-4">
										<input type="tel" readonly id="telefono3" name="telefono3" class="form-control" value="" placeholder="33-45-58-25-54">
										<br>
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Redes sociales:</label><br>
									<textarea class="form-control" readonly id="redes_sociales" name="redes_sociales" rows="8" cols="20" placeholder="Facebook:&#10;Twitter:&#10;Instagram:"></textarea>
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Página web:</label><br>
									<input type="text" readonly id="paginaweb" name="paginaweb" class="form-control" value="" placeholder="www.universidad.com">
								</div>

								<!-- Rector -->
								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Rector</label><br>
									<input type="hidden" id="rector_id" name="rector_id" value="">
									<input type="text" readonly id="nombre_rector" name="nombre_rector" class="form-control" value="" placeholder="Nombre del rector"><br>
									<input type="text" readonly id="apellido_paterno_rector" name="apellido_paterno_rector" class="form-control" value="" placeholder="Apellido paterno del rector"><br>
									<input type="text" readonly id="apellido_materno_rector" name="apellido_materno_rector" class="form-control" value="" placeholder="Apellido materno del rector">
								</div>

								<!-- Director -->
								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Director</label><br>
									<input type="hidden" id="director_id" name="director_id" value="">
									<input type="text" readonly id="nombre" name="nombre" class="form-control" value="" placeholder="Nombre del director"><br>
									<input type="text" readonly id="apellido_paterno" name="apellido_paterno" class="form-control" value="" placeholder="Apellido paterno del director"><br>
									<input type="text" readonly id="apellido_materno" name="apellido_materno" class="form-control" value="" placeholder="Apellido materno del director">
								</div>

								<div class="col-sm-12 col-md-12">
									<input type="hidden" id="id" value="<?=$_GET["id"]?>">
								</div>
						</div>
					</form>
			 </div>
		 </section>
	 </div>


		<!-- JS GOB.MX -->
		<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
		<!-- JS JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="../js/funciones.js"></script>
		<script src="../js/planteles.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_4zHAnZD2kXiCf3UIyoWn2lpB4FK3fy0&amp;callback=setMapa" async="" defer=""></script>

	</body>
	</html>
