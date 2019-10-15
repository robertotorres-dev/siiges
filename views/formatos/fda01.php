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

   //session_start( );
  if(!isset($_GET["id"]) && !$_GET["id"]){
    header("Location: ../home.php");exit();
  }

  class PDF extends FPDF
  {
    // Cabecera de p�gina
    function Header()
    {
      $this->Image( "../../images/encabezado.jpg",0,15,75);
      $this->Image("../../images/direccion_sicyt.PNG",155,12,40);
      $this->SetFont( "Arial", "B", 11 );
      $this->Ln( 25 );
      $this->SetTextColor( 255, 255, 255 );
      $this->SetFillColor( 0, 127, 204 );
      $this->Cell( 140, 5, "", 0, 0, "L");
      $this->Cell( 45, 6, "FDA01", 0, 0, "R", true);
      $this->Ln( 10 );
    }

    // Pie de p�gina
    function Footer()
    {
      $this->SetY( -30 );
      $this->SetFont( "Arial", "B", 8 );
      //$this->Cell( 0, 5, utf8_decode("Teléfono: 01 (33) 1543 2800 "), 0, 1, "L" );
      $this->SetFont( "Arial", "", 8 );
      //$this->Cell( 120, 5, "Edificio MIND. planta baja. Av. Faro 2350 / col. Verde Valle, 44550, Guadalajara, Jal. ", 0, 0, "L" );
      $this->SetTextColor( 205, 36, 33 );
      $this->SetFont( "Arial", "B", 11 );
      //$this->Cell( 10, 5, "SYCIT.", 0, 0, "R" );
      $this->SetTextColor( 0, 0, 0 );
      //$this->Cell( 17, 5, "JALISCO", 0, 0, "R" );
      $this->SetTextColor( 100, 100, 100 );
      //$this->Cell( 10, 5, ".GOB", 0, 0, "R" );
      $this->SetTextColor( 205, 36, 33 );
      $this->SetFont( "Arial", "", 11 );
      //$this->Cell( 7, 5, ".MX", 0, 0, "R" );
      $this->SetFillColor( 205, 36, 33 );
      //$this->Cell( 11, 5, "", 0, 1, "L",true);
      //$this->SetLineWidth(0.5);
      //$this->Line(20,260,195,260);
      $this->SetFont( "Arial", "B", 9 );
      $this->SetTextColor( 0 , 0, 0 );
      $this->Ln( 5 );
      $this->Image( "../../images/jalisco.png",20,250,20);
      //$this->Cell( 25, 5, "@ InnovaJal", 0, 0, "R" );
      //$this->Image( "../../images/facebook.JPG",53,264,0);
      //$this->Cell( 44, 5, "InnovacionJalisco", 0, 1, "R" );
    }

    function vcell($c_width, $c_height, $x_axis,$text){
        $w_text=str_split($text,15);
        $c_height = $c_height > sizeof($w_text)*5?$c_height:sizeof($w_text)*5;
        $w_w = sizeof($w_text);
        $len=strlen($text);
        if($len>15){
          $w_w_1 = $w_w + 4;
          foreach ($w_text as $key => $value) {
            $this->SetX($x_axis);
            $this->Cell($c_width,$w_w_1,$w_text[$key],'','','L');
            $w_w_1 += $w_w + 5;
          }
          $this->SetX($x_axis);
          $this->Cell($c_width,$c_height,'','LTRB',0,'L',0);
        }else{
            $this->SetX($x_axis);
            $this->Cell($c_width,$c_height,$text,'LTRB',0,'C',0);
        }
        return $c_height;
    }

    function Tabla($header,$datos)
   {

     $c_width = 29;
     $c_height = 0;
     $this->SetLineWidth(.3);
     $this->SetFont('Arial','B',9);
     $this->SetTextColor( 255, 255, 255 );
    //Cabecera
    foreach ($header as $key => $value) {
      $this->Cell($c_width,5,$value,1,0,'C',true);
    }
    $this->Ln();
    $this->SetFont('Arial','',9);
    $this->SetTextColor( 0, 0, 0 );
    foreach ($datos as $registro) {
      $x_axis=$this->getx();
      $c_height = $this->vcell($c_width,$c_height,$x_axis,utf8_decode($registro["nombre"]));
      $x_axis=$this->getx();
      $c_height = $this->vcell($c_width,$c_height,$x_axis,utf8_decode($registro["cargo"]));
      $x_axis=$this->getx();
      $c_height = $this->vcell($c_width,$c_height,$x_axis,utf8_decode($registro["telefono"]));
      $x_axis=$this->getx();
      $c_height = $this->vcell($c_width,$c_height,$x_axis,utf8_decode($registro["celular"]));
      $x_axis=$this->getx();
      $c_height = $this->vcell($c_width,$c_height,$x_axis,utf8_decode($registro["correo"]));
      $x_axis=$this->getx();
      $c_height = $this->vcell($c_width,$c_height,$x_axis,utf8_decode($registro["horario"]));
      $this->Ln();
    }
   }
  }

  session_start( );
  if(!isset($_GET["id"]) && !$_GET["id"]){
    header("Location: ../home.php");exit();
  }

// Solicitud
$solicitud = new Solicitud();
$solicitud->setAttributes(["id"=>$_GET["id"]]);
$solicitud = $solicitud->consultarId();
$solicitud = !empty($solicitud["data"])?$solicitud["data"]:false;
if(!$solicitud){
  $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Solicitud no encontrada.","data"=>[]]);
  header("Location: ../home.php");exit();
}
// Programa
$programa = new Programa();
$programa = $programa->consultarPor("programas",["solicitud_id"=>$_GET["id"]],"*");
$programa = !empty($programa["data"][0])?$programa["data"][0]:false;
if(!$programa){
  $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Programa no encontrado.","data"=>[]]);
  header("Location: ../home.php");exit();
}
// Nivel
$nivel = new Nivel();
$nivel->setAttributes(["id"=>$programa["nivel_id"]]);
$nivel = $nivel->consultarId();
$nivel = !empty($nivel["data"])?$nivel["data"]:false;
if(!$nivel){
  $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Nivel no encontrado.","data"=>[]]);
  header("Location: ../home.php");exit();
}
//Modalidad
$modalidad = new Modalidad();
$modalidad->setAttributes(["id"=>$programa["modalidad_id"]]);
$modalidad = $modalidad->consultarId();
$modalidad = !empty($modalidad["data"])?$modalidad["data"]:false;
if(!$modalidad){
  $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Modalidad no encontrada.","data"=>[]]);
  header("Location: ../home.php");exit();
}
//Ciclo
$ciclo = new Ciclo();
$ciclo->setAttributes(["id"=>$programa["ciclo_id"]]);
$ciclo = $ciclo->consultarId();
$ciclo = !empty($ciclo["data"])?$ciclo["data"]:false;
if(!$ciclo){
  $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Ciclo no encontrado.","data"=>[]]);
  header("Location: ../home.php");exit();
}
$turno = "";

// Turnos
$turnos = new Turno();

$turnos = $turnos->consultarPor("programas_turnos",["programa_id"=>$programa["id"]],"*");
$turnos = !empty($turnos["data"])?$turnos["data"]:false;
if(!$turnos){
  $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Turno no encontrada.","data"=>[]]);
  header("Location: ../home.php");exit();
}
foreach ($turnos as $value) {
  $objTurno = new Turno();
  $objTurno->setAttributes(["id"=>$value["turno_id"]]);
  $objTurno = $objTurno->consultarId();
  $objTurno = !empty($objTurno["data"])?$objTurno["data"]:false;
  if(!$objTurno){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Turno no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
  $turno .= $objTurno["nombre"].", ";
}

$nombreInstitucion = "";
// Institución
$institucion = new Institucion();
$institucion = $institucion->consultarPor("instituciones",["usuario_id"=>$solicitud["usuario_id"]],"*");
$institucion = !empty($institucion["data"][0])?$institucion["data"][0]:false;
if(!$institucion){
  $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Institució no encontrada.","data"=>[]]);
  header("Location: ../home.php");exit();
}
if($institucion["es_nombre_autorizado"]){
  $nombreInstitucion = $institucion["nombre"];
}else{
  // Institución
  $ratificacion = new RatificacionNombre();
  $ratificacion = $ratificacion->consultarPor("ratificacion_nombres",["institucion_id"=>$institucion["id"]],"*");
  $ratificacion = !empty($ratificacion["data"][0])?$ratificacion["data"][0]:false;
  if(!$ratificacion){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Ratificación no encontrada.","data"=>[]]);
    header("Location: ../home.php");exit();
  }
  $nombreInstitucion .= $ratificacion["nombre_propuesto1"].", ".$ratificacion["nombre_propuesto2"].", ".$ratificacion["nombre_propuesto3"];
}

//usuario
// Institución
$usuarioR = new Usuario();
$usuarioR->setAttributes(["id"=>$institucion["usuario_id"]]);
$usuarioR = $usuarioR->consultarId();
$usuarioR = !empty($usuarioR["data"])?$usuarioR["data"]:false;
if(!$usuarioR){
  $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Usuario representante no encontrado.","data"=>[]]);
  header("Location: ../home.php");exit();
}
$nombreRepresentante = $usuarioR["persona"]["nombre"]." ".$usuarioR["persona"]["apellido_paterno"]." ".$usuarioR["persona"]["apellido_materno"];

$diligencias = new SolicitudUsuario();
$diligencias = $diligencias->consultarPor("solicitudes_usuarios",["solicitud_id"=>$solicitud["id"]],"*");
$diligencias = !empty($diligencias["data"])?$diligencias["data"]:false;
if(!$diligencias){
  $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Personal para diligencias no encontrados.","data"=>[]]);
  header("Location: ../home.php");exit();
}
$nombresDiligencias = [];
foreach ($diligencias as $diligencia) {
  $usuarioD = new Persona();
  $usuarioD->setAttributes(["id"=>$diligencia["usuario_id"]]);
  $usuarioD = $usuarioD->consultarId();
  $usuarioD = !empty($usuarioD["data"])?$usuarioD["data"]:false;
  if(!$usuarioD){
    $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Persona para diligencia no encontrado.","data"=>[]]);
    header("Location: ../home.php");exit();

  }

  array_push($nombresDiligencias,["cargo"=>$usuarioD["titulo_cargo"],
                                  "nombre"=>$usuarioD["nombre"]." ".$usuarioD["apellido_paterno"]." ".$usuarioD["apellido_materno"],
                                  "telefono" => $usuarioD["telefono"],
                                  "celular" => $usuarioD["celular"],
                                  "correo" => $usuarioD["correo"],
                                  "horario" => $usuarioD["rfc"]
                                ]);
}

  $fecha = Solicitud::convertirFecha($solicitud['fecha']);
  $headers = [ "Nombre","Cargo", utf8_decode("Teléfono"), "Celular", "Correo", "Horario"];

  $pdf = new PDF( );
  $pdf->AliasNbPages( );
  $pdf->AddPage( "P", "Letter" );
  $pdf->SetFont( "Arial", "B", 11 );
  $pdf->SetMargins(20, 20 , 20);

  $pdf->SetTextColor( 0, 127, 204 );
  $pdf->Cell( 0, 5, utf8_decode("OFICIO ENTREGA DE LA DOCUMENTACIÓN"), 0, 1, "R");
  $pdf->SetTextColor( 0, 0, 0 );
  $pdf->Ln( 10 );
  $pdf->Cell( 0, 5, utf8_decode("DIRECTOR GENERAL DE EDUCACIÓN SUPERIOR"), 0, 1, "L");
  $pdf->Cell( 0, 5, utf8_decode("INVESTIGACIÓN Y POSGRADO"), 0, 1, "L");
  $pdf->Ln( 10 );
  $pdf->Cell( 0, 5, utf8_decode("AT´N: COORDINADORA DE INSTITUCIONES DE EDUCACIÓN"), 0, 1, "R");
  $pdf->Cell( 0, 5, utf8_decode("SUPERIOR INCORPORADAS"), 0, 1, "R");
  $pdf->Ln( 5 );
  $pdf->SetFont( "Arial", "", 9 );

  $pdf->Cell( 0, 5, utf8_decode("Guadalajara, Jal. a $fecha"), 0, 1, "R");
  $pdf->Ln( 5 );
  $pdf->MultiCell(0, 5, utf8_decode("Por este conducto manifiesto que estoy en condiciones para iniciar el trámite de Solicitud de Reconocimiento de Validez Oficial de Estudios (RVOE) para el programa ".$nivel['descripcion']." en ".$programa['nombre'].", ".$modalidad['nombre'].", en periodos ".$ciclo["nombre"].", turno ".$turno." de la institución ".$nombreInstitucion."."),0,"J");
  $pdf->Ln( 5 );

  $pdf->MultiCell(0, 5, utf8_decode("Así mismo declaro Bajo Protesta de Decir la Verdad que la información y los documentos anexos en la presente solicitud son verídicos y fueron elaborados siguiendo principios éticos profesionales, que son de mi conocimiento las penas en que incurren quienes se conducen con falsedad ante autoridad distinta de la judicial, y acepto que el domicilio de la institución sea el mismo para recibir notificaciones y que autorizo para oírlas y recibirlas a la(s) siguiente(s) persona(s):"),0,"J");
  $pdf->Ln( 5 );
  $pdf->SetTextColor( 0, 0, 0 );
  $pdf->Tabla($headers,$nombresDiligencias);
  $pdf->Ln( 5 );
  $pdf->MultiCell(0, 5, utf8_decode("Quedo enterado de todas las disposiciones establecidas en el Reglamento de La Ley de Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal, así como en el Instructivo para integrar el expediente de la solicitud de obtención de Reconocimiento de Validez Oficial de Estudios de Educación Superior."),0,"J");
  $pdf->Ln( 10 );
  $pdf->SetFont( "Arial", "B", 11 );
  $pdf->Cell( 0, 5, utf8_decode($nombreRepresentante), 0, 1, "C");

  $pdf->Output( "I", "FDA01.pdf" );

?>
