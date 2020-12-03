<?php
  /**
  * Clase que gestiona métodos de la tabla asignaturas
  */

  require_once "base-catalogo.php";

	define( "TABLA_ASIGNATURA", "asignaturas" );

  class Asignatura extends Catalogo
  {
    protected $id;
    protected $infraestructura_id;
    protected $docente_id;
    protected $academia;
    protected $programa_id;
    protected $area;
    protected $nombre;
    protected $clave;
    protected $seriacion;
    protected $objetivo;
    protected $temas;
    protected $actividades;
    protected $modelo_instruccional;
    protected $horas_docente;
    protected $horas_independiente;
    protected $minimo_horas;
    protected $minimo_creditos;
    protected $creditos;
    protected $tipo;
    protected $grado;
    protected $fecha_autorizacion;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_ASIGNATURA );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_ASIGNATURA );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_ASIGNATURA );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_ASIGNATURA );
			return $resultado;
    }
		
		
		// Método para consultar grados por programa
    public function consultarGradosPrograma( )
    {
      $sql = "select * from " . TABLA_ASIGNATURA . " where programa_id='$this->programa_id' and deleted_at is null group by grado order by grado";
			
			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }
		
		
		// Método para consultar asignaturas por grado
    public function consultarAsignaturasGrado( )
    {
      $sql = "select * from " . TABLA_ASIGNATURA . " where programa_id='$this->programa_id' and grado='$this->grado' and deleted_at is null order by id";
			
			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }
  }
?>
