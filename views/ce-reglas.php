<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );

	//====================================================================================================

	require_once "../models/modelo-programa.php";
	require_once "../models/modelo-institucion.php";

	$programa = new Programa( );
	$programa->setAttributes( array( "id"=>$_GET["programa_id"] ) );
	$resultadoPrograma = $programa->consultarId( );

	$plantel = new Plantel( );
	$plantel->setAttributes( array( "id"=>$resultadoPrograma["data"]["plantel_id"] ) );
	$resultadoPlantel = $plantel->consultarId();

	$institucion = new Institucion();
	$institucion->setAttributes( array( "id"=>$resultadoPlantel["data"]["institucion_id"] ) );
	$resultadoInstitucion = $institucion->consultarId();

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
						<li><a href="ce-programas-plantel.php?institucion_id=<?php echo $resultadoInstitucion["data"]["id"] ?>&plantel_id=<?php echo $resultadoPlantel["data"]["id"] ?>">Programas de Estudios</a></li>
						<li class="active">Configuraci&oacute;n de Reglas</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-programa.php">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre">Configuraci&oacute;n de Reglas</h2>
				<hr class="red">
				<div class="row">
          <div class="col-sm-12">
						<legend><?php echo $resultadoPrograma["data"]["nombre"]; ?></legend>
					</div>
				</div>
				<!-- NOTIFICACIÓN -->
				<?php if( isset( $_GET["codigo"] ) && $_GET["codigo"]==200 ){ ?>
        <div class="alert alert-success">
					<p>Registro guardado.</p>
        </div>
        <?php } ?>
				<!-- CONTENIDO -->
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="id">Id</label>
							<input type="text" id="id" name="id" value="<?php echo $resultadoPrograma["data"]["id"]; ?>" maxlength="11" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-8">
          </div>
        </div>
				<div class="row">
          <div class="col-sm-3">
            <div class="form-group">
							<label class="control-label" for="calificacion_minima">Calificaci&oacute;n M&iacute;nima</label>
							<input type="text" id="calificacion_minima" name="calificacion_minima" value="<?php echo $resultadoPrograma["data"]["calificacion_minima"]; ?>" maxlength="11" class="form-control" required />
						</div>
          </div>
					<div class="col-sm-3">
            <div class="form-group">
							<label class="control-label" for="calificacion_maxima">Calificaci&oacute;n M&aacute;xima</label>
							<input type="text" id="calificacion_maxima" name="calificacion_maxima" value="<?php echo $resultadoPrograma["data"]["calificacion_maxima"]; ?>" maxlength="11" class="form-control" required />
						</div>
          </div>
					<div class="col-sm-3">
            <div class="form-group">
							<label class="control-label" for="calificacion_aprobatoria">Calificaci&oacute;n Aprobatoria</label>
							<input type="text" id="calificacion_aprobatoria" name="calificacion_aprobatoria" value="<?php echo $resultadoPrograma["data"]["calificacion_aprobatoria"]; ?>" maxlength="11" class="form-control" required />
						</div>
          </div>
					<div class="col-sm-3">
            <div class="form-group">
							<label class="control-label" for="calificacion_aprobatoria">Calificaciones Decimales</label>
							<select class="form-control" id="calificacion_decimal" name="calificacion_decimal">
								<option value=""></option>
								<option value="1" <?php if(isset($resultadoPrograma["data"]["calificacion_decimal"])) {if ($resultadoPrograma["data"]["calificacion_decimal"] == 1) {echo "selected";}} ?>>Si</option>
								<option value="2" <?php if(isset($resultadoPrograma["data"]["calificacion_decimal"])) {if ($resultadoPrograma["data"]["calificacion_decimal"] == 2) {echo "selected";}} ?>>No</option>
							</select>
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <div class="form-group">
							<input type="submit" id="submit" name="submit" value="Enviar" class="btn btn-primary" />
							<input type="hidden"  name="webService" value="guardar" />
							<input type="hidden"  name="url" value="../views/ce-reglas.php?programa_id=<?php echo $_GET["programa_id"]; ?>&codigo=200" />
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
</body>
</html>
