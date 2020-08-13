<?php
  /**
  * Clase que gestiona métodos de la tabla calificaciones
  */

  require_once "base-catalogo.php";

	define( "TABLA_CALIFICACIONES", "calificaciones" );

  class Calificacion extends Catalogo
  {
    protected $id;
    protected $alumno_id;
    protected $asignatura_id;
    protected $estatus_calificacion_id;
    protected $calificacion;
    protected $fecha_examen;
    protected $tipo;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_CALIFICACIONES );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_CALIFICACIONES );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_CALIFICACIONES );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_CALIFICACIONES );
			return $resultado;
    }


		// Método para consultar alumno en asignatura
    public function consultarAlumnoAsignatura( )
    {
      $sql = "select * from " . TABLA_CALIFICACIONES . " where alumno_id='$this->alumno_id' and grupo_id='$this->grupo_id' and asignatura_id='$this->asignatura_id' and tipo='$this->tipo' and deleted_at is null order by id";

			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }


		// Método para consultar calificaciones de alumno
    public function consultarCalificacionesAlumno( )
    {
      $sql = "select * from " . TABLA_CALIFICACIONES . " where alumno_id='$this->alumno_id' and deleted_at is null order by id";

			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }


		// Método para eliminar alumno de asignaturas
    public function eliminarAlumnoGrupoAsignaturas( )
    {
      $this->deleted_at = date( "Y-m-d H:i:s" );

			$sql = "update " . TABLA_CALIFICACIONES . " set deleted_at='$this->deleted_at' where alumno_id='$this->alumno_id' and grupo_id='$this->grupo_id'";
			$res = $this->mysqli->query( $sql );
      //$max = $res->num_rows;

			$this->mysqli->close( );

			return array(
			"status"=>"200",
			"message"=>"OK",
			"data"=>array(
				"id"=>$this->id,
				"created_at"=>$this->created_at,
				"updated_at"=>$this->updated_at,
				"deleted_at"=>$this->deleted_at ) );
    }
  }
?>
