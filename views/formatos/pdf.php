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


class PDF extends FPDF
{
  // Cabecera de p�gina
  function Header()
  {
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
  // exit();
 }
 function checkNewPage(){
   if($this->GetY() > 220){
     $this->AliasNbPages( );
     $this->AddPage( "P", "Letter" );
     return true;
   }
 }
 function getData($id = null){
   // Solicitud
   $this->solicitud = new Solicitud();
   $this->solicitud->setAttributes(["id"=>$id]);
   $this->solicitud = $this->solicitud->consultarId();
   $this->solicitud = !empty($this->solicitud["data"])?$this->solicitud["data"]:false;
   if(!$this->solicitud){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Solicitud no encontrada.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   $this->tipoSolicitud = new TipoSolicitud();
   $this->tipoSolicitud->setAttributes(["id"=>$this->solicitud["tipo_solicitud_id"]]);
   $this->tipoSolicitud = $this->tipoSolicitud->consultarId();
   $this->tipoSolicitud = !empty($this->tipoSolicitud["data"])?$this->tipoSolicitud["data"]:false;
   if(!$this->tipoSolicitud){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Tipo de solicitud no encontrada.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   // Programa
   $this->programa = new Programa();
   $this->programa = $this->programa->consultarPor("programas",["solicitud_id"=>$id],"*");
   $this->programa = !empty($this->programa["data"][0])?$this->programa["data"][0]:false;
   if(!$this->programa){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Solicitud no encontrada.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   //print_r($this->programa);
   // Nivel
   $this->nivel = new Nivel();
   $this->nivel->setAttributes(["id"=>$this->programa["nivel_id"]]);
   $this->nivel = $this->nivel->consultarId();
   $this->nivel = !empty($this->nivel["data"])?$this->nivel["data"]:false;
   if(!$this->nivel){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Nivel no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   // Antecendentes
   $antecendente = new Nivel();
   $antecendente->setAttributes(["id"=>$this->programa["antecedente_academico"]]);
   $antecendente = $antecendente->consultarId();
   $antecendente = !empty($antecendente["data"])?$antecendente["data"]:false;
   if(!$antecendente){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Nivel no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   $this->programa["antecedente"] = $antecendente;
   //Modalidad
   $this->modalidad = new Modalidad();
   $this->modalidad->setAttributes(["id"=>$this->programa["modalidad_id"]]);
   $this->modalidad = $this->modalidad->consultarId();
   $this->modalidad = !empty($this->modalidad["data"])?$this->modalidad["data"]:false;
   if(!$this->modalidad){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Modalidad no encontrada.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   //Ciclo
   $this->ciclo = new Ciclo();
   $this->ciclo->setAttributes(["id"=>$this->programa["ciclo_id"]]);
   $this->ciclo = $this->ciclo->consultarId();
   $this->ciclo = !empty($this->ciclo["data"])?$this->ciclo["data"]:false;
   if(!$this->ciclo){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Ciclo no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   $this->turno = "";
   $this->turnoArray = [];
   // Turnos
   $this->turnos = new Turno();

   $this->turnos = $this->turnos->consultarPor("programas_turnos",["programa_id"=>$this->programa["id"]],"*");
   $this->turnos = !empty($this->turnos["data"])?$this->turnos["data"]:false;
   if(!$this->turnos){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Solicitud no encontrada.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   foreach ($this->turnos as $value) {
     $this->objTurno = new Turno();
     $this->objTurno->setAttributes(["id"=>$value["turno_id"]]);
     $this->objTurno = $this->objTurno->consultarId();
     $this->objTurno = !empty($this->objTurno["data"])?$this->objTurno["data"]:false;
     if(!$this->objTurno){
       $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Nivel no encontrado.","data"=>[]]);
       header("Location: ../home.php");exit();
     }
     $this->turno .= $this->objTurno["nombre"].", ";
     array_push($this->turnoArray,$this->objTurno["nombre"]);
   }
   // Plantel
   $this->plantel = new Plantel();
   $this->plantel->setAttributes(["id"=>$this->programa["plantel_id"]]);
   $this->plantel = $this->plantel->consultarId();
   $this->plantel = !empty($this->plantel["data"])?$this->plantel["data"]:false;
   if(!$this->plantel){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Plantel no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   // DOMICILIO plantel_id
   $this->domicilioPlantel = new Domicilio();
   $this->domicilioPlantel->setAttributes(["id"=>$this->plantel["domicilio_id"]]);
   $this->domicilioPlantel = $this->domicilioPlantel->consultarId();
   $this->domicilioPlantel = !empty($this->domicilioPlantel["data"])?$this->domicilioPlantel["data"]:false;
   if(!$this->domicilioPlantel){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Plantel no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   $this->nombreInstitucion = "";
   $this->razonSocial = "";
   // Institución
   $this->institucion = new Institucion();
   $this->institucion = $this->institucion->consultarPor("instituciones",["usuario_id"=>$this->solicitud["usuario_id"]],"*");
   $this->institucion = !empty($this->institucion["data"][0])?$this->institucion["data"][0]:false;
   if(!$this->institucion){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Institucion no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   $this->razonSocial = $this->institucion["razon_social"];
   if($this->institucion["es_nombre_autorizado"]){
     $this->nombreInstitucion = $this->institucion["nombre"];
   }else{
     // Institución
     $this->ratificacion = new RatificacionNombre();
     $this->ratificacion = $this->ratificacion->consultarPor("ratificacion_nombres",["institucion_id"=>$this->institucion["id"]],"*");
     $this->ratificacion = !empty($this->ratificacion["data"][0])?$this->ratificacion["data"][0]:false;
     if(!$this->ratificacion){
       $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Ratificación no encontrado.","data"=>[]]);
       header("Location: ../home.php");exit();
     }
     $this->nombreInstitucion .= $this->ratificacion["nombre_propuesto1"].", ".$this->ratificacion["nombre_propuesto2"].", ".$this->ratificacion["nombre_propuesto3"];
   }

   //usuario
   // Institución
   $this->usuarioR = new Usuario();
   $this->usuarioR->setAttributes(["id"=>$this->institucion["usuario_id"]]);
   $this->usuarioR = $this->usuarioR->consultarId();
   $this->usuarioR = !empty($this->usuarioR["data"])?$this->usuarioR["data"]:false;
   if(!$this->usuarioR){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Usuario representante no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   $this->nombreRepresentante = $this->usuarioR["persona"]["nombre"]." ".$this->usuarioR["persona"]["apellido_paterno"]." ".$this->usuarioR["persona"]["apellido_materno"];

   // Domicilio REPRESENTANTE
   $this->domicilioRepresentante = new Domicilio();
   $this->domicilioRepresentante->setAttributes(["id"=>$this->usuarioR["persona"]["domicilio_id"]]);
   $this->domicilioRepresentante = $this->domicilioRepresentante->consultarId();
   $this->domicilioRepresentante = !empty($this->domicilioRepresentante["data"])?$this->domicilioRepresentante["data"]:false;
   if(!$this->domicilioRepresentante){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Domicilio del representante no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   $this->diligencias = new SolicitudUsuario();
   $this->diligencias = $this->diligencias->consultarPor("solicitudes_usuarios",["solicitud_id"=>$this->solicitud["id"]],"*");
   $this->diligencias = !empty($this->diligencias["data"])?$this->diligencias["data"]:false;
   if(!$this->diligencias){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Solicitud usuario no encontrada.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   $this->nombresDiligencias = [];
   foreach ($this->diligencias as $this->diligencia) {
     $this->usuarioD = new Persona();
     $this->usuarioD->setAttributes(["id"=>$this->diligencia["usuario_id"]]);
     $this->usuarioD = $this->usuarioD->consultarId();
     $this->usuarioD = !empty($this->usuarioD["data"])?$this->usuarioD["data"]:false;
     if(!$this->usuarioD){
       $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Usuario de diligencia no encontrado.","data"=>[]]);
       header("Location: ../home.php");exit();

     }

     array_push($this->nombresDiligencias,["nombre"=>$this->usuarioD["nombre"]." ".$this->usuarioD["apellido_paterno"]." ".$this->usuarioD["apellido_materno"],
                                     "cargo"=>$this->usuarioD["titulo_cargo"],
                                     "telefono" => $this->usuarioD["telefono"],
                                     "celular" => $this->usuarioD["celular"],
                                     "correo" => $this->usuarioD["correo"],
                                     "horario" => $this->usuarioD["rfc"]
                                   ]);
   }
   //print_r($this->nombresDiligencias);

     $this->fecha = Solicitud::convertirFecha($this->solicitud['fecha']);


 }

 // Extrae los datos de las relaciones debiles de plantel
 function getDataPlantel($id = null){
   // Dictamenes del plantel
   $this->plantelDictamenes = new PlantelDictamen();
   $this->plantelDictamenes = $this->plantelDictamenes->consultarPor("plantel_dictamenes",["plantel_id"=>$id],"*");
   $this->plantelDictamenes = sizeof($this->plantelDictamenes["data"]) > 0? $this->plantelDictamenes["data"]:false;
   if(!$this->plantelDictamenes){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Dictamenes de plantel no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   // Edificios Niveles
   $this->plantelEdificioNiveles = new PlantelEdificioNivel();
   $this->plantelEdificioNiveles = $this->plantelEdificioNiveles->consultarPor("planteles_edificios_niveles",["plantel_id"=>$id],"*");
   $this->plantelEdificioNiveles = sizeof($this->plantelEdificioNiveles["data"]) > 0? $this->plantelEdificioNiveles["data"]:false;
   if(!$this->plantelEdificioNiveles){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Edificios o niveles de plantel no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   $this->edificioNiveles = [];
   foreach ($this->plantelEdificioNiveles as $key => $plantelNivel) {
     $this->edificioNivel = new EdificioNivel();
     $this->edificioNivel->setAttributes(["id"=>$plantelNivel["edificio_nivel_id"]]);
     $this->edificioNivel = $this->edificioNivel->consultarId();
     $this->edificioNivel = !empty($this->edificioNivel["data"])? $this->edificioNivel["data"]:false;
     if(!$this->edificioNivel){
       $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Edificios o niveles de plantel no encontrado.","data"=>[]]);
       header("Location: ../home.php");exit();
     }
     array_push($this->edificioNiveles,["nivel"=>$this->edificioNivel["descripcion"]]);
   }
   //Seguridad sistemas
   $this->plantelSeguridadSistemas = new PlantelSeguridadSistema();
   $this->plantelSeguridadSistemas = $this->plantelSeguridadSistemas->consultarPor("planteles_seguridad_sistemas",["plantel_id"=>$id],"*");
   $this->plantelSeguridadSistemas = sizeof($this->plantelSeguridadSistemas["data"]) > 0? $this->plantelSeguridadSistemas["data"]:false;
   if(!$this->plantelSeguridadSistemas){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Edificios o niveles de plantel no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   $this->seguridadSistemas = [];
   foreach ($this->plantelSeguridadSistemas as $key => $plantelSeguridad) {
     $this->seguridadSistema = new SeguridadSistema();
     $this->seguridadSistema->setAttributes(["id"=>$plantelSeguridad["seguridad_sistema_id"]]);
     $this->seguridadSistema = $this->seguridadSistema->consultarId();
     $this->seguridadSistema = !empty($this->seguridadSistema["data"])? $this->seguridadSistema["data"]:false;
     if(!$this->seguridadSistema){
       $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Sistemas de seguridad de plantel no encontrado.","data"=>[]]);
       header("Location: ../home.php");exit();
     }
     array_push($this->seguridadSistemas,["sistema"=>$this->seguridadSistema["descripcion"],
                                          "cantidad"=>$plantelSeguridad["cantidad"]]);
   }

   // Higienes
   $this->plantelHigienes = new PlantelHigiene();
   $this->plantelHigienes = $this->plantelHigienes->consultarPor("planteles_higienes",["plantel_id"=>$id],"*");
   $this->plantelHigienes = sizeof($this->plantelHigienes["data"]) > 0? $this->plantelHigienes["data"]:false;
   if(!$this->plantelHigienes){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Edificios o niveles de plantel no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   $this->higienes = [];
   foreach ($this->plantelHigienes as $key => $plantelHigiene) {
     $this->higiene = new Higiene();
     $this->higiene->setAttributes(["id"=>$plantelHigiene["higiene_id"]]);
     $this->higiene = $this->higiene->consultarId();
     $this->higiene = !empty($this->higiene["data"])? $this->higiene["data"]:false;
     if(!$this->higiene){
       $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Higiene de plantel no encontrado.","data"=>[]]);
       header("Location: ../home.php");exit();
     }
     if ($plantelHigiene["higiene_id"] == 8) {
       $plantelHigiene["cantidad"] = ($plantelHigiene["cantidad"] / $this->plantelHigienes[6]["cantidad"]);
     }
     array_push($this->higienes,["higiene"=>$this->higiene["descripcion"],
                                  "cantidad"=>$plantelHigiene["cantidad"]]);
   }

   // Infraestructura
   $this->plantelInfraestructura = new Infraestructura();
   $this->plantelInfraestructura = $this->plantelInfraestructura->consultarPor("infraestructuras",["plantel_id"=>$id],"*");
   $this->plantelInfraestructura = sizeof($this->plantelInfraestructura["data"]) > 0? $this->plantelInfraestructura["data"]:false;
   if(!$this->plantelInfraestructura){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Infraestructura de plantel no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   $this->tiposInstalacion = [];
   foreach ($this->plantelInfraestructura as $key => $infraestructura) {
     $this->instalacion = new TipoInstalacion();
     $this->instalacion->setAttributes(["id"=>$infraestructura["tipo_instalacion_id"]]);
     $this->instalacion = $this->instalacion->consultarId();
     $this->instalacion = !empty($this->instalacion["data"])? $this->instalacion["data"]:false;
     //print_r($this->instalacion);
     if(!$this->instalacion){
       $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Tipo de instalacion no encontrado.","data"=>[]]);
       header("Location: ../home.php");exit();
     }
     // Asignaturas
     $this->asignatura = new Asignatura();
     $this->asignatura = $this->asignatura->consultarPor("asignaturas",["infraestructura_id"=>$infraestructura["id"]],"*");
     $this->asignatura = sizeof($this->asignatura["data"]) > 0? $this->asignatura["data"]:[];

     $asignaturas = "";
     foreach ($this->asignatura as $key => $asignatura) {
       $asignaturas .= $asignatura["clave"].", ";
     }
     $asignaturas = !empty($asignaturas)?substr($asignaturas, 0, -2):"";
     array_push($this->tiposInstalacion,["instalacion"=>$this->instalacion["nombre"]." ".$infraestructura["nombre"],
                                        "capacidad"=>$infraestructura["capacidad"],
                                        "metros"=>$infraestructura["metros"],
                                        "recursos"=>$infraestructura["recursos"],
                                        "ubicacion"=>$infraestructura["ubicacion"],
                                        "asignaturas"=> $asignaturas
                                ]);
   }
   // Salud
   $this->salud = new SaludInstitucion();
   $this->salud = $this->salud->consultarPor("salud_instituciones",["plantel_id"=>$id],"*");
   $this->salud = sizeof($this->salud["data"]) > 0? $this->salud["data"]:[];
 }
 // Funcion para obtener la informacion de los programas con modalida mixta no escolarizada
 function getDataMixta($id = null){
   // MIXTA
   $this->mixta = new MixtaNoEscolarizada();
   $this->mixta = $this->mixta->consultarPor("mixta_noescolarizadas",["programa_id"=>$id],"*");
   $this->mixta = sizeof($this->mixta["data"]) > 0? $this->mixta["data"][0]:[];
   $licencias = isset($this->mixta["licencias_software"])?json_decode($this->mixta["licencias_software"]):[];
   $this->licencias_software = "";
   foreach ($licencias as $key => $licencia) {
     $this->licencias_software .= isset($licencia->contrato)?"Contrato:  ".$licencia->contrato."\n":"";
     $this->licencias_software .= isset($licencia->tipo)?"Tipo:  ".$licencia->tipo."\n":"";
     $this->licencias_software .= isset($licencia->terminos)?"Terminos:  ".$licencia->terminos."\n":"";
     $this->licencias_software .= isset($licencia->usuarios)?"Usuarios:  ".$licencia->usuarios."\n":"";
     $this->licencias_software .= isset($licencia->enlace)?"Enlace:  ".$licencia->enlace."\n":"";
   }
   $this->respaldos = new Respaldo();
   $this->respaldos = $this->respaldos->consultarPor("respaldos",["mixta_noescolarizada_id"=>$this->mixta["id"]],"*");
   $this->respaldos = sizeof($this->respaldos["data"]) > 0? $this->respaldos["data"]:[];
   $this->espejos = new Espejo();
   $this->espejos = $this->espejos->consultarPor("espejos",["mixta_noescolarizada_id"=>$this->mixta["id"]],"*");
   $this->espejos = sizeof($this->espejos["data"]) > 0? $this->espejos["data"][0]:[];
 }

 function getCoordinador(){
   $this->coordinador = new Persona();
   $this->coordinador->setAttributes(["id"=>$this->programa["persona_id"]]);
   $this->coordinador = $this->coordinador->consultarId();
   $this->coordinador = !empty($this->coordinador["data"])?$this->coordinador["data"]:false;
   if(!$this->coordinador){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Coordinadorno encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
 }

 function getAsignaturas(){
   $this->TodasAsignaturas = new Asignatura();
   $this->TodasAsignaturas = $this->TodasAsignaturas->consultarPor("asignaturas",["programa_id"=>$this->programa["id"]],"*");
   $this->TodasAsignaturas = sizeof($this->TodasAsignaturas["data"]) > 0? $this->TodasAsignaturas["data"]:[];
   $asignaturas = [];
   foreach ($this->TodasAsignaturas as $key => $asignatura) {
     //print_r(wordwrap($asignatura["nombre"], 11, "<br />\n"));
     //echo "<br>";
     $infra = new Infraestructura();
     $infra->setAttributes(["id"=>$asignatura["infraestructura_id"]]);
     $infra = $infra->consultarId();
     $infra = !empty($infra["data"])?$infra["data"]:false;
     $asignatura["infraestructura"] = $infra;
     $asignatura["infraestructura_nombre"] = $infra["nombre"];
     array_push($asignaturas,$asignatura);
   }
   $this->TodasAsignaturas = $asignaturas;
 }

 function getTrayectoria($solicitud_id = null){
   $this->solicitud = new Solicitud();
   $this->solicitud->setAttributes(["id"=>$solicitud_id]);
   $this->solicitud = $this->solicitud->consultarId();
   $this->solicitud = !empty($this->solicitud["data"])?$this->solicitud["data"]:false;

   if(!$this->solicitud){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Solicitud no encontrada.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   $this->representante = new Usuario();
   $this->representante->setAttributes(["id"=>$this->solicitud["usuario_id"]]);
   $this->representante = $this->representante->consultarId();
   $this->representante = !empty($this->representante["data"])?$this->representante["data"]:false;

   if(!$this->representante){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Representate no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   $this->nombreRepresentante = $this->representante["persona"]["nombre"]." ".$this->representante["persona"]["apellido_paterno"]." ".$this->representante["persona"]["apellido_materno"];

   $this->programa = new Programa();
   $this->programa = $this->programa->consultarPor("programas",["solicitud_id"=>$solicitud_id],"*");
   $this->programa = !empty($this->programa["data"])?$this->programa["data"][0]:false;

   if(!$this->programa){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Programa no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }
   $this->trayectoria = new Trayectoria();
   $this->trayectoria = $this->trayectoria->consultarPor("trayectorias",["programa_id"=>$this->programa["id"]],"*");
   $this->trayectoria = !empty($this->trayectoria["data"])?$this->trayectoria["data"][0]:false;
   if(!$this->trayectoria){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Trayectoria no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

 }

 function getDocentes($tipo_docente=null){
   $asignaturasDocente = new Asignatura();
   $asignaturasDocente = $asignaturasDocente->consultarPor("asignaturas",["programa_id"=>$this->programa["id"]],"*");
   $asignaturasDocente = !empty($asignaturasDocente["data"])?$asignaturasDocente["data"]:false;

   $mensaje = "";
   $this->AsigPorGrado = [];

   foreach ($asignaturasDocente as $key => $asignatura) {
     $docente = new Docente();
     $docente->setAttributes(["id"=>$asignatura["docente_id"]]);
     $docente = $docente->consultarId();
     $docente = !empty($docente["data"])?$docente["data"]:false;
     if(!$docente){
       $mensaje .="Docente " . $asignatura["docente_id"] . " no encontrado";
     }else {
       $PersonaDocente = new Persona();
       $PersonaDocente->setAttributes(["id"=>$docente["persona_id"]]);
       $PersonaDocente = $PersonaDocente->consultarId();
       $PersonaDocente = !empty($PersonaDocente["data"])?$PersonaDocente["data"]:false;
       if($docente){
         $formaciones = new Formacion();
         $formaciones = $formaciones->consultarPor("formaciones",["persona_id"=>$docente["persona_id"]],"*");
         $formaciones = !empty($formaciones["data"])?$formaciones["data"]:false;
       }

       if($tipo_docente == $docente["tipo_docente"]){
         if(!isset($this->AsigPorGrado[$asignatura["grado"]])){
           $this->AsigPorGrado[$asignatura["grado"]] = [];
           $fila = [
                     "docente"=>"NOMBRE DOCENTE",
                     "formacion"=>"FORMACIÓN PROFESIONAL",
                     "asignatura"=>"ASIGNATURA PROPUESTA",
                     "experiencia"=>"EXPERIENCIA",
                     "contratacion_antiguedad"=>"CONTRATO, ANTIGUEDAD",
                     "aceptado"=>"SE ACEPTA",
                     "observaciones"=>"OBSERVACIONES"
                   ];
          array_push($this->AsigPorGrado[$asignatura["grado"]],$fila);
        }
        $fTexto = "";

        foreach ($formaciones as $key => $formacion) {
          $nivel = new Nivel();
          $nivel->setAttributes(["id"=>$formacion["nivel"]]);
          $nivel = $nivel->consultarId();
          $nivel = !empty($nivel["data"])?$nivel["data"]:false;

          $fTexto .= $nivel["descripcion"]." en ".$formacion["nombre"].", ".$formacion["descripcion"]. " ";

        }
        $fila = [
                  "formacion"=>$fTexto,
                  "docente"=>$PersonaDocente["apellido_paterno"]." ".$PersonaDocente["apellido_materno"]." ".$PersonaDocente["nombre"],
                  "asignatura"=>$asignatura["clave"]." - ".$asignatura["nombre"],
                  "experiencia"=>"",
                  "contratacion_antiguedad"=>Docente::$TIPO_CONTRATACION[$docente["tipo_contratacion"]].", ".$docente["antiguedad"],
                  "aceptado"=>$docente["es_aceptado"]?"SI":"NO",
                  "observaciones"=>$docente["observaciones"]
                ];
                if ($PersonaDocente["id"] != 208) {
                  array_push($this->AsigPorGrado[$asignatura["grado"]],$fila);
                }

       }
     }
   }
   if(!empty($mensaje)){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>$mensaje,"data"=>[]]);
     header("Location: ../home.php");exit();
   }
 }

 function getDirector($solicitud_id = null){

   $this->solicitud = new Solicitud();
   $this->solicitud->setAttributes(["id"=>$solicitud_id]);
   $this->solicitud = $this->solicitud->consultarId();
   $this->solicitud = !empty($this->solicitud["data"])?$this->solicitud["data"]:false;
   if(!$this->solicitud){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Solicitud no encontrada.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   $this->representante = new Usuario();
   $this->representante->setAttributes(["id"=>$this->solicitud["usuario_id"]]);
   $this->representante = $this->representante->consultarId();
   $this->representante = !empty($this->representante["data"])?$this->representante["data"]:false;
   if(!$this->representante){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Usuario representante no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }


   $this->programa = new Programa();
   $this->programa = $this->programa->consultarPor("programas",["solicitud_id"=>$solicitud_id],"*");
   $this->programa = !empty($this->programa["data"])?$this->programa["data"][0]:false;
   if(!$this->programa){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Programa no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   $this->plantel = new Plantel();
   $this->plantel->setAttributes(["id"=>$this->programa["plantel_id"]]);
   $this->plantel = $this->plantel->consultarId();
   $this->plantel = !empty($this->plantel["data"])?$this->plantel["data"]:false;
   if(!$this->plantel){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Plantel no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   $this->director = new Persona();
   $this->director->setAttributes(["id"=>$this->plantel["persona_id"]]);
   $this->director = $this->director->consultarId();
   $this->director = !empty($this->director["data"])?$this->director["data"]:false;
   if(!$this->director){
     $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Director no encontrado.","data"=>[]]);
     header("Location: ../home.php");exit();
   }

   $this->formaciones = new Formacion();
   $this->formaciones = $this->formaciones->consultarPor("formaciones",array("persona_id"=>$this->director["id"], "deleted_at"),"*");
   $this->formaciones = !empty($this->formaciones["data"])?$this->formaciones["data"]:false;

   foreach ($this->formaciones as $key => $formacion) {
     $nivel = new Nivel();
     $nivel->setAttributes(["id"=>$formacion["nivel"]]);
     $nivel = $nivel->consultarId();
     $nivel = !empty($nivel["data"])?$nivel["data"]:false;

     $this->formaciones[$key]["nivel"] = $nivel["descripcion"];
   }

   $this->experiencias = new Experiencia();
   $this->experiencias = $this->experiencias->consultarPor("experiencias",array("persona_id"=>$this->director["id"], "deleted_at"),"*");
   $this->experiencias = !empty($this->experiencias["data"])?$this->experiencias["data"]:false;

   $this->experienciaDocente = [];
   $this->experienciaProDir = [];
   if ($this->experiencias) {
     foreach ($this->experiencias as $key => $experiencia) {
       if(Experiencia::EXPERIENCIA_DOCENTE == $experiencia["tipo"]){
         array_push($this->experienciaDocente,$experiencia);
       }else{
         array_push($this->experienciaProDir,$experiencia);

       }
     }
   }


   $publicaciones = new Publicacion();
   $publicaciones = $publicaciones->consultarPor("publicaciones",["persona_id"=>$this->director["id"]],"*");
   $publicaciones = !empty($publicaciones["data"])?$publicaciones["data"]:false;

   $this->publicaciones = [];
   if ($publicaciones) {
     foreach ($publicaciones as $key => $publicacion) {
       $p = [
         "titulo"=> $publicacion["titulo"],
         "detalles"=> $publicacion["volumen"]." ".$publicacion["editorial"]." ".$publicacion["anio"]." ".$publicacion["pais"]." ".$publicacion["otros"]
       ];
       array_push($this->publicaciones,$p);
     }
   }
 }

}
?>
