<?php
// Valida los permisos del usuario de la sesión

require_once "../utilities/utileria-general.php";
require_once "../Classes/PHPExcel/IOFactory.php";
$nombreArchivo = "../Classes/evaluacion_preguntas.xlsx";

$objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
$objPHPExcel->setActiveSheetIndex(0);
$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

Utileria :: validarSesion( basename(__FILE__));
/*Utileria :: validarAccesoModulo( basename(__FILE__));

$resultado = "";
if(isset($_SESSION["resultado"])){
    $resultado = json_decode($_SESSION["resultado"]);
    unset($_SESSION["resultado"]);
}

if(isset($resultado->status) && $resultado->status != "200"){
    $_SESSION["resultado"] = json_encode($resultado);
    header("Location: edicion-usuarios.php");
}*/

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preguntas</title>
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
              <li><?php echo $_SESSION["nombre_rol"];?></li>
              <li class="active"><?php echo $_SESSION["nombre"]. " ".$_SESSION["apellido_paterno"]. " " .$_SESSION["apellido_materno"]; ?></li>
            </ol>
            <ol class="breadcrumb">
              <li><a href="home.php"><i class="icon icon-home"></i></a></li>
              <li><a href="home.php">SIIGES</a></li>
              <li class="active">Usuarios</li>
            </ol>
          </div>
        </div>

        <!-- CUERPO PRINCIPAL -->
        <div class=" form-group col-sm-12 col-md-12 col-lg-12">
          <!-- TITULO -->
          <div class="col-sm-12 col-md-12 col-lg-12">
            <input id="usuario_id" type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
            <div id="cargar-todos"></div>
            <h2>Preguntas de evaluación</h2>
            <hr class="red">
          </div>

          <!-- Tabla de preguntas -->
          <form name="formPreguntas" method="post" action="../controllers/control-preguntas.php">
            <!-- Agregar separacion entre tabla y boton-->
            <br><br><br>
            <div class="col-sm-12 col-md-12 table respons">
              <table id="tabla-reporte" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 10px; overflow: auto;">id</th>
                    <th style="width: 20px; overflow: auto;">Categ</th>
                    <th style="width: 20px; overflow: auto;">Apart</th>
                    <th style="width: 20px; overflow: auto;">Mod</th>
                    <th style="width: 20px; overflow: auto;">Escala</th>
                    <th style="width: 500px; overflow: auto;">Descripción pregunta</th>
                    <th style="width: 130px; overflow: auto;">Evidencia</th>
                    <th>Creat</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                for ($i=2; $i <= $numRows ; $i++) {
                  $id = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                  $categoria = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                  $apartado= $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                  $modalidad = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                  $escala = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                  $descripcion = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
                  $item = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                  $evidencia = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                  $created = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
                  //$fechaCreated = date("d-m-Y",$created);
                  $updated = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
                  $deleted = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
                  echo '<tr>';
                  echo '<td>';
                  echo $id = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                  echo '</td>';
                  echo '<td>'.$categoria.'</td>';
                  echo '<td>'.$apartado.'</td>';
                  echo '<td>'.$modalidad.'</td>';
                  echo '<td>'.$escala.'</td>';
                  echo '<td>'.$descripcion.'</td>';
                  echo '<td>'.$evidencia.'</td>';
                  echo '<td>'.$created.'</td>';
                  echo '</tr>';
                  }?>
                  </tbody>
                </table>
              </div>
              <div class="col-md-8 col-md-offset-4">
                <input type="hidden"  name="webService" value="guardar" />
                <input type="submit" id="submit" name="submit" value="&nbsp;&nbsp;Dar de alta preguntas" class="btn btn-primary pull-right menu" />
                <input type="hidden" id="url" name="url" value="../views/home.php">
                <?php

                for ($j=2; $j <= $numRows ; $j++) {
                $id = $objPHPExcel->getActiveSheet()->getCell('A'.$j)->getCalculatedValue();
                $categoria = $objPHPExcel->getActiveSheet()->getCell('B'.$j)->getCalculatedValue();
                $apartado= $objPHPExcel->getActiveSheet()->getCell('C'.$j)->getCalculatedValue();
                $modalidad = $objPHPExcel->getActiveSheet()->getCell('D'.$j)->getCalculatedValue();
                $escala = $objPHPExcel->getActiveSheet()->getCell('E'.$j)->getCalculatedValue();
                $descripcion = $objPHPExcel->getActiveSheet()->getCell('F'.$j)->getCalculatedValue();
                $item = $objPHPExcel->getActiveSheet()->getCell('G'.$j)->getCalculatedValue();
                $evidencia = $objPHPExcel->getActiveSheet()->getCell('H'.$j)->getCalculatedValue();

                ?>
              <input type="hidden" name="id[]" value="<?php echo $id;?>">
              <input type="hidden" name="categoria_evaluacion_pregunta_id[]" value="<?php echo $categoria;?>">
              <input type="hidden" name="evaluacion_apartado_id[]" value="<?php echo $apartado;?>">
              <input type="hidden" name="modalidad_id[]" value="<?php echo $modalidad;?>">
              <input type="hidden" name="escala_id[]" value="<?php echo $escala;?>">
              <input type="hidden" name="nombre[]" value="<?php echo $descripcion;?>">
              <input type="hidden" name="item[]" value="<?php echo $item;?>">
              <input type="hidden" name="evidencia[]" value="<?php echo $evidencia;?>">

              <?php } ?>

              <!--<input type="hidden" name="preguntas[]" value="{'id':,'categoria_evaluacion_pregunta_id':'2','evaluacion_apartado_id':'1','modalidad_id':'1','escala_id':'1','modalidad_id':'1','nombre':'TÍtulo','item':'1','evidencia':'sdf'}">-->
              <!--<input type="hidden" name="preguntas[]" value='{"id":,"categoria_evaluacion_pregunta_id":"3","evaluacion_apartado_id":"1","modalidad_id":"1","escala_id":"1","modalidad_id":"1","nombre":"Cedula","item":"1","evidencia":"sdf"}'>-->


            </div>
          </form>
        </div>
      </section>
    </div>


  </body>

  <!-- JS GOB.MX -->
  <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
  <!-- JS JQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <!-- JS PROPIOS -->
  <script type="text/javascript">
	$(document).ready(function(){
		$("#tabla-reporte").DataTable({
			"language":{
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			}
		});
	});
</script>
</html>
