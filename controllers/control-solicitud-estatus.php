<?php

/**
 * Archivo que gestiona los web services de la clase SolicitudEstatus
 */

require_once "../models/modelo-solicitud-estatus.php";
require_once "../utilities/utileria-general.php";
require_once "../models/modelo-bitacora.php";


function retornarWebService($url, $resultado)
{
  if ($url != "") {
    header("Location: $url");
    exit();
  } else {
    echo json_encode($resultado);
    exit();
  }
}

//====================================================================================================

// Web service para consultar todos los registros
if ($_POST["webService"] == "consultarTodos") {
  $obj = new SolicitudEstatus();
  $obj->setAttributes(array());
  $resultado = $obj->consultarTodos();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"solicitudes_estatus_solicitudes","accion"=>"consultarTodos","lugar"=>"control-solicitud-estatus"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}

// Web service para consultar registro por id
if ($_POST["webService"] == "consultarId") {
  $obj = new SolicitudEstatus();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  $obj->setAttributes(array("id" => $_POST["id"]));
  $resultado = $obj->consultarId();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"solicitudes_estatus_solicitudes","accion"=>"consultarId","lugar"=>"control-solicitud-estatus"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}

// Web service para consultar registro por id
if ($_POST["webService"] == "consultarEstatusSolicitud") {
  $obj = new SolicitudEstatus();
  $aux = new Utileria();

  //print_r($_POST);

  $resultado = $obj->consultarPor("solicitudes_estatus_solicitudes", array("solicitud_id" => $_POST['solicitud_id'], "deleted_at" => ""), "*");

  // Registro en bitacora
  /*$bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"solicitudes_estatus_solicitudes","accion"=>"consultarId","lugar"=>"control-solicitud-estatus"]);
      $result = $bitacora->guardar();*/
  retornarWebService($_POST["url"], $resultado);
}


// Web service para guardar registro
if ($_POST["webService"] == "guardar") {
  $parametros = array();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  foreach ($_POST as $atributo => $valor) {
    $parametros[$atributo] = $valor;
  }
  $obj = new SolicitudEstatus();
  $obj->setAttributes($parametros);
  $resultado = $obj->guardar();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"solicitudes_estatus_solicitudes","accion"=>"guardar","lugar"=>"control-solicitud-estatus"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}

// Web service para eliminar registro
if ($_POST["webService"] == "eliminar") {
  $obj = new SolicitudEstatus();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  $obj->setAttributes(array("id" => $_POST["id"]));
  $resultado = $obj->eliminar();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"solicitudes_estatus_solicitudes","accion"=>"eliminar","lugar"=>"control-solicitud-estatus"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}

//Obtener todos estatus de las solicitudes por id
if ($_POST["webService"] == "estatus") {
  $obj = new SolicitudEstatus();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  $res = $obj->consultarPor("solicitudes_estatus_solicitudes", array("solicitud_id" => $_POST["id"]), "*");
  if (sizeof($res["data"]) > 0) {
    $resultado = $res["data"];
  } else {
    $resultado = "";
  }

  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"solicitudes_estatus_solicitudes","accion"=>"estatus","lugar"=>"control-solicitud-estatus"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}
