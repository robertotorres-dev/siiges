<?php
  /**
  * Clase que gestiona métodos de la tabla instituciones
  */

  require_once "base-catalogo.php";

	define( "TABLA_INSTITUCIONES", "instituciones" );

  class Institucion extends Catalogo
  {
    protected $id;
    protected $usuario_id;
    protected $nombre;
    protected $razon_social;
    protected $historia;
    protected $vision;
    protected $mision;
    protected $valores_institucionales;
    protected $es_nombre_autorizado;
    protected $clave_ies;
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
      $resultado = parent::consultarTodosCatalogo( TABLA_INSTITUCIONES );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_INSTITUCIONES );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_INSTITUCIONES );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_INSTITUCIONES );
			return $resultado;
    }


  }
?>
