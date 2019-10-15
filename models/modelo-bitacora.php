<?php
  /**
  * Clase que gestiona métodos de la tabla bitacoras
  */

  require_once "base-catalogo.php";

	define( "TABLA_BITACORAS", "bitacoras" );

  class Bitacora extends Catalogo
  {
    protected $id;
    protected $usuario_id;
    protected $entidad;
    protected $accion;
    protected $lugar;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_BITACORAS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_BITACORAS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_BITACORAS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_BITACORAS );
			return $resultado;
    }


  }
?>
