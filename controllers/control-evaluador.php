<?php
  /**
  * Archivo que gestiona los web services de la clase Evaluador
  */

  require_once "../models/modelo-evaluador.php";
  require_once "../utilities/utileria-general.php";
  require_once "../models/modelo-persona.php";
  require_once "../models/modelo-evaluador.php";
  require_once "../models/modelo-evaluador-modalidad.php";
  require_once "../models/modelo-evaluacion-proceso.php";
  require_once "../models/modelo-institucional.php";
  require_once "../models/modelo-formacion.php";
  require_once "../models/modelo-experiencia.php";
  require_once "../models/modelo-asociacion.php";
  require_once "../models/modelo-perfil.php";
  require_once "../models/modelo-documento.php";
  require_once "../models/modelo-usuario.php";
  require_once "../models/modelo-bitacora.php";

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
    $obj = new Evaluador( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluadores","accion"=>"consultarTodos","lugar"=>"control-evaluador"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Evaluador();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluadores","accion"=>"consultarId","lugar"=>"control-evaluador"]);
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
		$obj = new Evaluador( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluadores","accion"=>"guardar","lugar"=>"control-evaluador"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Evaluador( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluadores","accion"=>"eliminar","lugar"=>"control-evaluador"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para guardar el curriculum del evaluador
  if( $_POST["webService"]=="guardarCurriculum" )
  {
    $obj = new Evaluador( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $parametrosPersona =[];
    $parametrosEvaluador =[];
    $modalidades;
    $procesosEvaluacion = array();
    $parametrosInstitucional =[];
    $formaciones;
    $experiencias;
    $asociaciones;
    $errores="";
    //Atributos para guardar
    foreach ($_POST as $atributo => $valor) {
      if($valor == "null"){
        $valor = null;
      }
      if(strstr($atributo, '-', true) == "PERSONA" ){
        $parametrosPersona[substr(strstr($atributo, '-'),1)]= $valor;
      }
      if(strstr($atributo, '-', true) == "EVALUADOR" ){
        $parametrosEvaluador[substr(strstr($atributo, '-'),1)]=$valor;
      }
      if( $atributo == "RCEA"  && $valor != ""){
         $procesosEvaluacion["RCEA"] = $valor;
      }
      if( $atributo == "CIIES" && $valor != "" ){
         $procesosEvaluacion["CIIES"] = $valor;
      }
      if( $atributo == "COEPES"  && $valor != "" ){
         $procesosEvaluacion["COEPES"] = $valor;
      }
      if( $atributo == "CONACYT" && $valor != "" ){
        $procesosEvaluacion["CONACYT"] = $valor;
      }
      if(strstr($atributo, '-', true) == "INSTITUCIONAL" ){
        $parametrosInstitucional[substr(strstr($atributo, '-'),1)]=$valor;
      }
      if(strstr($atributo, '-', true) == "FORMACION" ){
        $formaciones = $valor;
      }
      if( $atributo == "EXPERIENCIA" ){
        $experiencias = $valor;
      }
      if( $atributo == "ASOCIACION" ){
        $asociaciones = $valor;
      }
      if(strstr($atributo, '-', true) == "MODALIDADES" ){
        $modalidades = $valor;
      }
    }

    //Proceder al guardado
    if( isset($parametrosPersona) )
    {
      //Subir fotografia
      if($_FILES["PERSONA-fotografia"]["name"]!="")
      {
        $foto = $_FILES["PERSONA-fotografia"];
        $nombre = $parametrosPersona["id"].strrchr( $foto["name"] , '.' );
        $directorio = Documento::$dir_subida."fotos/";
        $uploadFile = $directorio.$nombre;
        // Creacion de direcotrios
        !is_dir($directorio)?mkdir($directorio, 0755):false;
        if(move_uploaded_file($foto['tmp_name'],$uploadFile))
        {
          $parametrosPersona["fotografia"] = "uploads/fotos/".$nombre;
        }
      }

      //Actulizar los datos personales del evaluador
      $persona = new Persona();
      $persona->setAttributes($parametrosPersona);
      $res_persona = $persona->guardar();

      if($res_persona["data"]["id"] > 0)
      {
          //Guardar al evaluador
          $evaluador = new Evaluador();
          $parametrosEvaluador["persona_id"] = $res_persona["data"]["id"];
          $evaluador->setAttributes($parametrosEvaluador);
          $res_evaluador = $evaluador->guardar();
          if($res_evaluador["data"]["id"] > 0)
          {
            $id_evaluador = $res_evaluador["data"]["id"];
          //Guardar las modalidades del evaluador
            if(sizeof($modalidades)>0)
            {
              foreach ($modalidades as $posicion => $valor)
              {
                  $modalidad_consulta = new EvaluadorModalidad ();
                  $modalidad_existe = $modalidad_consulta->consultarPor("evaluadores_modalidades",array("evaluador_id"=>$id_evaluador,"modalidad_id"=>$valor),"id");
                  if(sizeof($modalidad_existe["data"])>0)
                  {
                    $id = $modalidad_existe["data"][0]["id"];
                  }else{
                    $modalidad = new EvaluadorModalidad();
                    $modalidad->setAttributes(array("evaluador_id"=>$id_evaluador,"modalidad_id"=>$valor));
                    $res_modalidad = $modalidad->guardar();
                    if($res_modalidad["data"]["id"] == 0 )
                    {
                      $errores .= "MODALIDADES - error al guardar";
                    }
                  }
              }
            }
            $perfiles = $_POST["PERFILES"];
            foreach ($perfiles as $posicionPerfil => $perfil) {
              if($perfil["aplica"] != "")
              {
                var_dump($perfil);
                $objPerfil = new Perfil();
                $parametrosPerfil["id"] = $perfil["id"];
                $parametrosPerfil["evaluador_id"] =$id_evaluador;
                $parametrosPerfil["nombre"] = $posicionPerfil;
                $parametrosPerfil["aplica"] = $perfil["aplica"];
                $parametrosPerfil["fecha"] = $perfil["fecha"];
                $objPerfil->setAttributes($parametrosPerfil);
                $res_perfil = $objPerfil->guardar();
                if ($res_perfil["data"]["id"] ==0){
                  $errores .= "PERFIL". $posicionPerfil." - error al guardar";
                }
              }
            }
          //Guardar procesos de evaluación
           foreach ($procesosEvaluacion as $indice => $campos) {
              if($campos["descripcion"]!="")
              {
                $proceso_evaluacion = new EvaluacionProceso();
                $parametros_temp = $campos;
                $parametros_temp["evaluador_id"] = $id_evaluador;
                $parametros_temp["registro"] = $indice;
                $parametros_temp["tipo_proceso"] = $proceso_evaluacion::ACREDITACIONCV;
                $proceso_evaluacion->setAttributes($parametros_temp);
                $res_temp = $proceso_evaluacion->guardar();
                echo "Procesos de evaluacion: ";
                var_dump($res_temp);
                echo "<br><br>";
                if($res_temp["data"]["id"]==0)
                {
                  $errores .= "PROCESOS DE EVALUACIÓN ".$indice." - no se pudo guardar";
                }
              }
            }
          // Guardar Instituconales
           if($parametrosInstitucional["institucion"] !="")
           {
             $institucional = new Institucional();
             $parametrosInstitucional["evaluador_id"] =$id_evaluador;
             $institucional->setAttributes($parametrosInstitucional);
             $res_institucional = $institucional->guardar();
             echo "INSITUCIONAL: ";
             var_dump($res_institucional);
             echo "<br><br>";
             if($res_institucional["data"]["id"]==0)
             {
              $errores .= "INSTITUCIONAL - error al guardar";
             }
           }
           //Formaciones
           if(isset($formaciones))
           {
             foreach ($formaciones as $formacion) {

               $formacion = str_replace('\\', '', $formacion);
               $formacion = json_decode(  $formacion);
               if(isset($formacion->borrar) && $formacion->borrar==1)
               {
                 $formacionEliminar = new Formacion();
                 $formacionEliminar->setAttributes(array("id"=>$formacion->id));
                 $formacionEliminar->eliminar();
               }else{
                 $temp_formacion = new Formacion();
                 $parametosFormacion["id"] = $formacion->id;
                 $parametosFormacion["persona_id"] = $parametrosPersona["id"];
                 $parametosFormacion["nombre"] = $formacion->nombre;
                 $parametosFormacion["nivel"] = $formacion->nivel;
                 $parametosFormacion["fecha_graduado"] = $formacion->fecha_graduado;
                 $temp_formacion->setAttributes($parametosFormacion);
                 $res_formacion = $temp_formacion->guardar();
                 if($res_formacion["data"]["id"] == 0)
                 {
                   $errores .= "FORMACIÓN - error a guardar";
                 }
               }
             }
           }
           //Experiencias académicas
           $trayectorias = $experiencias["trayectoria"];
           foreach ($trayectorias as $trayectoria) {
             if($trayectoria["nombre"]!=""){
             $experiencia_academica = new Experiencia();
             $atributos_temp = $trayectoria;
             $atributos_temp["persona_id"] = $parametrosPersona["id"];
             $atributos_temp["tipo"] = $experiencia_academica::EXPERIENCIA_DOCENTE;
             $experiencia_academica->setAttributes($atributos_temp);
             $res_experiencia_academica = $experiencia_academica->guardar();
             echo "Trayectorias: ";
             // var_dump($res_experiencia_academica);
             echo "<br><br>";
             if($res_experiencia_academica["data"]["id"] == 0)
             {
               $errores .= "EXPERIENCIA - error a guardar";
             }
             }
           }

           //Experiencias profesionales
           $profesionales = $experiencias["profesional"];
           foreach ($profesionales as $profesional) {
             if($profesional["nombre"]!="" ) {
               $experiencia_profesional = new Experiencia();
               $atributos_temporal = $profesional;
               $atributos_temporal["persona_id"] = $parametrosPersona["id"];
               $atributos_temporal["tipo"] = $experiencia_profesional::EXPERIENCIA_PROFECIONAL;
               $experiencia_profesional->setAttributes($atributos_temporal);
               $res_experiencia_profesional = $experiencia_profesional->guardar();
               // echo "Experiencias profesionales: ";
               // var_dump($res_experiencia_profesional);
               // echo "<br><br>";
               if($res_experiencia_profesional["data"]["id"] == 0)
               {
                 $errores .= "EXPERIENCIA - error a guardar";
               }
             }
           }
           //Asociaciones
           foreach ($asociaciones as $indiceAs => $asociacion) {
             if($asociacion["nombre"] !="")
             {
               $objAsociacion = new Asociacion();
               $atributos_asociacion = $asociacion;
               $atributos_asociacion["evaluador_id"] = $id_evaluador;
               $objAsociacion->setAttributes($atributos_asociacion);
               $res_asociacion = $objAsociacion->guardar();
               // echo "ASOCIACIONES: ";
               // var_dump($res_asociacion);
               // echo "<br><br>";
               if($res_asociacion["data"]["id"]==0)
               {
                 $errores .= "ASOCIACION - error al guardar";
               }
             }
           }

          }else
          {
            $errores .= "Evaluador - error al guardar";
          }

      }else
      {
        $errores .= "PERSONA - error al guardar";
      }

    }else
    {
      $errores .= "No se puede guardar intente de nuevo";
    }
    $resultado["status"] = "200";
    $resultado["message"] = "OK";
    $resultado["data"] = "";

    if( $errores != "")
    {
      $resultado["data"] = $errores;
    }

    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluadores","accion"=>"guardarCurriculum","lugar"=>"control-evaluador"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  //web service para obtenr los datos del cv
  if($_POST["webService"]=="datosCurriculum")
  {

    $evaluador = new Evaluador();
    if($_POST["opcionD"]==0)
    {
      session_start();
      $id_persona = $_SESSION["persona_id"];
      $resultado = $evaluador->informacionRelacionada($id_persona);
    }else {
      $resultado = $evaluador->informacionRelacionada($_POST["opcionD"]);
    }
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluadores","accion"=>"datosCurriculum","lugar"=>"control-evaluador"]);
      $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );
  }
  //Web service para obtener a los evaluadores
  if ( $_POST["webService"]="evaluadores")
  {
    $usuario = new Usuario();
    $usuarios = $usuario->consultarPor("usuarios",array("rol_id"=>5),"*");
    $evaluadores = array();
    if( sizeof($usuarios["data"]) > 0 )
    {
      $usuarios = $usuarios["data"];
      foreach ($usuarios as $posicion => $campos) {
        $usuario = new Usuario();
        $usuario->setAttributes(array("id"=>$campos["id"]));
        $res_usuario = $usuario->consultarId();
        $evaluador = new Usuario();
        $res_evaluador = $evaluador->consultarPor("evaluadores",array("persona_id"=>$res_usuario["data"]["persona_id"]),"*");
        if($res_evaluador["data"][0]["id"]!=1)
        {
          $temp["usuario"] = $res_usuario["data"];
          $temp["evaluador"] = $res_evaluador["data"][0];
          $temp["evaluaciones_pendientes"] = 0;
          $temp["evaluaciones_terminadas"] = 0;
          $pendiente = new Usuario();
          $pendientes = $pendiente->consultarPor("programa_evaluaciones",array("evaluador_id"=>$res_evaluador["data"][0]["id"],"estatus"=>1),"*");
          if(sizeof($pendientes["data"])>0)
          {
            $temp["evaluaciones_pendientes"] = sizeof($pendientes["data"]);
          }
          $terminada = new Usuario();
          $terminadas = $terminada->consultarPor("programa_evaluaciones",array("evaluador_id"=>$res_evaluador["data"][0]["id"],"estatus"=>2),"*");
          if(sizeof($terminadas["data"])>0)
          {
            $temp["evaluaciones_terminadas"] = sizeof($terminadas["data"]);
          }
          array_push($evaluadores,$temp);
        }
      }

      if(sizeof($evaluadores)>0)
      {
        $tabla = "";
        $espacio = "&nbsp;&nbsp;&nbsp;";
        foreach ($evaluadores as $indice => $valores) {
          $json = [];
          $nombre =  $valores["usuario"]["persona"]["nombre"]." ".$valores["usuario"]["persona"]["apellido_paterno"]." ".$valores["usuario"]["persona"]["apellido_materno"];
          $json["id"] = $valores["evaluador"]["id"];
          $json["nombre"] = $nombre;
          $json = json_encode($json);
          $activas = $valores["evaluaciones_pendientes"];
          $realizadas = $valores["evaluaciones_terminadas"];
          $acciones =  "<a target='_blank' href='curriculum.php?opcion=2&evaluador=".$valores["usuario"]["persona"]["id"]."'><span class='glyphicon glyphicon-eye-open'></span></a>".$espacio."<a href='#' onclick='Evaluacion.confirmarAsignacion(".htmlentities($json).")'><span class='glyphicon glyphicon-plus'></span></a>";


          $tabla.='{
                "nombre":"'.$nombre.'",
                "activas":"'.$activas.'",
                "realizadas":"'.$realizadas.'",
                "acciones":"'.$acciones.'"
              },';

        }
          $tabla = substr($tabla,0, strlen($tabla) - 1);
          echo '{"data":['.$tabla.']}';
      }else {
        $resultado = array(
       "status"=>"204",
       "message"=>"No Content",
       "data"=> "" );
       // Registro en bitacora
         $bitacora = new Bitacora();
         $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
         $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"evaluadores","accion"=>"evaluadores","lugar"=>"control-evaluador"]);
         $result = $bitacora->guardar();
       retornarWebService( $_POST["url"], $resultado );
      }
    }
  }
?>
