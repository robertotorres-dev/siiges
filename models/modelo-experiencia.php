<?php
  /**
  * Clase que gestiona métodos de la tabla experiencias
  * TIpos de experiencias 1=DOCENTE, 2=PROFESIONAL, 3=DIRECTIVA.
  *
  */

  require_once "base-catalogo.php";

	define( "TABLA_EXPERIENCIA", "experiencias" );

  class Experiencia extends Catalogo
  {
    protected $id;
    protected $persona_id;
    protected $tipo;
    protected $nombre;
    protected $funcion;
    protected $institucion;
    protected $periodo;

    const EXPERIENCIA_DOCENTE = 1;
    const EXPERIENCIA_PROFECIONAL = 2;
    const EXPERIENCIA_DIRECTIVA = 3;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_EXPERIENCIA );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_EXPERIENCIA );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_EXPERIENCIA );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_EXPERIENCIA );
			return $resultado;
    }


  }
?>
