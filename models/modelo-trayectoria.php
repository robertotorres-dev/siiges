<?php
  /**
  * Clase que gestiona métodos de la tabla trayectorias
  */

  require_once "base-catalogo.php";

	define( "TABLA_TRAYECTORIA", "trayectorias" );

  class Trayectoria extends Catalogo
  {
    protected $id;
    protected $programa_seguimiento;
    protected $tipo_tutoria;
    protected $estadistica_titulacion;
    protected $funcion_tutorial;
    protected $modalidades_titulacion;
    protected $tasa_egreso;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_TRAYECTORIA );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_TRAYECTORIA );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_TRAYECTORIA );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_TRAYECTORIA );
			return $resultado;
    }


  }
?>
