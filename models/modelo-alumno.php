<?php
  /**
  * Clase que gestiona métodos de la tabla alumnos
  */

  require_once "base-catalogo.php";

	define( "TABLA_ALUMNOS", "alumnos" );

  class Alumno extends Catalogo
  {
    protected $id;
    protected $persona_id;
    protected $situacion_id;
    protected $programa_id;
    protected $matricula;
    protected $adeudos_materias;
    protected $estatus;
    protected $descripcion_estatus;
    protected $archivo_certificado;
    protected $archivo_nacimiento;
    protected $archivo_curp;
    protected $estatus_certificado;
    protected $estatus_nacimiento;
    protected $estatus_curp;
    protected $observaciones1;
    protected $observaciones2;
    protected $fecha_baja;
    protected $observaciones_baja;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_ALUMNOS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_ALUMNOS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_ALUMNOS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_ALUMNOS );
			return $resultado;
    }

		// Método para consultar por matrícula
    public function consultarMatricula( )
    {
      $sql = "select * from " . TABLA_ALUMNOS . " where id!='$this->id' and programa_id='$this->programa_id' and matricula='$this->matricula' and deleted_at is null order by id";

			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }

		// Método para consultar alumnos por programa
    public function consultarAlumnosPrograma( )
    {
      $sql = "select * from " . TABLA_ALUMNOS . " where programa_id='$this->programa_id' and deleted_at is null order by id";

			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }
  }
?>
