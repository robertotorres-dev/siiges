<?php

/**
 * Archivo que gestiona los web services de la clase Inspeccion
 */
require_once "../models/modelo-oficio.php";
require_once "../utilities/utileria-general.php";
require_once "../models/modelo-bitacora.php";



function retornarWebService($url, $resultado)
{
  if ($url != "") {
    session_start();
    $_SESSION["resultado"] = json_encode($resultado);
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
  $obj = new Oficio();
  $obj->setAttributes(array());
  $resultado = $obj->consultarTodos();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"oficios","accion"=>"consultarTodos","lugar"=>"control-oficio"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}

// Web service para consultar registro por id
if ($_POST["webService"] == "consultarId") {
  $obj = new Oficio();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  $obj->setAttributes(array("id" => $_POST["id"]));
  $resultado = $obj->consultarId();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"oficios","accion"=>"consultarId","lugar"=>"control-oficio"]);
      $result = $bitacora->guardar(); */
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
  $obj = new Oficio();
  $obj->setAttributes($parametros);
  $resultado = $obj->guardar();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"oficios","accion"=>"guardar","lugar"=>"control-oficio"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}

// Web service para eliminar registro
if ($_POST["webService"] == "eliminar") {
  $obj = new Oficio();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  $obj->setAttributes(array("id" => $_POST["id"]));
  $resultado = $obj->eliminar();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"oficios","accion"=>"eliminar","lugar"=>"control-oficio"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}
// Web service para consultar oficio por solicitud id y nombre del documento
if ($_POST["webService"] == "consultarOficio") {
  $oficio = new Oficio();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);

  $oficio = $oficio->consultarPor("oficios", array("solicitud_id" => $_POST["solicitud_id"], "documento" => $_POST["documento"], "deleted_at"), "*");
  $resultado = !empty($oficio["data"][0]) ? $oficio["data"][0] : false;

  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"oficios","accion"=>"consultarOficio","lugar"=>"control-oficio"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}
