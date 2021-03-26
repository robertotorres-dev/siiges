<?php
// Valida los permisos del usuario de la sesión

require_once "../utilities/utileria-general.php";

Utileria :: validarSesion( basename(__FILE__));
//Utileria :: validarAccesoModulo( basename(__FILE__));

$resultado = "";
if(isset($_SESSION["resultado"])){
    $resultado = json_decode($_SESSION["resultado"]);
    unset($_SESSION["resultado"]);
}

if(isset($resultado->status) && $resultado->status != "200"){
    $_SESSION["resultado"] = json_encode($resultado);
    header("Location: home.php");
}

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
              <li class="active">Titulci&oacute;n Electr&oacute;nica</li>
            </ol>
          </div>
        </div>

        <!-- CUERPO PRINCIPAL -->
        <form name="formPreguntas" method="post" action="../controllers/control-preguntas.php">
          <div class="col-sm-12 col-md-12 col-lg-12">
            <!-- TITULO -->
            <input id="usuario_id" type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
            <div id="cargar-todos"></div>
            <h2>Titulci&oacute;n Electr&oacute;nica</h2>
            <hr class="red">
            <!-- TÍTULO -->
            <div class="row">
              <div class="col-sm-12">
                <legend><?php echo "Nombre" ?></legend>
              </div>
				    </div>
            <!-- NOTIFICACIÓN -->
            <?php if( isset( $_GET["codigo"] ) && $_GET["codigo"]==200 ){ ?>
            <div class="alert alert-success">
              <p>Registro guardado.</p>
            </div>
            <?php } ?>
            <?php if( isset( $_GET["codigo"] ) && $_GET["codigo"]==404 ){ ?>
            <div class="alert alert-danger">
              <p>Error en el archivo adjunto.</p>
            </div>
            <?php } ?>
            <!-- CONTENIDO -->
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="id">Id</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-8">
                <div class="form-group">
                  <label class="control-label" for="archivo_curp">Archivo CURP (PDF)</label>
                  <input type="file" id="archivo_curp" name="archivo_curp" accept="application/pdf" class="form-control" />
                  <div>
                    <a href="../uploads/certificados/<?php ?>" target="_blank"><?php ?></a>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="estatus_curp">Acreditaci&oacute;n CURP</label>
                  <input type="checkbox" id="estatus_curp" name="estatus_curp" value="1" class="form-control" <?php ?> />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4">
                <input type="hidden"  name="webService" value="guardar" />
                <input type="submit" id="submit" name="submit" value="&nbsp;&nbsp;Dar de alta preguntas" class="btn btn-primary pull-right menu" />
                <input type="hidden" id="url" name="url" value="../views/home.php" />
              </div>
            </div>
          </div>
        </form>
      </section>
    </div>


  </body>

  <!-- JS GOB.MX -->
  <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
  <!-- JS JQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <!-- JS PROPIOS -->
</html>
