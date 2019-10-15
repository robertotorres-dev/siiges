<?php
  /**
  * Clase que gestiona métodos de la tabla salud_instituciones
  */

  require_once "base-catalogo.php";

	define( "TABLA_SALUD_INSTITUCION", "salud_instituciones" );

  class SaludInstitucion extends Catalogo
  {
    protected $id;
    protected $plantel_id;
    protected $nombre;
    protected $tiempo;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_SALUD_INSTITUCION );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_SALUD_INSTITUCION );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_SALUD_INSTITUCION );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_SALUD_INSTITUCION );
			return $resultado;
    }


  }
?>
