<?php
  /**
  * Clase que gestiona métodos de la tabla inspecciones
  */

  require_once "base-catalogo.php";

	define( "INSPECCIONES_PREGUNTAS", "inspecciones_inspeccion_preguntas" );

  class InspeccionesPreguntas extends Catalogo
  {
    protected $id;
    protected $inspeccion_id;
    protected $inspeccion_pregunta_id;
    protected $respuesta;

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
      $resultado = parent::consultarTodosCatalogo( INSPECCIONES_PREGUNTAS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( INSPECCIONES_PREGUNTAS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( INSPECCIONES_PREGUNTAS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( INSPECCIONES_PREGUNTAS );
			return $resultado;
    }


  }
?>
