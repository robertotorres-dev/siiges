<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );

	//====================================================================================================

	require_once "../models/modelo-validacion.php";
  require_once "../models/modelo-programa.php";
	require_once "../models/modelo-alumno.php";
	require_once "../models/modelo-persona.php";
	require_once "../models/modelo-situacion.php";
	require_once "../models/modelo-institucion.php";
	require_once "../models/modelo-validacion.php";
	require_once "../models/modelo-situacion-validacion.php";

	$institucion = new Institucion( );
	$institucion->setAttributes( array( "usuario_id"=>	$_SESSION["id"] ) );
	$representante = new Institucion;
	$ce = $representante->consultarPor("usuario_usuarios",array("secundario_id"=>$_SESSION["id"]),"*");

	if(sizeof($ce["data"])>0)
	{
		$resultadoInstitucionIes = $institucion->consultarPor("instituciones", array("usuario_id"=>$ce["data"][0]["principal_id"]),"*");
	} else {
		$resultadoInstitucionIes = $institucion->consultarPor("instituciones", array("usuario_id"=>$_SESSION["id"]),"*");
	}

  /*$programa = new Programa( );
  $programa->setAttributes( array( "id"=>$_GET["programa_id"] ) );
  $resultadoPrograma = $programa->consultarId( );

  $plantel = new Plantel( );
  $plantel->setAttributes( array( "id"=>$resultadoPrograma["data"]["plantel_id"] ) );
  $resultadoPlantel = $plantel->consultarId();

  $institucion = new Institucion();
  $institucion->setAttributes( array( "id"=>$resultadoPlantel["data"]["institucion_id"] ) );
  $resultadoInstitucion = $institucion->consultarId();*/
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>Validación</title>
  	<!-- CSS GOB.MX -->
    <link href="../favicon.ico" rel="shortcut icon">
  	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
  	<!-- CSS DATATABLE -->
  	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  	<!-- CSS PROPIO -->
  	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
  </head>
  <body>
    <!-- HEADER Y BARRA DE NAVEGACION -->
    <?php
        require_once "menu.php";
    ?>
    <div class="container">
      <section class="main row margin-section-formularios">
        <div class="row" style="padding-left: 15px; padding-right: 15px;">
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
      				<li class="active">Validacion</li>
      			</ol>
          </div>
        </div>
        <div id="mesage">

        </div>
        <!-- CUERPO PRINCIPAL -->
        <div class=" form-group col-sm-12 col-md-12 col-lg-12">
          <!-- TÍTULO -->
          <div class="col-sm-12 col-md-12 col-lg-12">
            <input id="usuario_id" type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>" >
      			<div id="cargar-todos"></div>
      			<h2>Alumnos</h2>
      			<hr class="red">
						<div class="row">
		          <div class="col-sm-12">
								<legend><?php echo $resultadoInstitucionIes["data"][0]["nombre"]; ?></legend>
							</div>
						</div>
          </div>
          <!-- NOTIFICACIÓN -->
          <?php if( isset( $_GET["codigo"] ) && $_GET["codigo"]==200 ){ ?>
          <div class="alert alert-success">
            <p>Registro guardado.</p>
          </div>
          <?php } ?>
          <!-- Tabla de los usuarios-->
          <div class="col-sm-12 col-md-12 table respons">
            <table id="alumnos" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                <thead>
                <tr>
										<th>Matr&iacutecula</th>
                    <th style="width: 200px; overflow: auto;">Nombre</th>
                    <th>CURP</th>
                    <th>Programa</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                  <?php
    								$alumno = new Alumno( );
    								$alumno->setAttributes( array( ) );
    								$resultadoAlumno = $alumno->consultarTodos( );
										$max = count( $resultadoAlumno["data"] );

										$situacionValidacion = new SituacionValidacion( );
										$situacionValidacion->setAttributes( array( ) );
										$resultadoSituacionValidacion = $situacionValidacion->consultarTodos( );

    								for( $i=0; $i<$max; $i++ )
    								{

                      $parametros2["id"] = $resultadoAlumno["data"][$i]["persona_id"];

    									$persona = new Persona( );
    									$persona->setAttributes( $parametros2 );
    									$resultadoPersona = $persona->consultarId( );
											$parametros3["id"] = $resultadoAlumno["data"][$i]["situacion_id"];

											$programa = new Programa( );
										  $programa->setAttributes( array( "id"=>$resultadoAlumno["data"][$i]["programa_id"] ) );
										  $resultadoPrograma = $programa->consultarId( );

											$plantel = new Plantel( );
										  $plantel->setAttributes( array( "id"=>$resultadoPrograma["data"]["plantel_id"] ) );
										  $resultadoPlantel = $plantel->consultarId();

										  $institucion = new Institucion();
										  $institucion->setAttributes( array( "id"=>$resultadoPlantel["data"]["institucion_id"] ) );
										  $resultadoInstitucion = $institucion->consultarId();

											$validacion = new Validacion( );
											$res_validacion = $validacion->consultarPor('validaciones', array("alumno_id"=>$resultadoAlumno["data"][$i]["id"], "deleted_at"), '*' );

											// Consulta alumnos sólo de ésta institución
											if ($resultadoInstitucion["data"]["id"] === $resultadoInstitucionIes["data"][0]["id"]) {

    							?>
    							<tr>
										<td><?php echo $resultadoAlumno["data"][$i]["matricula"] ?></td>
    								<td><?php echo ($resultadoPersona["data"]["nombre"]." ".$resultadoPersona["data"]["apellido_paterno"]." ".$resultadoPersona["data"]["apellido_materno"]); ?></td>
    								<td><?php echo $resultadoPersona["data"]["curp"]; ?></td>
                    <td><?php echo $resultadoPrograma["data"]["nombre"]; ?></td>
                    <td><?php

										$maxSituacion = count( $resultadoSituacionValidacion["data"] );
										if (isset($res_validacion["data"][0]["situacion_validacion_id"])) {
											for( $j=0; $j<$maxSituacion; $j++ )
											{
												if( $resultadoSituacionValidacion["data"][$j]["id"]==$res_validacion["data"][0]["situacion_validacion_id"] )
												{
													echo $resultadoSituacionValidacion["data"][$j]["nombre"];
												}
											}
										} ?>
										</td>
    								<td>
											<a href="ce-validacion-alumno.php?programa_id=<?php echo $resultadoAlumno["data"][$i]["programa_id"]; ?>&alumno_id=<?php echo $resultadoAlumno["data"][$i]["id"]; ?>&proceso=consulta"><span id="" title="Abrir" class="glyphicon glyphicon-eye-open col-sm-1 size_icon"></span></a>
											<a href="ce-validacion-alumno.php?programa_id=<?php echo $resultadoAlumno["data"][$i]["programa_id"]; ?>&alumno_id=<?php echo $resultadoAlumno["data"][$i]["id"]; ?>&proceso=edicion"><span id="" title="Editar" class="glyphicon glyphicon-edit col-sm-1 size_icon"></span></a>
										</td>
    							</tr>
    							<?php
											}
    								}
    							?>
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
                      <h4 class="modal-title">¿Está seguro?</h4>
                  </div>
                  <div class="modal-body">
                      <p>Está apunto de borrar el usuario : <span id="modal-usuario"></span> ¿Está completamente seguro de eliminarlo? </p>
      						</div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button id="modal-eliminar" type="button" class="btn btn-danger" data-dismiss="modal">Eliminar</button>
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
		<script type="text/javascript">
			$(document).ready(function(){
				$("#alumnos").DataTable({
					"language":{
						"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
					}
				});
			});
		</script>
    <!-- JS PROPIOS -->
  </body>
</html>
