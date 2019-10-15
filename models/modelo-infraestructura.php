<?php
  /**
  * Clase que gestiona métodos de la tabla infraestructuras
  */

  require_once "base-catalogo.php";

	define( "TABLA_INFRAESTRUCTURA", "infraestructuras" );

  class Infraestructura extends Catalogo
  {
    protected $id;
    protected $plantel_id;
    protected $tipo_instalacion_id;
    protected $solicitud_id;
    protected $ubicacion;
    protected $capacidad;
    protected $metros;
    protected $recursos;
    protected $nombre;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_INFRAESTRUCTURA );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_INFRAESTRUCTURA );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_INFRAESTRUCTURA );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_INFRAESTRUCTURA );
			return $resultado;
    }


  }
?>
