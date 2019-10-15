<?php
session_start( );
$usuario_id = $_SESSION['id'];
$rol_id = $_SESSION['rol_id'];
$id = isset($_GET["id"])?$_GET["id"]:0;
unset($_GET["id"]);

require_once "../models/modelo-rol.php";

if($id != $usuario_id && Rol::ROL_ADMIN != $rol_id){
  $_SESSION["resultado"] = json_encode(["id"=>$usuario_id,"error"=>["codigo"=>"403","mensaje"=>"Acceso no autorizado"]]);
  header( "Location: home.php" );
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registro de Usuarios</title>

	<!-- CSS GOB.MX -->
	<link href="../favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<!-- CSS SIIGES -->
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body class="">
  <!-- HEADER Y BARRA DE NAVEGACION -->
	<?php
      require_once "menu.php";
  ?>

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
					<li><a href="#"><i class="icon icon-home"></i></a></li>
					<li><a href="home.php">SIIGES</a></li>
					<li class="active">Ver usuario</li>
				</ol>
        <h2 class="">Ver usuario</h2>

				<hr class="red">


				<!-- INICIA FORMULARIO -->
				<form role="form" id="registro-formulario" class="form" method="" action="">
          <input type="hidden"  id="id" value="<?= $id ?>">
					<!-- TODOS LOS CAMPOS DEL REGISTRO -->
					<fieldset class="col-md-12">
						<legend>Datos de usuario:</legend>
						<div class="form-group ">
							<label class="control-label" for="">Tipo de usuario</label><br>
              <input type="text" class="form-control" id="rol" disabled>
						</div>
            <div class="form-group">
							<label class="control-label" for="">Usuario</label><br>
							<input type="text" id="usuario"  class="form-control" disabled>
						</div>
            <div class="form-group">
							<label class="control-label" for="">Estatus</label><br>
							<input type="text" id="estatus"  class="form-control" disabled>
						</div>
            <div class="form-group">
							<label class="control-label" for="">Fecha de creción</label><br>
							<input type="text" id="creado"  class="form-control" disabled>
						</div>
						<div class="form-group">
							<label class="control-label" for="">Nombre(s)</label><br>
							<input type="text" id="nombre"  class="form-control" disabled>
						</div>
						<div class="form-group">
							<label class="control-label" for="">Apellido paterno</label><br>
							<input type="text" id="apellido_paterno" class="form-control" disabled>
						</div>
						<div class="form-group">
							<label class="control-label" for="">Apellido materno</label><br>
							<input type="text" id="apellido_materno" class="form-control" disabled>
						</div>
						<div class="form-group">
							<label class="control-label" for="">Correo electrónico</label><br>
							<input type="email" id="correo" class="form-control" disabled>
						</div>
						<div class="form-group">
							<label class="control-label" for="">Cargo</label><br>
							<input type="text" id="titulo_cargo" class="form-control"disabled>
						</div>
					</fieldset>
					<!-- BOTON REGISTRAR USUARIO -->
					<div class="form-group">
						<a href="usuarios.php" name="" class="btn btn-primary pull-right" >Aceptar</a>
					</div>
				</form>
			</div>
		</section>
	</div>


	<!-- JS GOB.MX -->
	<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
	<!-- JS JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- SECCION PARA SCRIPTS -->
  <script src="../js/usuarios.js"></script>

</body>
</html>
