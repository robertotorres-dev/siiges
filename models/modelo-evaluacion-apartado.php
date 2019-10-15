<?php
  /**
  * Clase que gestiona métodos de la tabla evaluacion_apartados
  */

  require_once "base-catalogo.php";

	define( "TABLA_EVALUACION_APARTADO", "evaluacion_apartados" );

  class EvaluacionApartado extends Catalogo
  {
    protected $id;
    protected $nombre;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_EVALUACION_APARTADO );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_EVALUACION_APARTADO );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_EVALUACION_APARTADO );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_EVALUACION_APARTADO );
			return $resultado;
    }


  }
?>
