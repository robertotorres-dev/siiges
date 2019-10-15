<?php
  /**
  * Clase que gestiona métodos de la tabla programa_evaluaciones
  */

  require_once "base-catalogo.php";

	define( "TABLA_PROGRAMA_EVALUACIONES", "programa_evaluaciones" );

  class ProgramaEvaluacion extends Catalogo
  {
    protected $id;
    protected $programa_id;
    protected $cumplimiento_id;
    protected $evaluador_id;
    protected $estatus;
    protected $fecha;
    protected $cumplimiento;
    protected $valoracion;
    protected $numero;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_PROGRAMA_EVALUACIONES );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_PROGRAMA_EVALUACIONES );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_PROGRAMA_EVALUACIONES );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_PROGRAMA_EVALUACIONES );
			return $resultado;
    }


  }
?>
