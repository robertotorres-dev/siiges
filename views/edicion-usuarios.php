<?php
require_once "../models/modelo-usuario.php";
require_once "../models/modelo-rol.php";

session_start( );
$resultado = "";
if(isset($_SESSION["resultado"])){
  $resultado = json_decode($_SESSION["resultado"]);
  unset($_SESSION["resultado"]);
}
$id = isset($_GET["id"])?$_GET["id"]:null;
unset($_GET["id"]);

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gestión de Usuarios</title>

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
					<li><a href="#">SIIGES</a></li>
					<li class="active">Gestión de usuarios</li>
				</ol>
        <?php if($id): ?>
          <h2 class="">Editar usuario</h2>
        <?php else:?>
          <h2 class="">Nuevo usuario</h2>
        <?php endif?>

				<hr class="red">
				<?php if($resultado && isset($resultado->status) && $resultado->status != "200"): ?>
					<div class="alert alert-danger">
					<p><?= $resultado->message ?></p>
					</div>
				<?php
              elseif(isset($resultado->message)):?>
              <div class="alert alert-success">
              <p><?= $resultado->message ?></p>
              </div>
          <?php  endif; ?>
        <div id="mensaje"></div>

				<!-- INICIA FORMULARIO -->
				<form role="form" id="registro-formulario" class="form" method="post" action="../controllers/control-usuario.php">
					<input type="hidden"  name="webService" value="registro">
          <input type="hidden"  name="url" value="../views/usuarios.php">
          <!-- // Cargar los datos desde JS -->
          <input type="hidden"  id="id" name="id" value=<?= $id ?>>



					<!-- TODOS LOS CAMPOS DEL REGISTRO -->
					<fieldset class="col-md-12">
						<legend>Llene los siguientes datos:</legend>
						<div class="form-group ">

							<label class="control-label" for="">Tipo de usuario</label><br>
              <?php
                if(Rol::ROL_ADMIN == $_SESSION["rol_id"]):
              ?>
              <select class="form-control" id="perfil-roles" name="rol_id" required placeholder="Seleccione una opcion">
								<option></option>
							</select>
              <?php
                else:
              ?>
                 <select class="form-control" name="rol_id" required placeholder="Seleccione una opcion">
		    <option></option>
                    <option value ="4">Gestor</option>
                    <option value ="12">Control escolar IES</option>
		 </select>
              <?php
                endif
              ?>
						</div>
            <div class="form-group">
							<label class="control-label" for="">Usuario</label><br>
							<input type="text" id="usuario" name="usuario" class="form-control" required placeholder="Usuario">
						</div>
						<div class="form-group">
							<label class="control-label" for="">Nombre(s)</label><br>
							<input type="text" id="nombre" name="nombre" class="form-control" required placeholder="Nombre(s) del usuario">
						</div>
						<div class="form-group">
							<label class="control-label" for="">Apellido paterno</label><br>
							<input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" required placeholder="Apellido paterno del usuario">
						</div>
						<div class="form-group">
							<label class="control-label" for="">Apellido materno</label><br>
							<input type="text" id="apellido_materno" name="apellido_materno" class="form-control" required placeholder="Apellido materno del usuario">
						</div>
						<div class="form-group">
							<label class="control-label" for="">Correo electrónico</label><br>
							<input type="email" id="correo" name="correo" class="form-control" required placeholder="@mi_correo.com">
						</div>
						<div class="form-group">
							<label class="control-label" for="">Cargo</label><br>
							<input type="text" id="titulo_cargo" name="titulo_cargo" class="form-control"   placeholder="Cargo desempeñado en la institución">
						</div>
            <?php
              if(!$id):
            ?>
						<div class="form-group">
							<label class="control-label" for="">Contraseña</label><br>
							<input type="password" id="registro-contrasena" name="contrasena" class="form-control" required placeholder="Asigne una contraseña para el usuario">
						</div>
						<div class="form-group">
							<label class="control-label" for="">Repetir Contraseña</label><br>
							<input type="password" id="registro-confirmacion-contrasena" name="confirmar_contrasena" class="form-control" required placeholder="Repita la contraseña asignada al usuario">
						</div>
          <?php endif ?>
					</fieldset>

					<!-- BOTON REGISTRAR USUARIO -->
					<div class="form-group">
						<input type="submit" id="btnGguardar" name="" class="btn btn-primary pull-right" value="Guardar usuario" />
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
	<script src="../js/validaciones.js"></script>

</body>
</html>