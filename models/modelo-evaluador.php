<?php
  /**
  * Clase que gestiona métodos de la tabla evaluadores
  */

  require_once "base-catalogo.php";
  require_once "modelo-persona.php";
  require_once "modelo-evaluador.php";
  require_once "modelo-evaluador-modalidad.php";
  require_once "modelo-evaluacion-proceso.php";
  require_once "modelo-institucional.php";
  require_once "modelo-perfil.php";
  require_once "modelo-formacion.php";
  require_once "modelo-experiencia.php";
  require_once "modelo-asociacion.php";

	define( "TABLA_EVALUADOR", "evaluadores" );

  class Evaluador extends Catalogo
  {
    protected $id;
    protected $persona_id;
    protected $tipo_evaluador;
    protected $especialidad;
    protected $otros_registros;
    protected $logros;
    protected $numero_evaluador;

    const SIIGA = 1;
    const CIFRHS = 2;
    const NO_DEFINIDO = 1;

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
      $resultado = parent::consultarTodosCatalogo( TABLA_EVALUADOR );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_EVALUADOR );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_EVALUADOR );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_EVALUADOR );
			return $resultado;
    }


    //Método para obtener las datos relacionados al evaluador recibe el id de la persona
    public function informacionRelacionada($id_persona)
    {
        $resultado["persona"] = null;
        $resultado["evaluador"] = null;
        $resultado["modalidades"] = null;
        $resultado["procesos_evaluacion"] = null;
        $resultado["puesto_institucional"] = null;
        $resultado["perfiles"] = null;
        $resultado["formaciones"] = null;
        $resultado["experiencias"] = null;
        $resultado["asociaciones"] = null;
        $objPersona = new Persona();
        $objPersona->setAttributes(array("id"=>$id_persona));
        $res_persona = $objPersona->consultarId();


        $objEvaluador = new Evaluador();
        $res_evaluador = $objEvaluador->consultarPor("evaluadores",array("persona_id"=>$id_persona,"deleted_at"),"*");
        if( sizeof($res_evaluador["data"])>0)
        {
          $resultado["persona"] = $res_persona["data"];
          $resultado["evaluador"] =  $res_evaluador["data"][0];
          $objModalidad = new EvaluadorModalidad();
          $res_modalidades = $objModalidad->consultarPor("evaluadores_modalidades",array("evaluador_id"=>  $resultado["evaluador"]["id"],"deleted_at"),"*");
          if( sizeof($res_modalidades["data"]) > 0 )
          {
            $resultado["modalidades"] = $res_modalidades["data"];
          }
          $objEvaluacionProceso = new EvaluacionProceso();
          $res_evaluacion_proceso = $objEvaluacionProceso->consultarPor("evaluacion_procesos",array("evaluador_id"=>$resultado["evaluador"]["id"],"deleted_at"),"*");
          if(sizeof($res_evaluacion_proceso["data"])>0)
          {
            $resultado["procesos_evaluacion"] = $res_evaluacion_proceso["data"];
          }
          $objInstitucional = new Institucional();
          $res_institucional = $objInstitucional->consultarPor("institucionales",array("evaluador_id"=>$resultado["evaluador"]["id"],"deleted_at"),"*");
          if(sizeof($res_institucional["data"])>0)
          {
            $resultado["puesto_institucional"] =  $res_institucional["data"][0];
          }
          $objPerfil = new Perfil();
          $res_perfil = $objPerfil->consultarPor("perfiles",array("evaluador_id"=>$resultado["evaluador"]["id"],"deleted_at"),"*");
          if(sizeof($res_perfil["data"])>0)
          {
            $resultado["perfiles"] = $res_perfil["data"];
          }
          $objFormacion = new Formacion();
          $res_formacion = $objFormacion->consultarPor("formaciones",array("persona_id"=>$id_persona,"deleted_at"),"*");
          if(sizeof($res_formacion["data"])>0)
          {
            $resultado["formaciones"] = $res_formacion["data"];
          }
          $objExperiencia = new Experiencia();
          $res_experiencia = $objExperiencia->consultarPor("experiencias",array("persona_id"=>$id_persona,"deleted_at"),"*");
          if(sizeof($res_experiencia["data"])>0)
          {
            $resultado["experiencias"] = $res_experiencia["data"];
          }

          $objAsociacion = new Asociacion();
          $res_asociacion = $objAsociacion->consultarPor("asociaciones",array("evaluador_id"=>$resultado["evaluador"]["id"],"deleted_at"),"*");
          if(sizeof($res_asociacion["data"])>0)
          {
            $resultado["asociaciones"] = $res_asociacion["data"];
          }

        }

      return $resultado;
    }

  }
?>
