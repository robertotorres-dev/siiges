<?php
  /**
  * Clase que gestiona métodos de la tabla inspecciones
  */

  require_once "base-catalogo.php";

	define( "TABLA_INSPECCIONES", "inspecciones" );

  class Inspeccion extends Catalogo
  {
    protected $id;
    protected $programa_id;
    protected $estatus_inspeccion_id;
    protected $fecha;
    protected $fecha_asignada;
    protected $resultado;
    protected $folio;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_INSPECCIONES );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_INSPECCIONES );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_INSPECCIONES );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_INSPECCIONES );
			return $resultado;
    }


  }
?>
