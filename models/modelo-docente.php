<?php
  /**
  * Clase que gestiona métodos de la tabla docentes
  */

  require_once "base-catalogo.php";

	define( "TABLA_DOCENTE", "docentes" );

  class Docente extends Catalogo
  {
    protected $id;
    protected $persona_id;
    protected $es_aceptado;
    protected $tipo_docente;
    protected $tipo_contratacion;
    protected $antiguedad;
    protected $experiencias;
    protected $observaciones;

    const DOCENTE_ASIGNATURA = 1;
    const DOCENTE_TIMEPO_COMPLETO = 2;

    public static $TIPO_CONTRATACION = [1=>"Contrato",2=>"Tiempo indefinido",3=>"Otro"];

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
      $resultado = parent::consultarTodosCatalogo( TABLA_DOCENTE );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_DOCENTE );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_DOCENTE );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_DOCENTE );
			return $resultado;
    }


  }
?>
