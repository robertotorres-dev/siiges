<?php
  /**
  * Clase que gestiona métodos de la tabla usuarios
  */

  require_once "base-catalogo.php";
  require_once "modelo-persona.php";
  require_once "modelo-rol.php";
  require_once "modelo-domicilio.php";
  require_once "modelo-modulo-rol.php";
  require_once "modelo-modulo.php";
	require_once "modelo-notificacion.php";

  define( "TABLA_USUARIOS", "usuarios" );

  class Usuario extends Catalogo
  {
    protected $id;
    protected $persona_id;
    protected $rol_id;
    protected $usuario;
		protected $contrasena;
		protected $estatus;
		protected $token_notificaciones;

    const USUARIO_BAJA = 0;
    const USUARIO_REGISTRADO = 1;
    const USUARIO_ACTIVADO = 2;
    const USUARIO_REGULAR = 3;

    const USUARIO_WEBSERVICE = -1;

    public static $USUARIO_ESTATUS = [
      0 => "BAJA" ,
      1 => "REGISTRADO" ,
      2 => "ACTIVADO",
      3 => "REGULAR"
    ];


		// Constructor
		public function __construct( )
    {
      parent::__construct( );
    }


		// Función para asignar atributos de la clase
    public function setAttributes( $parametros = array( ) )
    {
      foreach( $parametros as $atributo=>$valor )
			{
        $this->{$atributo} = $valor;
      }
    }


		// Método para consultar todos los registros
    public function consultarTodos( )
    {
      $resultado = parent::consultarTodosCatalogo( TABLA_USUARIOS );

			if( $resultado["status"]!="404" )
			{
				foreach( $resultado["data"] as $clave=>$usuario )
				{
					if(	$usuario["persona_id"] )
					{
						$persona = new Persona( );
						$persona->setAttributes( ["id"=>$usuario["persona_id"]] );
						$resultadoPersona = $persona->consultarId( );
						$resultado["data"][$clave]["persona"] = $resultadoPersona["data"];
						unset( $persona );
					}
					if( $usuario["rol_id"] )
					{
						$rol = new Rol( );
						$rol->setAttributes( ["id"=>$usuario["rol_id"]] );
						$resultadoRol = $rol->consultarId( );
						$resultado["data"][$clave]["rol"] = $resultadoRol["data"];
						unset( $rol );
					}
				}
			}

			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_USUARIOS );
			if( $resultado["status"]!="404" )
			{
				if(	$resultado["data"]["persona_id"] )
				{
					$persona = new Persona( );
					$persona->setAttributes( ["id"=>$resultado["data"]["persona_id"]] );
					$resultadoPersona = $persona->consultarId( );
					$resultado["data"]["persona"] = $resultadoPersona["data"];
					unset( $persona );
				}
				if( $resultado["data"]["rol_id"] )
				{
					$rol = new Rol( );
					$rol->setAttributes( ["id"=>$resultado["data"]["rol_id"]] );
					$resultadoRol = $rol->consultarId( );
					$resultado["data"]["rol"] = $resultadoRol["data"];
					unset( $rol );
				}
			}

			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			if( $this->contrasena )
			{
        $this->contrasena = md5( $this->contrasena );
      }

			$resultado = parent::guardarCatalogo( TABLA_USUARIOS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_USUARIOS );
			return $resultado;
    }


		// Método para validar inicio de sesión
		public function validarInicioSesion( )
    {
      $this->contrasena = md5( $this->contrasena );

			/*
			$consulta = "select * from " . TABLA_USUARIOS . " where binary usuario=? and binary contrasena=? and estatus>1 and deleted_at is null";
			$sql = $this->mysqli->prepare( $consulta );
      $sql->bind_param( "ss", $this->usuario, $this->contrasena );

      if( $sql->execute( ) )
			{
        $res = $sql->get_result( );
				$max = $res->num_rows;
				$sql->close( );
				unset( $sql );
      }
			*/
			
			$sql = "select * from " . TABLA_USUARIOS . " where binary usuario='$this->usuario' and binary contrasena='$this->contrasena' and estatus>1 and deleted_at is null";
			$res = $this->mysqli->query( $sql );
      $max = $res->num_rows;

			$this->id = null;

      if( $max>0 )
      {
				$res->data_seek( 0 );
        $obj = $res->fetch_object( );

				$this->id = $obj->id;
				$this->persona_id = $obj->persona_id;
				$this->rol_id = $obj->rol_id;
				$this->usuario = $obj->usuario;

				if(	$this->persona_id )
				{
					$persona = new Persona( );
					$persona->setAttributes( ["id"=>$this->persona_id] );
					$resultadoPersona = $persona->consultarId( );
					unset( $persona );
				}
        $modulosRoles = array( );
				if( $this->rol_id )
				{
					$rol = new Rol( );
					$rol->setAttributes( ["id"=>$this->rol_id] );
					$resultadoRol = $rol->consultarId( );
					unset( $rol );
          // consulta de los modulos y acciones que cada rol puede ejecutar
          $modulos_roles = new ModuloRol();
          $resultadoModulosRoles = $modulos_roles->consultarPor("modulos_roles",["rol_id"=>$this->rol_id],"*");

          foreach ($resultadoModulosRoles["data"] as $modulo) {
            $modulos = new Modulo();
            $modulos->setAttributes(["id"=>$modulo["modulo_id"]]);
            $RespuestaModulo = $modulos->consultarId();
            $moduloNuevo["modulo_id"] = $modulo["modulo_id"];
            $moduloNuevo["accion"] = $modulo["accion"];
            $moduloNuevo["modulo"]["id"] = $RespuestaModulo["data"]["id"];
            $moduloNuevo["modulo"]["nombre"] = $RespuestaModulo["data"]["nombre"];
            $moduloNuevo["modulo"]["descripcion"] = $RespuestaModulo["data"]["descripcion"];
            array_push($modulosRoles,$moduloNuevo);
          }
        }

				session_start( );
				$_SESSION["id"] = $this->id;
				$_SESSION["persona_id"] = $this->persona_id;
				$_SESSION["rol_id"] = $this->rol_id;
				$_SESSION["usuario"] = $this->usuario;
				$_SESSION["nombre"] = $resultadoPersona["data"]["nombre"];
				$_SESSION["apellido_paterno"] = $resultadoPersona["data"]["apellido_paterno"];
				$_SESSION["apellido_materno"] = $resultadoPersona["data"]["apellido_materno"];
        $_SESSION["nombre_rol"] = $resultadoRol["data"]["descripcion"];
				$_SESSION["modulos"] = $modulosRoles;

				$resultado = array(
				"status"=>"200",
				"message"=>"OK",
				"data"=>array(
					"id"=>$this->id,
					"persona_id"=>$this->persona_id,
					"rol_id"=>$this->rol_id,
					"usuario"=>$this->usuario,
					"persona"=>$resultadoPersona["data"],
					"rol"=>$resultadoRol["data"],
          "modulos"=>$modulosRoles) );
      }
			else
			{
				$resultado = array(
				"status"=>"404",
				"message"=>"Verifique los datos de inicio de sesión.",
				"data"=>"" );
			}

			$res->close( );
      $this->mysqli->close( );
			
			return $resultado;
    }


    // Método para consultar registro por campo usuario
    public function consultarUsuario( $opcion = null )
    {
      /*
			$consulta = "select * from " . TABLA_USUARIOS . " where usuario=? and estatus > 0 ";
      if($opcion)
      {
        $consulta = "select * from " . TABLA_USUARIOS . " where usuario=?";
      }
      $sql = $this->mysqli->prepare( $consulta );
      $sql->bind_param( "s", $this->usuario );

      if( $sql->execute( ) )
			{
        $res = $sql->get_result( );
				$max = $res->num_rows;
				$sql->close( );
				unset( $sql );
      }
			*/
			
			$sql = "select * from " . TABLA_USUARIOS . " where usuario='$this->usuario' and estatus>0 ";
      if( $opcion )
      {
        $sql = "select * from " . TABLA_USUARIOS . " where usuario='$this->usuario'";
      }
			
			$res = $this->mysqli->query( $sql );
      $max = $res->num_rows;

      if( $max>0 )
      {
        $res->data_seek( 0 );
        $obj = $res->fetch_object( );

        $this->id = $obj->id;
        $this->persona_id = $obj->persona_id;
        $this->rol_id = $obj->rol_id;
        $this->usuario = $obj->usuario;

				$resultado = array(
				"status"=>"200",
				"message"=>"OK",
				"data"=>array(
					"id"=>$this->id,
					"persona_id"=>$this->persona_id,
					"rol_id"=>$this->rol_id,
					"usuario"=>$this->usuario ) );
      }
			else
      {
        $resultado = array(
				"status"=>"404",
				"message"=>"No existe el usuario.",
				"data"=>"" );
      }

      $res->close( );
      $this->mysqli->close( );

			return $resultado;
    }


		// Método para reestablecer contraseña
    public function restablecerContrasena( )
    {
      /*
			$consulta = "update " . TABLA_USUARIOS . " set contrasena=? where md5(usuario)=? and estatus > 0";
			$sql = $this->mysqli->prepare( $consulta );
      $sql->bind_param( "ss", $this->contrasena, $this->usuario );

      if( $sql->execute( ) )
			{
        $res = $sql->get_result( );
				$max = $res->num_rows;
				$sql->close( );
				unset( $sql );
      }
			*/
			
			$sql = "update " . TABLA_USUARIOS . " set contrasena='$this->contrasena' where md5(usuario)='$this->usuario' and estatus>0";
			$res = $this->mysqli->query( $sql );
      $max = $res->num_rows;
			
			$this->mysqli->close( );
			
			return $resultado;
    }


    // Método para consultar todos los registros no borrados
    public function consultarNoBorrados( )
    {
      $usuarios = parent::consultarTodosCatalogo( TABLA_USUARIOS );
      $resultado = [];

      foreach( $usuarios["data"] as $usuario )
      {
        if(	$usuario["persona_id"] )
        {
          $persona = new Persona( );
          $persona->setAttributes( ["id"=>$usuario["persona_id"]] );
          $resultadoPersona = $persona->consultarId( );
          $usuario["persona"] = $resultadoPersona;

          unset( $persona );
        }
        if( $usuario["rol_id"] )
        {
          $rol = new Rol( );
          $rol->setAttributes( ["id"=>$usuario["rol_id"]] );
          $resultadoRol = $rol->consultarId( );
          $usuario["rol"] = $resultadoRol;
          unset( $rol );
        }
        if( $usuario["deleted_at"] == null )
          array_push( $resultado, $usuario );
      }

      return ["status"=>$usuarios["status"],"message"=>$usuarios["message"],"data"=>$resultado];
    }

    // Método para consultar todos los usuarios de un usuario
    public function consultarUsuariosDeUsuario( )
    {
      $usuarios = new Usuario( );
      $usuarios = $usuarios->consultarPor("usuario_usuarios",["principal_id"=>$this->id],"*");
      $resultado = [];

      foreach( $usuarios["data"] as $registro )
      {
        if(isset($registro["secundario_id"])	&& !empty($registro["secundario_id"]) )
        {
          $usuario = new Usuario( );
          $usuario->setAttributes( ["id"=>$registro["secundario_id"]] );
          $resultadoUsuario = $usuario->consultarId( );
          $registro = $resultadoUsuario["data"];

          unset( $usuario );
          if(	 isset($registro["persona_id"])	&& !empty($registro["persona_id"]))
          {
            $persona = new Persona( );
            $persona->setAttributes( ["id"=>$registro["persona_id"]] );
            $resultadoPersona = $persona->consultarId( );
            $registro["persona"] = $resultadoPersona;
            unset( $persona );
          }

          if( isset($registro["rol_id"])	&& !empty($registro["rol_id"]) )
          {
            $rol = new Rol( );
            $rol->setAttributes( ["id"=>$registro["rol_id"]] );
            $resultadoRol = $rol->consultarId( );
            $registro["rol"] = $resultadoRol;

            unset( $rol );
          }
          if($registro["deleted_at"] == null )
            array_push( $resultado, $registro);
        }
      }

      return ["status"=>$usuarios["status"],"message"=>$usuarios["message"],"data"=>$resultado];
    }


		// Método para enviar notificación por id usuario
    public function notificacionIdUsuario( $usuario_id, $titulo, $mensaje )
    {
      $sql = "select * from " . TABLA_USUARIOS . " where id='$usuario_id' and deleted_at is null";
			$resultado = parent::consultarSQLCatalogo( $sql );

			$resultadoNotificacion = $this->enviarNotificacion( "to", $resultado["data"][0]["token_notificaciones"], $titulo, $mensaje );

			$obj = new Notificacion();
			$obj->setAttributes( array( "usuario_id"=>$usuario_id, "titulo"=>$titulo, "mensaje"=>$mensaje ) );
			$res = $obj->guardar( );

			return array(
			"status"=>"200",
			"message"=>"OK",
			"data"=>$resultadoNotificacion );
		}


		// Método para enviar notificación por id rol o todos
    public function notificacionIdRol( $rol_id, $titulo, $mensaje )
    {
      if( $rol_id==-1 ){
				$sql = "select * from " . TABLA_USUARIOS . " where deleted_at is null";
			}
			else{
				$sql = "select * from " . TABLA_USUARIOS . " where rol_id='$rol_id' and deleted_at is null";
			}

			$resultado = parent::consultarSQLCatalogo( $sql );
			$token = array( );

			foreach( $resultado["data"] as $clave=>$usuario )
			{
				array_push( $token, $resultado["data"][$clave]["token_notificaciones"] );

				$obj = new Notificacion();
				$obj->setAttributes( array( "usuario_id"=>$resultado["data"][$clave]["id"], "titulo"=>$titulo, "mensaje"=>$mensaje ) );
				$res = $obj->guardar( );
			}

			$resultadoNotificacion = $this->enviarNotificacion( "registration_ids", $token, $titulo, $mensaje );

			return array(
			"status"=>"200",
			"message"=>"OK",
			"data"=>$resultadoNotificacion );
		}


		// Método para enviar notificaciones
    public function enviarNotificacion( $destino, $token, $titulo, $mensaje )
    {
      $url = 'https://fcm.googleapis.com/fcm/send';

			$headers = array(
				'Authorization: key=' . "AAAAmKEawcU:APA91bEUku-XQwY83GQgnidjx3Y3_YmQB5-Oa-ax2pXIrrqmprM86Kl6ifl3Z43OGelRj00QXGyEPGxfjApkq0_cJNWcIx0uo4Q339BXON_YYl5WNyNDKyUcLOHjgppsVjSm9ZotJPSR",
				'Content-Type: application/json'
			);

			$fields = array(
			  $destino => $token,
				'notification'=>array( 'title'=>'SIIGES - '.$titulo, 'body'=>$mensaje )
			);

			$fields = json_encode( $fields );

			$ch = curl_init( );
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields );
			$result = curl_exec( $ch );
			curl_close( $ch );

			return $result;
		}
  }
?>
