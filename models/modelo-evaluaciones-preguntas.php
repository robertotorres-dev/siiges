<?php
  /**
  * Clase que gestiona métodos de la tabla evaluaciones_evaluacion_preguntas
  */

  require_once "base-catalogo.php";

	define( "TABLA_EVALUACIONES_EVALUACION_PREGUNTAS", "evaluaciones_evaluacion_preguntas" );

  class EvaluacionesPreguntas extends Catalogo
  {
    protected $id;
    protected $programa_evaluacion_id;
    protected $evaluacion_pregunta_id;
    protected $escala_id;
    protected $respuesta;
    protected $comentarios;
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
      $resultado = parent::consultarTodosCatalogo( TABLA_EVALUACIONES_EVALUACION_PREGUNTAS );
			return $resultado;
    }

		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_EVALUACIONES_EVALUACION_PREGUNTAS );
			return $resultado;
    }

		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_EVALUACIONES_EVALUACION_PREGUNTAS );
			return $resultado;
    }

		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_EVALUACIONES_EVALUACION_PREGUNTAS );
			return $resultado;
    }


  }
?>
