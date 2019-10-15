<?php
  /**
  * Archivo que gestiona los web services de la clase Programa
  */

  require_once "../models/modelo-programa.php";
  require_once "../utilities/utileria-general.php";
  require_once "../models/modelo-institucion.php";
  require_once "../models/modelo-plantel.php";
  require_once "../models/modelo-domicilio.php";
  require_once "../models/modelo-solicitud.php";
  require_once "../models/modelo-mixta-noescolarizada.php";
  require_once "../models/modelo-respaldo.php";
  require_once "../models/modelo-espejo.php";
  //
  require_once "../models/modelo-asignatura.php";
  require_once "../models/modelo-docente.php";
  require_once "../models/modelo-infraestructura.php";
  require_once "../models/modelo-formacion.php";
  require_once "../models/modelo-tipo-instalacion.php";
  require_once "../models/modelo-usuario.php";
  require_once "../models/modelo-bitacora.php";
  require_once "../models/modelo-ratificacion-nombre.php";
  session_start();


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
    $obj = new Programa( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programas","accion"=>"consultarTodos","lugar"=>"control-programa"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }
  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Programa();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programas","accion"=>"consultarId","lugar"=>"control-programa"]);
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
		$obj = new Programa( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programas","accion"=>"guardar","lugar"=>"control-programa"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }
  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Programa( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programas","accion"=>"eliminar","lugar"=>"control-programa"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }
  //Carga información del programa
  if( $_POST["webService"] == "modificacionPrograma"  )
  {
    //session_start();
    $resultado["status"] = "200";
    $resultado["mesagge"] = "OK";
    $planteles_array = array();
    if( isset( $_SESSION["id"] ) ){
      //Colsultar la institucion
      $institucion = new Institucion();
      $id_institucion = $institucion->consultarPor("instituciones",array("usuario_id"=>$_SESSION["id"],"deleted_at"),"id");
      if( sizeof($id_institucion["data"]) > 0  || $_SESSION["rol_id"] > 6 || $_SESSION["rol_id"] == 2 ){
          if( $_SESSION["rol_id"] == 3 || $_SESSION["rol_id"] == 4 ){
            $id_institucion = $id_institucion["data"][0]["id"];
            //Planteles de la institucion
            $planteles = new Plantel();
            $ids_planteles = $planteles->consultarPor("planteles",array("institucion_id"=>$id_institucion,"deleted_at"),"id");
            $ids_planteles = $ids_planteles["data"];
          }else{
            $ids_planteles = array("Detalles"=>"Solo para definir la variable cuando es un usuario de sicyt");
          }


          if( sizeof( $ids_planteles ) > 0 ){
              //Programa
              $programa = new Programa();
              $res_programa = $programa->consultarPor("programas",array("id"=>$_POST["programaId"],"deleted_at"),array("id","plantel_id"));
              $res_programa  =   $res_programa["data"];
              if( sizeof($res_programa) > 0  ){
                  $res_programa = $res_programa[0];
                  if( $_SESSION["rol_id"] > 6 || $_SESSION["rol_id"] == 2 ){
                    $posicion_plantel = true;
                  }else{
                    $idsPlanteles = array_column($ids_planteles, 'id');
                    $posicion_plantel = array_search($res_programa["plantel_id"],$idsPlanteles);
                  }
                  if( $posicion_plantel  === false ){
                    $resultado["data"] = "El programa no le pertenece";
                  }else{
                    //Construir el resultado
                    $id_programa = $res_programa["id"];
                    $informacionPrograma = new Programa();
                    $informacionPrograma->setAttributes(array("id" =>  $id_programa));
                    $temp = $informacionPrograma->informacionRelacionada(2);
                    $resultado["data"]["programa"] = $temp["data"];
                    //Institucion
                    $insti = new Institucion();
                    $insti->setAttributes( array("id"=>$resultado["data"]["programa"]["plantel"]["institucion_id"]));
                    $res_institucion = $insti->consultarId();
                    $resultado["data"]["institucion"] =  $res_institucion["data"];
                    //Ratificacion
                    $ratificacion = new RatificacionNombre();
                    $res_ratificacion = $ratificacion->consultarPor("ratificacion_nombres",array("institucion_id"=>$resultado["data"]["programa"]["plantel"]["institucion_id"]),"*");
                    $resultado["data"]["ratificacion"] = $res_ratificacion["data"][0];
                    //Representante legal
                    $representante = new Usuario();
                    $representante->setAttributes(array("id"=>$resultado["data"]["programa"]["solicitud"]["usuario_id"]));
                    $res_representante =$representante->consultarId();
                    $resultado["data"]["representante"]["id"] = $res_representante["data"]["id"];
                    $resultado["data"]["representante"]["persona"] = $res_representante["data"]["persona"];
                    $domicilio = new Domicilio();
                    $domicilio->setAttributes(array("id"=>$res_representante["data"]["persona"]["domicilio_id"]));
                    $res_domicilio = $domicilio->consultarId();
                    $resultado["data"]["representante"]["domicilio"] =$res_domicilio["data"];
                    //Diligencias
                    $usuarios_solicitudes = new Solicitud();
                    $usuarios_diligencias = $usuarios_solicitudes->consultarPor("solicitudes_usuarios",array("solicitud_id"=> $resultado["data"]["programa"]["solicitud_id"],"deleted_at"), array("id","solicitud_id","usuario_id"));
                    $usuarios_diligencias = $usuarios_diligencias["data"];
                    if( sizeof( $usuarios_diligencias ) > 0 ){
                        $diligencias_array = array();
                        foreach ($usuarios_diligencias as $posicion => $campos) {
                          $persona = new Persona();
                          $persona->setAttributes( array("id"=>$campos["usuario_id"]) );
                          $res_temp = $persona->consultarId();
                          array_push($diligencias_array,$res_temp["data"]);
                        }
                        $resultado["data"]["programa"]["diligencias"] = $diligencias_array;
                    }
                    //Campos solo para los programas No escolarizados o Mixtos
                    if( $resultado["data"]["programa"]["modalidad_id"] > 1 ){
                        $mixta_noescolarizada = new MixtaNoEscolarizada();
                        $res_mixta = $mixta_noescolarizada->consultarPor("mixta_noescolarizadas",array( "programa_id" => $resultado["data"]["programa"]["id"] ),"*");
                        if( sizeof($res_mixta["data"]) > 0){
                          $resultado["data"]["programa"]["mixta"] = $res_mixta["data"][0];
                          $respaldo = new Respaldo();
                          $res_respaldo = $respaldo->consultarPor("respaldos",array("mixta_noescolarizada_id"=>$resultado["data"]["programa"]["mixta"]["id"]),"*");
                          if( sizeof($res_respaldo["data"]) > 0 ){
                            $resultado["data"]["programa"]["mixta"]["respaldos"] = $res_respaldo["data"];
                          }
                          $espejo = new Espejo();
                          $res_espejo = $espejo->consultarPor("espejos", array("mixta_noescolarizada_id"=>$resultado["data"]["programa"]["mixta"]["id"]), "*");
                          if( sizeof($res_espejo["data"]) > 0){
                            $resultado["data"]["programa"]["mixta"]["espejos"] = $res_espejo["data"];
                          }
                        }
                    }
                    if($_POST["opcion"]==1){
                            $asignatura = new Asignatura();
                            $asignaturas = $asignatura->consultarPor( "asignaturas" , array("programa_id"=>$resultado["data"]["programa"]["id"],"deleted_at"), "*" );
                            if( sizeof($asignaturas["data"]) > 0){
                              $docentes = array();
                              $infraestructuras = array();
                              foreach ($asignaturas["data"] as $index => $campos)
                              {
                                  $temporal_infraestructura = new Infraestructura();
                                  $temporal_infraestructura->setAttributes( array( 'id' => $campos["infraestructura_id"] ) );
                                  $resultado_temp = $temporal_infraestructura->consultarId();
                                  $resultado_temp["data"]["asignatura"] = $campos["clave"];
                                  array_push($infraestructuras,$resultado_temp["data"]);

                                  $temporal_docente = new Docente();
                                  $temporal_docente->setAttributes( array( 'id' => $campos["docente_id"] ) );
                                  $resultado_temp = $temporal_docente->consultarId();
                                  $resultado_temp["data"]["asignatura"] = $campos["clave"];

                                  $temp_persona = new Persona();
                                  $temp_persona->setAttributes( array( 'id' => $resultado_temp["data"]["persona_id"] ) );
                                  $respuesta_temp = $temp_persona->consultarId();
                                  $resultado_temp["data"]["persona"] =  $respuesta_temp["data"];
                                  array_push($docentes,$resultado_temp["data"]);


                              }
                              $resultado["data"]["asignaturas"] = $asignaturas["data"];
                              //Agregar las claves de las asignaturas al docente (Se eliminan los docentes repetidos)
                              $docentes_final = array();
                              foreach ($docentes as $key => $value) {
                                $value["asignaturas"] = [];
                                if(empty($docentes_final)){
                                    array_push($value["asignaturas"],$value["asignatura"]);
                                    array_push($docentes_final,$value);
                                  }else{
                                    $position = array_search($value["id"], array_column($docentes_final, 'id'));
                                    if($position === false){
                                       array_push($value["asignaturas"],$value["asignatura"]);
                                       array_push($docentes_final,$value);
                                      }else{
                                        array_push($docentes_final[$position]["asignaturas"],$value["asignatura"]);
                                      }
                                    }
                                }
                                //Se elimina el campo "asignatura" ya que es innecesario y se agregan formaciones del docente
                                foreach ($docentes_final as $key => $value) {
                                    unset($docentes_final[$key]["asignatura"]);
                                    $formacion_temp = new Formacion();
                                    $resultado_temp = $formacion_temp->consultarPor("formaciones",array("persona_id"=>$value["persona_id"]),"*");
                                    $docentes_final[$key]["formaciones"] = $resultado_temp["data"];
                                    if( sizeof($docentes_final[$key]["formaciones"]) > 0){
                                      foreach ( $docentes_final[$key]["formaciones"] as $indice => $campos) {
                                        $nivel_temp = new Nivel();
                                        $nivel_temp->setAttributes( array( 'id' => $campos["nivel"] ) );
                                        $resultado_temp = $nivel_temp->consultarId();
                                        $docentes_final[$key]["formaciones"][$indice]["grado"] = $resultado_temp["data"];
                                      }
                                    }
                                  }
                                $resultado["data"]["docentes"] = $docentes_final;
                                //Agregar las claves de las asignaturas a la infraestructura (Se eliminan  repetidos)
                                $infraestructuras_final = array();
                                foreach ($infraestructuras as $key => $value) {
                                    $value["asignaturas"] = [];
                                    if(empty($infraestructuras_final)){
                                      array_push($value["asignaturas"],$value["asignatura"]);
                                      array_push($infraestructuras_final,$value);
                                    }else{
                                      $position = array_search($value["id"], array_column($infraestructuras_final, 'id'));
                                      if($position === false){
                                        array_push($value["asignaturas"],$value["asignatura"]);
                                        array_push($infraestructuras_final,$value);
                                      }else{
                                        array_push($infraestructuras_final[$position]["asignaturas"],$value["asignatura"]);
                                      }
                                    }
                                }
                                //Se elimina el campo "asignatura" ya que es innecesario
                                foreach ($infraestructuras_final as $key => $value) {
                                  unset($infraestructuras_final[$key]["asignatura"]);
                                  $temporal_instalacion = new TipoInstalacion();
                                  $temporal_instalacion->setAttributes( array( 'id' => $value["tipo_instalacion_id"] ) );
                                  $resultado_temp = $temporal_instalacion->consultarId();
                                  $infraestructuras_final[$key]["instalacion"] = $resultado_temp["data"];
                                }
                                $resultado["data"]["asignatura_infraestructura"] =$infraestructuras_final;
                                //Infraestructura del plantel (No se imparten clase)
                                $infraestructura = new Infraestructura();
                                $infraestructuras = $infraestructura->consultarPor("infraestructuras", array( "plantel_id" => $resultado["data"]["programa"]["plantel"]["id"], "deleted_at" ), '*');
                                $infraestructuras = $infraestructuras["data"];
                                //Obtener infraestructuras de uso común
                                $infraestructura_final= array( );
                                  foreach ($infraestructuras as $key => $value) {
                                    if( $value["tipo_instalacion_id"] == 2 ||  $value["tipo_instalacion_id"] == 3 || $value["tipo_instalacion_id"] == 9 || $value["tipo_instalacion_id"] == 10 ||$value["tipo_instalacion_id"] == 11 ){
                                        $value["instalacion"] = [];
                                        $temporal_instalacion = new TipoInstalacion();
                                        $temporal_instalacion->setAttributes( array( 'id' => $value["tipo_instalacion_id"] ) );
                                        $resultado_temp = $temporal_instalacion->consultarId();
                                        $value["instalacion"] = $resultado_temp["data"];
                                        array_push($infraestructura_final,$value);
                                          //$infraestructuras_final["instalacion"] = $resultado_temp["data"];
                                    }
                                  }
                                $resultado["data"]["infraestructuraComun"] = $infraestructura_final;
                            }
                    }//Termina if de opcion

                  }
                }else{
                $resultado["data"] = "No existe el programa";
              }



          }else{
            $resultado["data"] = "No cuenta con planteles";
          }
      }else{
        $resultado["data"] = "No cuenta con institución";
      }

    }else{
      $resultado["data"] = "Debes de iniciar sesión";
    }


    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programas","accion"=>"modificacionPrograma","lugar"=>"control-programa"]);
      $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );

  }

  //Informacion para mis solicitudes
  if ( $_POST["webService"]=="informacionBasica") {
    //session_start();
    $resultado["status"] = "200";
    $resultado["mesagge"] = "OK";
    $programas = array();
      if( isset( $_SESSION["id"] ) )
      {
        //Obtener la institución
        $institucion = new Institucion();
        $res_institucion = $institucion->consultarPor( "instituciones", array( "usuario_id" =>  $_SESSION["id"], "deleted_at" )  ,"*");
        $programas_array = array();
        if( sizeof($res_institucion["data"])>0){
          $res_institucion = $res_institucion["data"][0];
          //$resultado["data"]["institucion"] = $res_institucion;
          //Obtener planteles
          $plantel = new Plantel();
          $ids_planteles = $plantel->consultarPor( "planteles", array( "institucion_id" =>  $res_institucion["id"], "deleted_at" )  ,array("id","domicilio_id"));
          $ids_planteles = $ids_planteles["data"];
          if( sizeof($ids_planteles)>0 ){
            foreach ( $ids_planteles as $posicionPlantel => $camposPlantel) {
                  $programa = new Programa();
                  //$programas = $programa->consultarPor("SELECT * FROM programas WHERE plantel_id=" . $camposPlantel["id"] . " AND acuerdo_rvoe != '' ");
                  $programas = $programa->consultarPor("programas", array("plantel_id"=>$camposPlantel["id"],"acuerdo_rvoe_lleno"=>''), "id");
                  $programas = $programas["data"];
                  if( sizeof($programas)>0 ){
                  foreach ($programas as $key => $value) {
                    $tempPrograma = new Programa();
                    $tempPrograma->setAttributes(array("id"=>$value["id"]));
                    $resTemp = $tempPrograma->consultarId();
                    $domicilio = new Domicilio();
                    $domicilio->setAttributes(array("id"=>$camposPlantel["domicilio_id"]));
                    $res_domicilio =$domicilio->consultarId();
                    if( sizeof($res_domicilio["data"])>0){
                      $resTemp["data"]["domicilio"] = $res_domicilio["data"];
                    }
                    array_push($programas_array,$resTemp["data"]);
                  }
                  }
            }
          }
          $resultado["data"]["programas"] = $programas_array;
        }else
        {
          $resultado["data"]  = "";
        }

      }else
      {
        $resultado["status"] = "202";
        $resultado["mesagge"] = "NO DATA";
        $resultado["data"]  = "";
      }
      // Registro en bitacora
        $bitacora = new Bitacora();
        $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
        $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programas","accion"=>"informacionBasica","lugar"=>"control-programa"]);
        $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );
  }

  //Web service para cargar los datos generales del programa (asignació de evaluación)
  if( $_POST["webService"] =="datosGenerales")
  {
    $resultado["status"] = "200";
    $resultado["message"] = "OK";
    $obj = new Programa( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $id_programa = $obj->consultarPor("programas",array("solicitud_id"=>$_POST["solicitud"]),"id");
    if( sizeof($id_programa["data"]) > 0 )
    {
      $id_programa = $id_programa["data"][0];
      $programa = new Programa();
      $programa->setAttributes(array("id"=>$id_programa["id"]));
      $res_programa = $programa->informacionRelacionada(2);
      $institucion = new Institucion();
      $institucion->setAttributes(array("id"=>$res_programa["data"]["plantel"]["institucion_id"]));
      $res_institucion = $institucion->consultarId();
      $res_institucion = $res_institucion["data"];
      $res_programa["data"]["institucion"] = $res_institucion;
      $resultado = $res_programa;
    }
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programas","accion"=>"datosGenerales","lugar"=>"control-programa"]);
      $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );

  }
?>
