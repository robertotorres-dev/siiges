<?php
	session_start( );

	if( isset( $_SESSION["id"] ) )
	{
		header( "Location: views/home.php" );
		exit( );
	}

	$resultado = "";
	if( isset( $_SESSION["resultado"] ) && $_SESSION["resultado"] )
	{
		$resultado = json_decode( $_SESSION["resultado"] );
		unset( $_SESSION["resultado"] );
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
	<link href="favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<!-- CSS SIIGES -->
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body class="fondo-imagen">
	<!-- HEADER Y BARRA DE NAVEGACION -->
	<?php require_once "menu.php"; ?>

	<!-- RECUADRO DE LOGIN -->
	<div class="container">
		<section class="main row margins-section-login tamano-pantalla">
			<div class="col-md-4 col-md-offset-4">

				<!-- HEADER DEL RECUADRO DE LOGIN -->
				<div class="header-login" >
					<h6>Iniciar Sesión</h6>
					<p class="small">Ingresa tus credenciales para <br>acceder al portal web</p>
				</div>

				<!-- CUERPO DEL RECUADRO DE LOGIN -->
				<div class="body-login">
					<form name="form1" method="post" action="controllers/control-usuario.php">
            <input type="hidden"  name="webService" value="validarInicioSesion" />
            <input type="hidden"  name="url" value="../views/home.php" />

						<?php if( isset( $_GET["error"] ) && $_GET["error"]==1 && false){ ?>
							<div class="alert alert-danger">
								Verifique los datos de inicio de sesi&oacute;n.
							</div>
						<?php } ?>
						<?php
						// Mostrar mensaje despues de registro de usuario exitoso
						if( $resultado && isset( $resultado->status ) && "200" == $resultado->status ){ ?>
							<div class="alert alert-success">
								<p><?= $resultado->message ?></p>
							</div>
						<?php }
										else if($resultado && isset( $resultado->message )){ ?>
											<div class="alert alert-danger">
				                <p><?= $resultado->message ?></p>
											</div>
            <?php
        					}
            ?>
						<div class="input-group">
							<span class="input-group-addon btn-sm"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" id="usuario" name="usuario" class="form-control input-sm" placeholder="Nombre de Usuario" required>
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon btn-sm"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" id="contrasena" name="contrasena" class="form-control input-sm" placeholder="Contraseña de acceso" required>
						</div>
						<p></p>
						<div class="form-group row">
							<div class="col-sm-12 text-center">
								<a href="#" class="small" data-toggle="modal" data-target="#modal-Recuperar-Contrasena">¿Olvidaste tu contraseña?</a>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 text-center">
								<input type="submit"  name="submit" class="btn btn-primary btn-block btn-sm" value="Ingresar" />
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 text-center">
								<p class="small">¿No tienes una cuenta?<a href="registro.php"> Regístrate</a> </p>
							</div>
						</div>
					</form>
				</div>
			</div>

			<!-- MODAL DE RECUPERAR CONTRASENA -->
			<div class="modal fade" id="modal-Recuperar-Contrasena" tabindex="-1" role="dialog" aria-labelledby="modalRecuperar" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content" style="background-color: #F7F7F7;">
						<div class="modal-header">
							<h5 class="modal-title" id="modalRecuperar">Recuperar Contraseña</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form name="form2" method="post" action="controllers/control-usuario.php">
								<p class="text-center">Ingrese su nombre de usuario para enviarle un email y pueda recuperar su contraseña </p>
								<div class="input-group">
									<span class="input-group-addon btn-sm"><i class="glyphicon glyphicon-user"></i></span>
									<input type="text" id="usuario" name="usuario" class="form-control input-sm" placeholder="Nombre de Usuario" required>
								</div>
								<br>
								<p></p>
								<p class="text-center small">Si el email no aparece en su bandeja de entrada, no olvide revisar en la sección de 'correo no deseado'</p>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									<input type="hidden" id="webService" name="webService" value="solicitarNuevaContrasena" />
									<input type="hidden" id="url" name="url" value="../index.php" />
									<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Recuperar" />
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>


	<!-- JS DE GOB.MX -->
	<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
	<!-- JS JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- SECCION PARA SCRIPTS -->
</body>
</html>
