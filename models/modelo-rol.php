<?php
  /**
  * Clase que gestiona métodos de la tabla roles
  */

  require_once "base-catalogo.php";

	define( "TABLA_ROLES", "roles" );

  class Rol extends Catalogo
  {
    protected $id;
    protected $nombre;
    protected $descripcion;

    const ROL_NUEVO = 1;
    const ROL_ADMIN = 2;
    const ROL_REPRESENTANTE_LEGAL = 3;
    const ROL_GESTOR = 4;
    const ROL_EVALUADOR = 5;
    const ROL_INSPECTOR = 6;
    const ROL_CONTROL_DOCUMENTAL = 7;
    const ROL_SICYT_LECTURA = 8;
    const ROL_SICYT_EDITAR = 9;
    const ROL_JEFE_INSPECCION = 11;
    const ROL_JEFE_EVALUACION = 10;
    const ROL_CONTROL_ESCOLAR_IES = 12;
    const ROL_CONTROL_ESCOLAR_SICYT = 13;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_ROLES );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_ROLES );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_ROLES );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_ROLES );
			return $resultado;
    }


  }
?>
