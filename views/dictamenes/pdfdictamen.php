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


class PDF extends FPDF
{
  // Cabecera de p�gina
  function Header()
  {
    //$this->Image( "../../images/encabezado.jpg",10,5,120);
    $this->Image("../../images/encabezado.jpg",0,15,75);
    $this->Image("../../images/direccion_sicyt.PNG",155,12,40);
  }

  // Pie de p�gina
  function Footer()
  {
    $this->SetY( -30 );
    $this->SetFont( "Arial", "B", 8 );
    //$this->Cell( 0, 5, utf8_decode("Teléfono: 01 (33) 1543 2800 "), 0, 1, "L" );
    $this->SetFont( "Arial", "", 8 );
    //$this->Cell( 120, 5, "Edificio MIND. planta baja. Av. Faro 2350 / col. Verde Valle, 44550, Guadalajara, Jal. ", 0, 0, "L" );
    $this->SetTextColor( 0, 107, 210 );
    $this->SetFont( "Arial", "B", 11 );
    //$this->Cell( 10, 5, "SYCIT.", 0, 0, "R" );
    $this->SetTextColor( 0, 0, 0 );
    //$this->Cell( 17, 5, "JALISCO", 0, 0, "R" );
    $this->SetTextColor( 100, 100, 100 );
    //$this->Cell( 10, 5, ".GOB", 0, 0, "R" );
    $this->SetTextColor( 0, 107, 210 );
    $this->SetFont( "Arial", "", 11 );
    //$this->Cell( 7, 5, ".MX", 0, 0, "R" );
    $this->SetFillColor( 0, 107, 210 );
    //$this->Cell( 11, 5, "", 0, 1, "L",true);
    //$this->SetLineWidth(0.5);
    //$this->Line(20,260,195,260);
    $this->SetFont( "Arial", "B", 9 );
    $this->SetTextColor( 0 , 0, 0 );
    $this->Ln( 5 );
    $this->Image( "../../images/jalisco.png",20,245,20);
    //$this->Cell( 25, 5, "@ InnovaJal", 0, 0, "R" );
    //$this->Image( "../../images/facebook.JPG",53,264,0);
    //$this->Cell( 44, 5, "InnovacionJalisco", 0, 1, "R" );
  }

function convertirFecha($fecha){
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    return date('d',strtotime($fecha))." de ".$meses[date('n',strtotime($fecha))-1]. " del ".date('Y') ;
  }

 function checkNewPage(){
   if($this->GetY() > 220){
     $this->AliasNbPages( );
     $this->AddPage( "P", "Letter" );
     return true;
   }
 }
//******************************************************//
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
//******************************************************//
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
//*********************************************//
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
//*******************************************///
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
//************************************************///
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


//****************************************************//
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
//*********************************************************//
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
  $persona->setAttributes(["id"=>$this->evaluador["persona_id"]]);
  $persona = $persona->consultarId();
  $persona = !empty($persona["data"])?$persona["data"]:false;
  if(!$persona){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Pesona no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
  $this->evaluador["persona"] = $persona;
}


}
?>
