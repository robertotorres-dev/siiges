<?php
  /**
  * Archivo que gestiona los web services de la clase Usuario
  *
  */

  require_once "../models/modelo-usuario.php";
  require_once "../models/modelo-persona.php";
  require_once "../models/modelo-domicilio.php";
  require_once "../models/modelo-rol.php";
  require_once "../models/modelo-usuario-usuarios.php";
  require_once "../models/modelo-plantel.php";
  require_once "../utilities/utileria-general.php";
  require_once "../models/modelo-bitacora.php";
  require_once "../models/modelo-evaluador.php";
  require_once "../models/modelo-inspector.php";

  define('PERSONA_DEFAULT',1);
  define('ROL_DEFAULT',1);
  define('DOMICILIO_DEFAULT',1);
  define('FOTO_DEFAULT','uploads/fotos/img-usuario.png');
  session_start( );
	function retornarWebService( $url, $resultado )
	{

    if( $url!="" )
		{
      //session_start( );
      $_SESSION["resultado"] = json_encode( $resultado );

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
    $obj = new Usuario( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"usuarios","accion"=>"consultarTodos","lugar"=>"control-usuario"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Usuario( );
		$aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"usuarios","accion"=>"consultarId","lugar"=>"control-usuario"]);
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
		$usuario = new Usuario( );
		$usuario->setAttributes( $parametros );
    $resultado = $usuario->guardar( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"usuarios","accion"=>"guardar","lugar"=>"control-usuario"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Usuario( );
		$aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"usuarios","accion"=>"eliminar","lugar"=>"control-usuario"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

	// Web service para validar inicio de sesión
  if( $_POST["webService"]=="validarInicioSesion" )
  {
    $obj = new Usuario( );
		$aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array(
		"usuario"=>$_POST["usuario"],
		"contrasena"=>$_POST["contrasena"] ) );
    $resultado = $obj->validarInicioSesion( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"usuarios","accion"=>"validarInicioSesion","lugar"=>"control-usuario"]);
    $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para solicitar nueva contraseña
  if( $_POST["webService"]=="solicitarNuevaContrasena" )
  {
    $obj = new Usuario( );
		$aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $resultado = $obj->consultarPor("usuarios",array("usuario"=>$_POST["usuario"]),"*" );
    $resultado = $resultado["data"][0];
		// Valida que el usuario exista
    if( $resultado["id"]!=null )
    {
      $persona = new Persona( );
      $persona->setAttributes( array( "id"=>$resultado["persona_id"] ) );
      $resultadoPersona = $persona->consultarId( );

			$destino = $resultadoPersona["data"]["correo"];
			$asunto = "Restablecer acceso SIIGA";
      $usuario = $resultado["usuario"];
			$contrasena = $resultado["contrasena"];
      $enlace = "<a href='https://siiges.com/restablecer-contrasena.php?key=" . md5( $usuario ) . "&reset=" . $contrasena . "'>Click para restablecer su acceso</a>";
      $mensaje = "Este correo fue enviado debido a que se solicito restablecer su acceso a el portal web SIIGA." .
                    "En caso de que usted no lo haya solicitado solo ignore este correo. De caso sontrario de clic en el enlace: " . $enlace;

      $resultado = Utileria::enviarCorreo( $destino, $asunto, $mensaje );
			// Valida que el correo se envió
      if( $resultado )
      {
        $resultado = array( "status"=>"200", "message"=>"Correo enviado", "data"=> $usuario);
      }
			else
      {
        $resultado = array( "status"=>"450", "message"=>"El correo no se pudo enviar", "data"=> $destino);
      }
    }
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"usuarios","accion"=>"solicitarNuevaContrasena","lugar"=>"control-usuario"]);
    $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );
  }

	// Web service para restablecer contraseña
  if( $_POST["webService"]=="restablecerContrasena" )
  {
    $obj = new Usuario( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $obj->setAttributes( array(
		"usuario"=>$_POST["usuario"],
		"contrasena"=>md5($_POST["contrasena"]) ) );
    $resultado = $obj->restablecerContrasena( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"usuarios","accion"=>"restablecerContrasena","lugar"=>"control-usuario"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para guardar registro
  if( $_POST["webService"]=="registro" )
  {
    //session_start();
    $parametros = array( );
		$aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    foreach( $_POST as $atributo=>$valor )
		{
			$parametros[$atributo] = $valor;
		}
    if(isset($_POST["id"]) && $_POST["id"] > 0){
      $usuario = new Usuario( );
  		$usuario->setAttributes( $parametros );
      $resultado= $usuario->guardar( );
      // sobre escribe el id de usuario por el de persona para actualizar la persona
      $usuario = new Usuario( );
      $usuario->setAttributes( ["id"=>$_POST["id"]] );
      $respuesta = $usuario->consultarId();
      unset($usuario);

      $parametros["id"] = $respuesta["data"]["persona_id"];
      $persona = new Persona( );
      $persona->setAttributes( $parametros );
      $resultado["data"]["persona"] = $persona->guardar( );
      $resultado["message"] = "Usuario actualizado exitosamente";

    }else{

      $usuario = new Usuario( );
  		$usuario->setAttributes( $parametros );
      $resultado = $usuario->consultarUsuario('existe');


      if("404" === $resultado['status']){

        $parametros["id"] = null;
        $parametros["fotografia"] = FOTO_DEFAULT;
        $parametros['domicilio_id'] = DOMICILIO_DEFAULT;

        $persona = new Persona( );
        $persona->setAttributes( $parametros );
        $resultadoPersona = $persona->guardar( );
        unset($usuario);

        $parametros["persona_id"] = $resultadoPersona["data"]["id"];
        $parametros['rol_id'] = isset($parametros['rol_id'])?
                                        $parametros['rol_id']:
                                        Rol::ROL_REPRESENTANTE_LEGAL;
        $parametros['estatus'] = (Rol::ROL_ADMIN == $_SESSION["rol_id"] || Rol::ROL_REPRESENTANTE_LEGAL == $_SESSION["rol_id"]) ?
                                  Usuario::USUARIO_ACTIVADO:
                                  Usuario::USUARIO_REGISTRADO;


        $usuario = new Usuario( );
        $usuario->setAttributes( $parametros );
        $resultado = $usuario->guardar( );

        if(isset($parametros['rol_id']) && Rol::ROL_EVALUADOR == $parametros['rol_id']){
          $evaluador = new Evaluador();
          $evaluador->setAttributes(["persona_id"=>$parametros["persona_id"]]);
          $rEvaluador = $evaluador->guardar();
          $resultado["message"] .= isset($rEvaluador["data"])?"":"Error al guardar Evaluador";
        }

        if(isset($parametros['rol_id']) && Rol::ROL_INSPECTOR == $parametros['rol_id']){
          $inspector = new inspector();
          $inspector->setAttributes(["persona_id"=>$parametros["persona_id"]]);
          $rInspector = $inspector->guardar();
          $resultado["message"] .= isset($rInspector["data"])?"":"Error al guardar Inspector";
        }

        $resultado["data"]["tipo"] = "nuevo";
        $resultado["message"] = "El registro fue exitoso";
        if(  Usuario::USUARIO_REGISTRADO == $parametros['estatus']){
          $resultado["message"] .= ", recibirá un correo de confirmación cuando sea activado.";
        }
        unset($usuario);

        if(isset($_SESSION["id"])){

            $usuario = new Usuario( );
            $temp = $usuario->consultarPor("usuarios",["id"=>$_SESSION["id"]],"*");

            if(Rol::ROL_REPRESENTANTE_LEGAL == $temp["data"][0]["rol_id"]){
              $tablaUsuarios = new UsuarioUsuarios();
              $tablaUsuarios->setAttributes(["principal_id"=>$temp["data"][0]["id"],"secundario_id"=>$resultado["data"]["id"]]);
              $respuesta = $tablaUsuarios->guardar();
              $resultado["message"] = "Usuario creado exitosamente";
            }
        }
      }else if(isset($resultado["data"]["usuario"])){
        $remplazos = array("status" => 1062,"message" =>"El usuario: ".$resultado["data"]["usuario"]." ya existe, por favor intente con otro distinto.");
        $resultado = array_replace($resultado,$remplazos);
      }
    }
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"usuarios","accion"=>"registro","lugar"=>"control-usuario"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST['url'], $resultado );
  }

  //Web service que carga los datos del Representante Legal
  if($_POST["webService"]=="datosRepresentante")
  {
    //session_start();
    if( isset( $_SESSION["persona_id"] ) ) {
      $persona = new Persona();
      $persona->setAttributes( array( "id" => $_SESSION["persona_id"] ) );

      if($_SESSION["rol_id"]==4)
      {
        $gestor = new Usuario();
        $representanteGestor = $gestor->consultarPor("usuario_usuarios", array("secundario_id"=>$_SESSION["id"]) , "*");
        $representanteGestor = $representanteGestor["data"][0]["principal_id"];
        $repre = new Usuario();
        $repre->setAttributes(array("id"=>$representanteGestor));
        $res_repre =$repre->consultarId();
        $res_repre = $res_repre["data"];
        $persona->setAttributes( array( "id" => $res_repre["persona_id"] ) );
      }
      $resultado = $persona->consultarId();
      if( sizeof($resultado["data"]) > 0 ){
        $domicilio = new Domicilio();
        $domicilio->setAttributes( array( "id" => $resultado["data"]["domicilio_id"] ) );
        $resultado_temp = $domicilio->consultarId();
        $resultado["data"]["domicilio"] = $resultado_temp["data"];
      }
      // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"usuarios","accion"=>"datosRepresentante","lugar"=>"control-usuario"]);
      $result = $bitacora->guardar();
      retornarWebService( $_POST["url"], $resultado );
    }

  }

  //Web service para obtener a los gestores de un representante legal
  if( $_POST["webService"]=="gestoresPorAsignar" )
  {
    $resultado = array();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $representante = new Usuario( );
    $gestores = $representante->consultarPor( 'usuario_usuarios',  array( "principal_id"=>$_POST["usuario_id"]), 'secundario_id' );
    $gestores = $gestores["data"];
    if(sizeof($gestores)>0){
      foreach ($gestores as $gestor) {
        //Obtener datos de tabla usuarios
        $usuario = new Usuario();
        $temp = $usuario->consultarPor('usuarios', array("id"=>$gestor['secundario_id'],"estatus"=>2), 'persona_id' );
        $temp = $temp["data"];
        if(sizeof($temp)>0){
          $datos['id'] = $gestor['secundario_id'];
          $datos['persona_id'] = $temp[0]['persona_id'];
          //Obtener datos de la tabla personas
          $persona = new Persona();
          $datos_persona = $persona->consultarPor('personas', array("id"=>$datos['persona_id']), '*' );
          $datos['persona'] = $datos_persona["data"];
          array_push($resultado,$datos);
          unset($persona);
        }
      }
      $resultado = array(
        "status"=>"200",
        "message"=>"OK",
        "data"=>$resultado );
    }else{
      $resultado = array(
      "status"=>"200",
      "message"=>"OK",
      "data"=>"No se han registrado gestores");
    }

    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"usuarios","accion"=>"gestoresPorAsignar","lugar"=>"control-usuario"]);
    $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );
  }

  //Web service para obtener la tabla de todos lo usuarios
  if ($_POST["webService"]=="consultarTodosTabla")
  {
    $usuario = new Usuario( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $usuario->setAttributes( array("id"=>$_POST['usuario_id']));
    $usuario =  $usuario->consultarId();
    $usuarioRol = $usuario["data"]["rol_id"];

    if(!Rol::ROL_ADMIN == $usuarioRol && !Rol::ROL_REPRESENTANTE_LEGAL == $usuarioRol){
      echo '{"data":""}';
      exit();
    }
    $usuarios = new Usuario( );
    if(Rol::ROL_ADMIN == $usuarioRol){
      $usuarios = $usuarios->consultarNoBorrados();
    }
    if(Rol::ROL_REPRESENTANTE_LEGAL == $usuarioRol){
      $usuarios->setAttributes(["id"=>$usuario["data"]["id"]]);
      $usuarios = $usuarios->consultarUsuariosDeUsuario();
    }


    $tablas = "";
    $numero ="#";
    $espacio=" ";
    foreach ($usuarios["data"] as $usuario) {
      $estatus_id = isset($usuario['estatus'])?$usuario['estatus']:"";
      if($estatus_id > 1) {
        $estatus = "Activado";
      }else {
        $estatus = "Desactivado";
      }
      $persona = $usuario["persona"]["data"];
      $rol = $usuario["rol"]["data"];

      $usuario_id = $usuario['id'];
      $espacio = "&nbsp;&nbsp;&nbsp;";
      $ver =   Rol::ROL_ADMIN == $usuarioRol?"<a href='ver-usuario.php?id=".$usuario_id."'<span class='glyphicon glyphicon-eye-open'></span></a>":"";
      $editar = "<a href='edicion-usuarios.php?id=".$usuario_id."'><span class='glyphicon glyphicon-pencil'></span></a>";
      $activar = "Activado" == $estatus ? "<div class='desactivar' value='$usuario_id' estatus='$estatus_id' onclick='Usuario.activacion(this)' >Desactivar</div>":"<div class='activar' value='$usuario_id' estatus='$estatus_id' onclick='Usuario.activacion(this)'>Activar</div>";

      $user = isset($usuario["usuario"])?$usuario["usuario"]:"";
      $apellido_paterno = isset($persona["apellido_paterno"])?$persona["apellido_paterno"]:"";
      $apellido_materno = isset($persona["apellido_materno"])?$persona["apellido_materno"]:"";
      $nombre = isset($persona["nombre"])?$persona["nombre"]:"";
      $correo = isset($persona["correo"])?$persona["correo"]:"";
      $rolNombre = isset($rol["nombre"])?$rol["nombre"]:"";
      $creado = isset($usuario["created_at"])?$usuario["created_at"]:"";

      $eliminarDatos = ["id"=>$usuario_id,"usuario"=>$user];
      $eliminar = "<a href='#' onclick='Usuario.datosModal(".htmlentities(json_encode($eliminarDatos)).")'><span class='glyphicon glyphicon-trash'></span></a>";

      $tablas.='{
        "usuario":"'.$user.'",
        "nombre":"'.$apellido_paterno.$espacio.$apellido_materno.$espacio.$nombre.'",
        "correo":"'.$correo.'",
        "rol":"'.$rolNombre.'",
        "creado":"'.$creado.'",
        "estatus":"'.$estatus.'",
        "acciones":"'.$ver.$espacio.$editar.$espacio.$eliminar.$activar.'"
      },';
    }

    $tablas = substr($tablas,0, strlen($tablas) - 1);
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"usuarios","accion"=>"consultarTodosTabla","lugar"=>"control-usuario"]);
    $result = $bitacora->guardar();

    echo '{"data":['.$tablas.']}';
  }

	// Web service para enviar notificación
  if( $_POST["webService"]=="enviarNotificacion" )
  {
    $obj = new Usuario( );
		$obj->setAttributes( array( ) );

		if( $_POST["usuario_id"] ){
		  $resultado = $obj->notificacionIdUsuario( $_POST["usuario_id"], $_POST["titulo"], $_POST["mensaje"] );
		}
		if( $_POST["rol_id"] ){
			$resultado = $obj->notificacionIdRol( $_POST["rol_id"], $_POST["titulo"], $_POST["mensaje"] );
		}

		retornarWebService( $_POST["url"], $resultado );
  }
?>
