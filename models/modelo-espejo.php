<?php
  /**
  * Clase que gestiona métodos de la tabla espejos
  */

  require_once "base-catalogo.php";

	define( "TABLA_ESPEJO", "espejos" );

  class Espejo extends Catalogo
  {
    protected $id;
    protected $mixta_noescolarizada_id;
    protected $proveedor;
    protected $ancho_banda;
    protected $ubicacion;
    protected $periodicidad;
    protected $url_espejo; //Se cambio de url a url_espejo

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
      $resultado = parent::consultarTodosCatalogo( TABLA_ESPEJO );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_ESPEJO );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_ESPEJO );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_ESPEJO );
			return $resultado;
    }


  }
?>
