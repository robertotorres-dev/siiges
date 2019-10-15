<?php
  /**
  * Clase que gestiona métodos de la tabla validaciones
  */

  require_once "base-catalogo.php";

	define( "TABLA_PRINCIPAL", "validaciones" );

  class Validacion extends Catalogo
  {
    protected $id;
    protected $alumno_id;
    protected $estado;
    protected $nombre_institucion_emisora;
    protected $fecha_expedicion;
    protected $documento_retenido;
    protected $folio;
    protected $oficio_respuesta;
    protected $oficio_envio;
    protected $fecha_acreditacion;
    protected $plan_anterior;
    protected $clave_centro_trabajo_emisor;
    protected $fecha_envio_oficio;
    protected $fecha_respuesta;
    protected $situacion_documento;
    protected $observaciones;
    protected $fecha_actualizacion;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_PRINCIPAL );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_PRINCIPAL );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_PRINCIPAL );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_PRINCIPAL );
			return $resultado;
    }


  }
?>
