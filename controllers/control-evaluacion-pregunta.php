<?php

/**
 * Archivo que gestiona los web services de la clase EvaluacionPregunta
 */

require_once "../models/modelo-evaluacion-pregunta.php";
require_once "../models/modelo-bitacora.php";
require_once "../utilities/utileria-general.php";
require_once "../models/modelo-solicitud.php";
require_once "../models/modelo-tipo-solicitud.php";
require_once "../models/modelo-programa.php";
require_once "../models/modelo-plantel.php";
require_once "../models/modelo-institucion.php";

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
  $obj = new EvaluacionPregunta();
  $obj->setAttributes(array());
  $resultado = $obj->consultarTodos();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluacion_preguntas","accion"=>"consultarTodos","lugar"=>"control-evaluacion-pregunta"]);
    $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}
// Web service para consultar registro por id
if ($_POST["webService"] == "consultarId") {
  $obj = new EvaluacionPregunta();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  $obj->setAttributes(array("id" => $_POST["id"]));
  $resultado = $obj->consultarId();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluacion_preguntas","accion"=>"consultarId","lugar"=>"control-evaluacion-pregunta"]);
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
  $obj = new EvaluacionPregunta();
  $obj->setAttributes($parametros);
  $resultado = $obj->guardar();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluacion_preguntas","accion"=>"guardar","lugar"=>"control-evaluacion-pregunta"]);
    $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}
// Web service para eliminar registro
if ($_POST["webService"] == "eliminar") {
  $obj = new EvaluacionPregunta();
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  $obj->setAttributes(array("id" => $_POST["id"]));
  $resultado = $obj->eliminar();
  // Registro en bitacora
  /* $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluacion_preguntas","accion"=>"eliminar","lugar"=>"control-evaluacion-pregunta"]);
    $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}
//Consultar preguntas para guia de evaluación recibe el id de la modalidad
if ($_POST["webService"] == "preguntasGuia") {
  $aux = new Utileria();
  $_POST = $aux->limpiarEntrada($_POST);
  //Obtener el programa por medio del id de la solicitud
  $programa = new EvaluacionPregunta();
  $res_programa = $programa->consultarPor("programas", array("solicitud_id" => $_POST["solicitud"]), array("id,nombre,modalidad_id,plantel_id"));
  if (sizeof($res_programa["data"]) > 0) {
    $programa = $res_programa["data"][0];
    //Obtener las evaluciones del programa
    $evaluacion = new EvaluacionPregunta();
    //$evaluaciones = $evaluacion->consultarPor("programa_evaluaciones",array("programa_id"=>$programa["id"],"estatus"=>1),"*");
    $evaluaciones = $evaluacion->consultarPor("programa_evaluaciones", array("programa_id" => $programa["id"]), "*");

    //Obtener la evalación actual (última)
    if (sizeof($evaluaciones["data"]) > 0) {
      $numero_evaluaciones = sizeof($evaluaciones["data"]);
      $ultima_evaluacion = $evaluaciones["data"][$numero_evaluaciones - 1];
      //Obtener las calificaciones para la guía
      $cumplimiento = new EvaluacionPregunta();
      $cumplimientos = $cumplimiento->consultarPor("cumplimientos", array("modalidad_id" => $programa["modalidad_id"]), "*");
      //Preguntas para la guía
      $obj = new EvaluacionPregunta();
      $resultado = $obj->informacionRelacionada($programa["modalidad_id"], $ultima_evaluacion["id"]);
      $resultado["cumplimientos"] = $cumplimientos["data"];
      //Resultado de la evaluación
      $resultado["evaluacion"] = $ultima_evaluacion;
      //Datos generales de la solicitud
      $solicitud = new Solicitud();
      $solicitud->setAttributes(array("id" => $_POST["solicitud"]));
      $res_solicitud = $solicitud->consultarId();
      $res_solicitud = $res_solicitud["data"];
      //Tipo de solicitud
      $tipo_solicitud = new TipoSolicitud();
      $tipo_solicitud->setAttributes(array("id" => $res_solicitud["tipo_solicitud_id"]));
      $res_tipo_solicitud = $tipo_solicitud->consultarId();
      $res_tipo_solicitud = $res_tipo_solicitud["data"];
      $resultado["datos_generales"]["tipo_tramite"] = $res_tipo_solicitud["nombre"];
      //Institución
      $plantel = new Plantel();
      $plantel->setAttributes(array("id" => $programa["plantel_id"]));
      $res_plantel = $plantel->consultarId();
      $res_plantel = $res_plantel["data"];
      $institucion = new Institucion();
      $institucion->setAttributes(array("id" => $res_plantel["institucion_id"]));
      $res_institucion = $institucion->consultarId();
      $res_institucion = $res_institucion["data"];
      $resultado["datos_generales"]["institucion"] =  $res_institucion["nombre"];
      //Programa
      $plan_estudios = new Programa();
      $plan_estudios->setAttributes(array("id" => $programa["id"]));
      $res_plan_estudios = $plan_estudios->informacionRelacionada(2);
      $res_plan_estudios = $res_plan_estudios["data"];
      $resultado["datos_generales"]["plan"] = $res_plan_estudios["nombre"];
      $resultado["datos_generales"]["nivel"] = $res_plan_estudios["nivel"]["descripcion"];
      $resultado["datos_generales"]["modalidad"] = $res_plan_estudios["modalidad"]["nombre"];
      $resultado["datos_generales"]["modalidad_id"] = $res_plan_estudios["modalidad"]["id"];
      $resultado["datos_generales"]["periodicidad"] = $res_plan_estudios["ciclo"]["nombre"];
      $resultado["datos_generales"]["coordinador"] = $res_plan_estudios["coordinador"]["nombre"] . " " . $res_plan_estudios["coordinador"]["apellido_paterno"] . " " . $res_plan_estudios["coordinador"]["apellido_materno"];
      $resultado["datos_generales"]["perfil_coordinador"] = $res_plan_estudios["coordinador"]["titulo_cargo"];
      $resultado["datos_generales"]["solicitud_id"] = $res_plan_estudios["solicitud_id"];
    }
  } else {
    $resultado = null;
  }
  // $preguntas = $resultado["preguntas"];
  // foreach ($preguntas as $posicion => $arreglo) {
  //     $categorias = $arreglo["categorias"];
  //     foreach ($categorias as $indice => $valores) {
  //         $reactivosCategoria = $valores["reactivos"];
  //         foreach ($reactivosCategoria as $key => $value) {
  //           var_dump($value["id"]);
  //           var_dump($value["nombre"]);
  //         }
  //     }
  //     exit();
  // }

  // Registro en bitacora
  /* $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluacion_preguntas","accion"=>"preguntasGuia","lugar"=>"control-evaluacion-pregunta"]);
    $result = $bitacora->guardar(); */
  retornarWebService($_POST["url"], $resultado);
}
