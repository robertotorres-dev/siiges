<?php
  /**
  * Clase que gestiona métodos de la tabla higienes
  */

  require_once "base-catalogo.php";

	define( "TABLA_HIGIENE", "higienes" );

  class Higiene extends Catalogo
  {
    protected $id;
    protected $nombre;
    protected $descripcion;

    public static $higiene = ["sanitarios_alumnos_hombres"=>1,
                              "sanitarios_alumnos_mujeres"=>2,
                              "sanitarios_administrativos_hombres"=>3,
                              "sanitarios_administrativos_mujeres"=>4,
                              "personal_limpieza"=>5,
                              "cestos_basura"=>6,
                              "numero_aulas"=>7,
                              "butacas_aula"=>8,
                              "ventanas"=>9,
                              "ventilador"=>10,
                              "acondicionado"=>11
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
      $resultado = parent::consultarTodosCatalogo( TABLA_HIGIENE );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_HIGIENE );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_HIGIENE );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_HIGIENE );
			return $resultado;
    }


  }
?>
