<?php
  /**
  * Clase que gestiona métodos de la tabla titulo electronico
  */

  require_once "base-catalogo.php";

	define( "TABLA_TITULOS_ELECTRONICOS", "titulos_electronicos" );

  class TitulosElectronicos extends Catalogo
  {
    protected $id;
    protected $institucion_id;
    protected $estado_id;
    protected $cargo_id;
    protected $autorizacion_reconocimiento_id;
    protected $modalidad_titulacion_id;
    protected $estado_antecedente_id;
    protected $fundamento_legal_servicio_social_id;
    protected $tipo_estudio_antecedente_id;
    protected $version;
    protected $folio_control;
    protected $nombre_responsable;
    protected $primer_apellido_responsable;
    protected $segundo_apellido_responsable; //optional
    protected $curp_responsable; //string 18
    protected $sello;
    protected $certificado_responsable;
    protected $no_certificado_responsable;
    protected $nombre_institucion;
    protected $cve_institucion;
    protected $cve_carrera; // string 7
    protected $nombre_carrera;
    protected $fecha_inicio; //date optional
    protected $fecha_terminacion; //date
    protected $numero_rvoe; // string 100 optional
    protected $curp; //string 18
    protected $nombre;
    protected $primer_apellido;
    protected $segundo_apellido; //optional
    protected $correo_electronico;
    protected $fecha_expedicion; //Date
    protected $fecha_examen_profesional; //Date optional
    protected $fecha_exencion_examen_profesional; // date optional
    protected $cumplio_servicio_social; //1 cumplió  - 0 no cumplió
    protected $institucion_procedencia;
    protected $fecha_inicio_antecedente; //date optional
    protected $fecha_terminacion_antecedente; //date
    protected $no_cedula; //string 8 optional
    protected $folio_digital;
    protected $fecha_autenticacion;
    protected $sello_titulo;
    protected $no_certificado_autoridad;
    protected $sello_autenticacion;
    

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
      $resultado = parent::consultarTodosCatalogo( TABLA_TITULOS_ELECTRONICOS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_TITULOS_ELECTRONICOS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_TITULOS_ELECTRONICOS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_TITULOS_ELECTRONICOS );
			return $resultado;
    }


  }
?>
