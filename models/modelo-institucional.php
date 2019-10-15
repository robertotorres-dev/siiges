<?php
  /**
  * Clase que gestiona métodos de la tabla institucionales
  */

  require_once "base-catalogo.php";

	define( "TABLA_INSTITUCIONAL", "institucionales" );

  class Institucional extends Catalogo
  {
    protected $id;
    protected $evaluador_id;
    protected $nombre;
    protected $nombramiento;
    protected $departamento;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_INSTITUCIONAL );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_INSTITUCIONAL );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_INSTITUCIONAL );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_INSTITUCIONAL );
			return $resultado;
    }


  }
?>
