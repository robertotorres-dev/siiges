<?php
  /**
  * Clase que gestiona métodos de la tabla plantel_dictamenes
  */

  require_once "base-catalogo.php";

	define( "TABLA_PLANTEL_DICTAMEN", "plantel_dictamenes" );

  class PlantelDictamen extends Catalogo
  {
    protected $id;
    protected $plantel_id;
    protected $nombre;
    protected $fecha_emision;
    protected $autoridad;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_PLANTEL_DICTAMEN );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_PLANTEL_DICTAMEN );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_PLANTEL_DICTAMEN );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_PLANTEL_DICTAMEN );
			return $resultado;
    }


  }
?>
