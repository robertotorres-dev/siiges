<?php
  /**
  * Clase que gestiona métodos de la tabla solicitudes_estatus_soli
  */

  require_once "base-catalogo.php";

	define( "TABLA_SOLICITUD_ESTATUS", "solicitudes_estatus_solicitudes" );

  class SolicitudEstatus extends Catalogo
  {
    protected $id;
    protected $estatus_solicitud_id;
    protected $solicitud_id;
    protected $comentario;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_SOLICITUD_ESTATUS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_SOLICITUD_ESTATUS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_SOLICITUD_ESTATUS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_SOLICITUD_ESTATUS );
			return $resultado;
    }


  }
?>
