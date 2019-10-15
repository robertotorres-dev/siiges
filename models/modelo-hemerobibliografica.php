<?php
  /**
  * Clase que gestiona métodos de la tabla hemerobibliograficas
  */

  require_once "base-catalogo.php";

	define( "TABLA_PRINCIPAL", "hemerobibliograficas" );

  class Hemerobibliografica extends Catalogo
  {
    protected $id;
    protected $plantel_id;
    protected $titulo;
    protected $autor;
    protected $ejemplares;
    protected $editorial;
    protected $anio;
    protected $tipo;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_PRINCIPAL );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_PRINCIPAL );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_PRINCIPAL );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_PRINCIPAL );
			return $resultado;
    }


  }
?>
