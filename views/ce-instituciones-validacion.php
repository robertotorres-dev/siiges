<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );

	//====================================================================================================

	require_once "../models/modelo-institucion.php";
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
						<li class="active">Instituciones</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre">Instituciones</h2>
				<hr class="red">
				<!-- CONTENIDO -->
				<div class="row" style="padding-top: 20px;">
          <div class="col-sm-12">
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <table id="tabla-reporte" class="table table-striped table-bordered" cellspacing="0" width="100%">
	            <thead>
								<tr>
	                <th width="20%">Id</th>
									<th width="60%">Nombre</th>
									<th width="20%">Acciones</th>
								</tr>
							</thead>
	            <tbody>
							<?php
								$institucion = new Institucion( );
								$institucion->setAttributes( array( ) );
								$resultadoInstitucion = $institucion->consultarTodos( );

								$max = count( $resultadoInstitucion["data"] );

								for( $i=0; $i<$max; $i++ )
								{
							?>
							<tr>
								<td><?php echo $resultadoInstitucion["data"][$i]["id"]; ?></td>
								<td><?php echo $resultadoInstitucion["data"][$i]["nombre"]; ?></td>
								<td>
									<?php if(Rol::ROL_CONTROL_ESCOLAR_SICYT == $_SESSION["rol_id"] || (Rol::ROL_ADMIN == $_SESSION["rol_id"] )): ?>
									<a href="ce-planteles-validacion.php?institucion_id=<?php echo $resultadoInstitucion["data"][$i]["id"]; ?>">Planteles</a><br />
									<a href="ce-clave-ies.php?institucion_id=<?php echo $resultadoInstitucion["data"][$i]["id"]; ?>">Clave IES</a>
									<?php endif;?>
								</td>
							</tr>
							<?php
								}
							?>
	            </tbody>
						</table>
          </div>
        </div>
			</div>

		</section>
	</div>

<!-- JS GOB.MX -->
<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
<!-- JS JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#tabla-reporte").DataTable({
			"language":{
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			}
		});
	});
</script>
</body>
</html>
