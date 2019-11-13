<?php
  require( "pdf.php" );
  require_once "../../models/modelo-solicitud.php";
  require_once "../../models/modelo-docente.php";


  session_start( );

  if(!isset($_GET["id"]) && !$_GET["id"]){
    header("../home.php");
  }

  class FDP06 extends PDF{

    public function nuevaPagina(){
      $this->AliasNbPages( );
      $this->AddPage( "P", "Letter" );
    }

    public function getNombreFormato(){
      // Nombre del formato
        $this->SetFont( "Arial", "B", 11 );
        $this->Ln( 10);
        $this->SetTextColor( 255, 255, 255 );
        $this->SetFillColor( 0, 127, 204 );
        $this->Cell( 140, 5, "", 0, 0, "L");
        $this->Cell( 35, 6, "FDP06", 0, 0, "R", true);
        $this->Ln( 10 );
        $this->SetTextColor( 0, 0, 0 );
    }
  }

  $pdf = new FDP06();
  $pdf->getData($_GET["id"]);
  $pdf->getDocentes(Docente::DOCENTE_ASIGNATURA);

  $pdf->nuevaPagina();

  $pdf->SetFont( "Arial", "B", 10 );
  $pdf->SetMargins(20, 20 , 20);

  // Nombre del formato
  $pdf->Ln( 15 );
  $pdf->getNombreFormato();

  $pdf->SetTextColor( 0, 127, 204 );
  $pdf->Cell( 0, 5, utf8_decode("FORMATO PLANTILLA DE DOCENTES DE ASIGNATURA"), 0, 1, "R");
  $pdf->SetTextColor( 0, 0, 0 );
  $pdf->Ln( 10 );


  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 68, 5, utf8_decode("NOMBRE DE LA INSTITUCIÓN"), 1, 0, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 108, 5, utf8_decode($pdf->institucion["nombre"]), 1,1, "L");

  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 68, 5, utf8_decode("NIVEL Y NOMBRE DEL PLAN DE ESTUDIOS"), 1, 0, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 108, 5, utf8_decode($pdf->nivel["descripcion"]." en ".$pdf->programa["nombre"]), 1,1, "L");

  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 68, 5, utf8_decode("MODALIDAD"), 1, 0, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 108, 5, utf8_decode($pdf->modalidad["nombre"]), 1,1, "L");

  $domicilio1 = $pdf->domicilioPlantel["calle"]." "
  .$pdf->domicilioPlantel["numero_exterior"]." "
  .$pdf->domicilioPlantel["numero_interior"].", "
  .$pdf->domicilioPlantel["colonia"]." "
  .$pdf->domicilioPlantel["codigo_postal"]." "
  .$pdf->domicilioPlantel["municipio"]." "
  .$pdf->domicilioPlantel["estado"];

  $domicilio1 = substr($domicilio1, 0, 70);

  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 68, 5, utf8_decode("DOMICILIO"), 1, 0, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 108, 5, utf8_decode($domicilio1), 1,1, "L");

  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 68, 5, utf8_decode("TELEFONOS"), 1, 0, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 108, 5, utf8_decode($pdf->plantel["telefono1"].", ".$pdf->plantel["telefono2"].", ".$pdf->plantel["telefono3"]), 1,1, "L");

  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 68, 5, utf8_decode("TIPO DE TRÁMITE"), 1, 0, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 108, 5, utf8_decode($pdf->tipoSolicitud["nombre"]), 1,1, "L");

  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 68, 5, utf8_decode("DURACIÓN DEL PROGRAMA"), 1, 0, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 108, 5, utf8_decode($pdf->programa["duracion"]), 1,1, "L");

  $pdf->Ln( 5 );

  $headers = ["formacion"=>"","docente"=>"","asignatura"=>"","experiencia"=>"","contratacion_antiguedad"=>"","aceptado"=>"","observaciones"=>""];
  // 176
  $widths = ["formacion"=>26,"docente"=>25,"asignatura"=>25,"experiencia"=>25,"contratacion_antiguedad"=>25,"aceptado"=>25,"observaciones"=>25];
  // 95
  $length = ["formacion"=>12,"docente"=>11,"asignatura"=>11,"experiencia"=>11,"contratacion_antiguedad"=>11,"aceptado"=>11,"observaciones"=>11];

  foreach ($pdf->AsigPorGrado as $grado => $asignatura) {
    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->Cell( 0, 5, utf8_decode($grado), 1, 1, "L", true );
    $data = $asignatura;

    $pdf->Tabla($headers,$data,$widths,0,$length,false);

    if($pdf->checkNewPage()){
      $pdf->Ln(25);
    }
    $pdf->Ln( 5 );
  }


  $pdf->Ln( 30 );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->Cell( 60, 5, utf8_decode(mb_strtoupper($pdf->nombreRepresentante)), 0, 0, "L");
  $pdf->Cell( 65, 5, utf8_decode( Solicitud::convertirFecha(date("d-m-y"))), 0, 0, "L");
  $pdf->Cell( 55, 5, utf8_decode( "AUTORIZÓ"), 0, 0, "L");
  $pdf->Ln( 5 );
  $pdf->Cell( 275, 5, utf8_decode( "DIRECTOR DE EDUCACIÓN SUPERIOR"), 0, 0, "C");

  $pdf->Output( "I", "FDP06.pdf" );
?>
