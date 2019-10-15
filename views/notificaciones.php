<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );

	//====================================================================================================

	require_once "../models/modelo-usuario.php";
	require_once "../models/modelo-persona.php";
	require_once "../models/modelo-rol.php";
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
						<li class="active">Notificaciones</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-usuario.php">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre">Notificaciones</h2>
				<hr class="red">
				<div class="row">
          <div class="col-sm-12">
						<legend>Env&iacute;o de notificaciones a aplicaciones m&oacute;viles</legend>
					</div>
				</div>
				<!-- NOTIFICACIÓN -->
				<?php if( isset( $_GET["codigo"] ) && $_GET["codigo"]==200 ){ ?>
        <div class="alert alert-success">
					<p>Mensaje enviado con &eacute;xito</p>
        </div>
        <?php } ?>
				<!-- CONTENIDO -->
				<div class="row">
          <div class="col-sm-8">
            <div class="form-group">
							<label class="txt-label1" for="usuario_id">Usuario</label>
							<select id="usuario_id" name="usuario_id" class="selectpicker" data-live-search="true" data-width="100%" data-size="8">
								<option value=""> </option>
								<?php
									$usuario = new Usuario( );
									$usuario->setAttributes( array( ) );
									$resultadoUsuario = $usuario->consultarTodos( );

									$max = count( $resultadoUsuario["data"] );

									for( $i=1; $i<$max; $i++ )
									{
										$parametros["id"] = $resultadoUsuario["data"][$i]["persona_id"];

										$persona = new Persona( );
										$persona->setAttributes( $parametros );
										$resultadoPersona = $persona->consultarId( );

										echo "<option value='".$resultadoUsuario["data"][$i]["id"]."'>".$resultadoPersona["data"]["apellido_paterno"]." ".$resultadoPersona["data"]["apellido_materno"]." ".$resultadoPersona["data"]["nombre"]."</option>";
									}
								?>
							</select>
						</div>
          </div>
					<div class="col-sm-4">
          </div>
        </div>
				<div class="row">
          <div class="col-sm-8">
            <div class="form-group">
							<label class="txt-label1" for="rol_id">Rol</label>
							<select id="rol_id" name="rol_id" class="selectpicker" data-live-search="true" data-width="100%" data-size="8">
								<option value=""> </option>
								<option value="-1">Todos</option>
								<?php
									$rol = new Rol( );
									$rol->setAttributes( array( ) );
									$resultadoRol = $rol->consultarTodos( );

									$max = count( $resultadoRol["data"] );

									for( $i=0; $i<$max; $i++ )
									{
										echo "<option value='".$resultadoRol["data"][$i]["id"]."'>".$resultadoRol["data"][$i]["nombre"]."</option>";
									}
								?>
							</select>
						</div>
          </div>
					<div class="col-sm-4">
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <div class="form-group">
							<label class="control-label" for="titulo">T&iacute;tulo</label>
							<input type="text" id="titulo" name="titulo" value="<?php if(isset($resultadoNoticia)){echo $resultadoNoticia["data"]["titulo"];} ?>" maxlength="255" class="form-control" required />
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <div class="form-group">
							<label class="control-label" for="mensaje">Mensaje</label>
							<textarea id="mensaje" name="mensaje" rows="6" class="form-control" required><?php if(isset($resultadoNoticia)){echo $resultadoNoticia["data"]["descripcion"]; }?></textarea>
						</div>
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <div class="form-group">
							<input type="submit" id="submit" name="submit" value="Enviar" class="btn btn-primary" />
							<input type="hidden"  name="webService" value="enviarNotificacion" />
							<input type="hidden"  name="url" value="../views/notificaciones.php?codigo=200" />
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
<script>
	$(document).ready(function(){
	  $("#usuario_id").on("change", function(e){
			$("#rol_id").val("");
			$("#rol_id").selectpicker("refresh");
		});

		$("#rol_id").on("change", function(e){
			$("#usuario_id").val("");
			$("#usuario_id").selectpicker("refresh");
		});
	});
</script>
</body>
</html>
