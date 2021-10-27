<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
Utileria::validarSesion(basename(__FILE__));

//====================================================================================================

require_once "../models/modelo-programa.php";
require_once "../models/modelo-grupo.php";
require_once "../models/modelo-turno.php";
require_once "../models/modelo-institucion.php";


$programa = new Programa();
$programa->setAttributes(array("id" => $_GET["programa_id"]));
$resultadoPrograma = $programa->consultarId();

$plantel = new Plantel();
$plantel->setAttributes(array("id" => $resultadoPrograma["data"]["plantel_id"]));
$resultadoPlantel = $plantel->consultarId();

$institucion = new Institucion();
$institucion->setAttributes(array("id" => $resultadoPlantel["data"]["institucion_id"]));
$resultadoInstitucion = $institucion->consultarId();

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
						<li class="active"><?php echo $_SESSION["nombre"] . " " . $_SESSION["apellido_paterno"] . " " . $_SESSION["apellido_materno"]; ?></li>
					</ol>
					<!-- BARRA DE NAVEGACION -->
					<ol class="breadcrumb pull-left">
						<li><i class="icon icon-home"></i></li>
						<li><a href="ce-programas-plantel-equivalencia.php?institucion_id=<?php echo $resultadoInstitucion["data"][0]["id"] ?>&plantel_id=<?php echo $resultadoPlantel["data"]["id"] ?>">Programas de Estudios</a></li>
						<li><a href="ce-ciclos-escolares-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>">Ciclos Escolares</a></li>
						<li><a href="ce-grados-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>">Grados</a></li>
						<li class="active">Grupos</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre">Grupos</h2>
				<hr class="red">
				<div class="row">
					<div class="col-sm-12">
						<legend><?php echo $resultadoPrograma["data"]["nombre"]; ?></legend>
					</div>
				</div>
				<!-- NOTIFICACIÓN -->
				<?php if (isset($_GET["codigo"]) && $_GET["codigo"] == 200) { ?>
					<div class="alert alert-success">
						<p>Registro guardado.</p>
					</div>
				<?php } ?>
				<!-- CONTENIDO -->
				<div class="row">
					<div class="col-sm-12">
						<a href="ce-catalogo-grupo-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>&grupo_id=&proceso=alta" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-plus"></i> Alta de Grupo</a>
					</div>
				</div>
				<div class="row" style="padding-top: 20px;">
					<div class="col-sm-12">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<table id="tabla-reporte" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th width="15%">Grado</th>
									<th width="15%">Grupo</th>
									<th width="10%">Acciones</th>
									<th width="10%">Acciones</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$parametros["ciclo_escolar_id"] = $_GET["ciclo_id"];
								$parametros["grado"] = $_GET["grado"];

								$grupo = new Grupo();
								$grupo->setAttributes($parametros);
								$resultadoGruposCicloGrado = $grupo->consultarGruposCicloGrado();

								$max = count($resultadoGruposCicloGrado["data"]);

								for ($i = 0; $i < $max; $i++) {
									$parametros2["id"] = $resultadoGruposCicloGrado["data"][$i]["turno_id"];

									$turno = new Turno();
									$turno->setAttributes($parametros2);
									$resultadoTurno = $turno->consultarId();
								?>
									<tr>
										<td><?php echo $resultadoGruposCicloGrado["data"][$i]["grado"]; ?></td>
										<td><?php echo $resultadoGruposCicloGrado["data"][$i]["grupo"]; ?></td>
										<td>
											<a href="ce-catalogo-grupo-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>&grupo_id=<?php echo $resultadoGruposCicloGrado["data"][$i]["id"]; ?>&proceso=consulta"><span id="" title="Abrir" class="glyphicon glyphicon-eye-open col-sm-1 size_icon"></span></a>
											<a href="ce-catalogo-grupo-equivalencia.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>&grupo_id=<?php echo $resultadoGruposCicloGrado["data"][$i]["id"]; ?>&proceso=edicion"><span id="" title="Editar" class="glyphicon glyphicon-edit col-sm-1 size_icon"></span></a>
											<a href="#" data-toggle="modal" data-target="#modalEliminar"><span id="" title="Eliminar" class="glyphicon glyphicon-trash col-sm-1 size_icon"></span></a>
										</td>
										<td>
											<a href="ce-inscripcion.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>&grupo_id=<?php echo $resultadoGruposCicloGrado["data"][$i]["id"]; ?>&tramite=equiv">Inscripci&oacute;n</a><br>
											<a href="ce-asignaturas.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>&grupo_id=<?php echo $resultadoGruposCicloGrado["data"][$i]["id"]; ?>&tramite=equiv">Acreditaci&oacute;n</a>
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
</body>

</html>