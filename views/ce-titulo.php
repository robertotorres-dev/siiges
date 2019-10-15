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
	<meta charset="utf_8">
	<meta http_equiv="X_UA_Compatible" content="IE=edge">
	<meta name="viewport" content="width=device_width, initial_scale=1">
	<title>Gestión de Títulos</title>

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
					<li class="active">Título electrónico</li>
				</ol>
          <h2 class="">Título electrónico</h2>

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
				<form role="form" id="registro_formulario" class="form" method="post" action="../controllers/control-titulo.php">
					<input type="hidden"  name="webService" value="registro">
          <input type="hidden"  name="url" value="../views/home.php">
          <!-- // Cargar los datos desde JS -->
          <input type="hidden"  id="id" name="id" value=<?= $id ?>>

					<!-- TODOS LOS CAMPOS DEL REGISTRO -->
					<fieldset class="col-md-12">
						<legend>Institución</legend>
						<div class="form-group col-md-4 ">
							<label class="control-label" for="">Clave de institución *</label><br>
              <select class="form-control" id="INSTITUCION-cveInstitucion" name="INSTITUCION-cveInstitucion" >
								<option value="">090002</option>
							</select>
						</div>
            <div class="form-group col-md-8">
							<label class="control-label" for="">Nombre de intitución *</label><br>
							<input type="text" id="INSTITUCION-nombreInstitucion" name="INSTITUCION-nombreInstitucion" class="form-control"  placeholder="Escribe el nombre de tu institución" value="INSTITUTO POLITÉCNICO NACIONAL">
              <br>
						</div>
            <legend>Carrera</legend>
            <div class="form-group col-md-4">
							<label class="control-label" for="">Clave de carrera *</label><br>
							<input type="text" id="CARRERA-cveCarrera" name="CARRERA-cveCarrera" class="form-control"  placeholder="Escribe la clave de carrera" value="515237">
						</div>
            <div class="form-group col-md-8">
							<label class="control-label" for="">Nombre de carrera *</label><br>
							<input type="text" id="CARRERA-nombreCarrera" name="CARRERA-nombreCarrera" class="form-control"  placeholder="Escribe el nombre de tu carrera" value="TÉCNICO EN PLÁSTICOS">
						</div>
            <div class="col-sm-12 col-md-3">
              <label> Inicio</label>
              <input id="CARRERA-fechaInicio" class="form-control" type="date" value="2006-01-01">
            </div>
            <div class="col-sm-12 col-md-3">
              <label> Fin *</label>
              <input id="CARRERA-fechaTerminacion" class="form-control" type="date" value="2009-01-01">
              <br>
            </div>
						<div class="form-group col-md-7">
							<label class="control-label" for="">Autorización o reconocimiento</label><br>
              <select class="form-control" id="CARRERA-autorizacionReconocimiento" name="CARRERA-autorizacionReconocimiento"  placeholder="Seleccione una opcion">
								<option value="">Seleccione una opcion</option>
								<option value="1">RVOE FEDERAL</option>
								<option value="2">RVOE ESTATAL</option>
								<option value="3" selected>AUTORIZACIÓN FEDERAL</option>
								<option value="4">AUTORIZACIÓN ESTATAL</option>
								<option value="5">ACTA DE SESIÓN</option>
								<option value="6">ACUERDO DE INCORPORACIÓN</option>
								<option value="7">ACUERDO SECRETARIAL SEP</option>
								<option value="8">DECRETO DE CREACIÓN</option>
								<option value="9">OTRO</option>
							</select>
						</div>
						<div class="form-group col-md-5">
							<label class="control-label" for="">RVOE</label><br>
							<input type="text" id="num_rvoe" name="num_rvoe" class="form-control"  placeholder="Escribe el número de RVOE"><br>
						</div>
            <legend>Profesionista</legend>
            <div class="form-group col-md-12">
							<label class="control-label" for="">Nombrer(s)</label><br>
							<input type="text" id="PROFESIONISTA-nombre" name="PROFESIONISTA-nombre" class="form-control"  placeholder="Apellido materno del estudiante" value="MARIANA">
						</div>
						<div class="form-group col-md-6">
							<label class="control-label" for="">Apellido paterno</label><br>
							<input type="text" id="PROFESIONISTA-primerApellido" name="PROFESIONISTA-primerApellido" class="form-control"  placeholder="Apellido paterno del profesionista" value="ALONSO">
						</div>
						<div class="form-group col-md-6">
							<label class="control-label" for="">Apellido materno</label><br>
							<input type="text" id="PROFESIONISTA-segundoApellido" name="PROFESIONISTA-segundoApellido" class="form-control" placeholder="Apellido materno del profesionista" value="JIMENEZ">
						</div>
						<div class="form-group col-md-6">
							<label class="control-label" for="">CURP</label><br>
							<input type="text" id="PROFESIONISTA-curp" name="PROFESIONISTA-curp" class="form-control"  placeholder="CURP del estudiante" value="AOJM910903MMCLMR07">
						</div>
						<div class="form-group col-md-6">
							<label class="control-label" for="">Correo electrónico</label><br>
							<input type="email" id="PROFESIONISTA-correoElectronico" name="PROFESIONISTA-correoElectronico" class="form-control"  placeholder="@mi_correo.com" value="a.mar.sanorbac_jimenez@hotmail.com">
              <br>
						</div>
            <legend>Expedición</legend>
            <div class="form-group col-md-8">
							<label class="control-label" for="">Entidad federativa de expedición</label><br>
              <select class="form-control" id="EXPEDICION-entidadFederativa" name="EXPEDICION-entidadFederativa"  placeholder="Seleccione una opcion">
								<option value="09">CIUDAD DE MÉXICO</option>
							</select>
						</div>
						<div class="form-group col-md-8">
							<label class="control-label" for="">Modalidad</label><br>
              <select class="form-control" id="EXPEDICION-modalidadTitulacion" name="EXPEDICION-modalidadTitulacion"  placeholder="Seleccione una opcion">
								<option value="">Seleccione una opcion</option>
								<option value="1" selected>POR TESIS</option>
								<option value="2">POR PROMEDIO</option>
								<option value="3">POR ESTUDIOS DE POSGRADOS</option>
								<option value="4">POR EXPERIENCIA LABORAL</option>
								<option value="5">POR CENEVAL</option>
								<option value="6">OTRO</option>
							</select>
						</div>
            <div class="col-sm-12 col-md-4">
              <label> Fecha Expedición de Título*</label>
              <input id="EXPEDICION-fechaExpedicion" class="form-control" type="date" value="2013-12-04">
              <br>
            </div>
            <div class="form-group col-md-4">
							<label class="control-label" for="">Servicio Social</label><br>
              <select class="form-control" id="EXPEDICION-cumplioServicioSocial" name="EXPEDICION-cumplioServicioSocial"  placeholder="Seleccione una opcion">
								<option value="">Seleccione una opcion</option>
								<option value="1" selected>SI</option>
								<option value="2">NO</option>
							</select>
						</div>
            <div class="form-group col-md-8">
							<label class="control-label" for="">Fundamento *</label><br>
              <select class="form-control" id="EXPEDICION-fundamentoLegalServicioSocial" name="EXPEDICION-fundamentoLegalServicioSocial"  placeholder="Seleccione una opcion">
								<option value="">Seleccione una opcion</option>
								<option value="1" selected>ART. 52 LRART. 5 CONST</option>
								<option value="2">ART. 55 LRART. 5 CONST</option>
								<option value="3">ART. 91 RLRART. 5 CONST</option>
								<option value="4">ART. 10 REGLAMENTO PARA LA PRESTACIÓN DEL SERVICIO SOCIAL DE LOS ESTUDIANTES DE LAS INSTITUCIONES DE EDUCACIÓN SUPERIOR EN LA REPÚBLICA MEXICANA</option>
								<option value="5">NO APLICA</option>
							</select>
						</div> <br>
						<div class="form-group col-md-4">
							<label class="control-label" for="">Exámen Profesional</label><br>
              <input id="EXPEDICION-fechaExamenProfesional" class="form-control" type="date" value="2009-08-05">
              <br>
            </div>
            <div class="form-group col-md-4">
              <input type="checkbox" class="form-check-input" id="extencion">
              <label class="control-label" for="">Extención de Exámen Profesional</label><br>
              <input id="fecha_extencion" class="form-control" type="date" >
              <br>
            </div>
            <legend>Estudios de procedencia</legend>
            <div class="form-group col-md-8">
							<label class="control-label" for="">Nombre de intitución de procedencia *</label><br>
							<input type="text" id="ANTECEDENTE-institucionProcedencia" name="ANTECEDENTE-institucionProcedencia" class="form-control"  placeholder="Institución de procedenca" value="ESCUELA SECUNDARIA TECNICA 47, MÉXICO, D. F. ">
              <br>
						</div>
            <div class="form-group col-md-4">
							<label class="control-label" for="">Tipo de estudio *</label><br>
              <select class="form-control" id="ANTECEDENTE-tipoEstudioAntecedente" name="ANTECEDENTE-tipoEstudioAntecedente"  placeholder="Seleccione una opcion">
                <option value="">Seleccione una opción</option>
								<option value="1">MAESTRÍA</option>
								<option value="2">LICENCIATURA</option>
								<option value="3">TÉCNICO SUPERIOR UNIVERSITARIO</option>
								<option value="4">BACHILLERATO</option>
								<option value="5">EQUIVALENTE A BACHILLERATO</option>
								<option value="6" selected>SECUNDARIA</option>
							</select>
						</div>
            <div class="form-group col-md-8">
							<label class="control-label" for="">Entidad federativa</label><br>
              <select class="form-control" id="ANTECEDENTE-entidadFederativa" name="ANTECEDENTE-entidadFederativa"  placeholder="Seleccione una opcion">
								<option value="09" selected>CIUDAD DE MÉXICO</option>
							</select>
						</div>
            <div class="col-sm-12 col-md-4">
              <label> Cédula profesional</label>
              <input id="cedula" class="form-control" type="text" ><br>
            </div>
            <div class="col-sm-12 col-md-3">
              <label> Inicio *</label>
              <input id="ANTECEDENTE-fechaInicio" class="form-control" type="date" value="2003-01-01">
            </div>
            <div class="col-sm-12 col-md-3">
              <label> Fin *</label>
              <input id="ANTECEDENTE-fecha_Terminacion" class="form-control" type="date" value="2006-01-01">
              <br>
            </div>
					</fieldset>

					<!-- BOTON REGISTRAR USUARIO -->
					<div class="form-group col-md-12">
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

</body>
</html>
