<?php
  /**
  * Clase que gestiona métodos de la tabla niveles
  */

  require_once "base-catalogo.php";

	define( "TABLA_NIVEL", "niveles" );

  class Nivel extends Catalogo
  {
    protected $id;
    protected $nombre;
    protected $descripcion;

    public static $niveles = [1=>"BA",2=>"LI",3=>"DI",4=>"E",5=>"M",6=>"D",7=>"EC"];

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
      $resultado = parent::consultarTodosCatalogo( TABLA_NIVEL );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_NIVEL );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_NIVEL );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_NIVEL );
			return $resultado;
    }


  }
?>
