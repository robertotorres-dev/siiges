<?php
  /**
  * Clase que gestiona métodos de la tabla grupos
  */
  
  require_once "base-catalogo.php";

	define( "TABLA_GRUPOS", "grupos" );

  class Grupo extends Catalogo
  {
    protected $id;
    protected $programa_id;
    protected $turno_id;
    protected $grupo;
    protected $generacion;
    protected $generacion_fecha_inicio;
    protected $generacion_fecha_fin;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_GRUPOS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_GRUPOS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_GRUPOS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_GRUPOS );
			return $resultado;
    }


		// Método para consultar grupos por ciclo y grado
    public function consultarGruposCicloGrado( )
    {
      $sql = "select * from " . TABLA_GRUPOS . " where ciclo_escolar_id='$this->ciclo_escolar_id' and grado='$this->grado' and deleted_at is null order by id";
			
			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }
  }
?>
