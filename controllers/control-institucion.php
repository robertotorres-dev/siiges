<?php
  /**
  * Archivo que gestiona los web services de la clase Institucion
  */

  require_once "../models/modelo-institucion.php";
  require_once "../models/modelo-plantel.php";
  require_once "../models/modelo-usuario.php";
  require_once "../models/modelo-documento.php";
  require_once "../models/modelo-ratificacion-nombre.php";
  require_once "../utilities/utileria-general.php";
  require_once "../models/modelo-bitacora.php";
  require_once "../models/modelo-domicilio.php";
  require_once "../models/modelo-solicitud.php";
  require_once "../models/modelo-estatus-solicitud.php";

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
    $obj = new Institucion( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"instituciones","accion"=>"consultarTodos","lugar"=>"control-institucion"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar todos los registros
  if( $_POST["webService"]=="obtener_listado_instituciones" )
  {
    $obj = new Institucion( );
    $obj->setAttributes( array( ) );
    $resultado = $obj->consultarTodos( );

    $instituciones = isset($resultado["data"])?$resultado["data"]:[];
    $aux["status"] = $resultado["status"];
    $aux["message"] = $resultado["message"];
    $aux["data"]["selector"]= [];

    foreach ($instituciones as $key => $institucion) {
      $inst["id"] = $institucion["id"];
      $inst["nombre"] = $institucion["nombre"];
      $inst["usuario_id"] = $institucion["usuario_id"];
      $inst["persona_id"] = $institucion["persona_id"];
      $inst["es_nombre_autorizado"] = $institucion["es_nombre_autorizado"];
      array_push($aux["data"]["selector"],$inst);
    }
    $resultado["data"]["selector"] = $aux;
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"instituciones","accion"=>"obtener_listado_instituciones","lugar"=>"control-institucion"]);
      $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $aux );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Institucion();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"instituciones","accion"=>"consultarId","lugar"=>"control-institucion"]);
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
		$obj = new Institucion( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    //Tratar archivos en caso de existir
    if( !empty( $_FILES ) )
    {
      $archivo = $_FILES["acta_constitutiva"];
      //Comprueba si se subio archivo
      if( !empty( $archivo["name"] ) &&  $archivo["error"] === 0 )
      {
        //Construir el nombre del archivo  ejemplo "Tipoocumento_idsuario.pdf"
        $id_usuario = $_POST["usuario_id"];
        $extension =  strrchr( $archivo["name"] , '.' );
        $nombre_archivo = "acta-constitutiva_".$id_usuario.$extension;
        //Subimos el archivo
        $ruta_archivo = Documento::$dir_subida."actas-constitutivas/".basename($nombre_archivo);
        if(move_uploaded_file($archivo["tmp_name"],$ruta_archivo))
        {
          //Obtenemos el id e la tabla
          $id_tabla = array_search('instituciones',Documento::$tablas);
          //Obtenemos los datos de del tipo_documento
          $posicion_arreglo = array_search("Acta constitutiva", array_column(Documento::$tipos_documentos, 'nombre'));
          //$tipo_documento = Documento::$tipos_documentos[$posicion_arreglo];
          $tipo_documento = Documento::$nombresDocumentos["acta_constitutiva"];
          $atributos = array();
          if( $_POST['documento_id']!="" )
          {
            $atributos["id"] = $_POST['documento_id'];
          }
          $atributos["tipo_entidad"] = $id_tabla;
          $atributos["entidad_id"] = $resultado["data"]["id"];
          $atributos["tipo_documento"] = $tipo_documento;
          $atributos["nombre"] = $nombre_archivo;
          $atributos["archivo"] = $ruta_archivo;
          $documento = new Documento( );
          $documento->setAttributes( $atributos );
          $resultado = $documento->guardar( );
        }else
        {
          $resultado = array(
          "status"=>"500",
          "message"=>"INTERNAL SERVER ERROR",
          "data"=>"El archivo no se pudo subir al servidor" );
        }
      }else
      {
        $resultado  = array(
        "status"=>"500",
        "message"=>"INTERNAL SERVER ERROR",
        "data"=>"El archivo no se pudo subir al servidor por que no existe o ocurrio un error"  );
      }
    }
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"instituciones","accion"=>"guardar","lugar"=>"control-institucion"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Institucion( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"instituciones","accion"=>"eliminar","lugar"=>"control-institucion"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }
  //Web service para obtener la institución que representa un usuario
  if ($_POST["webService"]=="consultarUsuarioInstitucion")
  {
    $obj = new Institucion( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $resultado = $obj->consultarPor('instituciones', array( "usuario_id"=>$_POST["id"], "deleted_at" ), '*');
    $documentos = new Documento();
    $tipo_entidad = array_search('instituciones',Documento::$tablas);
    if(sizeof($resultado['data'])>0){
      $resultado['data'][0]['documentos'] = $documentos->consultarPor('documentos',array("tipo_entidad"=>$tipo_entidad,"entidad_id"=>$resultado['data'][0]['id']),'*');

    }

    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"instituciones","accion"=>"consultarUsuarioInstitucion","lugar"=>"control-institucion"]);
      $result = $bitacora->guardar();retornarWebService( $_POST["url"], $resultado);
  }
  //Web service para obtener los planteles con los que cuenta la institucion
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
    $condicionantes = array( "institucion_id"=>$_POST["institucion_id"],"deleted_at");
    $planteles = $plantel->consultarPor($tabla,$condicionantes,'*');
    $planteles = $planteles["data"];
    $tabla="";
    $res_planteles = [];
    if( sizeof($planteles) > 0 )
    {

      foreach ($planteles as $key => $value)
      {
          $domicilio = new Domicilio();
          $domicilio->setAttributes(array("id"=>$value["domicilio_id"]));
          $res_domicilio = $domicilio->consultarId();
          $res_domicilio = $res_domicilio["data"];
          $temp["plantel"] = $value;
          $temp["domicilio"] = $res_domicilio;
          array_push($res_planteles,$temp);
      }
      $estatus = "";
      $tabla = "";
      if( sizeof($res_planteles) > 0 )
      {
        foreach ($res_planteles as $posicion => $campo)
        {
          $json = [];
          $json["plantel"]["id"] = $campo["plantel"]["id"];
          $json["institucion_id"] = $campo["plantel"]["institucion_id"];
          $json["domicilio"] = $campo["domicilio"];
          $json = json_encode($json);
          $txt_aux = "id=".$campo["plantel"]["id"]."";
          $editar = "<a href='editar-plantel.php?".$txt_aux."'><span class='glyphicon glyphicon-pencil'></span></a>";
          $espacio = "&nbsp;&nbsp;&nbsp;";
          $eliminar = "<a  href='#' onclick='Institucion.datosModal(".htmlentities($json).")'><span class='glyphicon glyphicon-trash'></span></a>";
          $ver =  "<a href='ver-plantel.php?".$txt_aux."'><span class='glyphicon glyphicon-eye-open'></span></a>";
          $tabla.='{
                "domicilio":"'.$campo["domicilio"]['calle'].$espacio.$campo["domicilio"]['numero_exterior'].'",
                "colonia":"'.$campo["domicilio"]['colonia'].'",
                "municipio":"'.$campo["domicilio"]['municipio'].'",
                "cp":"'.$campo["domicilio"]['codigo_postal'].'",
                "acciones":"'.$editar.$espacio.$ver.$espacio.$eliminar.'"
              },';
        }
        $tabla = substr($tabla,0, strlen($tabla) - 1);
      }
    }
    echo '{"data":['.$tabla.']}';

  }

  // Web service para guardar registro
  if( $_POST["webService"]=="guardarPrimeraVez" )
  {
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $resultadofinal = array();
    if( !empty( $_FILES ) )
    {
      foreach ( $_FILES as $nombre => $archivo )
      {

        if( !empty( $archivo["name"] ) &&  $archivo["error"] === 0 )
        {
          //Construir el nombre del archivo  ejemplo "Tipoocumento_idsuario.pdf"
          $id_usuario = $_POST["usuario_id"];
          $extension =  strrchr( $archivo["name"] , '.' );
          if($nombre == "ratificacion_nombre")
          {
            $nombre_archivo = "ratificacion_".$id_usuario.$extension;
            $ruta_archivo = Documento::$dir_subida."ratificaciones/".basename($nombre_archivo);;
            //Obtenemos el id e la tabla
            $id_tabla = array_search('ratificacion_nombres',Documento::$tablas);
            $parametros = array( );
            foreach( $_POST as $atributo=>$valor )
            {
              $parametros[$atributo] = $valor;
            }
            $parametros['nombre_autorizado'] = $_POST['nombre'];
            $parametros['institucion_id'] = $institucion_id;
            $obj = new RatificacionNombre( );
            $obj->setAttributes( $parametros );
          }
          if($nombre == "acta_constitutiva")
          {
            $nombre_archivo = "acta-constitutiva_".$id_usuario.$extension;
            $ruta_archivo = Documento::$dir_subida."actas-constitutivas/".basename($nombre_archivo);
            //Obtenemos el id e la tabla
            $id_tabla = array_search('instituciones',Documento::$tablas);
            $parametros = array( );
            foreach( $_POST as $atributo=>$valor )
            {
              $parametros[$atributo] = $valor;
            }
            $obj = new Institucion( );
            $obj->setAttributes( $parametros );
          }
          if($nombre == "logotipo")
          {
            $nombre_archivo = "logotipo_".$id_usuario.$extension;
            $ruta_archivo = Documento::$dir_subida."logotipos/".basename($nombre_archivo);
            //Obtenemos el id e la tabla
            $id_tabla = array_search('instituciones',Documento::$tablas);
          }
          if(move_uploaded_file($archivo["tmp_name"],$ruta_archivo))
          {
            if( $nombre =="acta_constitutiva" )
            {
              $resultado = $obj->guardar( );
              $resultado = $resultado["data"];
              $entidad_id = $resultado['id'];
              $institucion_id = $resultado['id'];

            }else if ( $nombre =="ratificacion_nombre" )
            {
              $resultado = $obj->guardar( );
              $resultado = $resultado["data"];
              $entidad_id = $resultado['id'];
            }else
            {
              $entidad_id = $institucion_id;
            }
            //Obtenemos los datos de del tipo_documento
            $posicion_arreglo = array_search($nombre, array_column(Documento::$tipos_documentos, 'formulario'));
            $tipo_documento = Documento::$tipos_documentos[$posicion_arreglo];
            $atributos = array();
            $atributos["tipo_entidad"] = $id_tabla;
            $atributos["entidad_id"] = $entidad_id;
            $atributos["tipo_documento"] = $tipo_documento["id"];
            $atributos["nombre"] = $nombre_archivo;
            $atributos["archivo"] = $ruta_archivo;
            $documento = new Documento( );
            $documento->setAttributes( $atributos );
            $resultado = $documento->guardar( );
            array_push($resultadofinal,$resultado["data"]);
          }else
          {
            $resultadofinal = "ERROR";
          }
        }

      }
    }
    // Actualizar el estatus del usuario
    $usuario = new Usuario();
    $usuario->setAttributes(["id"=>$_POST["usuario_id"],"estatus"=>Usuario::USUARIO_REGULAR]);
    $usuario->guardar();

      if($resultadofinal=="ERROR"){
        $resultado = array( "status"=>"500", "message"=>"INTERNAL SERVER ERROR", "data"=> "Error para subir al archivo" );
      }else{
        $resultado = array( "status"=>"200", "message"=>"OK", "data"=> $resultadofinal );
      }

      // Registro en bitacora
        $bitacora = new Bitacora();
        $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
        $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"instituciones","accion"=>"guardarPrimeraVez","lugar"=>"control-institucion"]);
        $result = $bitacora->guardar();
      retornarWebService( $_POST["url"], $resultado );
  }

  //Mostrar todas las solicitudes
  // if( $_POST["webService"] == "institucionesActivas" )
  // {
  //   $aux = new Utileria( );
  //   $institucion = new Institucion();
  //   $instituciones = $institucion->consultarTodos();
  //   if(!empty( $instituciones["data"])){
  //     $resultado = $instituciones["data"];
  //     $tabla = "";
  //     foreach ($resultado as $key => $value) {
  //         $txt_aux = "?institucion=".$value["id"];
  //         $espacio = "&nbsp;";
  //         $nombre = $value["nombre"];
  //         $repre = new Usuario();
  //         $id_persona = $repre->consultarPor("usuarios",array("id"=>$value["usuario_id"]),"persona_id");
  //         if( sizeof($id_persona["data"]) > 0 ){
  //           $id_persona = $id_persona["data"][0]["persona_id"];
  //           $persona = new Persona();
  //           $nombre_representante = $persona->consultarPor("personas",array("id"=>$id_persona),"*");
  //           $nombre_representante = $nombre_representante["data"][0];
  //         }
  //         $representante = $nombre_representante["nombre"]." ".$nombre_representante["apellido_paterno"]. " ". $nombre_representante["apellido_materno"];
  //         $autorizado =  $value["es_nombre_autorizado"]==0 ? "<a  class='enlace' href='autorizar-institucion.php'>No</a>" : "Si";
  //         $acciones = "<a class='enlace' href='ver-planteles.php".$txt_aux."'>Ver planteles</a>";
  //         $tabla.='{
  //               "nombre":"'.$nombre.'",
  //               "representante":"'.$representante.'",
  //               "autorizado":"'.$autorizado.'",
  //               "acciones":"'.$acciones.'"
  //             },';
  //     }
  //     $tabla = substr($tabla,0, strlen($tabla) - 1);
  //     echo '{"data":['.$tabla.']}';
  //
  //
  //   }else{
  //     $resultado["status"] = "204";
  //     $resultado["message"] = "No content";
  //     $resultado["data"] = "";
  //   }
  //
  //
  // }

  //Web service para graficas
  if($_POST["webService"]=="solictiudesInstitucion")
  {
    $resultado["data"] = [];
    $parametros = array( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $institucion = new Institucion();
    $institucion->setAttributes(array("id"=>$_POST["id"]));
    $instituto = $institucion->consultarId();
    $instituto = $instituto["data"];
    $estatus = new EstatusSolicitud();
    $res_estatus = $estatus->consultarTodos();
    if(sizeof($res_estatus["data"])>0)
    {
      $total = 0;
      $res_estatus = $res_estatus["data"];
        if($_POST["filtro"]==2)
        {
          foreach ($res_estatus as  $value)
          {
            $temp = new Solicitud();
            $res_temp = $temp->consultarPor("solicitudes",array("estatus_solicitud_id"=>$value["id"],"usuario_id"=>$instituto["usuario_id"],"deleted_at"),"*");
            $solicitudes[] = array(
                'estatus'   => $value["nombre"],
                'cantidad'  => count($res_temp["data"])
              );
            $total += count($res_temp["data"]);
          }
          $resultado["total"] = $total;
          $resultado["institucion"] = $instituto["nombre"];
          $resultado["data"] = $solicitudes;
        }
        if($_POST["filtro"]==1)
        {
          $solicitudes[1] = array('estatus'=>'RECHAZADAS','cantidad'=>0);
          $solicitudes[0] = array('estatus'=>'COMPLETADAS','cantidad'=>0);
          $solicitudes[2] = array('estatus'=>'EN PROCESO','cantidad'=>0);

          foreach ($res_estatus as  $value)
          {
            $temp = new Solicitud();
            $res_temp = $temp->consultarPor("solicitudes",array("estatus_solicitud_id"=>$value["id"],"usuario_id"=>$instituto["usuario_id"],"deleted_at"),"*");
            if($value["id"] == 100)
            {
              $solicitudes[1]["cantidad"] += count($res_temp["data"]);
            }else if($value["id"] == 11)
            {
              $solicitudes[0]["cantidad"] += count($res_temp["data"]);

            }else
            {
              $solicitudes[2]["cantidad"] += count($res_temp["data"]);
            }
            $total += count($res_temp["data"]);
          }
          $resultado["total"] = $total;
          $resultado["institucion"] = $instituto["nombre"];
          $resultado["data"] = $solicitudes;
        }

      }
      //var_dump($resultado);
    retornarWebService("",$resultado);

  }

  //Obtener las solicitudes en proceso, terminads y rechazadas por insitución
  if($_POST["webService"]=="numeroSolicitudesInstitucion")
  {

    $solicitud = new Solicitud();
    if($_SESSION["rol_id"]==3)
    {
      $usuario_id = $_SESSION["id"];

    }
    if($_SESSION["rol_id"]==4)
    {
      $usuario = new Usuario();
      $representante = $usuario->consultarPor("usuario_usuarios",array("secundario_id"=>$_SESSION["id"],"deleted_at"),"*");
      $usuario_id = $representante["data"][0]["principal_id"];
    }
    $solicitudes = $solicitud->consultarPor("solicitudes",array("usuario_id"=>$usuario_id,"deleted_at"),"*");
    $resultado["data"] = [];
    $proceso = 0;
    $terminadas = 0;
    $rechazadas = 0;
    if(sizeof($solicitudes["data"])>0)
    {
      $solicitudes = $solicitudes["data"];
      foreach ($solicitudes as $key => $value)
      {
        if($value["estatus_solicitud_id"]==11)
        {
          $terminadas++;
        }
        if($value["estatus_solicitud_id"]!=100 && $value["estatus_solicitud_id"]!=11)
        {
          $proceso++;
        }
        if($value["estatus_solicitud_id"]==100)
        {
          $rechazadas++;
        }
      }
      $resultado["data"]["proceso"] = $proceso;
      $resultado["data"]["terminadas"] = $terminadas;
      $resultado["data"]["rechazadas"] = $rechazadas;
    }
    retornarWebService("",$resultado);

  }

  //Web service para graficas
  if($_POST["webService"]=="solictiudesPorInstitucion")
  {
    $resultado["data"] = [];
    $estatus = new EstatusSolicitud();
    $res_estatus = $estatus->consultarTodos();
    if(sizeof($res_estatus["data"])>0)
    {
      $total = 0;
      $res_estatus = $res_estatus["data"];
        if($_POST["filtro"]==2)
        {
          foreach ($res_estatus as  $value)
          {
            $temp = new Solicitud();
            $res_temp = $temp->consultarPor("solicitudes",array("estatus_solicitud_id"=>$value["id"],"usuario_id"=>$_SESSION["id"],"deleted_at"),"*");
            $solicitudes[] = array(
                'estatus'   => $value["nombre"],
                'cantidad'  => count($res_temp["data"])
              );
            $total += count($res_temp["data"]);
          }
          $resultado["total"] = $total;
          $resultado["data"] = $solicitudes;
        }
        if($_POST["filtro"]==1)
        {
          $solicitudes[1] = array('estatus'=>'RECHAZADAS','cantidad'=>0);
          $solicitudes[0] = array('estatus'=>'COMPLETADAS','cantidad'=>0);
          $solicitudes[2] = array('estatus'=>'EN PROCESO','cantidad'=>0);

          foreach ($res_estatus as  $value)
          {
            $temp = new Solicitud();
            $res_temp = $temp->consultarPor("solicitudes",array("estatus_solicitud_id"=>$value["id"],"usuario_id"=>$_SESSION["id"],"deleted_at"),"*");
            if($value["id"] == 100)
            {
              $solicitudes[1]["cantidad"] += count($res_temp["data"]);
            }else if($value["id"] == 11)
            {
              $solicitudes[0]["cantidad"] += count($res_temp["data"]);

            }else
            {
              $solicitudes[2]["cantidad"] += count($res_temp["data"]);
            }
            $total += count($res_temp["data"]);
          }
          $resultado["total"] = $total;
          $resultado["data"] = $solicitudes;
        }

      }
    retornarWebService("",$resultado);

  }
?>
