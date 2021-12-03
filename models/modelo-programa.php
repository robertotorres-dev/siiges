<?php

/**
 * Clase que gestiona métodos de la tabla programas
 */

require_once "base-catalogo.php";
require_once "modelo-plantel.php";
require_once "modelo-programa-turno.php";
require_once "modelo-turno.php";

define("TABLA_PROGRAMAS", "programas");

class Programa extends Catalogo
{
  protected $id;
  protected $evaluador_id;
  protected $ciclo_id;
  protected $nivel_id;
  protected $solicitud_id;
  protected $modalidad_id;
  protected $plantel_id;
  protected $persona_id;
  protected $duracion;
  protected $objetivos;
  protected $antecedentes;
  protected $creditos;
  protected $minimo_horas_optativas;
  protected $minimo_creditos_optativas;
  protected $vigencia;
  protected $acuerdo_rvoe;
  protected $nombre;
  protected $tipo;
  protected $actualizacion;
  protected $seguimiento_egresados;
  protected $total_alumnos;
  protected $convenios_vinculacion;
  protected $fuentes_informacion;
  protected $estudio_oferta_demanda;
  protected $lineas_generacion_aplicacion_conocimiento;
  protected $necesidad_profesional;
  protected $necesidad_institucional;
  protected $recursos_operacion;
  protected $necesidad_social;
  protected $antecedente_academico;
  protected $perfil_ingreso_conocimientos;
  protected $perfil_ingreso_habilidades;
  protected $perfil_ingreso_actitudes;
  protected $perfil_egreso_conocimientos;
  protected $perfil_egreso_habilidades;
  protected $perfil_egreso_actitudes;
  protected $metodos_induccion;
  protected $proceso_seleccion;
  protected $mapa_curricular;
  protected $flexibilidad_curricular;
  protected $objetivo_general;
  protected $objetivos_particulares;
  protected $fecha_asignacion_evaluador;
  protected $otros_rvoes;
  protected $total_alumnos_otros_rvoes;
  protected $calificacion_minima;
  protected $calificacion_maxima;
  protected $calificacion_aprobatoria;
  protected $calificacion_decimal;

  // Constructor
  public function __construct()
  {
    parent::__construct();
  }

  // Función para asignar atributos de la clase
  public function setAttributes($parametros = array())
  {
    foreach ($parametros as $atributo => $valor) {
      $this->{$atributo} = $valor;
    }
  }

  // Método para consultar todos los registros
  public function consultarTodos()
  {
    $resultado = parent::consultarTodosCatalogo(TABLA_PROGRAMAS);
    return $resultado;
  }


  // Método para consultar registro por id
  public function consultarId()
  {
    $resultado = parent::consultarIdCatalogo(TABLA_PROGRAMAS);
    return $resultado;
  }


  // Método para guardar registro
  public function guardar()
  {
    $resultado = parent::guardarCatalogo(TABLA_PROGRAMAS);
    return $resultado;
  }


  // Método para eliminar registro
  public function eliminar()
  {
    $resultado = parent::eliminarCatalogo(TABLA_PROGRAMAS);
    return $resultado;
  }


  // Método para consultar programas acreditados con RVOE
  public function consultarAcreditados()
  {
    $fecha_actual =  date("Y-m-d");
    /*$sql = "select * from solicitudes, programas where
			solicitudes.usuario_id='$this->usuario_id' and
			solicitudes.deleted_at is null and
			solicitudes.id = programas.solicitud_id and
      programas.vigencia>='$fecha_actual' and
			programas.acuerdo_rvoe!='' and
			programas.deleted_at is null";*/
    $sql = "select * from solicitudes, programas where
			solicitudes.usuario_id='$this->usuario_id' and
			solicitudes.deleted_at is null and
			solicitudes.id = programas.solicitud_id and
			programas.acuerdo_rvoe!='' and
			programas.deleted_at is null";

    $resultado = parent::consultarSQLCatalogo($sql);
    return $resultado;
  }


  // Método para consultar programas no acreditados con RVOE
  public function consultarNoAcreditados()
  {
    $fecha_actual =  date("Y-m-d");
    /*$sql = "select * from solicitudes, programas where
			solicitudes.usuario_id='$this->usuario_id' and
			solicitudes.deleted_at is null and
			solicitudes.id = programas.solicitud_id and
      (programas.vigencia<'$fecha_actual' or
			programas.acuerdo_rvoe='') and
			programas.deleted_at is null";*/

    $sql = "select * from solicitudes, programas where
			solicitudes.usuario_id='$this->usuario_id' and
			solicitudes.deleted_at is null and
			solicitudes.id = programas.solicitud_id and
      programas.acuerdo_rvoe is null and
			programas.deleted_at is null";

    $resultado = parent::consultarSQLCatalogo($sql);
    return $resultado;
  }


  // Método para consultar programas acreditados con RVOE por plantel
  public function consultarAcreditadosPlantel()
  {
    $fecha_actual =  date("Y-m-d");

    //$sql = "select * from programas where plantel_id='$this->plantel_id' and vigencia>='$fecha_actual' and acuerdo_rvoe!='' and deleted_at is null";
    $sql = "select * from programas where plantel_id='$this->plantel_id'
      and acuerdo_rvoe!=''
      and deleted_at is null";
    $resultado = parent::consultarSQLCatalogo($sql);
    return $resultado;
  }


  // Método para consultar programas no acreditados con RVOE por plantel
  public function consultarNoAcreditadosPlantel()
  {
    $fecha_actual =  date("Y-m-d");
    //$sql = "select * from programas where plantel_id='$this->plantel_id' and (vigencia<'$fecha_actual' or acuerdo_rvoe='') and deleted_at is null";
    $sql = "select programas.nombre, programas.vigencia, programas.id, programas.acuerdo_rvoe FROM programas, solicitudes 
          where programas.solicitud_id = solicitudes.id 
          and programas.plantel_id='$this->plantel_id'
          and programas.acuerdo_rvoe is null
          and programas.deleted_at is null
          and solicitudes.deleted_at is null";

    $resultado = parent::consultarSQLCatalogo($sql);
    return $resultado;
  }


  //Método para consultar información del programa con sus respectivas relaciones
  public function informacionRelacionada($opcion)
  {
    if ($opcion == 1) {
      //Construir consulta
      $consulta = "select * from " . TABLA_PROGRAMAS . " where id=? and acuerdo_rvoe=''";
      $consultaR = "select * from " . TABLA_PROGRAMAS . " where id='$this->id' and acuerdo_rvoe=''";
    }
    if ($opcion == 2) {
      //Construir consulta
      $consulta = "select * from " . TABLA_PROGRAMAS . " where id=?";
      $consultaR = "select * from " . TABLA_PROGRAMAS . " where id='$this->id'";
    }


    //Preparar la consulta
    $stmt = $this->mysqli->prepare($consulta);
    if ($stmt) {
      //Obligar la consulta con numero de parametros
      $stmt->bind_param("s", $this->id);
      //Ejecutar la consulta
      $stmt->execute();
      if ($stmt) {
        //Terminar la consulta
        $stmt->close();
        //Obtener resultado
        //$result = $stmt->get_result();
        $result = $this->mysqli->query($consultaR);
        if ($result->num_rows > 0) {
          $resultado["status"] = "200";
          $resultado["message"] = "OK";
          $resultado["data"] = $result->fetch_assoc();
          /* liberar el conjunto de resultados */
          $result->free();
          //Agregar evaluador
          $result = $this->mysqli->query("select * from evaluadores where id=" . $resultado['data']['evaluador_id'] . "");
          if ($result->num_rows > 0) {
            $resultado["data"]["evaluador"] = $result->fetch_assoc();
            $result->free();
          }
          //Agregar ciclo
          $result = $this->mysqli->query("select * from ciclos where id=" . $resultado['data']['ciclo_id'] . "");
          if ($result->num_rows > 0) {
            $resultado["data"]["ciclo"] = $result->fetch_assoc();
            $result->free();
          }
          //Agregar ciclo
          $result = $this->mysqli->query("select * from niveles where id=" . $resultado['data']['nivel_id'] . "");
          if ($result->num_rows > 0) {
            $resultado["data"]["nivel"] = $result->fetch_assoc();
            $result->free();
          }
          //Agregar solicitud
          $result = $this->mysqli->query("select * from solicitudes where id=" . $resultado['data']['solicitud_id'] . "");
          if ($result->num_rows > 0) {
            $resultado["data"]["solicitud"] = $result->fetch_assoc();
            $result->free();
          }
          //Agregar solicitud
          $result = $this->mysqli->query("select * from modalidades where id=" . $resultado['data']['modalidad_id'] . "");
          if ($result->num_rows > 0) {
            $resultado["data"]["modalidad"] = $result->fetch_assoc();
            $result->free();
          }
          //Agregar plantel
          $plantel = new Plantel();
          $plantel->setAttributes(array("id" => $resultado['data']['plantel_id']));
          $res = $plantel->informacionRelacionada();
          if (sizeof($res) > 0) {
            $resultado["data"]["plantel"] = $res["data"];
          }
          //Turnos
          $turno = new ProgramaTurno();
          $ids_turnos = $turno->consultarPor("programas_turnos", array("programa_id" => $resultado["data"]["id"], "deleted_at"), "turno_id");
          $ids_turnos = $ids_turnos["data"];
          $array_turnos = array();
          if (sizeof($ids_turnos) > 0) {
            foreach ($ids_turnos as $key => $value) {

              $temp_turno = new Turno();
              $temp_turno->setAttributes(array("id" => $value["turno_id"]));
              $res_temp = $temp_turno->consultarId();
              if (sizeof($res_temp["data"]) > 0) {
                array_push($array_turnos, $res_temp["data"]["id"]);
              }
            }
            $resultado["data"]["turnos"] = $array_turnos;
          }
          //Trayectoria programa
          $result = $this->mysqli->query("select * from trayectorias where programa_id=" . $resultado['data']['id'] . "");
          if ($result->num_rows > 0) {
            $resultado["data"]["trayectoria"] = $result->fetch_assoc();
            $result->free();
          }
          //Agregar coordinador
          $result = $this->mysqli->query("select * from personas where id=" . $resultado['data']['persona_id'] . "");
          if ($result->num_rows > 0) {
            $resultado["data"]["coordinador"] = $result->fetch_assoc();
            $result->free();
          }
        } else {
          $resultado["status"] = "404";
          $resultado["message"] = "Error";
          $resultado["data"] = "No se cumple la consulta " . $consulta . "o No existe el id:" . $this->id;
        }
      } else {
        $resultado["status"] = "404";
        $resultado["message"] = "Error";
        $resultado["data"] = "No se puede ejecutar la consulta";
      }
    } else {
      $resultado["status"] = "404";
      $resultado["message"] = "Error";
      $resultado["data"] =  "Existe un error en la consulta: " . $consulta;
    }

    //Cerrar la conexion
    $this->mysqli->close();
    return $resultado;
  }
}
