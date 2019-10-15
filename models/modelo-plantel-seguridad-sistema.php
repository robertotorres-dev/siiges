<?php
  /**
  * Clase que gestiona métodos de la tabla planteles_seguridad_sistemas
  */

  require_once "base-catalogo.php";

	define( "TABLA_PLANTEL_SEGURIDAD_SISTEMA", "planteles_seguridad_sistemas" );

  class PlantelSeguridadSistema extends Catalogo
  {
    protected $id;
    protected $plantel_id;
    protected $seguridad_sistema_id;
    protected $cantidad;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_PLANTEL_SEGURIDAD_SISTEMA );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_PLANTEL_SEGURIDAD_SISTEMA );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_PLANTEL_SEGURIDAD_SISTEMA );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_PLANTEL_SEGURIDAD_SISTEMA );
			return $resultado;
    }


  }
?>
