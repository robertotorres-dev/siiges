<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );

	//====================================================================================================

	require_once "../models/modelo-institucion.php";
	require_once "../models/modelo-plantel.php";
	require_once "../models/modelo-domicilio.php";
	require_once "../models/modelo-usuario.php";
	require_once "../models/modelo-persona.php";

	$institucion = new Institucion( );
	$institucion->setAttributes( array( "usuario_id"=>	$_SESSION["id"] ) );
	$representante = new Institucion;
	$ce = $representante->consultarPor("usuario_usuarios",array("secundario_id"=>$_SESSION["id"]),"*");
	
	if(sizeof($ce["data"])>0)
	{
		$resultadoInstitucion = $institucion->consultarPor("instituciones", array("usuario_id"=>$ce["data"][0]["principal_id"]),"*");
	} else {
		$resultadoInstitucion = $institucion->consultarPor("instituciones", array("usuario_id"=>$_SESSION["id"]),"*");
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
						<li><a href="ce-instituciones.php">Instituciones</a></li>
						<li class="active">Planteles</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre">Planteles</h2>
				<hr class="red">
				<div class="row">
          <div class="col-sm-12">
						<legend><?php echo $resultadoInstitucion["data"][0]["nombre"]; ?></legend>
					</div>
				</div>
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
	                <th width="10%">Id</th>
									<th width="30%">Plantel</th>
									<th width="20%">Clave de Centro de Trabajo</th>
									<th width="30%">Representante Legal</th>
									<th width="10%">Acciones</th>
								</tr>
							</thead>
	            <tbody>
							<?php
								$parametros["institucion_id"] = $resultadoInstitucion["data"][0]["id"];

								$plantel = new Plantel( );
								$plantel->setAttributes( $parametros );
								$resultadoPlantel = $plantel->consultarPlantelesInstitucion( );

								$max = count( $resultadoPlantel["data"] );

								for( $i=0; $i<$max; $i++ )
								{
									$parametros2["id"] = $resultadoPlantel["data"][$i]["domicilio_id"];

									$domicilio = new Domicilio( );
									$domicilio->setAttributes( $parametros2 );
									$resultadoDomicilio = $domicilio->consultarId( );

									$parametros3["id"] = $resultadoInstitucion["data"][0]["usuario_id"];

									$usuario = new Usuario( );
									$usuario->setAttributes( $parametros3 );
									$resultadoUsuario = $usuario->consultarId( );

									$parametros4["id"] = $resultadoUsuario["data"]["persona_id"];

									$persona = new Persona( );
									$persona->setAttributes( $parametros4 );
									$resultadoPersona = $persona->consultarId( );
							?>
							<tr>
								<td><?php echo $resultadoPlantel["data"][$i]["id"]; ?></td>
								<td><?php echo $resultadoDomicilio["data"]["calle"]." ".$resultadoDomicilio["data"]["numero_exterior"].", ". $resultadoDomicilio["data"]["municipio"]; ?></td>
								<td><?php echo $resultadoPlantel["data"][$i]["clave_centro_trabajo"]; ?></td>
								<td><?php echo $resultadoPersona["data"]["nombre"]." ".$resultadoPersona["data"]["apellido_paterno"]." ".$resultadoPersona["data"]["apellido_materno"]; ?></td>
								<td>
									<a href="ce-programas-plantel.php?institucion_id=<?php echo $resultadoInstitucion["data"][0]["id"]; ?>&plantel_id=<?php echo $resultadoPlantel["data"][$i]["id"]; ?>">Programas</a>
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
