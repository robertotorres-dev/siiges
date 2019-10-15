<?php
  /**
  * Clase que gestiona métodos de la tabla seguridad_sistemas
  */

  require_once "base-catalogo.php";

	define( "TABLA_SEGURIDAD", "seguridad_sistemas" );

  class SeguridadSistema extends Catalogo
  {
    protected $id;
    protected $nombre;
    protected $descripcion;

    public static $seguridad = [
                              "recubrimiento_plastico" => 1,
                              "alarma"=>2,
                              "senal_evacuacion"=>3,
                              "botiquin"=>4,
                              "escalera_emergencia"=>5,
                              "area_seguridad"=>6,
                              "extintor"=>7,
                              "punto_reunion"=>8
                            ];

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
      $resultado = parent::consultarTodosCatalogo( TABLA_SEGURIDAD );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_SEGURIDAD );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_SEGURIDAD );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_SEGURIDAD );
			return $resultado;
    }


  }
?>
