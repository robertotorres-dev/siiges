<?php
require_once "../models/modelo-rol.php";
session_start( ); $usuario_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos Institución</title>
	<!-- CSS GOB.MX -->
	<link href="../favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<!-- CSS DATATABLE -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
	<!-- CSS PROPIO -->
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body >


  <!-- HEADER Y BARRA DE NAVEGACION -->
	<?php require_once "menu.php"; ?>


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
				<li class="active">Planteles</li>
			</ol>

			<div class="mensaje" id="mensaje"></div>
			<!-- Datos Institucion -->
			<input id="usuario_id" type="hidden" name="usuario_id" value="<?=$usuario_id?>" >
			<input type="hidden" id="institucion_id" name="institucion_id">
			<input type="hidden" id="webService" name="webService" value="consultarPlantelesInstitucion">
			<input type="hidden" id="url" name="url" value="">
					<h2 id="txtNombre">Mi institución</h2>
					<hr class="red">
					<?php if(Rol::ROL_REPRESENTANTE_LEGAL == $_SESSION["rol_id"]): ?>
					<a href="informacion-institucion.php" class="btn btn-primary pull-center"><i class=" 	glyphicon glyphicon-pencil" aria-hidden="true"></i>&nbsp;&nbsp;Editar Institución</a>

					<br>
						<br>	<br>
					<div>

					</div>
			<!-- Tabla de los planteles-->
		<div>

	    <div class="col-sm-12 col-md-12 ">
	       <a id="enlace_alta" href="#" class="btn btn-primary pull-right menu"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i>&nbsp;&nbsp;Dar alta plantel</a>
				 <br><br> <br>
			</div>
<?php endif; ?>
			<!-- Agregar separacion entre tabla y boton de nuevo usuario-->
	    <div class="col-12">
	        <table id="planteles" class="table table-striped table-bordered" cellspacing="0" width="100%">
	            <thead>
	            <tr>
	                <th>Domicilio</th>
	                <th>Colonia</th>
	                <th>Municipio</th>
	                <th>CP</th>
	                <th>Acciones</th>
	            </tr>
	            </thead>
	            <tbody>
	            </tbody>
	        </table>
	    </div>
		</div>
	</section>


<!-- Modal eliminar-->
<div id="modalEliminar" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">¿Estás seguro?</h4>
            </div>
            <div class="modal-body">
                <p>Esta apunto de borrar el plantel con domicilio: <span id="domicilio-completo"></span></p>
                <p class="text-warning"><small>Si lo borras, nunca podrás recuperarlo.</small></p>
						</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="eliminar" value=""  onclick="Institucion.borrarRegistro()"type="button" class="btn btn-danger" data-dismiss="modal">Eliminar</button>
            </div>
        </div>
    </div>
</div>

</div>


<!-- JS GOB.MX -->
<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
<!-- JS JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<!-- JS PROPIOS -->
<script src="../js/funciones.js"></script>
<script src="../js/instituciones.js"></script>
</body>
</html>
