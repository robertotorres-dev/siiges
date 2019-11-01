<?php
  /**
  * Archivo que gestiona los web services de la clase ProgramaEvaluacion
  */

  require_once "../models/modelo-programa-evaluacion.php";
  require_once "../models/modelo-evaluaciones-preguntas.php";
  require_once "../utilities/utileria-general.php";
  require_once "../models/modelo-programa.php";
  require_once "../models/modelo-solicitud.php";
  require_once "../models/modelo-institucion.php";
  require_once "../models/modelo-solicitud-estatus.php";
  require_once "../models/modelo-bitacora.php";
  require_once "../models/modelo-usuario.php";

	function retornarWebService( $url, $resultado )
	{
    if( $url!="" )
		{
			header( "Location: $url" );
			exit( );
		}
		else
		{
			echo json_encode( $resultado );
			exit( );
		}
	}

	//====================================================================================================

  // Web service para consultar todos los registros
  if( $_POST["webService"]=="consultarTodos" )
  {
    $obj = new ProgramaEvaluacion( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programa_evaluaciones","accion"=>"consultarTodos","lugar"=>"control-programa-evaluacion"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new ProgramaEvaluacion();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programa_evaluaciones","accion"=>"consultarId","lugar"=>"control-programa-evaluacion"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para guardar registro
  if( $_POST["webService"]=="guardar" )
  {
    $parametros = array( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		foreach( $_POST as $atributo=>$valor )
		{
			$parametros[$atributo] = $valor;
		}
		$obj = new ProgramaEvaluacion( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programa_evaluaciones","accion"=>"guardar","lugar"=>"control-programa-evaluacion"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new ProgramaEvaluacion( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programa_evaluaciones","accion"=>"eliminar","lugar"=>"control-programa-evaluacion"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  //Web service para guardar avances
  if($_POST["webService"] == "guardarRevision" )
  {
      $resultado["status"] ="200";
      $resultado["message"] = "OK";
      $resultado["data"] = "";
      $aux = new Utileria( );
      $_POST = $aux->limpiarEntrada( $_POST );
      $programa = new ProgramaEvaluacion( );
      $res_programa = $programa->consultarPor("programas",array("solicitud_id"=>$_POST["solicitud_id"]),array("id,nombre,modalidad_id"));
      if( sizeof( $res_programa["data"] ) > 0 )
      {
        $resultado_pregunta = null;
        $programa = $res_programa["data"][0];
        //Guardar respuestas de la evluación
        foreach ($_POST["respuestas"] as $key => $value)
        {

          isset($value["idRespuesta"]) ? $id = $value["idRespuesta"] : $id=null;
          //Guarda solo en caso de que exista una respuesta
          if( $value["opcion"] != "" )
          {
            $respuesta = new EvaluacionesPreguntas();
            $respuesta->setAttributes(array("id"=>$id,"programa_evaluacion_id"=>$_POST["evaluacion_id"],"evaluacion_pregunta_id"=>$key,"escala_id"=>$value["escala_id"],"respuesta"=>$value["opcion"],"comentarios"=>$value["comentario"]));
            $resultado_pregunta = $respuesta->guardar();
          }
        }
        //Guardar los datos de la evalución
        if( $resultado_pregunta != null){
           $evaluacion = new ProgramaEvaluacion( );
           if($_POST["opcion_evaluacion"] == 2)
           {
             $fecha = date(Y)."/".date(m)."/".date(d);
             $evaluacion->setAttributes(array("id"=>$_POST["evaluacion_id"],"cumplimiento_id"=>$_POST["cumplimiento_id"],"cumplimiento"=>$_POST["porcentaje_resultado"],"valoracion"=>$_POST["resultado_valoracion"],"fecha"=>$fecha,"numero"=>$_POST["resultado_numero"],"estatus"=>2));
           }else
           {
             $evaluacion->setAttributes(array("id"=>$_POST["evaluacion_id"],"cumplimiento_id"=>$_POST["cumplimiento_id"],"cumplimiento"=>$_POST["porcentaje_resultado"],"valoracion"=>$_POST["resultado_valoracion"],"numero"=>$_POST["resultado_numero"]));
           }
           $respuesta_evaluacion =$evaluacion->guardar();
           //Actualizar estatus de solicitud
           if($_POST["opcion_evaluacion"] == 2 &&  $respuesta_evaluacion["data"]["id"]>0)
           {
             $actualizar_solicitud = new Solicitud();
             if($_POST["porcentaje_resultado"] == 70)
             {
                $actualizar_solicitud->setAttributes(array("id"=> $_POST["solicitud_id"],"estatus_solicitud_id"=>100));
                $estatus_solicitud_id = 100;
                $comentarios = "No cumplió con lo solicitado";
             }
             if($_POST["porcentaje_resultado"] == 80)
             {
                $actualizar_solicitud->setAttributes(array("id"=> $_POST["solicitud_id"],"estatus_solicitud_id"=>200));
                $estatus_solicitud_id = 200;
                $comentarios = "Necesita atender observaciones para que se realice otra evaluación";
             }
             if($_POST["porcentaje_resultado"] >= 90)
             {
                $actualizar_solicitud->setAttributes(array("id"=> $_POST["solicitud_id"],"estatus_solicitud_id"=>6));
                $estatus_solicitud_id = 6;
                $comentarios = "Cumplió con lo solicitado";

             }
             $actualizar_solicitud->guardar();

             $act_coment = new SolicitudEstatus();
             $res_act =  $act_coment->consultarPor("solicitudes_estatus_solicitudes",array("estatus_solicitud_id"=>5,"solicitud_id"=>$_POST["solicitud_id"]),"*");
             $tam = sizeof($res_act["data"]);
             $res_act = $res_act["data"][$tam-1];
             $msj =  $_POST["porcentaje_resultado"]."% de cumplimiento.";

             $coment = new SolicitudEstatus();
             $coment->setAttributes(array("id"=>$res_act["id"],"comentario"=>$msj));
             $coment->guardar();

             $actualizar_estatus_solicitudes = new SolicitudEstatus();
             $actualizar_estatus_solicitudes->setAttributes(array("estatus_solicitud_id"=>$estatus_solicitud_id,"solicitud_id"=>$_POST["solicitud_id"]));
             $actualizar_estatus_solicitudes->guardar();

             //Notificación apps
             $usuarioNotificar = new Solicitud();
             $usuarioNotificar->setAttributes(array("id"=>$_POST["solicitud_id"]));
             $resUsuarioNotificar = $usuarioNotificar->consultarId();
             $resUsuarioNotificar = $resUsuarioNotificar["data"];
             $notificacion = new Usuario();
             $msj = "Su programa de estudios obtuvo un " . $_POST["porcentaje_resultado"] .  "% en la evaluación técnico currilar";
             $notificacion->notificacionIdUsuario($resUsuarioNotificar["usuario_id"],"Evaluación técnico curricular",$msj);

           }

        }
      }else
      {
          $resultado["message"] = "ERROR";
          $resultado["data"] = "Error al guardar la guía";
      }
      // Registro en bitacora
        $bitacora = new Bitacora();
        $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
        $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programa_evaluaciones","accion"=>"guardarRevision","lugar"=>"control-programa-evaluacion"]);
        $result = $bitacora->guardar();
      	retornarWebService( $_POST["url"], $resultado );
  }

  //Web service para obtener los programas que tienen asiganados los evaluadores
  if( $_POST["webService"] == "evaluacionesProgramas" )
  {
    $resultado["status"] = "200";
    $resultado["message"] = "OK";
    $resultado["data"] = "";
    session_start();
    $tabla = "";
    if( $_SESSION["rol_id"] == 5 )
    {

      $registros = array();
      $evaluador = new ProgramaEvaluacion();
      $res_evaluador = $evaluador->consultarPor("evaluadores",array("persona_id"=>$_SESSION["persona_id"]),"*");
      $res_evaluador = $res_evaluador["data"];
      if( sizeof($res_evaluador)>0)
      {
        $res_evaluador =   $res_evaluador[0];
        $evaluacion = new ProgramaEvaluacion();
        $evaluaciones = $evaluacion->consultarPor("programa_evaluaciones",array("evaluador_id"=>$res_evaluador["id"]),"*");
        if( sizeof( $evaluaciones["data"] ) > 0 )
        {
          $evaluaciones = $evaluaciones["data"];
          foreach ($evaluaciones as $posicion => $campos) {
            $programa = new Programa();
            $programa->setAttributes(array("id"=>$campos["programa_id"]));
            $res_programa = $programa->informacionRelacionada(2);
            $institucion = new Institucion();
            $institucion->setAttributes(array("id"=>$res_programa["data"]["plantel"]["institucion_id"]));
            $res_institucion = $institucion->consultarId();
            $temp["id_solicitud"] = $res_programa["data"]["solicitud"]["id"];
            $temp["folio"] = $res_programa["data"]["solicitud"]["folio"];
            $temp["programa"] = $res_programa["data"]["nombre"];
            $temp["asignacion"] = $campos["created_at"];
            $temp["institucion"] = $res_institucion["data"]["nombre"];
            $temp["cumplimiento"] = $campos["cumplimiento"];
            $temp["estatus"] = $campos["estatus"];
            array_push($registros,$temp);
          }

          if( sizeof($registros) > 0 )
          {

            foreach ($registros as $indice => $valores) {
              $folio =  $valores["folio"];
              $planestudios = $valores["programa"];
              $institucion = $valores["institucion"];
              $cumplimiento = $valores["cumplimiento"] . "%";
              $alta =$valores["asignacion"];
              $estatus = ($valores["estatus"]==1)? "Asignada" : "Terminada";
              if( $valores["estatus"] == 1 )
              {
                $acciones =  "<a href='guia-evaluacion.php?solicitud=".$valores["id_solicitud"]."&opcion=1'><span class='glyphicon glyphicon-pencil'></span></a>";
              }else
              {
                $acciones =  "<a href='guia-evaluacion.php?solicitud=".$valores["id_solicitud"]."&opcion=2'><span class='glyphicon glyphicon-eye-open'></span></a>";
              }

              $tabla.='{
                    "folio":"'.$folio.'",
                    "planestudios":"'.$planestudios.'",
                    "institucion":"'.$institucion.'",
                    "alta":"'.$alta.'",
                    "estatus":"'.$estatus.'",
                    "acciones":"'.$acciones.'"
                  },';

            }
              $tabla = substr($tabla,0, strlen($tabla) - 1);
          }


        }
      }else {
        $resultado = array(
       "status"=>"204",
       "message"=>"No Content",
       "data"=> "" );
       // Registro en bitacora
         $bitacora = new Bitacora();
         $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
         $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programa_evaluaciones","accion"=>"evaluacionesProgramas","lugar"=>"control-programa-evaluacion"]);
         $result = $bitacora->guardar();
       retornarWebService( $_POST["url"], $resultado );
      }

    }
    echo '{"data":['.$tabla.']}';

    //retornarWebService( $_POST["url"], $resultado );

  }

  //Web service para asignar una evaluación
  if($_POST["webService"] == "asignarEvaluacion")
  {
    $parametros = array( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    foreach( $_POST as $atributo=>$valor )
    {
      $parametros[$atributo] = $valor;
    }

    $obj = new ProgramaEvaluacion( );
    $obj->setAttributes( $parametros );
    $res_guardar = $obj->guardar( );
    if($res_guardar["data"]["id"]!=0)
    {
      $consultarPrograma = new Programa();
      $datos_programa = $consultarPrograma->consultarPor("programas",array("id"=>$_POST["programa_id"]),"*");
      $datos_programa = $datos_programa["data"][0];
      $id_solicitud =  $datos_programa["solicitud_id"];


      $programa = new Programa();
      $programa->setAttributes(array("id"=>$_POST["programa_id"],"evaluador_id"=>$_POST["evaluador_id"],"minimo_horas_optativas"=>$datos_programa["minimo_horas_optativas"],"minimo_creditos_optativas"=>$datos_programa["minimo_creditos_optativas"],"metodos_induccion"=>$datos_programa["metodos_induccion"]));
      $res_programa = $programa->guardar();


      $solicitud = new Solicitud();
      $solicitud->setAttributes(array("id"=>$id_solicitud,"estatus_solicitud_id"=>5));
      $res_solicitud = $solicitud->guardar();

      $act_coment = new SolicitudEstatus();
      $res_act = $act_coment->consultarPor("solicitudes_estatus_solicitudes",array("estatus_solicitud_id"=>4,"solicitud_id"=>$id_solicitud),"*");
      $res_act = $res_act["data"][0];
      $msj = "Asignación evaluación " . date("Y-m-d");
      $coment = new SolicitudEstatus();
      $coment->setAttributes(array("id"=>$res_act["id"],"comentario"=>$msj));
      $coment->guardar();


      $avanceSolicitud = new SolicitudEstatus();
      $avanceSolicitud->setAttributes(array("estatus_solicitud_id"=>5,"solicitud_id"=>$id_solicitud));
      $resultado = $avanceSolicitud->guardar();

      //Notificación apps
      $usuarioNotificar = new Solicitud();
      $usuarioNotificar->setAttributes(array("id"=>$id_solicitud));
      $resUsuarioNotificar = $usuarioNotificar->consultarId();
      $resUsuarioNotificar = $resUsuarioNotificar["data"];
      $notificacion = new Usuario();
      $msj = "Su programa de estudios: ".$datos_programa["nombre"] ." será sometido a evaluación técnico currilar";
      $notificacion->notificacionIdUsuario($resUsuarioNotificar["usuario_id"],"Evaluación técnico curricular",$msj);

      // Registro en bitacora
        $bitacora = new Bitacora();
        $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
        $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programa_evaluaciones","accion"=>"asignarEvaluacion","lugar"=>"control-programa-evaluacion"]);
        $result = $bitacora->guardar();
      retornarWebService( $_POST["url"], $resultado );
    }
  }
?>
