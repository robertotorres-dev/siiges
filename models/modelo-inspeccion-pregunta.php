<?php
  /**
  * Clase que gestiona métodos de la tabla inspecciones
  */

  require_once "base-catalogo.php";

	define( "INSPECCION_PREGUNTAS", "inspeccion_preguntas" );

  class InspeccionPregunta extends Catalogo
  {
    protected $id;
    protected $pregunta;
    protected $id_inspeccion_tipo_pregunta;
    protected $id_inspeccion_apartado;
    protected $id_inspeccion_categoria;

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
      $resultado = parent::consultarTodosCatalogo( INSPECCION_PREGUNTAS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( INSPECCION_PREGUNTAS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( INSPECCION_PREGUNTAS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( INSPECCION_PREGUNTAS );
			return $resultado;
    }


  }
?>
