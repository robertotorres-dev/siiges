<?php

/**
 * Archivo que gestiona los web services de la clase Rol
 */

require_once "../models/modelo-rol.php";
require_once "../utilities/utileria-general.php";
require_once "../models/modelo-bitacora.php";

session_start();
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
  $obj = new Rol();
  $obj->setAttributes(array());
  $resultado = $obj->consultarTodos();
  $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
  // Registro en bitacora
  /* $bitacora = new Bitacora();
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"roles","accion"=>"consultarTodos","lugar"=>"control-rol"]);
    $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado, $usuarioId);
}

// Web service para consultar registro por id
if ($_POST["webService"] == "consultarId") {
  $obj = new Rol();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  $obj->setAttributes(array("id" => $_POST["id"]));
  $resultado = $obj->consultarId();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"roles","accion"=>"consultarId","lugar"=>"control-rol"]);
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
  $obj = new Rol();
  $obj->setAttributes($parametros);
  $resultado = $obj->guardar();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"roles","accion"=>"guardar","lugar"=>"control-rol"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}

// Web service para eliminar registro
if ($_POST["webService"] == "eliminar") {
  $obj = new Rol();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  $obj->setAttributes(array("id" => $_POST["id"]));
  $resultado = $obj->eliminar();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"roles","accion"=>"eliminar","lugar"=>"control-rol"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}
