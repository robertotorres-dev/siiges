<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SIIGES</title>
	<!--Funciones para validaciones-->
	<script src="js/funciones.js"></script>
	<!-- CSS GOB.MX -->
	<link href="/favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<!-- CSS SIIGES -->
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<? if($_GET['key'] && $_GET['reset']){
?>
<body class="fondo-imagen">

	<!-- RECUADRO DE RECUPERAR CONTRASEÑA -->
	<div class="container">
		<section class="main row margins-section-login tamano-pantalla">
			<div class="col-md-4 col-md-offset-4">

				<!-- HEADER DEL RECUADRO DE LOGIN -->
				<div class="header-login" >
					<h6>Restablecer la contraseña</h6>
					<p class="small">Ingresa tu nueva contraseña <br> para recuperar tu accesso al portal web</p>
				</div>

				<!-- CUERPO DEL RECUADRO DE LOGIN -->
				<div class="body-login">
					<form name="form1" method="post" action="controllers/control-usuario.php">
						<div class="input-group">
							<span class="input-group-addon btn-sm"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" id="contrasena" name="contrasena" class="form-control input-sm" placeholder="Introduzca su nueva contraseña" required onkeyup="validarContrasena();" minlenght="5" maxlength="20">
						</div>
						<span id="insturcciones_contrasena"></span>
						<br>
						<br>
						<div class="input-group">
							<span class="input-group-addon btn-sm"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" id="verificar_contrasena" name="verificar_contrasena" class="form-control input-sm" placeholder="Confirme su contraseña" onblur="confirmarContrasena()" onkeyup="validarContrasena();" minlenght="5" maxlength="20" required>
						</div>
						<span id="insturcciones_contrasena2"></span>
						<br>
						<br>
						<div class="form-group row">
							<div class="col-sm-12 text-center">
								<input type="hidden" id=usuario name="usuario" value=<?=$_GET['key']?>  />
								<input type="hidden" id="webService" name="webService"  value="restablecerContrasena"/>
								<input type="hidden" id="url" name="url" value="../index.php" />
								<input type="submit" id="submit" name="submit" class="btn btn-primary btn-block btn-sm" value="Guardar Cambios" disabled/>
							</div>
						</div>
					</form>
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


<?}
else{

}?>
