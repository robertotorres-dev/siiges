<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Asignar Inspector</title>

	<!-- CSS GOB.MX -->
	<link href="../favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<!-- CSS SIIGES -->
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body class="">
	<!-- HEADER Y BARRA DE NAVEGACION -->
	<?php require_once "menu.php"; ?>

	<!-- CUERPO DEL FORMULARIO -->
	<div class="container">
		<section class="main row margin-section-formularios">
			<div class="col-sm-12 col-md-12 col-lg-9">
				<ol class="breadcrumb">
					<li><a href="#"><i class="icon icon-home"></i></a></li>
					<li><a href="#">SIIGES</a></li>
					<li class="active">Asignar Inspector Físico</li>
				</ol>

				<h2>Asignar Inspector Físico</h2>
				<hr class="red">

				<!-- PLAN DE ESTUDIOS Y PLANTEL -->
				<h3 class="text-info">Nombre del Plan de Estudios</h3>
				<h3 class="text-info">Plantel</h3><br>

				<!-- SELECTOR CON OPCIONES PARA IESI -->
				<div class="form-group col-md-12">
					<label class="control-label" for="">Seleccione un aspirante inspector del listado</label><br>
					<select class="form-control">
						<option>...</option>
					</select>
				</div>
				<div class="form-group col-md-12" style="margin-bottom: 80px;">
					<div class="col-md-6">
						<input type="submit" id="" name="" class="btn btn-default" value="Ver CV del aspirante" />
					</div>
					<div class="col-md-6">
						<input type="submit" id="" name="" data-toggle="modal" data-target="#modalAsignar" class="btn btn-primary pull-right" value="Asignar como Evaluador" />
					</div>
				</div>
			</div>

			<!-- CARD USUARIO LATERAL -->
			<?php require_once "aside-usuario.php"; ?>

			<div class="col-sm-12 col-md-12 col-lg-3">
				<div class="form-group">
					<label class="control-label" for="">Código de ética SINECyT</label><br>
					<a href="codigo-etica-sinecyt.php" target="_blank">
						<button class="btn btn-default" type="button">
							<span class="glyphicon glyphicon-file"></span>
							Abrir documento
						</button>
					</a>
				</div>
			</div>

			<!-- TABS DEL CV DEL ASPIRANTE -->
			<ul class="nav nav-tabs col-sm-12 col-md-9">
				<li class="active"><a data-toggle="tab" href="#tab-01">Datos Generales</a></li>
				<li><a data-toggle="tab" href="#tab-02">Datos Institucionales</a></li>
				<li><a data-toggle="tab" href="#tab-03">Trayectoria Académica</a></li>
				<li><a data-toggle="tab" href="#tab-04">Asociaciones Profesionales</a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="tab-01">
					<div class="col-sm-12 col-md-9">
						<form class="form-horizontal" role="form">
							<div class="form-group">
								<legend><br>Datos Generales</legend>
								<div class="col-sm-12">
									<img src="../images/img-usuario.png" width="150px">
								</div>
								<label class="col-sm-3 control-label" for="">Fotografía (JPG)</label>
								<div class="col-sm-9">
									<input class="form-control" id="" type="file" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">No. Evaluador</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Número de evaluador" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Modalidad</label>
								<div class="col-sm-9">
									<select id="" class="form-control" disabled>
										<option>Presencial</option>
										<option>Mixta</option>
										<option>Abierta y a distancia</option>
										<option>...</option>
									</select>
								</div>
								<label class="col-sm-3 control-label" for="">Especialidad</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Ingrese Especialidad" type="text" disabled>
								</div>
							</div>

							<legend><br>Registros de procesos de evaluación y/o acreditación</legend>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="">Registro RCEA</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Número de su RCEA" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Evaluador CIEES</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Número de evaluador CIEES" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Evaluador COEPES</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Número de evaluador COEPES" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Evaluador CONACYT</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Número de evaluador CONACYT" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Otros</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Número de evaluador" type="text" disabled>
								</div>
							</div>

							<legend><br>Datos Generales</legend>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="">Nombre(s)</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Ingrese su nombre" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Apellido paterno</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Ingrese su apellido paterno" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Apellido materno</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Ingrese su apellido materno" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Teléfono</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="(lada) + Número de teléfono" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Teléfono móvil</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="(lada) + Número de teléfono móvil" type="text" disabled>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="tab-pane" id="tab-02">
					<div class="col-sm-12 col-md-9">
						<form class="form-horizontal" role="form">
							<div class="form-group">
								<legend><br>Datos institucionales</legend>
								<label class="col-sm-3 control-label" for="">Institución</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Nombre de la Institución donde labora" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Departamento</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Nombre del Departamento de adscripción" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Nombramiento</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Nombramiento dentro del departamento" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">PROMED</label>
								<div class="col-sm-9">
									<select id="" class="form-control" disabled>
										<option>Vigente</option>
										<option>No Vigente</option>
										<option>...</option>
									</select>
								</div>
								<label class="col-sm-3 control-label" for="">SNI</label>
								<div class="col-sm-9">
									<select id="" class="form-control" disabled>
										<option>Vigente</option>
										<option>No Vigente</option>
										<option>...</option>
									</select>
								</div>
							</div>

							<legend><br>Formación académica</legend>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="">Licenciatura</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Licenciatura cursada" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Disciplina</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Disciplina de la licenciatura cursada" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Especialidad</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Especialidad cursada" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Disciplina</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Disciplina de la Especialidad" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Maestría</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Maestría cursada" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Disciplina</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Disciplina de la Maestría" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Doctorado</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Doctorado cursado" type="text" disabled>
								</div>
								<label class="col-sm-3 control-label" for="">Disciplina</label>
								<div class="col-sm-9">
									<input class="form-control" id="" placeholder="Disciplina del Doctorado" type="text" disabled>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="tab-pane" id="tab-03">
					<div class="col-sm-12 col-md-9">
						<form class="form-horizontal" role="form">
							<div class="form-group">
								<legend><br>Trayectoria académica y en procesos de evaluación de planes de programas de estudio<br><p class="small">Puestos académico-administrativos, comités institucionales y comisiones de evaluación</p></legend>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Actividad o puesto" type="text" disabled>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Institución" type="text" disabled><br>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Actividad o puesto" type="text" disabled>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Institución" type="text" disabled><br>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Actividad o puesto" type="text" disabled>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Institución" type="text" disabled>
								</div>
							</div>

							<legend><br>Experiencia prifesional no docente (ordenar por el más reciente)</legend>
							<div class="form-group">
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Actividad o puesto" type="text" disabled>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Institución" type="text" disabled><br>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Actividad o puesto" type="text" disabled>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Institución" type="text" disabled><br>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Actividad o puesto" type="text" disabled>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Institución" type="text" disabled>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="tab-pane" id="tab-04">
					<div class="col-sm-12 col-md-9">
						<form class="form-horizontal" role="form">
							<div class="form-group">
								<legend><br>Pertenencia a asociaciones profesionales</legend>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Nombre de la Asociación" type="text" disabled>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Membresía" type="text" disabled><br>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Nombre de la Asociación" type="text" disabled>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Membresía" type="text" disabled><br>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Nombre de la Asociación" type="text" disabled>
								</div>
								<div class="col-sm-6">
									<input class="form-control" id="" placeholder="Membresía" type="text" disabled>
								</div>
							</div>

							<legend><br>Logros<br>
								<p class="small">(En caso que lo considere conveniente reseñe los logros académicos y/o profesionales más importantes destacando su participación en procesos de evaluación y/o acreditación)</p>
							</legend>
							<div class="form-group">
								<div class="col-md-12">
									<textarea id="" placeholder="Describa a detalle sus logros" class="col-md-12"></textarea>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<!-- -------------------------------------------------------------------------------- -->

			<!-- MODAL DE ASIGNAR EVALUADOR -->
			<div class="modal fade" id="modalAsignar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Asignar evaluador</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body text-center">
							¿Confirma que el Plan de estudios _______________ , del plantel _________________ , será asignado al inspector ___________?<br>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<button type="button" class="btn btn-primary">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>


	<!-- JS GOB.MX -->
	<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
	<!-- JS JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</body>
</html>
