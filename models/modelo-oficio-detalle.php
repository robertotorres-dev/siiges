<?php
  /**
  * Clase que gestiona métodos de la tabla inspecciones
  */

  require_once "base-catalogo.php";

	define( "TABLA_OFICIO_DETALLES", "oficio_detalles" );

  class OficioDetalle extends Catalogo
  {
    protected $id;
    protected $oficio_id;
    protected $propiedad;
    protected $detalle;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_OFICIO_DETALLES );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_OFICIO_DETALLES );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_OFICIO_DETALLES );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_OFICIO_DETALLES );
			return $resultado;
    }


  }
?>
