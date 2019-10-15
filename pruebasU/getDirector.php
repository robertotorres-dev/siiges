<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";

	Utileria::validarSesion( basename( __FILE__ ) );
	//====================================================================================================
	$resultado = "";
	if(isset($_SESSION["resultado"])){
	  $resultado = json_decode($_SESSION["resultado"]);
	  unset($_SESSION["resultado"]);
	}
	if($_SESSION["rol_id"] < 7 && $_SESSION["rol_id"] != 2){
		header( "Location: home.php?error=1" );
		exit( );
	}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
<form id="solicitudes" class="form-horizontal" action="../controllers/control-solicitud.php" enctype="multipart/form-data" method="post">
  <input id="usuario_id" type="hidden"  value="<?=$_SESSION["id"]?>">
  <input type="hidden"  id="rol_id" value="<?=$_SESSION["rol_id"]?>">
  <input type="hidden" id="opcion" value="1">
  <input type="hidden" id="webService" name="webService" value="solicitudes" />
  <button type="submit" name="" class="btn btn-default pull-right" style="margin-right: 10px;"> Guardar solicitud</button>


</form>

  </body>
</html>
