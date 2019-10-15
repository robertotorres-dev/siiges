<?php
require_once "../utilities/utileria-general.php";
Utileria::validarSesion( basename( __FILE__ ) );
// Utileria::validarAccesoModulo( basename( __FILE__ ) );
//====================================================================================================
$resultado = "";
if(isset($_SESSION["resultado"])){
  $resultado = json_decode($_SESSION["resultado"]);
  unset($_SESSION["resultado"]);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Curriculum</title>
    <!-- CSS GOB.MX -->
    <link href="../favicon.ico" rel="shortcut icon">
    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
    <!-- CSS DATATABLE -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

    <!-- CSS PROPIO -->
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
  </head>
	<body>
		<div id="cargando" class="loader">

		</div>
		<!-- HEADER Y MENÚ -->

		<?php require_once "menu.php"; ?>

		<div class="container">
			<section  class="main row margin-section-formularios">
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
              <li><a href="home.php"><i class="icon icon-home"></i></a></li>
							<li><a href="home.php">SIIGES</a></li>
              <li class="active">Curriculum</li>
            </ol>
          </div>

					<div id="mensaje">
						<?php if(isset($resultado) && isset($resultado->status) && $resultado->status != "200"): ?>
							<div class="alert alert-danger">
								<p><?= $resultado->message ?></p>
							</div>
							<?php  endif; ?>
					</div>
					<!-- Cuerpo PRINCIPAL  -->
					<div class=" form-group col-sm-12 col-md-12 col-lg-12">
						<!-- TÍTULO -->
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h1 id="txtNombre">Curriculum</h1>
						</div>
						<!-- MENÚ PARA FORMULARIO -->
						<ul class="nav nav-tabs col-sm-12 col-md-12">
							<li class="active"><a data-toggle="tab" href="#tab-01">Datos Generales</a></li>
							<li><a data-toggle="tab" href="#tab-02">Datos Institucionales</a></li>
							<li><a data-toggle="tab" href="#tab-03">Trayectoria Académica</a></li>
							<li><a data-toggle="tab" href="#tab-04">Asociaciones Profesionales</a></li>
						</ul>
						<!-- FORMULARIO -->
						<form id="curriculum" class="form-horizontal" action="../controllers/control-evaluador.php" method="post" enctype="multipart/form-data" >
							<div class="tab-content col-sm-12">
								<!-- Datos generales -->
								<div class="tab-pane active" id="tab-01">
									<div class="col-sm-12 col-md-12">
											<!-- Datos personales -->
											<div class="form-group">
												<legend><br>Datos Generales</legend>

                        <div class="col-sm-12 col-md-12">
                          <img  name="fotografia" id="fotografia" src="../images/img-usuario.png" width="150px">
                          <br>
                        </div>
                        <?php if ($_SESSION["rol_id"]=="5"){?>
                          <div class="col-sm-12 col-md-12">
                            <label class="control-label" for="">Fotografía (JPG)</label>
                            <input class="form-control" campo="Fotografía"  id="fotografiasubir" name="PERSONA-fotografia" type="file" ><br>
                          </div>
                        <?php } ?>

													<!-- <div class="col-sm-12 col-md-6">
														<label class="control-label" for="">No. Evaluador</label>
                            <input class="form-control" id="numero_evaluador" name="EVALUADOR-numero_evaluador" placeholder="Número de evaluador" type="text" readonly >
                          </div> -->
                          <div class="col-sm-12 col-md-6">
                            <label class="control-label" for="">Tipo de evaluador *</label>
                            <input type="hidden" id="id_evaluador" name="EVALUADOR-id" >
                            <select class="form-control obligatorio" id="tipo_evaluador" campo="Tipo de evaluador" name="EVALUADOR-tipo_evaluador">
                              <option value="">Seleccione una opción</option>
                              <option value="1">Evaluador SIIGES</option>
                              <option value="2">Evaluador CIFRHS</option>
                            </select>
                          </div>
													<div class="col-sm-12 col-md-6">
                            <input type="hidden" name="PERSONA-id" value="<?=$_SESSION['persona_id']?>">
														<label class="control-label" for="">Nombre(s) *</label>
														<input class="form-control obligatorio" campo="Nombre" id="nombre"  name="PERSONA-nombre" placeholder="Ingrese su nombre" type="text" >
													</div>
													<div class="col-sm-12 col-md-6">
														<label class="control-label" for="">Apellido paterno *</label>
														<input class="form-control obligatorio" campo="Apellido paterno" id="apellido_paterno" name="PERSONA-apellido_paterno" placeholder="Ingrese su apellido paterno" type="text" >
													</div>
													<div class="col-sm-12 col-md-6">
														<label class="control-label" for="">Apellido materno *</label>
														<input class="form-control" id="apellido_materno" name="PERSONA-apellido_materno" placeholder="Ingrese su apellido materno" type="text" >
													</div>
													<div class="col-sm-12 col-md-6">
														<label class="control-label" for="">Teléfono </label>
														<input class="form-control" id="telefono" name="PERSONA-telefono" placeholder="(lada) + Número de teléfono" type="text" >
													</div>
													<div class="col-sm-12 col-md-6">
														<label class="control-label" for="">Teléfono móvil *</label>
														<input class="form-control obligatorio" campo="Telefóno móvil" id="celular" name="PERSONA-celular" placeholder="(lada) + Número de teléfono móvil" type="text" >
													</div>
                          <div class="col-sm-12 col-md-6">
                            <label class="control-label" for="">Especialidad *</label>
                            <input class="form-control obligatorio" campo="Especialidad" id="especialidad" name="EVALUADOR-especialidad"placeholder="Ingrese Especialidad" type="text" >
                          </div>

													<div class="col-sm-12 col-md-6">
														<label class="control-label" for="">Modalidad de evaluación *</label>
														<select class="form-control selectpicker obligatorio" campo="Modalidad de evaluación " id="modalidad" name="MODALIDADES-ids[]" multiple title="Seleccione una opción">
														</select><br>
													</div>
												</div>
											<!-- Registros de evaluación  -->
											<div class="form-group">
												<legend><br>Registros de procesos de evaluación y/o acreditación</legend>

												<div class="col-sm-12 col-md-6">
                          <input  id="rcea_id" name="RCEA[id]" placeholder="Número de su RCEA" type="hidden" >
													<label class="control-label" for="">Registro RCEA</label>
                          <input class="form-control" id="rcea" name="RCEA[descripcion]" placeholder="Número de su RCEA" type="text" >
                        </div>
												<div class="col-sm-12 col-md-6">
                          <input  id="ciies_id" name="CIIES[id]" placeholder="Número de su RCEA" type="hidden" >
													<label class="control-label" for="">Evaluador CIEES</label>
													<input class="form-control" id="ciies" name="CIIES[descripcion]" placeholder="Número de evaluador CIEES" type="text" >
												</div>
												<div class="col-sm-12 col-md-6">
                          <input  id="coepes_id" name="COEPES[id]" placeholder="Número de su RCEA" type="hidden" >
													<label class="control-label" for="">Evaluador COEPES</label>
													<input class="form-control" id="coepes" name="COEPES[descripcion]" placeholder="Número de evaluador COEPES" type="text" >
												</div>
												<div class="col-sm-12 col-md-6">
                          <input  id="conacyt_id" name="CONACYT[id]"  type="hidden" >
													<label class="control-label" for="">Evaluador CONACYT</label>
													<input class="form-control" id="conacyt" name="CONACYT[descripcion]" placeholder="Número de evaluador CONACYT" type="text" >
												</div>
												<div class="col-sm-12 col-md-12">
													<label class="control-label" for="">Otros</label>
													<textarea class="form-control" rows="8"  cols="80" id="otros_registros"  name="EVALUADOR-otros_registros"></textarea>
												</div>
											</div>
									</div>
								</div>
								<!-- Datos institucionales -->
								<div class="tab-pane" id="tab-02">
									<div class="col-sm-12 col-md-12">
											<div class="form-group col-sm-12">
                        <input type="hidden" id="institucional_id" name="INSTITUCIONAL-id" >
												<legend><br>Datos institucionales</legend>
												<div class="col-sm-12 col-md-6">
													<div class="col-sm-12 col-md-12">
														<label class="control-label" for="">Institución</label>
														<input class="form-control" id="institucion" name="INSTITUCIONAL-institucion" placeholder="Nombre de la Institución donde labora" type="text" >
													</div>
													<div class="col-sm-12 col-md-12">
														<label class="control-label" for="">Departamento</label>
														<input class="form-control" id="departamento" name="INSTITUCIONAL-departamento" placeholder="Nombre del Departamento de adscripción" type="text" >
													</div>
													<div class="col-sm-12 col-md-12">
														<label class="control-label" for="">Nombramiento</label>
														<input class="form-control" id="nombramiento" name="INSTITUCIONAL-nombramiento" placeholder="Nombramiento dentro del departamento" type="text" ><br>
													</div>
												</div>
												<div class="col-sm-12 col-md-6">
													<div class="col-sm-12 col-md-6">
														<label class="control-label" for="">PROMED</label>
                            <input type="hidden" id="promed_id" name="PERFILES[PROMED][id]" >
														<select id="promed" name="PERFILES[PROMED][aplica]" class="form-control" >
                              <option value="">Seleccione</option>
                              <option value="VIGENTE">Vigente</option>
															<option value="NO VIGENTE">No Vigente</option>
                              <option valu="NO CUENTA">No Cuenta</option>
														</select>
													</div>
													<div class="col-sm-12 col-md-6">
														<label class="control-label" for="">Vigencia</label>
														<input type="date" class="form-control " id="promed_fecha" name="PERFILES[PROMED][fecha]" value=""><br>
													</div>
													<div class="col-sm-12 col-md-12">
													</div>
													<div class="col-sm-12 col-md-6">
														<label class="control-label" for="">SNI</label>
                            <input type="hidden" id="sni_id" name="PERFILES[SNI][id]" >
														<select id="sni" class="form-control" name="PERFILES[SNI][aplica]" >
                              <option value="">Seleccione</option>
                              <option value="VIGENTE">Vigente</option>
															<option value="NO VIGENTE">No Vigente</option>
                              <option valu="NO CUENTA">No Cuenta</option>
														</select>
													</div>
													<div class="col-sm-12 col-md-6">
														<label class="control-label" for="">Vigencia</label>
														<input type="date" class="form-control" id="sni_fecha" name="PERFILES[SNI][fecha]">
													</div>
												</div>
											</div>

											<legend><br>Formación académica</legend>
                      <?php if ($_SESSION["rol_id"]=="5" || $_SESSION["rol_id"]=="6" ){?>

                      <!-- Insertar valores -->
                      <div class="form-group col-sm-12">
                        <div class="col-sm-12 col-md-3">
                          <label>Nivel*</label>
                          <select class="form-control" id="nivelCarrera">
                            <option value="">Seleccione</option>
                            <option value="2">Licenciatura</option>
                            <option value="3">Diplomado</option>
                            <option value="4">Especialidad</option>
                            <option value="5">Maestría</option>
                            <option value="6">Doctorado</option>
                          </select>
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <label>Nombre*</label>
                          <input class="form-control" type="text" id="nombreCarrera" placeholder="Nombre de la carrera cursada">
                        </div>
                        <div class="col-sm-12 col-md-3">
                          <label>Obtención de título*</label>
                          <input class="form-control" type="date" id="graduacionCarrera">
                          <br>
                        </div>
                        <div class="col-sm-4 col-md-4">
                          <button class="btn btn-secundary" type="button" name="button" onclick="Curriculum.agregarFormacion()">Agregar formación</button><br><br>
                        </div>
									    </div>
                    <?php } ?>
                      <!-- Tabla para mostrar las formaciones -->
                      <div class="form-group col-sm-12">
                        <div id="inputsFormaciones"></div>
                        <div id="mensajesFormaciones"></div>
                          <div class="table-responsive">
                            <table  class="table  table-bordered">
                              <thead>
                                <th class="size" scope="col">Nivel</th>
                                <th class="size" scope="col">Nombre de la formación</th>
                                <th class="size" scope="col">Obtención de grado</th>
                                <th class="size" scope="col">Acciones</th>

                              </thead>
                              <tbody id="formaciones">
                                <tr>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                      </div>
                  </div>
                </div>
								<!-- Trayectoria académica -->
								<div class="tab-pane" id="tab-03">
									<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<legend><br>Trayectoria académica y en procesos de evaluación de planes de programas de estudio<br><p class="small">Puestos académico-administrativos, comités institucionales y comisiones de evaluación</p></legend>
												<div class="col-sm-6">
                          <input type="hidden" id="trayectoria1-id" name="EXPERIENCIA[trayectoria][0][id]" >
													<input class="form-control" id="trayectoria1-nombre" name="EXPERIENCIA[trayectoria][0][nombre]" placeholder="Actividad o puesto" type="text" >
												</div>
												<div class="col-sm-6">
													<input class="form-control" id="trayectoria1-institucion" name="EXPERIENCIA[trayectoria][0][institucion]" placeholder="Institución" type="text" ><br>
												</div>
												<div class="col-sm-6">
                          <input type="hidden" id="trayectoria2-id" name="EXPERIENCIA[trayectoria][1][id]" >
                          <input class="form-control" id="trayectoria2-nombre" name="EXPERIENCIA[trayectoria][1][nombre]" placeholder="Actividad o puesto" type="text" >
												</div>
												<div class="col-sm-6">
													<input class="form-control" id="trayectoria2-institucion" name="EXPERIENCIA[trayectoria][1][institucion]"  placeholder="Institución" type="text" ><br>
												</div>
												<div class="col-sm-6">
                          <input type="hidden" id="trayectoria3-id" name="EXPERIENCIA[trayectoria][2][id]" >
													<input class="form-control" id="trayectoria3-nombre" name="EXPERIENCIA[trayectoria][2][nombre]" placeholder="Actividad o puesto" type="text" >
												</div>
												<div class="col-sm-6">
													<input class="form-control" id="trayectoria3-institucion" name="EXPERIENCIA[trayectoria][2][institucion]" placeholder="Institución" type="text" >
												</div>
											</div>
											<legend><br>Experiencia prifesional no docente (ordenar por el más reciente)</legend>
											<div class="form-group">
												<div class="col-sm-6">
                          <input type="hidden" id="experiencia1-id" name="EXPERIENCIA[profesional][0][id]" >
													<input class="form-control" id="experiencia1-nombre" name="EXPERIENCIA[profesional][0][nombre]" placeholder="Actividad o puesto" type="text" >
												</div>
												<div class="col-sm-6">
													<input class="form-control" id="experiencia1-institucion" name="EXPERIENCIA[profesional][0][institucion]" placeholder="Institución" type="text" ><br>
												</div>
												<div class="col-sm-6">
                          <input type="hidden" id="experiencia2-id" name="EXPERIENCIA[profesional][1][id]" >
													<input class="form-control" id="experiencia2-nombre" name="EXPERIENCIA[profesional][1][nombre]" placeholder="Actividad o puesto" type="text" >
												</div>
												<div class="col-sm-6">
													<input class="form-control" id="experiencia2-institucion" name="EXPERIENCIA[profesional][1][institucion]" placeholder="Institución" type="text" ><br>
												</div>
												<div class="col-sm-6">
                          <input type="hidden" id="experiencia3-id" name="EXPERIENCIA[profesional][2][id]" >
													<input class="form-control" id="experiencia3-nombre" name="EXPERIENCIA[profesional][2][nombre]" placeholder="Actividad o puesto" type="text" >
												</div>
												<div class="col-sm-6">
													<input class="form-control" id="experiencia3-institucion"  name="EXPERIENCIA[profesional][2][institucion]" placeholder="Institución" type="text" >
												</div>
											</div>
									</div>
								</div>
								<!-- Asociaciones profesionales -->
								<div class="tab-pane" id="tab-04">
									<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<legend><br>Pertenencia a asociaciones profesionales</legend>
												<div class="col-sm-6">
                          <input type="hidden" id="asociacion1-id" name="ASOCIACION[0][id]" >
													<input class="form-control" id="asociacion1-nombre" name="ASOCIACION[0][nombre]" placeholder="Nombre de la Asociación" type="text" >
												</div>
												<div class="col-sm-6">
													<input class="form-control" id="asociacion1-tipo_membresia" name="ASOCIACION[0][tipo_membresia]" placeholder="Membresía" type="text" ><br>
												</div>
                        <div class="col-sm-6">
                          <input type="hidden" id="asociacion2-id" name="ASOCIACION[1][id]" >
													<input class="form-control" id="asociacion2-nombre" name="ASOCIACION[1][nombre]" placeholder="Nombre de la Asociación" type="text" >
												</div>
												<div class="col-sm-6">
													<input class="form-control" id="asociacion2-tipo_membresia" name="ASOCIACION[1][tipo_membresia]" placeholder="Membresía" type="text" ><br>
												</div>
                        <div class="col-sm-6">
                          <input type="hidden" id="asociacion3-id" name="ASOCIACION[2][id]" >
													<input class="form-control" id="asociacion1-nombre" name="ASOCIACION[2][nombre]" placeholder="Nombre de la Asociación" type="text" >
												</div>
												<div class="col-sm-6">
													<input class="form-control" id="asociacion1-tipo_membresia" name="ASOCIACION[2][tipo_membresia]" placeholder="Membresía" type="text" ><br>
												</div>
											</div>
											<legend><br>Logros<br>
												<p class="small">(En caso que lo considere conveniente reseñe los logros académicos y/o profesionales más importantes destacando su participación en procesos de evaluación y/o acreditación)</p>
											</legend>
											<div class="form-group">
												<div class="col-md-12">
													<textarea class="col-sm-12 form-control" id="evaluador_logros" name="EVALUADOR-logros" rows="6" cols="80"  placeholder="Describa a detalle sus logros"></textarea>
												</div>
											</div>
										</form>
									</div>
								</div>
								<!-- Controles formulario  -->
								<?php if($_SESSION["rol_id"] == 5 || $_SESSION["rol_id"] == 6){ ?>
								<div class="col-sm-12 col-md-12">
                  <p class="small">* Campos obligatorios</p>
									<input type="hidden" id="webService" name="webService" value="guardarCurriculum" />
									<!-- Dependiendo puede variar -->
									<input type="hidden" id="url" name="url" value="../views/home.php" />
									<input type="hidden" id="id_usuario" value="<?=$_SESSION["id"]?>">
									<button type="button" name="" class="btn btn-primary pull-right" style="margin-right: 10px;" onclick="Curriculum.obligatorios()"> Guardar</button>
									<!-- Filtrar informacion a cargar  -->
									<input type="hidden" id="auxmodalidad" value="<?= $_GET["modalidad"] ?>">
								</div>
							<?php } ?>
							</div>
						</form>
					</div>
          <!-- Cargar datos  -->
          <?php if(isset($_GET["opcion"]) &&  $_GET["opcion"] == "2") {?>
            <input type="hidden" id="opcion" value="2">
            <input type="hidden" id="evaluador" value="<?=$_GET["evaluador"]?>">
          <?php }else{ ?>
          <input type="hidden" id="opcion" value="1">
          <input type="hidden" id="evaluador" value="<?=$_SESSION["id"]?>">
          <?php } ?>
        </div>
			</section>
      <!-- Modal para mensaje de errores -->
        <div class="modal fade" id="modalErrores"  tabindex="-1" role="dialog" aria-hidden="true">
          <div  id="tamanoModal" class="modal-dialog" >
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Error en llenado</h4>
              </div>
              <div class="modal-body">
                  <div id="mensajesError">

                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
            </div>

          </div>
        </div>
        <!-- Modal para confirmación -->
        <div class="modal fade" id="modalConfirmacion" role="dialog">
            <div id="tamanoModales" class="modal-dialog" >
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Confirmación</h4>
                </div>
                <div class="modal-body">
                    <div id="mensajesTerminar" class="alert alert-info">
                      <p class="text-justify">
                        Esta a punto de concluir el llenado de la solicitudes. Si usted lleno en su totalidad los campos solicitados de clic en "Concluir" para terminar la solicitud.
                      </p>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button  id="boton-terminar" type="button" class="btn btn-primary" onclick="Solicitud.terminar()">Concluir</button>
                </div>
              </div>
            </div>
          </div>
		</div>

		<!-- JS GOB.MX -->
		<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
		<!-- JS JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <!-- JS PROPIOS -->
    <script src="../js/funciones.js"></script>
    <script src="../js/curriculum.js"></script>

	</body>
</html>
