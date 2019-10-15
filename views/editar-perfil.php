<?php
session_start( );

if(isset($_SESSION["id"]) && $_SESSION["id"]){
$usuaio_id = $_SESSION["id"];
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Editar Perfil</title>

	<!-- CSS GOB.MX -->
	<link href="../favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body class="">

	<!-- HEADER Y BARRA DE NAVEGACION -->
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
				<li><a href="home.php"><i class="icon icon-home"></i></a></li>
				<li><a href="home.php">SIIGES</a></li>
				<li class="active">Perfil</li>
			</ol>
      <div class="alert" id="mensaje"></div>

			<h2>Editar Perfil</h2>
			<hr class="red">
			<!-- INICIA FORMULARIO -->
			<form id="form-edicion"  role="form" class="form" method="post" action="../controllers/control-persona.php" enctype="multipart/form-data">
				<input type="hidden" id="webService" name="webService" value="guardar" />
				<input type="hidden" id="url" name="url" value="../views/home.php" />
        <input type="hidden" id="persona_id" name="id" value="<?= $_SESSION["persona_id"] ?>" />
				<input type="hidden" id="rol_id" name="rol_id" value="<?= $_SESSION["rol_id"] ?>" />
        <div class="form-group">
          <img id="fotografia-img" src="" width="150px">
          <div class="form-group">
            <label class="control-label" for="fotografia">Cargar foto</label>
            <input type="file" id="fotografia" name="fotografia" class="form-control" value="">
          </div>
        </div>
				<div class="">

					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="selRol">Rol</label><br>
						<select id="selRol" class="form-control" <?php echo Rol::ROL_ADMIN == $_SESSION["rol_id"]? 'name="rol_id"': 'disabled'; ?>>
							<option>Selecciona el Rol</option>
						</select>
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="txtNombre">Nombres*</label><br>
						<input class="form-control" id="txtNombre" name="nombre" value="" placeholder="Ingresa tu nombre" type="text" required>
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="txtApellidoPaterno">Apellido paterno*</label>
						<input class="form-control" id="txtApellidoPaterno" name="apellido_paterno" value="" placeholder="Apellido paterno" type="text" required>
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="txtApellidoMaterno">Apellido materno*</label>
						<input class="form-control" id="txtApellidoMaterno" name="apellido_materno" value="" placeholder="Apellido materno" type="text" required>
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="dateFechaNacimiento">Fecha de Nacimiento</label>
						<input class="form-control" id="dateFechaNacimiento" name="fecha_nacimiento" value=""placeholder="Fecha de nacimiento" type="date">
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="txtCargo">Cargo</label><br>
						<input class="form-control" id="txtCargo" name="titulo_cargo" value="" placeholder="Ingrese su cargo" type="text" required>
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="selectSexo">Sexo</label>
						<select id="selectSexo" class="form-control" name="sexo" value="" required>
							<option value="null">Seleccione una opción</option>
							<option value="Masculino" >Masculino</option>
							<option value="Femenino" >Femenino</option>
						</select>
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="txtNacionalidad">Nacionalidad</label>
						<input class="form-control" id="txtNacionalidad" name="nacionalidad" type="text" value="">
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="txtTelefono">Teléfono</label>
						<input class="form-control" id="txtTelefono" name="telefono" type="text" value="">
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="txtCelular">Celular</label>
						<input class="form-control" id="txtCelular" name="celular" type="text" value="">
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="txtCurp">CURP</label>
						<input class="form-control" id="txtCurp" name="curp" type="text" value="">
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="txtRfc">RFC</label>
						<input class="form-control" id="txtRfc" name="rfc" type="text" value="">
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="txtIne">INE</label>
						<input class="form-control" id="txtIne" name="ine" type="text" value="">
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label class="control-label" for="txtCorreo">Correo electrónico</label>
						<input  class="form-control" id="txtCorreo" name="correo" value="" type="email" >
					</div>
				</div>

        <div class="form-group col-sm-6 col-md-4">
          <p class="small text-muted">*Campos obligatorios</p>
          <input type="submit" id="btnEditarPerfilLateral" name="" class="btn btn-primary pull-right" value="Guardar cambios" />
        </div>
			</form>

		</div>

	</section>
</div>


<!-- JS GOB.MX -->
<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
<!-- JS JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- JS PROPIOS -->
<script src="../js/home.js"></script>
<script src="../js/personas.js"></script>
</body>
</html>
