<?php
  /**
  * Clase que gestiona métodos de la tabla modulos_roles
  */

  require_once "base-catalogo.php";

	define( "TABLA_MODULOS_ROLES", "modulos_roles" );

  class ModuloRol extends Catalogo
  {
    protected $id;
    protected $modulo_id;
    protected $rol_id;
    protected $accion;

    const VER_PROPIO = 1;
    const VER_TODO = 2;
    const VER_DETALLE = 3;
    const CREAR = 4;
    const ACTUALIZAR = 5;
    const ELIMINAR = 6;

    public static $acciones = [1=>"Ver propios", 2=>"Ver todo",3=>"Ver detalles",4=>"Crear",5=>"Editar",6=>"Eliminar"];


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
      $resultado = parent::consultarTodosCatalogo( TABLA_MODULOS_ROLES );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_MODULOS_ROLES );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_MODULOS_ROLES );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_MODULOS_ROLES );
			return $resultado;
    }


  }
?>
