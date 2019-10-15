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
		<title>Menu RVOE (IESI)</title>
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
		<div class="container">
			<section class="main row margin-section-formularios">

				<!-- BARRA DE INFORMACION -->
				<div class="row" style="padding-left: 15px; padding-right: 15px;">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<!-- BARRA DE USUARIO -->
						<ol class="breadcrumb pull-right">
							<li><i class="icon icon-user"></i></li>
							<li class="active"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"]; ?></li>
						</ol>
						<!-- BARRA DE NAVEGACION -->
						<ol class="breadcrumb pull-left">
							<li><a href="home.php"><i class="icon icon-home"></i></a></li>
							<li><a href="home">SIIGES</a></li>
							<li class="active">Instituciones</li>
						</ol>
					</div>
				</div>
				<div id="mensaje">
					<?php if(isset($resultado) && isset($resultado->status) && $resultado->status != "200"): ?>
						<div class="alert alert-danger">
							<p><?= $resultado->message ?></p>
						</div>
						<?php  endif; ?>
				</div>
				<!-- CUERPO PRINCIPAL -->
				<div class=" form-group col-sm-12 col-md-12 col-lg-12">
					<!-- TÍTULO -->
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h1 id="txtNombre">Instituciones</h2>
								<hr class="red">
						</div>
						<!-- <div id="cargando" class="loader">

						</div> -->

					<!-- Tabla de mis Solicitudes -->
					<div class="col-sm-12 col-md-12">
						<table id="instituciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
										<th>Nombre de institución</th>
										<th>Representante legal</th>
										<th>Nombre autotizado</th>
										<th>Acciones</th>
								</tr>
							</thead>
						</table>
					</div>

				</div>

			</section>
			<!-- usuario_id -->
			<input id="usuario_id" type="hidden"  value="<?=$_SESSION["id"]?>">
			<input type="hidden" id="rol_id" value="<?=$_SESSION["rol_id"]?>">
		</div>
		<!-- JS GOB.MX -->
		<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
		<!-- JS JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
		<!-- SECCION PARA SCRIPTS -->
		<script src="../js/instituciones-planteles.js"></script>

	</body>

</html>
