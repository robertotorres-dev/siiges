<?php

/**
 * Clase que gestiona métodos de la tabla solicitudes
 */

require_once "base-catalogo.php";
require_once "modelo-tipo-solicitud.php";
require_once "modelo-institucion.php";

define("VISTA_VDETALLES_SOLICITUD", "vdetalles_solicitudes");

class VDetallesSolicitud extends Catalogo
{
  protected $id;
  protected $usuario_id;
  protected $folio;
  protected $tipo_solicitud_id;
  protected $tipo_solicitud;
  protected $programa_id;
  protected $modalidad_id;
  protected $nombre_programa;
  protected $acuerdo_rvoe;
  protected $estatus_solicitud_id;
  protected $estatus_solicitud;
  protected $institucion_id;
  protected $nombre_institucion;
  protected $domicilio_id;
  protected $calle;
  protected $numero_exterior;
  protected $municipio;

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
    $resultado = parent::consultarTodosCatalogo(VISTA_VDETALLES_SOLICITUD);
    return $resultado;
  }


  // Método para consultar registro por id
  public function consultarId()
  {
    $resultado = parent::consultarIdCatalogo(VISTA_VDETALLES_SOLICITUD);
    return $resultado;
  }


  // Método para guardar registro
  public function guardar()
  {
    $resultado = parent::guardarCatalogo(VISTA_VDETALLES_SOLICITUD);
    return $resultado;
  }


  // Método para eliminar registro
  public function eliminar()
  {
    $resultado = parent::eliminarCatalogo(VISTA_VDETALLES_SOLICITUD);
    return $resultado;
  }
}
