<?php
// Válida los permisos del usuario de la sesión
require_once "../utilities/utileria-general.php";
require_once "../models/modelo-institucion.php";
require_once "../models/modelo-titulo-electronico.php";

Utileria::validarSesion( basename( __FILE__ ) );
Utileria::validarAccesoModulo( basename( __FILE__ ) );

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
  	<title>Cat&aacute;logo T&iacute;tulo Electr&oacute;nico</title>
  	<!-- CSS GOB.MX -->
	<link href="../favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<!-- CSS DATATABLE -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
	<!-- CSS LIVESELECT -->
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-select.min.css">
	<!-- CSS CALENDAR -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
      				<li class="active">Cat&aacute;logo T&iacute;tulo Electr&oacute;nico</li>
      			</ol>
          </div>
        </div>
        <div id="mesage">
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
        </div>
        <!-- CUERPO PRINCIPAL -->
        <div class=" form-group col-sm-12 col-md-12 col-lg-12">
          <!-- TÍTULO -->
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
              <div id="cargar-todos"></div>
              <h2>Cat&aacute;logo T&iacute;tulo Electr&oacute;nico</h2>
              <hr class="red">
            </div>
          </div>
          <div class="row">
            <div class="col-md-8 col-md-offset-4">
              <a id="cargarXML" class="btn btn-primary pull-right menu">&nbsp;&nbsp;Cargar XML</a>
              <br><br><br>
            </div>
          </div>

          <!-- Agregar separacion entre tabla y boton de nuevo usuario-->
          <div class="col-md-8 col-md-offset-2"></div>
          <!-- Tabla de registros-->
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <pre class="hidden" id="xml_data"></pre>
            </div>
          </div>
          <div class="col-sm-12 col-md-12 table respons">
            <table id="usuarios" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                <thead>
                <tr>
                    <th width="30%">Nombre</th>
                    <th width="30%">Instituci&oacute;n</th>
                    <th width="10%">Folio de Control</th>
                    <th width="10%">CURP</th>
                    <th width="10%">Fecha de expedici&oacute;n</th>
                    <th width="10%">Acciones</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $titulo = new TitulosElectronicos( );
                  $titulo->setAttributes( array( ) );
                  $resultadoTitulo = $titulo->consultarTodos( );

                  $max = count( $resultadoTitulo["data"] );

                  for( $i=0; $i<$max; $i++ )
                  {
                    $institucion = new Institucion();
                    $institucion->setAttributes( array( "id"=>$resultadoTitulo["data"][$i]["institucion_id"] ) );
                    $res_institucion = $institucion->consultarId( );
                  ?>
                  <tr>
                    <td><?php echo $resultadoTitulo["data"][$i]["primer_apellido"]." ".$resultadoTitulo["data"][$i]["segundo_apellido"]." ".$resultadoTitulo["data"][$i]["nombre"]; ?></td>
                    <td><?php echo $res_institucion["data"]["nombre"]; ?></td>
                    <td><?php echo $resultadoTitulo["data"][$i]["folio_control"]; ?></td>
                    <td><?php echo $resultadoTitulo["data"][$i]["curp"]; ?></td>
                    <td><?php echo $resultadoTitulo["data"][$i]["fecha_expedicion"]; ?></td>
                    <td>
						            <a href= <?= "formatos/fdtitulo.php?id=".$resultadoTitulo["data"][$i]["folio_control"] ?> target="_blank"><span id="" title="PDF" class="glyphicon glyphicon-print col-sm-1 size_icon"></span></a>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
            </table>
          </div>
        </div>
      </section>
      <!-- Modal eliminar-->
      <form method="post" name="xmlForm" id="xmlForm" enctype="multipart/form-data">
      <div id="modalXML" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Carga de XML</h4>
                  </div>
                  <div class="modal-body">
                      <p>Adjunta el archivo XML para generar el archivo PDF correspondiente  </p>
                      <label class="control-label" for="archivo-xml">Cargar archivo XML</label>
                      <input class="form-control" type="file" id="archivo-xml" name="archivo-xml">
                      <br>
                      <label class="control-label" for="institucion" required>Instituci&oacute;n de origen* </label>
                      <select id="institucion_id" name="institucion_id" class="selectpicker" data-live-search="true" data-width="100%" required>
                        <option value=""> </option>
                        <?php
                          $institucion = new Institucion( );
                          $institucion->setAttributes( array( ) );
                          $resultadoInstitucion = $institucion->consultarTodos( );

                          $max = count( $resultadoInstitucion["data"] );

                          for( $i=0; $i<$max; $i++ )
                          {
                            echo "<option value='".$resultadoInstitucion["data"][$i]["id"]."'>".$resultadoInstitucion["data"][$i]["nombre"]."</option>";
                          }
                        ?>
                      </select>
                      <input type="hidden"  name="url" value="../views/ce-catalogo-titulo-electronico.php"/>
                      <input type="hidden"  name="webService" value="guardar" />
      						</div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button id="generar-pdf" type="submit" class="btn btn-primary" data-dismiss="modal">Generar PDF</button>
                  </div>
              </div>
          </div>
      </div>
      </form>
    </div>
    <!-- JS GOB.MX -->
    <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
    <!-- JS JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- JS DATATABLE -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <!-- JS LIVESELECT -->
    <script src="../js/bootstrap-select.min.js"></script>
    <!-- JS CALENDAR -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- JS PROPIOS -->
    <script src="../js/tituloElectronico.js"></script>
  </body>
</html>
