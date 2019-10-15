<?php
  /**
  * Archivo que gestiona los web services de la clase Inspector
  */

  require_once "../models/modelo-inspector.php";
  require_once "../utilities/utileria-general.php";
  require_once "../models/modelo-bitacora.php";
  require_once "../models/modelo-persona.php";
  require_once "../models/modelo-inspeccion.php";
  require_once "../models/modelo-usuario.php";
  require_once "../models/modelo-solicitud-estatus.php";
  require_once "../models/modelo-solicitud.php";
  if ($_POST["webService"]=="consultarPlantelesInstitucion")
  {
    $plantel = new Plantel( );
    $aux = new Utileria( );
    $usuario = new Usuario( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $tabla = "planteles";
    $usuario->setAttributes( array("id"=>$_POST['usuario_id']));
    $representante =  $usuario->consultarId();
    $id_representate = $representante["data"]["persona_id"];
    unset($usuario);
    $condicionantes = array( "institucion_id"=>$_POST["institucion_id"],"deleted_at");
    $planteles = $plantel->consultarPor($tabla,$condicionantes,'*');
    $tabla="";
    if(sizeof($planteles["data"]) > 0){
          $resultado = array();
          foreach ($planteles["data"] as $registro) {
             $temp = new Plantel( );
             $registro['domicilio'] = $temp->consultarPor('domicilios',array('id'=>$registro['domicilio_id']),'*');
             unset($temp);
             array_push($resultado,$registro);
          }
          foreach ($resultado as $registro) {
            // if($registro['persona_id'] == $id_representate){
            //   $estatus = "Por asignar gestor";
            // }else {
            //   $estatus="Gestor asignado";
            // }
            $estatus = "";
            if(is_array($registro["domicilio"]["data"][0])){

              $json =$registro["domicilio"]["data"][0] ;
              $json["institucion_id"] = $registro["id"];
              $json = json_encode($json);
              $txt_aux = "id=".$registro["id"]."&usuario_id=".$registro['persona_id'];
              $editar = "<a href='editar-plantel.php?".$txt_aux."'><span class='glyphicon glyphicon-pencil'></span></a>";
              $espacio = "&nbsp;&nbsp;&nbsp;";
              $eliminar = "<a  href='#' onclick='Institucion.datosModal(".htmlentities($json).")'><span class='glyphicon glyphicon-trash'></span></a>";
              $ver =  "<a href='ver-plantel.php?".$txt_aux."'><span class='glyphicon glyphicon-eye-open'></span></a>";
              $tabla.='{
                    "domicilio":"'.$registro["domicilio"]["data"][0]['calle'].$espacio.$registro["domicilio"]["data"][0]['numero_exterior'].'",
                    "colonia":"'.$registro["domicilio"]["data"][0]['colonia'].'",
                    "municipio":"'.$registro["domicilio"]["data"][0]['municipio'].'",
                    "cp":"'.$registro["domicilio"]["data"][0]['codigo_postal'].'",
                    "estatus":"'.$estatus.'",
                    "acciones":"'.$editar.$espacio.$ver.$espacio.$eliminar.'"
                  },';
            }
            // var_dump($registro["domicilio"]["data"][0]);
          }
          $tabla = substr($tabla,0, strlen($tabla) - 1);
          echo '{"data":['.$tabla.']}';
    }else{
      $resultado = array(
     "status"=>"204",
     "message"=>"No Content",
     "data"=> "" );
     // Registro en bitacora
       $bitacora = new Bitacora();
       $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
       $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"instituciones","accion"=>"consultarPlantelesInstitucion","lugar"=>"control-institucion"]);
       $result = $bitacora->guardar();
     retornarWebService( $_POST["url"], $resultado );
    }

  }


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
    $obj = new Inspector( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"inspectores","accion"=>"consultarTodos","lugar"=>"control-inspector"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Inspector();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"inspectores","accion"=>"consultarId","lugar"=>"control-inspector"]);
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
		$obj = new Inspector( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"inspectores","accion"=>"guardar","lugar"=>"control-inspector"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Inspector( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"inspectores","accion"=>"eliminar","lugar"=>"control-inspector"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  //Obtener los inspectores
  if($_POST["webService"]=="inspectores")
  {
    $usuario = new Usuario();
    $usuarios = $usuario->consultarPor("usuarios",array("rol_id"=>6,"deleted_at"),"*");
    $inspectores = array();
    if( sizeof($usuarios["data"]) > 0 )
    {
      $usuarios = $usuarios["data"];
      foreach ($usuarios as $posicion => $campos)
      {
        $persona = new Persona();
        $persona->setAttributes(array("id"=>$campos["persona_id"]));
        $res_persona = $persona->consultarId();
        $inspecciones = new Inspeccion();
        $res_inspecciones = $inspecciones->consultarPor("inspectores",array("persona_id"=>$res_persona["data"]["id"]),"programa_id");
        $temp["inspector"] = $res_persona["data"];
        $aux["inspecciones"] = $res_inspecciones["data"];
        $temp["inspecciones_activas"] = 0;
        $temp["inspecciones_realizadas"] = 0;
        if(sizeof($aux["inspecciones"])>0)
        {
          foreach ($aux["inspecciones"] as $key => $value)
          {
              $inspeccion = new Inspeccion();
              $res_inspeccion = $inspeccion->consultarPor("inspecciones",array("programa_id"=>$value["programa_id"],"deleted_at"),"*");
              if(sizeof($res_inspeccion["data"])>0)
              {
                $res_inspeccion = $res_inspeccion["data"][0];
                if($res_inspeccion["estatus_inspeccion_id"]==5)
                {
                  $temp["inspecciones_realizadas"] +=1;
                }else
                {
                  $temp["inspecciones_activas"] +=1;
                }
              }


          }

        }
        array_push($inspectores,$temp);


      }
    }
    if(sizeof($inspectores)>0)
    {
      $tabla = "";
      $espacio = "&nbsp;&nbsp;&nbsp;";
      foreach ($inspectores as $key => $valores)
      {
        $json = [];
        $nombre =  $valores["inspector"]["nombre"]." ".$valores["inspector"]["apellido_paterno"]." ".$valores["inspector"]["apellido_materno"];
        $json["id"] = $valores["inspector"]["id"];
        $json["nombre"] = $nombre;
        $json = json_encode($json);
        $activas = $valores["inspecciones_activas"];
        $realizadas = $valores["inspecciones_realizadas"];
        $acciones =  "<a href='#' onclick='Inspeccion.confirmarAsignacion(".htmlentities($json).")'><span class='glyphicon glyphicon-plus'></span></a>";
        $tabla.='{
              "nombre":"'.$nombre.'",
              "activas":"'.$activas.'",
              "realizadas":"'.$realizadas.'",
              "acciones":"'.$acciones.'"
            },';
      }
      $tabla = substr($tabla,0, strlen($tabla) - 1);
      echo '{"data":['.$tabla.']}';
    }

  }
  //Asignar una inspección
  if($_POST["webService"]=="asignarInspeccion")
  {
    $parametros = array( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    foreach( $_POST as $atributo=>$valor )
    {
      $parametros[$atributo] = $valor;
    }
    $obj = new Inspector( );
    $obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    $retorno = "";
    if(sizeof($resultado["data"])>0)
    {
        $inspeccion = new Inspeccion();
        $inspeccion->setAttributes(array("programa_id"=>$_POST["programa_id"],"estatus_inspeccion_id"=>1,"fecha_asignada"=>$_POST["fecha_inspeccion"],"folio"=>$_POST["folio"]));
        $res_inspeccion = $inspeccion->guardar();
        $retorno = $res_inspeccion;
        $estatusAsignacion = new SolicitudEstatus();
        $res_estatusAsignacion = $estatusAsignacion->consultarPor("solicitudes_estatus_solicitudes",array("solicitud_id"=>$_POST["solicitud_id"],"estatus_solicitud_id"=>6),"*");
        $res_estatusAsignacion = $res_estatusAsignacion["data"][0];
        //Actualizar el estatus de asignacion de inspección
        $asignacionInspeccion = new SolicitudEstatus();
        $asignacionInspeccion->setAttributes(array("id"=>$res_estatusAsignacion["id"],"comentario"=>"Visita de inspeccion programada para: ".$_POST["fecha_inspeccion"]));
        $asignacionInspeccion->guardar();
        //Nuevo estatus
        $estatus = new SolicitudEstatus();
        $estatus->setAttributes(array("estatus_solicitud_id"=>7,"solicitud_id"=>$_POST["solicitud_id"],"comentario"=>""));
        $estatus->guardar();
        $solicitud = new Solicitud();
        $solicitud->setAttributes(array("id"=>$_POST["solicitud_id"],"estatus_solicitud_id"=>7));
        $solicitud->guardar();
        //Notificación apps
        $usuarioNotificar = new Solicitud();
        $usuarioNotificar->setAttributes(array("id"=>$_POST["solicitud_id"]));
        $resUsuarioNotificar = $usuarioNotificar->consultarId();
        $resUsuarioNotificar = $resUsuarioNotificar["data"];
        $notificacion = new Usuario();
        $msj = "Su institución tiene una visita de inspección programada.";
        $notificacion->notificacionIdUsuario($resUsuarioNotificar["usuario_id"],"Inspección física",$msj);
    }
    retornarWebService( "", $retorno );

  }

?>
