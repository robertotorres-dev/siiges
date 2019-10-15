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
	<link href="/favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<!-- CSS SIIGES -->
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">

</head>

<body class="">
	<!-- HEADER Y BARRA DE NAVEGACION -->
	<?php require_once "menu.php"; ?>

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
					<li class="active">Alta plantel</li>
				</ol>

				<h2>Alta plantel</h2>
					<hr class="red">

					<!-- INICIA FORMULARIO -->
					<form id="form-alta-plantel" role="form" class="form" method="post" action="../controllers/control-plantel.php" >
						<div class="form-group">
							 <div class="form-group col-sm-12 col-md-12">
								<legend>Domicilio</legend>
							</div>
								<div class="form-group col-sm-6 col-md-12">
									<label class="control-label" for="">Calle</label><br>
									<input type="text" id="calle" name="calle" class="form-control" value="" placeholder="Nombre de la calle, avenida" required>
								</div>
								<div class="form-group col-sm-6 col-md-6">
									<label class="control-label" for="">Número exterior</label><br>
									<input type="text" id="numero_exterior" name="numero_exterior" class="form-control" value="" placeholder="Número exterior" required>
								</div>
								<div class="form-group col-sm-6 col-md-6">
									<label class="control-label" for="">Número interior</label><br>
									<input type="text" id="numero_interior" name="numero_interior" class="form-control" value="" placeholder="Número interior en caso de tener">
								</div>
								<div class="form-group col-sm-6 col-md-6">
									<label class="control-label" for="">Colonia</label><br>
									<input type="text" id="colonia" name="colonia" class="form-control" value="" placeholder="Nombre de la colonia" required>
								</div>
								<div class="form-group col-sm-6 col-md-6">
									<label class="control-label" for="">CP</label><br>
									<input type="text" id="codigo_postal" name="codigo_postal" class="form-control" value="" placeholder="Código postal" required>
								</div>
								<div class="form-group col-sm-6 col-md-12">
									<label class="control-label" for="">Municipio</label><br>
									<div id="municipios">
										<select class="form-control" id="municipio" name="municipio"  onchange="coordenadas()" required>
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
							</div>
								<div class="form-group col-sm-12 col-md-12">
									<legend>Datos generales</legend>
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Clave de centro de trabajo:</label><br>
									<input id="clave_centro_trabajo" type="text" name="clave_centro_trabajo" class="form-control" value="" placeholder="En caso de contar">
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Correo(s) electrónico(s):</label><br>
									<input type="email" name="email1" class="form-control" value="" placeholder="correo@dominio.com">
									<br>
									<input type="email" name="email2" class="form-control" value="" placeholder="correo@dominio.com">
									<br>
									<input type="email" name="email3" class="form-control" value="" placeholder="correo@dominio.com">
									<br>
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Teléfono(s):</label><br>
									<div class="form-group col-sm-6 col-md-4">
										<input type="tel" name="telefono1" class="form-control" value="" placeholder="33-45-58-25-54">
										<br>
									</div>
									<div class="form-group col-sm-6 col-md-4">
										<input type="tel" name="telefono2" class="form-control" value="" placeholder="33-45-58-25-54">
										<br>
									</div>
									<div class="form-group col-sm-6 col-md-4">
										<input type="tel" name="telefono3" class="form-control" value="" placeholder="33-45-58-25-54">
										<br>
									</div>
						    </div>
								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Redes sociales:</label><br>
									<textarea class="form-control" name="redes_sociales" rows="8" cols="20" placeholder="Fecebook:&#10;Twitter:&#10;Instagram:"></textarea>
								</div>
								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Página web:</label><br>
									<input type="url" name="paginaweb" class="form-control" value="" placeholder="www.universidad.com">
								</div>

								<div class="form-group col-sm-12 col-md-12">
									<label class="control-label" for="">Director</label><br>
									<input type="text" name="nombre" class="form-control" value="" placeholder="Nombre del director" required><br>
									<input type="text" name="apellido_paterno" class="form-control" value="" placeholder="Apellido paterno del director" required><br>
									<input type="text" name="apellido_materno" class="form-control" value="" placeholder="Apellido materno del director" required>
								</div>

								<div class="col-sm-12 col-md-12">
									<input type="hidden" id="pais" name="pais" value="mexico">
									<input type="hidden" id="latitud" name="latitud" value="">
									<input type="hidden" id="longitud" name="longitud" value="" >
									<input type="hidden" id="estado_id" name="estado_id" value="14">
									<input type="hidden" id="estado" name="estado" value="Jalisco">
									<input type="hidden" name="institucion_id" value=<?=$_GET['institucion']?>>
									<input type="hidden" id="id_usuario" name="representante_usuario" value=<?=$_GET['usuario']?>>
									<input type="hidden" id="webService" name="webService" value="guardarInformacion" />
									<input type="hidden" id="url" name="url" value="../views/institucion-planteles.php" />
									<input type="submit" id="submit" name="submit"   class="btn btn-primary btn-lg pull-right" style="margin-right: 10px;" value="Guardar" />
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
	 <!-- JS MAPS -->
	 <!-- <script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js" integrity="sha512-tAGcCfR4Sc5ZP5ZoVz0quoZDYX5aCtEm/eu1KhSLj2c9eFrylXZknQYmxUssFaVJKvvc0dJQixhGjG2yXWiV9Q==" crossorigin=""></script>
	 <script src="https://unpkg.com/esri-leaflet@2.2.2/dist/esri-leaflet.js"	integrity="sha512-cll/dcqNKG7yfQBrTbRNzGQ70Bh4m+J5jnvU97tPyMnWsD1Ry+CXi0JE+T7Rk54pdJEYlRgXtpwxa9sUqzUAyg==" crossorigin=""></script>
	 <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js" integrity="sha512-zdT4Pc2tIrc6uoYly2Wp8jh6EPEWaveqqD3sT0lf5yei19BC1WulGuh5CesB0ldBKZieKGD7Qyf/G0jdSe016A==" crossorigin=""></script> -->
	 <script src="../js/funciones.js"></script>
	 <script src="../js/plantel.js"></script>
	 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_4zHAnZD2kXiCf3UIyoWn2lpB4FK3fy0&amp;callback=setMapa" async="" defer=""></script>
	</body>
	</html>
