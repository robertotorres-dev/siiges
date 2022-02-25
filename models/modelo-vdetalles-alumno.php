<?php

/**
 * Clase que gestiona métodos de la vista vdetalles_alumnos
 */

require_once "base-catalogo.php";

define("VISTA_VDETALLES_ALUMNO", "vdetalles_alumnos");

class VDetallesAlumno extends Catalogo
{
  protected $id;
  protected $matricula;
  protected $nombre;
  protected $apellido_paterno;
  protected $apellido_materno;
  protected $programa_id;
  protected $situacion;
  protected $situacion_validacion;

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
    $resultado = parent::consultarTodosCatalogo(VISTA_VDETALLES_ALUMNO);
    return $resultado;
  }


  // Método para consultar registro por id
  public function consultarId()
  {
    $resultado = parent::consultarIdCatalogo(VISTA_VDETALLES_ALUMNO);
    return $resultado;
  }


  // Método para guardar registro
  public function guardar()
  {
    $resultado = parent::guardarCatalogo(VISTA_VDETALLES_ALUMNO);
    return $resultado;
  }


  // Método para eliminar registro
  public function eliminar()
  {
    $resultado = parent::eliminarCatalogo(VISTA_VDETALLES_ALUMNO);
    return $resultado;
  }

  // Método para consultar alumnos por programa
  public function consultarAlumnosPrograma()
  {
    $sql = "select * from " . VISTA_VDETALLES_ALUMNO . " where programa_id='$this->programa_id' and deleted_at is null order by id";

    $resultado = parent::consultarSQLCatalogo($sql);
    return $resultado;
  }
}
