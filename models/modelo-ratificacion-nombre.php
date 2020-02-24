<?php
  /**
  * Clase que gestiona métodos de la tabla ratificacion_nombres
  */

  require_once "base-catalogo.php";

	define( "TABLA_RATIFICACION_NOMBRES", "ratificacion_nombres" );

  class RatificacionNombre extends Catalogo
  {
    protected $id;
    protected $institucion_id;
    protected $acuerdo;
    protected $autoridad;
    protected $nombre_propuesto1;
    protected $nombre_propuesto2;
    protected $nombre_propuesto3;
    protected $nombre_solicitado;
    protected $nombre_autorizado;
    protected $fecha_autorizacion;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_RATIFICACION_NOMBRES );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_RATIFICACION_NOMBRES );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_RATIFICACION_NOMBRES );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_RATIFICACION_NOMBRES );
			return $resultado;
    }


  }
?>
