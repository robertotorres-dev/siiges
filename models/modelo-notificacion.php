<?php
  /**
  * Clase que gestiona métodos de la tabla notificaciones
  */

  require_once "base-catalogo.php";

	define( "TABLA_NOTIFICACIONES", "notificaciones" );

  class Notificacion extends Catalogo
  {
    protected $id;
		protected $usuario_id;
    protected $titulo;
    protected $mensaje;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_NOTIFICACIONES );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_NOTIFICACIONES );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_NOTIFICACIONES );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_NOTIFICACIONES );
			return $resultado;
    }


		// Método para consultar notificaciones por usuario
    public function consultarNotificacionesIdUsuario( )
    {
      $sql = "select * from " . TABLA_NOTIFICACIONES . " where usuario_id='$this->usuario_id' and deleted_at is null order by id";
			
			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }
  }
?>
