<?php
  /**
  * Clase que gestiona métodos de la tabla alumnos_grupos
  */

  require_once "base-catalogo.php";

	define( "TABLA_ALUMNOS_GRUPOS", "alumnos_grupos" );

  class AlumnoGrupo extends Catalogo
  {
    protected $id;
    protected $alumno_id;
    protected $grupo_id;
    protected $periodo_fecha_inicio;
    protected $periodo_fecha_fin;
    protected $grado;
  
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
      $resultado = parent::consultarTodosCatalogo( TABLA_ALUMNOS_GRUPOS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_ALUMNOS_GRUPOS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_ALUMNOS_GRUPOS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_ALUMNOS_GRUPOS );
			return $resultado;
    }
		
		
		// Método para consultar alumnos por grupo
    public function consultarAlumnosGrupo( )
    {
      $sql = "select * from " . TABLA_ALUMNOS_GRUPOS . " where grupo_id='$this->grupo_id' and deleted_at is null order by id";
			
			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }
		
		
		// Método para consultar grupos por grado
    public function consultarGrupoGrado( )
    {
      $sql = "select * from " . TABLA_ALUMNOS_GRUPOS . " where grupo_id='$this->grupo_id' and grado='$this->grado' and deleted_at is null order by id";
			
			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }
  }
?>
