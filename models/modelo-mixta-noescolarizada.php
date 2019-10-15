<?php
  /**
  * Clase que gestiona métodos de la tabla mixta_noescolarizadas
  */

  require_once "base-catalogo.php";

	define( "TABLA_MIXTA_NOESCOLARIZADAS", "mixta_noescolarizadas" );

  class MixtaNoEscolarizada extends Catalogo
  {
    protected $id;
    protected $programa_id;
    protected $licencias_software;
    protected $servicios_herramientas_educativas;
    protected $sistemas_seguridad;
    protected $direccionamiento_ip_publico;
    protected $tecnologias_informacion_comunicacion;
    protected $mantenimiento_plataforma;
    protected $diagrama_plataforma;
    protected $acceso_internet;
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
      $resultado = parent::consultarTodosCatalogo( TABLA_MIXTA_NOESCOLARIZADAS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_MIXTA_NOESCOLARIZADAS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_MIXTA_NOESCOLARIZADAS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_MIXTA_NOESCOLARIZADAS );
			return $resultado;
    }


  }
?>
