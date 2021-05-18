<?php
  /**
  * Clase que gestiona métodos de la tabla titulo electronico
  */

  require_once "base-catalogo.php";

	define( "TABLA_TITULO_ELECTRONICO", "titulo_electronico" );

  class TituloElectronico extends Catalogo
  {
    protected $id;
    protected $folio_control;
    protected $nombre_responsable;
    protected $primer_apellido_resposnable;
    protected $segundo_apellido_resposnable;
    protected $curp_responsable;
    protected $id_cargo;
    protected $sello;
    protected $certificado_responsable;
    protected $no_certificado_responsable;
    protected $cve_institucion;
    protected $id_institucion;
    protected $cve_carrera;
    protected $nombre_carrera;
    protected $fecha_inicio;
    protected $fecha_terminacion;
    protected $id_autorizacion_reconocimiento;
    protected $numero_rvoe;
    protected $curp;
    protected $nombre;
    protected $primer_apellido;
    protected $segundo_apellido;
    protected $correo_electronico;
    protected $fecha_expedicion;
    protected $id_modalidad_titulacion;
    protected $fecha_exencion_examen_profesional;
    protected $cumplio_servicio_social;
    protected $id_fundamento_legal_servicio_social;
    protected $id_estado;
    protected $instituto_procedencia;
    protected $id_tipo_estudio_antecedente;
    protected $id_estado_antecedente;
    protected $fecha_inicio_antecedente;
    protected $fecha_terminacion_antecedente;
    protected $no_cedula;
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
      $resultado = parent::consultarTodosCatalogo( TABLA_TITULO_ELECTRONICO );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_TITULO_ELECTRONICO );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_TITULO_ELECTRONICO );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_TITULO_ELECTRONICO );
			return $resultado;
    }


  }
?>
