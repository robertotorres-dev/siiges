<?php
require( "../../fpdf181/fpdf.php" );
require_once "../../models/modelo-titulo-electronico.php";
// include QR_BarCode class 
include "../../Classes/QR_BarCode.php";

class PDF extends FPDF
{
  // Cabecera de p�gina
  function Header()
  {
    $this->AddFont('Nutmeg', '', 'Nutmeg-Regular.php');
    //$this->Image( "../../images/encabezado.jpg",10,5,120);
    $this->Image("../../images/titulo_fondo.png",-2,-3,220);
    $this->Ln(10);  
    $this->SetFont( "Nutmeg", "", 8 );
    $this->Cell( 0, 0, utf8_decode("SECRETARÍA DE INNOVACIÓN, CIENCIA"), 0, 0, "C", false);
    $this->Ln(4);
    $this->Cell( 0, 0, utf8_decode("Y TECNOLOGÍA DE JALISCO."), 0, 0, "C", false);
    $this->Ln(5);
    $this->Cell( 0, 0, utf8_decode("SUBSECRETARÍA DE EDUCACIÓN SUPERIOR."), 0, 0, "C", false);
    $this->Ln(5);
    $this->Cell( 0, 0, utf8_decode("DIRECCIÓN GENERAL DE INCORPORACIÓN"), 0, 0, "C", false);
    $this->Ln(4);
    $this->Cell( 0, 0, utf8_decode("Y SERVICIOS ESCOLARES."), 0, 0, "C", false);
    $this->Ln(5);
    $this->Cell( 0, 0, utf8_decode("DIRECCIÓN DE SERVICIOS ESCOLARES."), 0, 0, "C", false);
  }

  // Pie de p�gina
  function Footer()
  {
    //https://programacion.net/articulo/como_generar_un_codigo_qr_con_php_utilizando_la_api_de_google_chart_1706
    // QR_BarCode object 
    $qr = new QR_BarCode(); 
    $qr->url('www.google.com.mx');
    $temp = sys_get_temp_dir();
    $qr->qrCode(350, $temp."cw-qr.png");
    $this->Image( $temp."cw-qr.png" ,150,180,50);
  }

  
  function vcell($c_width, $c_height, $x_axis,$text,$length){
    // var_dump($text);
      /*echo "<br>";
      echo $text;
      echo $length;
      echo "<br>";*/
      $w_text=str_split($text,$length);
      $c_height = $c_height > sizeof($w_text)*5?$c_height:sizeof($w_text)*5;
      $w_w = sizeof($w_text);
      $len=strlen($text);
      if($len>$length){
        $w_w_1 = $w_w + 4;
        foreach ($w_text as $key => $value) {
          $this->SetX($x_axis);
          $this->Cell($c_width,$w_w_1,utf8_decode($value),'','','L');
          if($w_w > 4){
            $w_w_1 += 7;
          }else{
            $w_w_1 += $w_w + 5;
          }
        }
        $this->SetX($x_axis);
        $this->Cell($c_width,$c_height,'','LTRB',0,'L',0);
      }else{
          $this->SetX($x_axis);
          $this->Cell($c_width,$c_height,utf8_decode($text),'LTRB',0,'L',0);
      }
      return $c_height;
  }

  function Tabla($header,$datos,$width = 0,$height = 0,$length = 15,$sHeaders=true)
 {
   $c_width = $width;
   $c_height = $height;
   $this->SetLineWidth(.3);
   $this->SetFont('Arial','B',9);
  //Cabecera
  if($sHeaders){
    foreach ($header as $key => $value) {
      // $x_axis=$this->getx();
      // $c_height = $this->vcell($c_width[$key],$c_height,$x_axis,$value,$length[$key]);
      $this->Cell($c_width[$key],5,utf8_decode($value),1,0,'C',true);
    }
    $this->Ln();
  }

  $this->SetFont('Arial','',7);
  //print_r($datos);
  if (is_array($datos) || is_object($datos))
  {
    foreach ($datos as $registro) {
      $registro = (array) $registro;
      foreach ($header as $key => $value) {
        if($this->checkNewPage()){
          $this->Ln(25);
        }

        $x_axis=$this->getx();
        $c_height = $this->vcell($c_width[$key],$c_height,$x_axis,$registro[$key],$length[$key]);

      }

      $this->Ln();
    }
  }
  // exit();
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
function getData($titulo_id = null){
  $this->titulo = new TitulosElectronicos();
  $this->titulo->setAttributes(["folio_control"=>$titulo_id]);
  $this->titulo = $this->titulo->consultarPor("titulos_electronicos",array(["folio_control"=>$titulo_id], "deleted_at"),"*");
  //print_r($this->titulo);
  $this->titulo = !empty($this->titulo["data"])?$this->titulo["data"][0]:false;
}
//******************************************************//
function getProgramaPorSolicitud($solicitud_id = null){
  $this->programa = new Programa();
  $this->programa = $this->programa->consultarPor("programas",["solicitud_id"=>$solicitud_id],"*");
  $this->programa = !empty($this->programa["data"][0])?$this->programa["data"][0]:false;
  /* if(!$this->programa){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Programa no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */
  // Nivel
  $nivel = new Nivel();
  $nivel->setAttributes(["id"=>$this->programa["nivel_id"]]);
  $nivel = $nivel->consultarId();
  $nivel = !empty($nivel["data"])?$nivel["data"]:false;
  /* if(!$nivel){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Nivel no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */
  $this->programa["nivel"] = $nivel;

  // Modalidad
  $modalidad = new Modalidad();
  $modalidad->setAttributes(["id"=>$this->programa["modalidad_id"]]);
  $modalidad = $modalidad->consultarId();
  $modalidad = !empty($modalidad["data"])?$modalidad["data"]:false;
  /* if(!$modalidad){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Modalidad no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */
  $this->programa["modalidad"] = $modalidad;

  // Ciclo
  $ciclo = new Ciclo();
  $ciclo->setAttributes(["id"=>$this->programa["ciclo_id"]]);
  $ciclo = $ciclo->consultarId();
  $ciclo = !empty($ciclo["data"])?$ciclo["data"]:false;
  /* if(!$ciclo){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Ciclo no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */
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
    /* if(!$turno){
      $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Turno no encontrado.","data"=>[]]);
      header("Location: ../home.php");exit();
    } */
    $this->programa["turno"] .= $turno["nombre"].", ";
  }
}
//*********************************************//
function getPlantel($plantel_id = null){
  $this->plantel = new Plantel();
  $this->plantel->setAttributes(["id"=>$plantel_id]);
  $this->plantel = $this->plantel->consultarId();
  $this->plantel = !empty($this->plantel["data"])?$this->plantel["data"]:false;
  /* if(!$this->plantel){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Plantel no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */

  $domicilio = new Domicilio();
  $domicilio->setAttributes(["id"=>$this->plantel["domicilio_id"]]);
  $domicilio = $domicilio->consultarId();
  $domicilio = !empty($domicilio["data"])?$domicilio["data"]:false;
  /* if(!$domicilio){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Domicilio no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */

  $this->plantel["domicilio"] = $domicilio;

}
//*******************************************///
function getInstitucion($institucion_id = null){

  $this->institucion = new Institucion();
  $this->institucion->setAttributes(["id"=>$institucion_id]);
  $this->institucion = $this->institucion->consultarId();
  $this->institucion = !empty($this->institucion["data"])?$this->institucion["data"]:false;
  /* if(!$this->institucion){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Institucion no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */
}
//************************************************///
function getRepresentante($usuario_id = null){

  $this->representante = new Usuario();
  $this->representante->setAttributes(["id"=>$usuario_id]);
  $this->representante = $this->representante->consultarId();
  $this->representante = !empty($this->representante["data"])?$this->representante["data"]:false;
  /* if(!$this->representante){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Representante no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */
}


//****************************************************//
function getInstitucionPorUsuario($usuario_id = null){
  $this->institucion = new Institucion();
  $this->institucion = $this->institucion->consultarPor("instituciones",["usuario_id"=>$usuario_id],"*");
  $this->institucion = !empty($this->institucion["data"][0])?$this->institucion["data"][0]:false;
  /* if(!$this->institucion){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Institución no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */
}

function getPrograma($programa_id = null){
  $this->programa = new Programa();
  $this->programa->setAttributes(["id"=>$programa_id]);
  $this->programa = $this->programa->consultarId();
  $this->programa = !empty($this->programa["data"])?$this->programa["data"]:false;
  /* if(!$this->programa){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Programa no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */
}
//*********************************************************//
function getEvaluador($evaluador_id = null){
  $this->evaluador = new Evaluador();
  $this->evaluador->setAttributes(["id"=>$evaluador_id]);
  $this->evaluador = $this->evaluador->consultarId();
  $this->evaluador = !empty($this->evaluador["data"])?$this->evaluador["data"]:false;
  /* if(!$this->evaluador){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Evaluador no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */
  $persona = new Persona();
  $persona->setAttributes(["id"=>$this->evaluador["persona_id"]]);
  $persona = $persona->consultarId();
  $persona = !empty($persona["data"])?$persona["data"]:false;
  /* if(!$persona){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Pesona no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  } */
  $this->evaluador["persona"] = $persona;
}


}
?>
