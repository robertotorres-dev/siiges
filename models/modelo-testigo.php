<?php
  /**
  * Clase que gestiona métodos de la tabla testigos
  */

  require_once "base-catalogo.php";

	define( "TABLA_TESTIGOS", "testigos" );

  class Testigo extends Catalogo
  {
    protected $id;
    protected $persona_id;
    protected $inspeccion_id;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_TESTIGOS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_TESTIGOS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_TESTIGOS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_TESTIGOS );
			return $resultado;
    }


  }
?>
