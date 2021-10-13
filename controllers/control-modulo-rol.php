<?php

/**
 * Archivo que gestiona los web services de la clase ModuloRol
 */

require_once "../models/modelo-modulo-rol.php";
require_once "../models/modelo-modulo.php";
require_once "../models/modelo-rol.php";
require_once "../utilities/utileria-general.php";
require_once "../models/modelo-bitacora.php";
session_start();


function retornarWebService($url, $resultado)
{
  if ($url != "") {
    //session_start( );
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
  $obj = new ModuloRol();
  $obj->setAttributes(array());
  $resultado = $obj->consultarTodos();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"modulos_roles","accion"=>"consultarTodos","lugar"=>"control-modulo-rol"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}

// Web service para consultar registro por id
if ($_POST["webService"] == "consultarId") {
  $obj = new ModuloRol();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  $obj->setAttributes(array("id" => $_POST["id"]));
  $resultado = $obj->consultarId();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"modulos_roles","accion"=>"consultarId","lugar"=>"control-modulo-rol"]);
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

  $mensaje = "";
  $status = "";
  $mr = new ModuloRol();
  $resultadoMR = $mr->consultarPor("modulos_roles", ["modulo_id" => $parametros["modulo_id"], "rol_id" => $parametros["rol_id"], "accion" => $parametros["accion"], "deleted_at" => null], "*");
  $libre = empty($resultadoMR["data"]);

  $resultado = [];
  if ($libre) {
    $obj = new ModuloRol();
    $obj->setAttributes($parametros);
    $resultado = $obj->guardar();
    $mensaje = isset($resultado["data"]["id"]) ? "Guardado exitoso!" : "Error al guardar";
    $status = isset($resultado["data"]["id"]) ? "200" : "400";
  } else {
    $mensaje = "Registro ya existe, intente de nuevo";
    $status = "302";
  }

  $resultado["message"] = $mensaje;
  $resultado["status"] = $status;

  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"modulos_roles","accion"=>"guardar","lugar"=>"control-modulo-rol"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}

// Web service para eliminar registro
if ($_POST["webService"] == "eliminar") {
  $obj = new ModuloRol();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  $obj->setAttributes(array("id" => $_POST["id"]));
  $resultado = $obj->eliminar();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"modulos_roles","accion"=>"eliminar","lugar"=>"control-modulo-rol"]);
      $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}
//Web service para obtener la tabla de todos lo modulos-roles
if ($_POST["webService"] == "consultarTodosTabla") {
  //session_start( );
  if (!Rol::ROL_ADMIN == $_SESSION["rol_id"]) {
    echo '{"data":[]}';
    exit();
  }
  $modulosRoles = new ModuloRol();
  $modulosRoles = $modulosRoles->consultarTodos();

  $tabla = "";

  foreach ($modulosRoles["data"] as $moduloR) {
    $id = $moduloR["id"];
    $moduloId = $moduloR["modulo_id"];
    $rolId = $moduloR["rol_id"];
    $accion = ModuloRol::$acciones[$moduloR["accion"]];

    $m = new Modulo();
    $r = new Rol();

    $m->setAttributes(["id" => $moduloId]);
    $r->setAttributes(["id" => $rolId]);

    $m = $m->consultarId();
    $r = $r->consultarId();

    $mNombre = isset($m["data"]["descripcion"]) ? $m["data"]["descripcion"] : "";
    $rNombre = isset($r["data"]["descripcion"]) ? $r["data"]["descripcion"] : "";

    $espacio = "&nbsp;&nbsp;&nbsp;";
    $editar = "<a href='alta-modulos-roles.php?id=" . $id . "'><span class='glyphicon glyphicon-pencil'></span></a>";

    $eliminarDatos = ["id" => $id, "modulo" => $mNombre, "rol" => $rNombre, "accion" => $accion];
    $eliminar = "<a href='#' onclick='ModuloRol.datosModal(" . htmlentities(json_encode($eliminarDatos)) . ")'><span class='glyphicon glyphicon-trash'></span></a>";

    $tabla .= '{
        "rol":"' . $rNombre . '",
        "modulo":"' . $mNombre . '",
        "accion":"' . $accion . '",
        "acciones":"' . $editar . $espacio . $eliminar . '"
      },';
  }

  // Registro en bitacora
  /* $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"modulos_roles","accion"=>"consultarTodosTabla","lugar"=>"control-modulo-rol"]);
      $result = $bitacora->guardar(); */
  $tabla = substr($tabla, 0, strlen($tabla) - 1);
  echo '{"data":[' . $tabla . ']}';
}
