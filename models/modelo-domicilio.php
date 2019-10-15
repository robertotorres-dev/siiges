<?php
  /**
  * Clase que gestiona métodos de la tabla domicilios
  */

  require_once "base-catalogo.php";

	define( "TABLA_DOMICILIOS", "domicilios" );

  class Domicilio extends Catalogo
  {
    protected $id;
    protected $calle;
    protected $numero_exterior;
    protected $numero_interior;
    protected $colonia;
    protected $municipio;
    protected $estado;
    protected $codigo_postal;
    protected $pais;
    protected $latitud;
    protected $longitud;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_DOMICILIOS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_DOMICILIOS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_DOMICILIOS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_DOMICILIOS );
			return $resultado;
    }


  }
?>
