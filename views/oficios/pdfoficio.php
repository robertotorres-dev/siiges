<?php
require( "../../fpdf181/fpdf.php" );
require_once "../../models/modelo-solicitud.php";
require_once "../../models/modelo-programa.php";
require_once "../../models/modelo-nivel.php";
require_once "../../models/modelo-modalidad.php";
require_once "../../models/modelo-ciclo.php";
require_once "../../models/modelo-turno.php";
require_once "../../models/modelo-institucion.php";
require_once "../../models/modelo-ratificacion-nombre.php";
require_once "../../models/modelo-usuario.php";
require_once "../../models/modelo-solicitud-usuario.php";
require_once "../../models/modelo-domicilio.php";

require_once "../../models/modelo-plantel-dictamen.php";
require_once "../../models/modelo-plantel-edificio-nivel.php";
require_once "../../models/modelo-edificio-nivel.php";
require_once "../../models/modelo-plantel-higiene.php";
require_once "../../models/modelo-higiene.php";
require_once "../../models/modelo-plantel-seguridad-sistema.php";
require_once "../../models/modelo-seguridad-sistema.php";
require_once "../../models/modelo-infraestructura.php";
require_once "../../models/modelo-tipo-instalacion.php";
require_once "../../models/modelo-asignatura.php";
require_once "../../models/modelo-salud-institucion.php";

require_once "../../models/modelo-mixta-noescolarizada.php";
require_once "../../models/modelo-respaldo.php";
require_once "../../models/modelo-espejo.php";

require_once "../../models/modelo-persona.php";

require_once "../../models/modelo-trayectoria.php";

require_once "../../models/modelo-docente.php";
require_once "../../models/modelo-formacion.php";
require_once "../../models/modelo-experiencia.php";
require_once "../../models/modelo-publicacion.php";
require_once "../../models/modelo-evaluador.php";
require_once "../../models/modelo-inspector.php";
require_once "../../models/modelo-inspeccion.php";
require_once "../../models/modelo-testigo.php";

require_once "../../models/modelo-oficio.php";
require_once "../../models/modelo-oficio-detalle.php";
require_once "../../models/modelo-solicitud-estatus.php";
require_once "../../models/modelo-programa-evaluacion.php";
require_once "../../models/modelo-inspeccion-pregunta.php";
require_once "../../models/modelo-inspeccion-apartado.php";
require_once "../../models/modelo-inspeccion-observacion.php";
require_once "../../models/modelo-bitacora.php";



class PDF extends FPDF
{
  // Cabecera de p�gina
  function Header()
  {
    //$this->Image( "../../images/marcaDeAguaSicyt.jpg",0,0,215,279);
    $this->Image("../../images/encabezado.jpg",0,15,75);
    $this->Image("../../images/direccion_sicyt.PNG",155,12,40);
  }

  // Pie de p�gina
  function Footer()
  {
    $this->Image( "../../images/jalisco.png",20,245,20);
  }

function convertirFecha($fecha){
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    return date('d',strtotime($fecha))." de ".$meses[date('n',strtotime($fecha))-1]. " del ".date('Y') ;
  }

function getSolicitud($solicitud_id = null){
  $this->solicitud = new Solicitud();
  $this->solicitud->setAttributes(["id"=>$solicitud_id]);
  $this->solicitud = $this->solicitud->consultarId();
  $this->solicitud = !empty($this->solicitud["data"])?$this->solicitud["data"]:false;
  if(!$this->solicitud){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Solicitud no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
}

function getProgramaPorSolicitud($solicitud_id = null){
  $this->programa = new Programa();
  $this->programa = $this->programa->consultarPor("programas",["solicitud_id"=>$solicitud_id],"*");
  $this->programa = !empty($this->programa["data"][0])?$this->programa["data"][0]:false;
  if(!$this->programa){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Programa no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
  // Nivel
  $nivel = new Nivel();
  $nivel->setAttributes(["id"=>$this->programa["nivel_id"]]);
  $nivel = $nivel->consultarId();
  $nivel = !empty($nivel["data"])?$nivel["data"]:false;
  if(!$nivel){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Nivel no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
  $this->programa["nivel"] = $nivel;

  // Modalidad
  $modalidad = new Modalidad();
  $modalidad->setAttributes(["id"=>$this->programa["modalidad_id"]]);
  $modalidad = $modalidad->consultarId();
  $modalidad = !empty($modalidad["data"])?$modalidad["data"]:false;
  if(!$modalidad){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Modalidad no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
  $this->programa["modalidad"] = $modalidad;

  // Ciclo
  $ciclo = new Ciclo();
  $ciclo->setAttributes(["id"=>$this->programa["ciclo_id"]]);
  $ciclo = $ciclo->consultarId();
  $ciclo = !empty($ciclo["data"])?$ciclo["data"]:false;
  if(!$ciclo){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Ciclo no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
  $this->programa["ciclo"] = $ciclo;

  $this->programa["turno"] = "";
  // Turno
  $turnos = new Turno();

  $turnos = $turnos->consultarPor("programas_turnos",["programa_id"=>$this->programa["id"]],"*");
  $turnos = !empty($turnos["data"])?$turnos["data"]:false;
  if(!$turnos){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Turnos no encontrados.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
  foreach ($turnos as $value) {
    $turno = new Turno();
    $turno->setAttributes(["id"=>$value["turno_id"]]);
    $turno = $turno->consultarId();
    $turno = !empty($turno["data"])?$turno["data"]:false;
    if(!$turno){
      $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Turno no encontrado.","data"=>[]]);
      header("Location: ../home.php");exit();
    }
    $this->programa["turno"] .= $turno["nombre"].", ";
  }
}

function getPlantel($plantel_id = null){
  $this->plantel = new Plantel();
  $this->plantel->setAttributes(["id"=>$plantel_id]);
  $this->plantel = $this->plantel->consultarId();
  $this->plantel = !empty($this->plantel["data"])?$this->plantel["data"]:false;
  if(!$this->plantel){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Plantel no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }

  $domicilio = new Domicilio();
  $domicilio->setAttributes(["id"=>$this->plantel["domicilio_id"]]);
  $domicilio = $domicilio->consultarId();
  $domicilio = !empty($domicilio["data"])?$domicilio["data"]:false;
  if(!$domicilio){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Domicilio no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }

  $this->plantel["domicilio"] = $domicilio;

}

function getInstitucion($institucion_id = null){

  $this->institucion = new Institucion();
  $this->institucion->setAttributes(["id"=>$institucion_id]);
  $this->institucion = $this->institucion->consultarId();
  $this->institucion = !empty($this->institucion["data"])?$this->institucion["data"]:false;
  if(!$this->institucion){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Institucion no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
}

function getRepresentante($usuario_id = null){
  $this->representante = new Usuario();
  $this->representante->setAttributes(["id"=>$usuario_id]);
  $this->representante = $this->representante->consultarId();
  $this->representante = !empty($this->representante["data"])?$this->representante["data"]:false;
  if(!$this->representante){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Representante no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
}



function getInstitucionPorUsuario($usuario_id = null){
  $this->institucion = new Institucion();
  $this->institucion = $this->institucion->consultarPor("instituciones",["usuario_id"=>$usuario_id],"*");
  $this->institucion = !empty($this->institucion["data"][0])?$this->institucion["data"][0]:false;
  if(!$this->institucion){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Institución no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
}

function getPrograma($programa_id = null){
  $this->programa = new Programa();
  $this->programa->setAttributes(["id"=>$programa_id]);
  $this->programa = $this->programa->consultarId();
  $this->programa = !empty($this->programa["data"])?$this->programa["data"]:false;
  if(!$this->programa){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Programa no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
}

function getEvaluador($evaluador_id = null){
  $this->evaluador = new Evaluador();
  $this->evaluador->setAttributes(["id"=>$evaluador_id]);
  $this->evaluador = $this->evaluador->consultarId();
  $this->evaluador = !empty($this->evaluador["data"])?$this->evaluador["data"]:false;
  if(!$this->evaluador){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Evaluador no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
  $persona = new Persona();
  $persona->setAttributes(["id"=>$evaluador_id]);
  $persona = $persona->consultarId();
  $persona = !empty($persona["data"])?$persona["data"]:false;
  if(!$persona){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Pesona no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
  $this->evaluador["persona"] = $persona;
}

function getInspectores($programa_id = null){
  $inspectores = new Inspector();
  $inspectores = $inspectores->consultarPor("inspectores",["programa_id"=>$programa_id],"*");
  $inspectores = !empty($inspectores["data"])?$inspectores["data"]:false;
  if(!$inspectores){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Inspector no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }

  $this->inspectores = [];
  foreach ($inspectores as $key => $inspector) {
    $persona = new Persona();
    $persona->setAttributes(["id"=>$inspector["persona_id"]]);
    $persona = $persona->consultarId();
    $persona = !empty($persona["data"])?$persona["data"]:false;
    if(!$persona){
      $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Pesona no encontrada.","data"=>[]]);
      header("Location: ../home.php");exit();
    }
    array_push($this->inspectores,$persona);
  }

}
function getTestigos($programa_id = null){
  $inspeccion = new Inspeccion();
  $inspeccion = $inspeccion->consultarPor("inspecciones",["programa_id"=>$programa_id],"*");
  $inspeccion = !empty($inspeccion["data"][0])?$inspeccion["data"][0]:false;
  if(!$inspeccion){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Inspección no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }

  $testigos = new Testigo();
  $testigos = $testigos->consultarPor("testigos",["inspeccion_id"=>$inspeccion["id"]],"*");
  $testigos = !empty($testigos["data"])?$testigos["data"]:false;
  if(!$testigos){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Testigo no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
  $this->testigos = [];
  foreach ($testigos as $key => $testigo) {
    $persona = new Persona();
    $persona->setAttributes(["id"=>$testigo["persona_id"]]);
    $persona = $persona->consultarId();
    $persona = !empty($persona["data"])?$persona["data"]:false;
    if(!$persona){
      $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Pesona no encontrada.","data"=>[]]);
      header("Location: ../home.php");exit();
    }
    array_push($this->testigos,$persona);
  }

}

function getInspecciones($programa_id = null){
  $this->inspecciones = new Inspeccion();
  $this->inspecciones = $this->inspecciones->consultarPor("inspecciones",["programa_id"=>$programa_id],"*");
  $this->inspecciones = !empty($this->inspecciones["data"])?$this->inspecciones["data"][0]:false;
  if(!$this->inspecciones){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Inspección no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
}

function getOficio($oficio = null ){
  $oficioE = new Oficio();
  $oficioE = $oficioE->consultarPor("oficios",["solicitud_id"=>$oficio["solicitud_id"],"documento"=>$oficio["documento"]],"*");
  $oficioE =!empty($oficioE["data"])?$oficioE["data"][0]:false;

  if($oficioE){
    $detalles = new OficioDetalle();
    $detalles = $detalles->consultarPor("oficio_detalles",["oficio_id"=>$oficioE["id"]],"*");
    $detalles =!empty($detalles["data"])?$detalles["data"]:false;
    if($detalles){
      $oficioE["detalles"] = $detalles;
    }
  }

  return $oficioE;
}

function limpiar($registro = null){
  $registroOficios = array( );
  $buscar = array(
    '@<script[^>]*?>.*?</script>@si', // Elimina javascript
    '@<[\/\!]*?[^<>]*?>@si',          // Elimina las etiquetas HTML
    '@<style[^>]*?>.*?</style>@siU',  // Elimina las etiquetas de estilo
    '@<![\s\S]*?--[ \t\n\r]*>@'       // Elimina los comentarios multi-l�nea revisar para la app m�vil
  );

  $registro = preg_replace( $buscar, '', $registro );
  foreach( $registro as $atributo=>$valor )
  {
    $registroOficios[$atributo] = $valor;
  }
  return $registroOficios;
}
function guardarOficio($registro = null){

  $registroOficios = $this->limpiar($registro);

  $this->oficioG = $this->getOficio($registroOficios);
  if(!$this->oficioG){
    $this->oficioG = new Oficio();
    $this->oficioG->setAttributes($registroOficios);
    $this->oficioG->guardar();

    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"oficios","accion"=>"guardar","lugar"=>$registroOficios["documento"]]);
    $result = $bitacora->guardar();
  }

}
function guardarOficioDetalles($registro = null){

  $registroDetalles = $this->limpiar($registro);

  $detalles = new OficioDetalle();
  $detalles = $detalles->consultarPor("oficio_detalles",["oficio_id"=>$registro["oficio_id"],"propiedad"=>$registro["propiedad"]],"*");
  $detalles =!empty($detalles["data"])?$detalles["data"]:false;
  if(!$detalles){
    $detalles = new OficioDetalle();
    $detalles->setAttributes($registroDetalles);
    $detalles->guardar();
  }
}

function getFechaEstatus($solicitud_id = null, $estatus = null){
  $estatusSolicitud = new SolicitudEstatus();
  $estatusSolicitud = $estatusSolicitud->consultarPor("solicitudes_estatus_solicitudes",["solicitud_id"=>$solicitud_id,"estatus_solicitud_id"=>$estatus],"*");

  return !empty($estatusSolicitud["data"])?$estatusSolicitud["data"][0]["created_at"]:false;
}

function getProgramaEvaluaciones($programa_id = null){
  $programaEvaluaciones = new ProgramaEvaluacion();
  $programaEvaluaciones = $programaEvaluaciones->consultarPor("programa_evaluaciones",["programa_id"=>$programa_id],"*");

  return !empty($programaEvaluaciones["data"])?$programaEvaluaciones["data"]:[];
}

function getDetalleInspeccion($programa_id){
  $this->inspeccion = new Inspeccion();
  $this->inspeccion = $this->inspeccion->consultarPor("inspecciones",["programa_id"=>$programa_id],"*");

  $this->inspeccion = !empty($this->inspeccion["data"])?$this->inspeccion["data"][0]:false;

  $this->preguntas = [];
  //Obtener las preguntas con sus respuestas apartir del id de la inspección
  $respuestas = array();
  $respuestas_inspeccion = new Inspeccion();
  $res_respuestas = $respuestas_inspeccion->consultarPor("inspecciones_inspeccion_preguntas",array("inspeccion_id"=> $this->inspeccion["id"],"deleted_at"),array("inspeccion_pregunta_id","respuesta"));

  if( sizeof($res_respuestas["data"]) > 0 ){
    $res_respuestas = $res_respuestas["data"];
    foreach ($res_respuestas as $posicion => $campo) {
        $pregunta = new inspeccionPregunta();
        $pregunta->setAttributes(array("id" => $campo["inspeccion_pregunta_id"]));
        $res_pregunta = $pregunta->consultarId();
        $apartado = new InspeccionApartado();
        $apartado->setAttributes(array("id"=>$res_pregunta["data"]["id_inspeccion_apartado"]));
        $res_apartado = $apartado->consultarId();
        $temp["apartado"] = $res_apartado["data"]["nombre"];
        $temp["pregunta"] = $res_pregunta["data"]["pregunta"];
        $temp["respuesta"] = $campo["respuesta"];
        array_push($respuestas,$temp);
    }
    //Agrupar por apartados
    function arraySort($input,$sortkey){
      foreach ($input as $key => $val) {
         $output[$val[$sortkey]][] = $val;
      }
      return $output;
    }
    $myArray = arraySort($respuestas,'apartado');

    //Quita indices inecesarios y da el formato requerido
    $arrPreguntas = array();
    foreach ($myArray as $llave => $valor) {
        $res["apartado"] = $llave;
        $arrCampo = array();
        foreach ($valor as $key => $value) {
          $tempo["pregunta"] = $value["pregunta"];
          $tempo["respuesta"] = $value["respuesta"];
          array_push($arrCampo,$tempo);
        }
        $res["respuestas"]=$arrCampo ;
        array_push($arrPreguntas,$res);
    }

    //Agrega los campos del acta constitutiva
    $observacion = new InspeccionObservacion();
    $observaciones = $observacion->consultarPor("inspeccion_observaciones",array("inspeccion_id"=>$this->inspeccion["id"]),array("inspeccion_apartado_id","comentario"));
    if( sizeof($observaciones["data"]) > 0 ){
      foreach ($observaciones["data"] as $key => $value) {
        $apartado_observaciones = new InspeccionApartado();
        $apartado_observaciones->setAttributes(array("id"=>$value["inspeccion_apartado_id"]));
        $res_apar_obs = $apartado_observaciones->consultarId();
        $res_apar_obs = $res_apar_obs["data"];
        $tem_obser["apartado"] =  $res_apar_obs["nombre"];
        $tem_obser["respuestas"] = array();
        $otro["pregunta"] = "";
        $otro["respuesta"] = $value["comentario"];
        array_push($tem_obser["respuestas"],$otro);
        array_push($arrPreguntas,$tem_obser);
      }

    }
    $this->preguntas = $arrPreguntas;
  }
}

function actualizarEstatus($estatus,$solicitud_id,$mensaje)
{
  $solicitud = new Solicitud();
  $solicitud->setAttributes(array("id"=>$solicitud_id,"estatus_solicitud_id"=>$estatus));
  $solicitud->guardar();

  $estatusSolicitud = new SolicitudEstatus();
  $estatusSolicitud->setAttributes(array("solicitud_id"=>$solicitud_id,"estatus_solicitud_id"=>$estatus,"comentario"=>$mensaje));
  $estatusSolicitud->guardar();

  //Notificación apps
  if($estatus == 9)
  {
    $msj = "Su solicitud está a la espera de la emisón del acuerdo de RVOE.";
  }
  if($estatus == 10)
  {
    $msj = "Su solicitud obtuvo el RVOE ¡Felicidades!. Por favor pase a recogerlo a la SICyt.";
  }
  $usuarioNotificar = new Solicitud();
  $usuarioNotificar->setAttributes(array("id"=>$solicitud_id));
  $resUsuarioNotificar = $usuarioNotificar->consultarId();
  $resUsuarioNotificar = $resUsuarioNotificar["data"];
  $notificacion = new Usuario();
  $notificacion->notificacionIdUsuario($resUsuarioNotificar["usuario_id"],"Acuerdo RVOE",$msj);
}

function actualizarPrograma($solicitud_id,$rvoe)
{
  $programa = new Programa();
  $res_programa = $programa->consultarPor("programas",array("solicitud_id"=>$solicitud_id),"*");
  $programas = $res_programa["data"][0];

  $programaAct = new Programa();
  $programaAct->setAttributes(array("id"=>$programas["id"] ,"acuerdo_rvoe"=>$rvoe,"minimo_horas_optativas"=>$programas["minimo_horas_optativas"],"minimo_creditos_optativas"=>$programas["minimo_creditos_optativas"],"metodos_induccion"=>$programas["metodos_induccion"]));
  $programaAct->guardar();
}


}
?>
