<?php
  /**
  * Archivo que gestiona los web services de la clase Documento
  */

  require_once "../models/modelo-documento.php";
  require_once "../models/modelo-bitacora.php";
  require_once "../utilities/utileria-general.php";
  require_once "../models/modelo-programa.php";

  session_start( );
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
    $obj = new Documento( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
	   // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"documentos","accion"=>"consultarTodos","lugar"=>"control-documento"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Documento();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
	   // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"documentos","accion"=>"consultarId","lugar"=>"control-documento"]);
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
    $obj = new Documento( );
    print_r($parametros);
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
	   // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"documentos","accion"=>"guardar","lugar"=>"control-documento"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Documento( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
	   // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"documentos","accion"=>"eliminar","lugar"=>"control-documento"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para obtener formatos
  if( $_POST["webService"]=="consultarFormato" )
  {
    $parametros = array( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );

    $documento = new Documento( );
    $programa = $documento->consultarPor('programas', array("solicitud_id"=>$_POST['solicitud_id']), '*' );

    $programa = (isset($programa["data"][0]) && !empty($programa["data"][0]))?$programa["data"][0]:false;
    if(!$programa){
      $resultado = ["status"=>"404","message"=>"Programa de la solicitud ".$_POST['solicitud_id']." no encontrado","data"=>[]];
    }else{
      $documento = new Documento( );
      $documento = $documento->consultarPor('documentos', array("tipo_entidad"=>$_POST['tipo_entidad'],"entidad_id"=>$programa["id"],"tipo_documento"=>$_POST['tipo_documento']), '*' );

      $resultado = (isset($documento["data"][0]) && !empty($documento["data"][0]))?$documento["data"][0]:false;
      if(!$resultado){
        $resultado = ["status"=>"404","message"=>"Formato no encontrado","data"=>[]];
      }else{
        $resultado = ["status"=>"200","message"=>"OK","data"=>$resultado];
      }
    }

    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"documentos","accion"=>"consultarFormato","lugar"=>"control-documento"]);
    $result = $bitacora->guardar();

    retornarWebService( $_POST["url"], $resultado );
  }

  //Web service para obtener documentos para evaluaciones requiere id solicitud
  if( $_POST["webService"]=="documentosGuiaEvaluacion")
  {
    $parametros = array( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );

    //Consultar ids
    $programa = new Programa();
    $res_programa = $programa->consultarPor("programas",array("solicitud_id"=>$_POST["solicitud"]),"id,plantel_id");
    $res_programa = $res_programa["data"][0];
    $trayectoria = new Programa();
    $res_trayectoria = $trayectoria->consultarPor("trayectorias",array("programa_id"=>$res_programa["id"]),"id");
    $res_trayectoria = $res_trayectoria["data"][0];

    //IDS
    $id_solicitud = $_POST["solicitud"];
    $id_programa = $res_programa["id"];
    $id_plantel = $res_programa["plantel_id"];
    $id_trayectoria = $res_trayectoria["id"];


    //Obtener los documentos

    $resultado = [];

    $estudioPertenencia = new Documento();
    $res_estudioPertenencia = $estudioPertenencia->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["estudio_pertinencia"],"deleted_at"),"*");
    if(sizeof($res_estudioPertenencia["data"])>0)
    {
      $resultado["documentos"]["estudio_pertinencia"] =$res_estudioPertenencia["data"][0];
    }

    $ofertaDemanda = new Documento();
    $res_ofertaDemanda = $ofertaDemanda->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["archivo_oferta_demanda"],"deleted_at"),"*");
    if (sizeof($res_ofertaDemanda["data"])>0)
    {
      $resultado["documentos"]["oferta_demanda"] =$res_ofertaDemanda["data"][0];
    }

    $convenios = new Documento();
    $res_convenios = $convenios->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["convenios"],"deleted_at"),"*");
    if (sizeof($res_convenios["data"])>0)
    {
      $resultado["documentos"]["convenios"] =$res_convenios["data"][0];
    }

    $mapaCurricular = new Documento();
    $res_mapaCurricular = $mapaCurricular->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["archivo_mapa_curricular"],"deleted_at"),"*");
    if (sizeof($res_mapaCurricular["data"])>0)
    {
      $resultado["documentos"]["mapa_curricular"] =$res_mapaCurricular["data"][0];
    }

    $reglasAcademia = new Documento();
    $res_reglasAcademia = $reglasAcademia->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["archivo_reglas_academias"],"deleted_at"),"*");
    if (sizeof($res_reglasAcademia["data"])>0)
    {
      $resultado["documentos"]["reglas_academias"] =$res_reglasAcademia["data"][0];
    }

    $asignaturas = new Documento();
    $res_asignaturas = $asignaturas->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["archivo_asignaturas_detalle"],"deleted_at"),"*");
    //print_r($res_asignaturas);
    if (sizeof($res_asignaturas["data"])>0)
    {
      $resultado["documentos"]["asignaturas"] =$res_asignaturas["data"][0];
    }

    $bibliografia = new Documento();
    $res_bibliografia = $bibliografia->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["propuesta_hemerobibliografica"],"deleted_at"),"*");
    if (sizeof($res_bibliografia["data"])>0)
    {
      $resultado["documentos"]["bibliografia"] =$res_bibliografia["data"][0];
    }

    $informeResultados = new Documento();
    $res_informeResultados = $informeResultados->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["TRAYECTORIA"],"entidad_id"=>$id_trayectoria,"tipo_documento"=>Documento::$nombresDocumentos["archivo_informe_resultados_trayectoria_educativa"],"deleted_at"),"*");
    if (sizeof($res_informeResultados["data"])>0)
    {
      $resultado["documentos"]["informe_resultados"] =$res_informeResultados["data"][0];
    }

    $instrumentosTrayectoria = new Documento();
    $res_instrumentosTrayectoria = $instrumentosTrayectoria->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["TRAYECTORIA"],"entidad_id"=>$id_trayectoria,"tipo_documento"=>Documento::$nombresDocumentos["archivo_instrumentos_trayectoria_educativa"],"deleted_at"),"*");
    if (sizeof($res_instrumentosTrayectoria["data"])>0)
    {
      $resultado["documentos"]["instrumentos_trayectoria"] =$res_instrumentosTrayectoria["data"][0];
    }

    $trayectoriaEducativa = new Documento();
    $res_trayectoriaEducativa = $trayectoriaEducativa->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["TRAYECTORIA"],"entidad_id"=>$id_trayectoria,"tipo_documento"=>Documento::$nombresDocumentos["archivo_trayectoria_educativa"],"deleted_at"),"*");
    if (sizeof($res_trayectoriaEducativa["data"])>0)
    {
      $resultado["documentos"]["trayectoria_educativa"] =$res_trayectoriaEducativa["data"][0];
    }

    $fotografias = new Documento();
    $res_fotografias = $fotografias->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PLANTEL"],"entidad_id"=>$id_plantel,"tipo_documento"=>Documento::$nombresDocumentos["fotografia_inmueble"],"deleted_at"),"*");
    if (sizeof($res_fotografias["data"])>0)
    {
      $resultado["documentos"]["fotografias"] =$res_fotografias["data"][0];
    }

    $plano = new Documento();
    $res_plano = $plano->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PLANTEL"],"entidad_id"=>$id_plantel,"tipo_documento"=>Documento::$nombresDocumentos["plano"],"deleted_at"),"*");
    if (sizeof($res_plano["data"])>0)
    {
      $resultado["documentos"]["plano"] =$res_plano["data"][0];
    }

    $calendario = new Documento();
    $res_calendario = $calendario->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["propuesta_calendario"],"deleted_at"),"*");
    if (sizeof($res_calendario["data"])>0)
    {
      $resultado["documentos"]["propuesta_calendario"] =$res_calendario["data"][0];
    }

    $acuerdoAnterior = new Documento();
    $res_acuerdoAnterior = $acuerdoAnterior->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["acuerdo_anterior"],"deleted_at"),"*");
    if (sizeof($res_acuerdoAnterior["data"])>0)
    {
      $resultado["documentos"]["acuerdo_anterior"] =$res_acuerdoAnterior["data"][0];
    }

    $vinculacion = new Documento();
    $res_vinculacion = $vinculacion->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["proyecto_vinculacion"],"deleted_at"),"*");
    if (sizeof($res_vinculacion["data"])>0)
    {
      $resultado["documentos"]["proyecto_vinculacion"] =$res_vinculacion["data"][0];
    }

    $superacion = new Documento();
    $res_superacion = $superacion->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["programa_superacion"],"deleted_at"),"*");
    if (sizeof($res_superacion["data"])>0)
    {
      $resultado["documentos"]["programa_superacion"] =$res_superacion["data"][0];
    }

    $mejora = new Documento();
    $res_mejora = $mejora->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["plan_mejora"],"deleted_at"),"*");
    if (sizeof($res_mejora["data"])>0)
    {
      $resultado["documentos"]["plan_mejora"] =$res_mejora["data"][0];
    }

    $reglamento = new Documento();
    $res_reglamento = $reglamento->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["reglamento_institucional"],"deleted_at"),"*");
    if (sizeof($res_reglamento["data"])>0)
    {
      $resultado["documentos"]["reglamento_institucional"] =$res_reglamento["data"][0];
    }

    $horarios = new Documento();
    $res_horarios = $horarios->consultarPor("documentos",array("tipo_entidad"=>Documento::$tipoEntidad["PROGRAMA"],"entidad_id"=>$id_programa,"tipo_documento"=>Documento::$nombresDocumentos["propuesta_horario"],"deleted_at"),"*");
    if (sizeof($res_horarios["data"])>0)
    {
      $resultado["documentos"]["propuesta_horario"] =$res_horarios["data"][0];
    }

    retornarWebService("",$resultado);
  }

?>
