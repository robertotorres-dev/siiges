<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );

	//====================================================================================================

	require_once "../models/modelo-programa.php";
	require_once "../models/modelo-alumno.php";
	require_once "../models/modelo-persona.php";
	require_once "../models/modelo-pais.php";
	require_once "../models/modelo-situacion.php";
  require_once "../models/modelo-alumno-grupo.php";
  require_once "../models/modelo-grupo.php";
	require_once "../models/modelo-institucion.php";
	require_once "../models/modelo-domicilio.php";
	require_once "../models/modelo-estado.php";
	require_once "../models/modelo-situacion-validacion.php";
	require_once "../models/modelo-tipo-validacion.php";
	require_once "../models/modelo-validacion.php";
  require_once "../models/modelo-usuario.php";

	$validacion = new Validacion( );
	$res_validacion = $validacion->consultarPor('validaciones', array("alumno_id"=>$_GET["alumno_id"], "deleted_at"), '*' );

	if ($res_validacion["data"]) {
		$usuario = new Usuario( );
		$usuario->setAttributes( array( "id"=>$res_validacion["data"][0]["usuario_id"] ) );
		$resultadoUsuario = $usuario->consultarId( );
	}

	$programa = new Programa( );
	$programa->setAttributes( array( "id"=>$_GET["programa_id"] ) );
	$resultadoPrograma = $programa->consultarId( );

	$plantel = new Plantel( );
	$plantel->setAttributes( array( "id"=>$resultadoPrograma["data"]["plantel_id"] ) );
	$resultadoPlantel = $plantel->consultarId( );

	$institucion = new Institucion( );
	$institucion->setAttributes( array( "id"=>$resultadoPlantel["data"]["institucion_id"] ) );
	$resultadoInstitucion = $institucion->consultarId( );

	$domicilio = new Domicilio( );
	$domicilio->setAttributes( array( "id"=>$resultadoPlantel["data"]["domicilio_id"] ) );
	$resultadoDomicilio = $domicilio->consultarId( );

	$estado = new Estado( );
	$estado->setAttributes( array( ) );
	$resultadoEstado = $estado->consultarTodos( );

	$situacionValidacion = new SituacionValidacion( );
	$situacionValidacion->setAttributes( array( ) );
	$resultadoSituacionValidacion = $situacionValidacion->consultarTodos( );

	$tipoValidacion = new TipoValidacion( );
	$tipoValidacion->setAttributes( array( ) );
	$resultadoTipoValidacion = $tipoValidacion->consultarTodos( );

	if( $resultadoPrograma["data"]["nivel_id"]==2 )
	{
		$titulo_certificado1 = "Archivo Certificado de Bachillerato o equivalente (PDF)";
		$titulo_certificado2 = "Acreditación Certificado de Bachillerato";
	}

	if( $resultadoPrograma["data"]["nivel_id"]>=3 && $resultadoPrograma["data"]["nivel_id"]<=7)
	{
		$titulo_certificado1 = "Archivo C&eacute;dula Profesional o T&iacute;tulo (PDF)";
		$titulo_certificado2 = "Acreditación C&eacute;dula Profesional o T&iacute;tulo";
	}


	if( $_GET["proceso"]=="alta" )
	{
		$titulo = "Validación de Alumno";
	}

	if( $_GET["proceso"]=="consulta" )
	{
		$titulo = "Consulta de Validación Alumno";

		$alumno = new Alumno( );
		$alumno->setAttributes( array( "id"=>$_GET["alumno_id"] ) );
		$resultadoAlumno = $alumno->consultarId( );

		$persona = new Persona( );
		$persona->setAttributes( array( "id"=>$resultadoAlumno["data"]["persona_id"] ) );
		$resultadoPersona = $persona->consultarId( );
	}

	if( $_GET["proceso"]=="edicion" )
	{
		$titulo = "Validaci&oacute;n de Alumno";

		$alumno = new Alumno( );
		$alumno->setAttributes( array( "id"=>$_GET["alumno_id"] ) );
		$resultadoAlumno = $alumno->consultarId( );

		$persona = new Persona( );
		$persona->setAttributes( array( "id"=>$resultadoAlumno["data"]["persona_id"] ) );
		$resultadoPersona = $persona->consultarId( );
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
						<?php if(Rol::ROL_CONTROL_ESCOLAR_SICYT == $_SESSION["rol_id"] || (Rol::ROL_ADMIN == $_SESSION["rol_id"] )): ?>
							<li><a href="ce-programas-plantel-validacion.php?institucion_id=<?php echo $resultadoInstitucion["data"]["id"] ?>&plantel_id=<?php echo $resultadoPlantel["data"]["id"] ?>">Programas de Estudios</a></li>
							<li><a href="ce-validacion.php?programa_id=<?php echo $_GET["programa_id"]; ?>">Alumnos</a></li>
							<li class="active"><?php echo $titulo; ?></li>
						<?php endif;?>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-validacion.php" enctype="multipart/form-data">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre"><?php echo $titulo; ?></h2>
				<hr class="red">

				<!-- NOTIFICACIÓN -->
				<?php if( isset( $_GET["codigo"] ) && $_GET["codigo"]==404 ){ ?>
        <div class="alert alert-danger">
					<p>La matr&iacute;cula ingresada ya se encuentra registrada.</p>
        </div>
        <?php } ?>
				<!-- CONTENIDO -->
        <div class="row">
          <div class="col-sm-12">
						<legend>Datos del Alumno</legend>
					</div>
				</div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="id">Id</label>
							<input type="text" id="alumno_id" name="alumno_id" value="<?php echo (isset($resultadoAlumno)) ? $resultadoAlumno["data"]["id"] : "";
								?>" maxlength="11" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="persona_id">Persona Id</label>
							<input type="text" id="" name="" value="<?php echo(isset($resultadoAlumno)) ? $resultadoAlumno["data"]["persona_id"] : ""; ?>" maxlength="11" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="programa_id">Programa Id</label>
							<input type="text" id="" name="" value="<?php echo $_GET["programa_id"]; ?>" maxlength="11" class="form-control" required readonly />
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="nombre">Nombre</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoPersona)) ? $resultadoPersona["data"]["nombre"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="apellido_paterno">Apellido Paterno</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoPersona)) ? $resultadoPersona["data"]["apellido_paterno"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="apellido_materno">Apellido Materno</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoPersona)) ? $resultadoPersona["data"]["apellido_materno"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="curp">CURP</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoPersona)) ? $resultadoPersona["data"]["curp"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="nombre_programa">Programa</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoPersona)) ? $resultadoPrograma["data"]["nombre"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="nombre_programa">Modificado por</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoUsuario)) ? $resultadoUsuario["data"]["persona"]["nombre"]." ".$resultadoUsuario["data"]["persona"]["apellido_materno"]." ".$resultadoUsuario["data"]["persona"]["apellido_paterno"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
						<br>
					</div>
				</div>
        <div class="row">
          <div class="col-sm-12">
						<legend>Datos de Insituci&oacute;n de Origen</legend>
					</div>
				</div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="institucion">Instituci&oacute;n</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoInstitucion)) ? $resultadoInstitucion["data"]["nombre"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label" for="plantel">Plantel</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoDomicilio)) ? $resultadoDomicilio["data"]["calle"]." ".$resultadoDomicilio["data"]["numero_exterior"].", ". $resultadoDomicilio["data"]["municipio"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
					</div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="clave_centro_trabajo">Clave de Centro de Trabajo</label>
							<input type="text" id="" name="" value="<?php echo (isset($resultadoPlantel)) ? $resultadoPlantel["data"]["clave_centro_trabajo"] : ""; ?>" maxlength="255" class="form-control" readonly />
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
						<br>
					</div>
				</div>
        <div class="row">
          <div class="col-sm-12">
						<legend>Datos de Insituci&oacute;n de Procedencia</legend>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
            <div class="form-group">
							<label class="control-label" for="archivo_certificado"><?php echo $titulo_certificado1; ?></label>
							<div><a href="../uploads/certificados/<?php echo $resultadoAlumno["data"]["archivo_certificado"]; ?>" target="_blank"><?php echo $resultadoAlumno["data"]["archivo_certificado"]; ?></a></div>
						</div>
          </div>
				</div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="nombre_institucion_emisora">Instituci&oacute;n de Procedencia</label>
							<input type="text" id="nombre_institucion_emisora" name="nombre_institucion_emisora" value="<?php echo $res_validacion["data"] ? $res_validacion["data"][0]["nombre_institucion_emisora"] : ""; ?>" maxlength="255" class="form-control" required />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="txt-label1" for="estado">Estado de procedencia</label>
							<select id="estado_id" name="estado_id" class="selectpicker" data-live-search="true" data-width="100%" required>
								<option value=""> </option>
								<?php

									$max = count( $resultadoEstado["data"] );

									for( $i=0; $i<$max; $i++ )
									{
										if( $resultadoEstado["data"][$i]["id"]==$res_validacion["data"][0]["estado_id"] )
										{
											echo "<option value='".$resultadoEstado["data"][$i]["id"]."' selected>".$resultadoEstado["data"][$i]["estado"]."</option>";
										}
										else
										{
										  echo "<option value='".$resultadoEstado["data"][$i]["id"]."'>".$resultadoEstado["data"][$i]["estado"]."</option>";
										}
									}
								?>
							</select>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="txt-label1" for="clave_centro_trabajo_emisor">CCT de Procedencia</label>
							<input type="text" id="clave_centro_trabajo_emisor" name="clave_centro_trabajo_emisor" value="<?php echo $res_validacion["data"] ? $res_validacion["data"][0]["clave_centro_trabajo_emisor"] : ""; ?>" maxlength="255" class="form-control" required />
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="folio">Folio de Certificado</label>
							<input type="text" id="folio" name="folio" value="<?php echo $res_validacion["data"] ? $res_validacion["data"][0]["folio"] : ""; ?>" maxlength="255" class="form-control" required />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="txt-label1" for="fecha_expedicion">Fecha de expedici&oacute;n</label>
							<input type="text" id="fecha_expedicion" name="fecha_expedicion" value="<?php echo $res_validacion["data"] ? $res_validacion["data"][0]["fecha_expedicion"] : ""; ?>" maxlength="255" class="form-control" required />
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="txt-label1" for="situacion_validacion_id">Situaci&oacute;n de documento</label>
							<select id="situacion_validacion_id" name="situacion_validacion_id" class="selectpicker" data-live-search="true" data-width="100%" required>
								<option value=""> </option>
								<?php
									$max = count( $resultadoSituacionValidacion["data"] );

									for( $i=0; $i<$max; $i++ )
									{
										if( $resultadoSituacionValidacion["data"][$i]["id"]==$res_validacion["data"][0]["situacion_validacion_id"] )
										{
											echo "<option value='".$resultadoSituacionValidacion["data"][$i]["id"]."' selected>".$resultadoSituacionValidacion["data"][$i]["nombre"]."</option>";
										}
										else
										{
										  echo "<option value='".$resultadoSituacionValidacion["data"][$i]["id"]."'>".$resultadoSituacionValidacion["data"][$i]["nombre"]."</option>";
										}
									}
								?>
							</select>
						</div>
          </div>
        </div>
				<div class="row">
          
					<div class="col-sm-4">
            <div class="form-group">
							<label class="txt-label1" for="tipo_validacion">Tipo de validaci&oacute;n</label>
							<select id="tipo_validacion_id" name="tipo_validacion_id" class="selectpicker" data-live-search="true" data-width="100%" required>
							<option value=""> </option>
								<?php
									$max = count( $resultadoTipoValidacion["data"] );

									for( $i=0; $i<$max; $i++ )
									{
										if( $resultadoTipoValidacion["data"][$i]["id"]==$res_validacion["data"][0]["tipo_validacion_id"] )
										{
											echo "<option value='".$resultadoTipoValidacion["data"][$i]["id"]."' selected>".$resultadoTipoValidacion["data"][$i]["nombre"]."</option>";
										}
										else
										{
										  echo "<option value='".$resultadoTipoValidacion["data"][$i]["id"]."'>".$resultadoTipoValidacion["data"][$i]["nombre"]."</option>";
										}
									}
								?>
							</select>
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
						<br>
					</div>
				</div>
        <div class="row">
          <div class="col-sm-12">
						<legend>Validaci&oacute;n de Documentos</legend>
					</div>
				</div>
				<div class="row">
          <div class="col-sm-8">
            <div class="form-group">
							<label class="control-label" for="archivo_validacion">Archivo de Validaci&oacute;n</label>
							<input type="file" id="archivo_validacion" name="archivo_validacion" accept="application/pdf" class="form-control" />
							<div><a href="../uploads/<?php echo $res_validacion["data"] ? "Institucion".$resultadoInstitucion["data"]["id"]."/PLANTEL".$resultadoPlantel["data"]["id"]."/validaciones/".$res_validacion["data"][0]["archivo_validacion"] : ""; ?>" target="_blank"><?php echo isset($res_validacion["data"][0]["archivo_validacion"]) ? "Oficio de validación" : ""; ?></a></div>
						</div>
          </div>
					<div class="col-sm-4">
            <div class="form-group">
							<label class="txt-label1" for="fecha_validacion">Fecha de Archivo de Validaci&oacute;n</label>
							<input type="text" id="fecha_validacion" name="fecha_validacion" value="<?php echo $res_validacion["data"] ? $res_validacion["data"][0]["fecha_validacion"] : ""; ?>" maxlength="255" class="form-control" required />
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-8">
            <div class="form-group">
							<br>
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
							<input type="hidden"  name="id" value="<?php echo $res_validacion["data"] ? $res_validacion["data"][0]["id"] : ""; ?>" />
							<input type="hidden"  name="institucion_id" value="<?php echo($resultadoInstitucion["data"]["id"]); ?>" />
							<input type="hidden"  name="plantel_id" value="<?php echo($resultadoPlantel["data"]["id"]); ?>" />
							<input type="hidden"  name="usuario_id" value="<?php echo isset($_SESSION["id"])?$_SESSION["id"]:-1; ?>" />
							<?php if(Rol::ROL_CONTROL_ESCOLAR_SICYT == $_SESSION["rol_id"] || (Rol::ROL_ADMIN == $_SESSION["rol_id"] )): ?>
								<input type="hidden"  name="url" value="../views/ce-validacion.php?programa_id=<?php echo $_GET["programa_id"]."&codigo=200"; ?> "/>
							<?php endif;?>
							<?php if(Rol::ROL_CONTROL_ESCOLAR_IES == $_SESSION["rol_id"] || (Rol::ROL_REPRESENTANTE_LEGAL == $_SESSION["rol_id"] )): ?>
								<input type="hidden"  name="url" value="../views/ce-alumnos.php?programa_id=<?php echo $_GET["programa_id"]."&codigo=200"; ?> "/>
							<?php endif;?>
							<input type="hidden"  name="webService" value="guardar" />
							<input type="submit" id="submit" name="submit" value="Enviar" class="btn btn-primary" />
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
		$("#fecha_expedicion").datepicker({
			firstDay: 1,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			dateFormat: 'yy-mm-dd'
		})
		$("#fecha_validacion").datepicker({
			firstDay: 1,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			dateFormat: 'yy-mm-dd'
		})
		$("#fecha_respuesta").datepicker({
			firstDay: 1,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			dateFormat: 'yy-mm-dd'
		})
	});
</script>
</body>
</html>
