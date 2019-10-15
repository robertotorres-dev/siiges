<?php
  /**
  * Clase que gestiona métodos de la tabla evaluacion_procesos
  */

  require_once "base-catalogo.php";

	define( "TABLA_PROCESOS_EVALUACION", "evaluacion_procesos" );

  class EvaluacionProceso extends Catalogo
  {
    protected $id;
    protected $evaluador_id;
    protected $registro;
    protected $tipo_proceso;
    protected $descripcion;

    const ACREDITACIONCV= 1;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_PROCESOS_EVALUACION );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_PROCESOS_EVALUACION );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_PROCESOS_EVALUACION );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_PROCESOS_EVALUACION );
			return $resultado;
    }


  }
?>
