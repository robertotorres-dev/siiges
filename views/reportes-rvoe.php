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
	<!-- CSS PROPIO -->
	<link rel="stylesheet" type="text/css" href="../css/cargar.css">
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
          <br><br>
				</div>
        <div class="col-sm-12 col-md-12 col-lg-12">
          <!-- BARRA DE USUARIO -->
          <ol class="breadcrumb pull-right">
            <li><i class="icon icon-user"></i></li>
              <li><?php echo $_SESSION["nombre_rol"]; ?></li>
            <li class="active"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"]; ?></li>
          </ol>
          <!-- BARRA DE NAVEGACION -->
          <ol class="breadcrumb pull-left">
            <li><a href="home.php"><i class="icon icon-home"></i></a></li>
            <li><a href="home.php">SIIGES</a></li>
            <li class="active">Reportes</li>
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
      <div id="cargando"  class="loader"></div>
			<!-- CUERPO PRINCIPAL -->
			<div class="row">
        <!-- Datos  -->
        <div class="col-sm-12 col-md-4">
          <div class="form-group col-sm-12 col-md-12">
            <h2 class="text-center">Datos a consultar</h2>

            <div class="col-sm-12 col-md-12">
              <br>
              <label for="">Generar gráfica por:</label>
              <select class="form-control" id="opcionGrafica" onchange="Grafica.opcionesConsulta()">
                <option value="">Seleccione opción</option>
                <option value="1">Estatus</option>
                <option value="2">Institución</option>
                <option value="3">General</option>
              </select>
              <br>
            </div>

            <div class="col-sm-12 col-md-12" id="informacionInstitucion" style="display:none">
              <label for="">Institución:</label>
              <select class="form-control" id="instituciones" name="">
                <option value="">Seleccione opción</option>
              </select>
              <br>
              <select class="form-control" id="institucionesOpciones" name="">
                <option value="">Seleccione opción</option>
                <option value="1">General</option>
                <option value="2">Estatus</option>

              </select>
            </div>

            <div class="col-sm-12 col-md-12">
              <br>
              <button class="btn btn-primary btn-block" type="button" name="button" onclick="Grafica.solicitar()">Consultar</button>
            </div>


          </div>
        </div>
        <!-- Graficas -->
        <div class="col-sm-12 col-md-8">
          <div class="col-sm-12 col-md-12">
            <h2 id="tituloGrafica">Solicitudes al momento</h2>
          </div>
          <div class="col-sm-12 col-md-12">
            <div id="areaGraficas"></div>
          </div>
        </div>
			</div>

      <div class="col-sm-12 col-md-12 col-lg-12">
        <br>
      </div>

		</section>

	</div>


<!-- JS GOB.MX -->
<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="../js/graficas.js"></script>
</body>
</html>
