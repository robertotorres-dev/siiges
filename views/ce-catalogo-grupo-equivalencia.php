<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );

	//====================================================================================================

	require_once "../models/modelo-programa.php";
	require_once "../models/modelo-grupo.php";
	require_once "../models/modelo-turno.php";

	$programa = new Programa( );
	$programa->setAttributes( array( "id"=>$_GET["programa_id"] ) );
	$resultadoPrograma = $programa->consultarId( );

	if( $_GET["proceso"]=="alta" )
	{
		$titulo = "Alta de Grupo";
	}

	if( $_GET["proceso"]=="consulta" )
	{
		$titulo = "Consulta de Grupo";

		$grupo = new Grupo( );
		$grupo->setAttributes( array( "id"=>$_GET["grupo_id"] ) );
		$resultadoGrupo = $grupo->consultarId( );
	}

	if( $_GET["proceso"]=="edicion" )
	{
		$titulo = "Edici&oacute;n de Grupo";

		$grupo = new Grupo( );
		$grupo->setAttributes( array( "id"=>$_GET["grupo_id"] ) );
		$resultadoGrupo = $grupo->consultarId( );
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
						<li><a href="ce-ciclos-escolares-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>">Ciclos Escolares</a></li>
						<li><a href="ce-grados-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>">Grados</a></li>
						<li><a href="ce-grupos-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>">Grupos</a></li>
						<li class="active"><?php echo $titulo; ?></li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-grupo.php">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<!-- TÍTULO -->
					<h2 id="txtNombre"><?php echo $titulo; ?></h2>
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
					<?php if( isset( $_GET["codigo"] ) && $_GET["codigo"]==404 ){ ?>
					<div class="alert alert-danger">
						<p>La matr&iacute;cula ingresada no existe.</p>
					</div>
					<?php } ?>
					<!-- CONTENIDO -->
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="id">Id</label>
								<input type="text" id="id" name="id" value="<?php echo (isset($resultadoGrupo["data"]["id"])) ? $resultadoGrupo["data"]["id"] : ""; ?>" maxlength="11" class="form-control" readonly />
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="ciclo_escolar_id">Ciclo Escolar Id</label>
								<input type="text" id="ciclo_escolar_id" name="ciclo_escolar_id" value="<?php echo $_GET["ciclo_id"]; ?>" maxlength="11" class="form-control" required readonly />
							</div>
						</div>
						<div class="col-sm-4">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="grado">Grado</label>
								<input type="text" id="grado" name="grado" value="<?php echo $_GET["grado"]; ?>" maxlength="11" class="form-control" required readonly />
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="grupo">Grupo</label>
								<select id="grupo" name="grupo" value="<?php echo (isset($resultadoGrupo["data"]["grupo"])) ? $resultadoGrupo["data"]["grupo"] : ""; ?>" maxlength="255" class="form-control" required >
									<option value=""> </option>
									<option value="UNICO" <?php if (isset($resultadoGrupo["data"]["grupo"])) { if( $resultadoGrupo["data"]["grupo"]=="UNICO" ) { echo "selected"; }} ?>>UNICO</option>
								</select>
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
								<input type="hidden"  name="url" value="../views/ce-grupos-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>&codigo=200" />
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
<script>
	$(document).ready(function(){
		$("#generacion_fecha_inicio").datepicker({
			firstDay: 1,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			dateFormat: 'yy-mm-dd'
		});

		$("#generacion_fecha_fin").datepicker({
			firstDay: 1,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			dateFormat: 'yy-mm-dd'
		});
	});
</script>
</body>
</html>
