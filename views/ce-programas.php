<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );
	//====================================================================================================
	require_once "../models/modelo-programa.php";
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
						<li class="active">Programas de Estudios</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre">Programas de Estudios</h2>
				<hr class="red">
				<div class="row">
          <div class="col-sm-12">
						<legend>Programas de estudios acreditados con RVOE</legend>
					</div>
				</div>
				<!-- CONTENIDO -->
				<div class="row" style="padding-top: 20px;">
          <div class="col-sm-12">
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <table id="tabla-reporte1" class="table table-striped table-bordered" cellspacing="0" width="100%">
	            <thead>
								<tr>
	                <th width="10%">Id</th>
	                <th width="40%">Nombre</th>
	                <th width="20%">Surte efecto</th>
									<th width="20%">Acuerdo RVOE</th>
	                <th width="10%">Acciones</th>
								</tr>
							</thead>
	            <tbody>
							<?php
								$programa = new Programa( );
								$programa->setAttributes( array( "usuario_id"=>$_SESSION["id"] ) );
								$representante = new Programa();
								$ce = $representante->consultarPor("usuario_usuarios",array("secundario_id"=>$_SESSION["id"]),"*");
								if(sizeof($ce["data"])>0)
								{
									$programa->setAttributes( array( "usuario_id"=>	$ce["data"][0]["principal_id"] ) );
								}
								$resultadoPrograma = $programa->consultarAcreditados( );

								$max = count( $resultadoPrograma["data"] );

								for( $i=0; $i<$max; $i++ )
								{
							?>
							<tr>
								<td><?php echo $resultadoPrograma["data"][$i]["id"]; ?></td>
								<td><?php echo $resultadoPrograma["data"][$i]["nombre"]; ?></td>
								<td><?php echo $resultadoPrograma["data"][$i]["fecha_surte_efecto"]; ?></td>
								<td><?php echo $resultadoPrograma["data"][$i]["acuerdo_rvoe"]; ?></td>
								<td>
									<a href="ce-reglas.php?programa_id=<?php echo $resultadoPrograma["data"][$i]["id"]; ?>">Reglas</span></a>
									<br/>
									<a href="ce-alumnos.php?programa_id=<?php echo $resultadoPrograma["data"][$i]["id"]; ?>">Alumnos</span></a>
									<br/>
									<a href="ce-ciclos-escolares.php?programa_id=<?php echo $resultadoPrograma["data"][$i]["id"]; ?>">Acreditaci&oacute;n</span></a>
								</td>
							</tr>
							<?php
								}
							?>
	            </tbody>
						</table>
          </div>
        </div>

				<div class="row" style="padding-top: 50px;">
          <div class="col-sm-12">
          </div>
        </div>

				<!-- TÍTULO -->
				<div class="row">
          <div class="col-sm-12">
						<legend><span style="color: red;">Programas de estudios no acreditados con RVOE</span></legend>
					</div>
				</div>
				<!-- CONTENIDO -->
				<div class="row" style="padding-top: 20px;">
          <div class="col-sm-12">
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <table id="tabla-reporte2" class="table table-striped table-bordered" cellspacing="0" width="100%">
	            <thead>
								<tr>
	                <th width="10%">Id</th>
	                <th width="40%">Nombre</th>
	                <th width="20%">Surte efecto</th>
									<th width="20%">Acuerdo RVOE</th>
	                <th width="10%">Acciones</th>
								</tr>
							</thead>
	            <tbody>
							<?php
								$programa = new Programa( );
								$programa->setAttributes( array( "usuario_id"=>$_SESSION["id"] ) );
								$resultadoPrograma = $programa->consultarNoAcreditados( );
								$max = count( $resultadoPrograma["data"] );
								for( $i=0; $i<$max; $i++ )
								{
							?>
							<tr>
								<td><?php echo $resultadoPrograma["data"][$i]["id"]; ?></td>
								<td><?php echo $resultadoPrograma["data"][$i]["nombre"]; ?></td>
								<td><?php echo $resultadoPrograma["data"][$i]["fecha_surte_efecto"]; ?></td>
								<td><?php echo $resultadoPrograma["data"][$i]["acuerdo_rvoe"]; ?></td>
								<td>N/A</td>
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
		$("#tabla-reporte1").DataTable({
			"language":{
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			}
		});

		$("#tabla-reporte2").DataTable({
			"language":{
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			}
		});
	});
</script>
</body>
</html>
