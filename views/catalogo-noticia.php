<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );

	//====================================================================================================

	require_once "../models/modelo-noticia.php";
	
	if( $_GET["proceso"]=="alta" )
	{
		$titulo = "Alta de Noticia";
	}

	if( $_GET["proceso"]=="consulta" )
	{
		$titulo = "Consulta de Noticia";

		$noticia = new Noticia( );
		$noticia->setAttributes( array( "id"=>$_GET["noticia_id"] ) );
		$resultadoNoticia = $noticia->consultarId( );
	}

	if( $_GET["proceso"]=="edicion" )
	{
		$titulo = "Edici&oacute;n de Noticia";

		$noticia = new Noticia( );
		$noticia->setAttributes( array( "id"=>$_GET["noticia_id"] ) );
		$resultadoNoticia = $noticia->consultarId( );
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
						<li class="active"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"]; ?></li>
					</ol>
					<!-- BARRA DE NAVEGACION -->
					<ol class="breadcrumb pull-left">
						<li><i class="icon icon-home"></i></li>
						<li><a href="home.php">SIIGES</a></li>
						<li><a href="noticias.php">Noticias</a></li>
						<li class="active"><?php echo $titulo; ?></li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-noticia.php">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre"><?php echo $titulo; ?></h2>
				<hr class="red">
				<div class="row">
          <div class="col-sm-12">
						<legend>Datos generales de la noticia</legend>
					</div>
				</div>
				<!-- CONTENIDO -->
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="id">Id</label>
							<input type="text" id="id" name="id" value="<?php echo $resultadoNoticia["data"]["id"]; ?>" maxlength="11" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-8">
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <div class="form-group">
							<label class="control-label" for="titulo">T&iacute;tulo</label>
							<input type="text" id="titulo" name="titulo" value="<?php echo $resultadoNoticia["data"]["titulo"]; ?>" maxlength="255" class="form-control" required />
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <div class="form-group">
							<label class="control-label" for="subtitulo">Subt&iacute;tulo</label>
							<input type="text" id="subtitulo" name="subtitulo" value="<?php echo $resultadoNoticia["data"]["subtitulo"]; ?>" maxlength="255" class="form-control" required />
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <div class="form-group">
							<label class="control-label" for="descripcion">Descripci&oacute;n</label>
							<textarea id="descripcion" name="descripcion" rows="6" class="form-control" required><?php echo $resultadoNoticia["data"]["descripcion"]; ?></textarea>
						</div>
          </div>
        </div>
				<?php
					if( $_GET["proceso"]!="consulta" )
					{
				?>
				<div class="row">
          <div class="col-sm-12">
            <div class="form-group">
							<input type="submit" id="submit" name="submit" value="Enviar" class="btn btn-primary" />
							<input type="hidden"  name="webService" value="guardar" />
							<input type="hidden"  name="url" value="../views/noticias.php?codigo=200" />
						</div>
          </div>
        </div>
				<?php
					}
				?>
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
</body>
</html>
