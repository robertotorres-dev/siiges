<?php
  require( "pdf.php" );
  require_once "../../models/modelo-solicitud.php";
  require_once "../../models/modelo-docente.php";


  session_start( );

  if(!isset($_GET["id"]) && !$_GET["id"]){
    header("../home.php");
  }

  class FDP08 extends PDF{

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
        $this->Cell( 35, 6, "FDP08", 0, 0, "R", true);
        $this->Ln( 10 );
        $this->SetTextColor( 0, 0, 0 );
    }
  }

  $pdf = new FDP08();
  $pdf->getDirector($_GET["id"]);

  $pdf->nuevaPagina();

  $pdf->SetFont( "Arial", "B", 10 );
  $pdf->SetMargins(20, 20 , 20);

  // Nombre del formato
  $pdf->Ln( 15 );
  $pdf->getNombreFormato();

  $pdf->SetTextColor( 0, 127, 204 );
  $pdf->Cell( 0, 5, utf8_decode("PROPUESTA DE DIRECTOR DEL PLANTEL"), 0, 1, "R");
  $pdf->SetTextColor( 0, 0, 0 );
  $pdf->Ln( 10 );


  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("DATOS GENERALES"), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 68, 5, utf8_decode("NOMBRE (S)"), 1, 0, "L", true );
  $pdf->Cell( 54, 5, utf8_decode("PRIMER APELLIDO"), 1, 0, "L", true );
  $pdf->Cell( 54, 5, utf8_decode("SEGUNDO APELLIDO"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 68, 5, utf8_decode($pdf->director["nombre"]), 1,0, "L");
  $pdf->Cell( 54, 5, utf8_decode($pdf->director["apellido_paterno"]), 1,0, "L");
  $pdf->Cell( 54, 5, utf8_decode($pdf->director["apellido_materno"]), 1,1, "L");

  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 68, 5, utf8_decode("CLAVE CURP"), 1, 0, "L", true );
  $pdf->Cell( 54, 5, utf8_decode("NACIONALIDAD"), 1, 0, "L", true );
  $pdf->Cell( 54, 5, utf8_decode("GÉNERO"), 1, 1, "L", true );

  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 68, 5, utf8_decode($pdf->director["curp"]), 1,0, "L");
  $pdf->Cell( 54, 5, utf8_decode($pdf->director["nacionalidad"]), 1,0, "L");
  $pdf->Cell( 54, 5, utf8_decode($pdf->director["sexo"]), 1,1, "L");

  $pdf->Ln( 5 );

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("FORMACIÓN ACADÉMICA"), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );

  $headers = ["nombre"=>"NOMBRE DE LOS ESTUDIOS","nivel"=>"NIVEL","descripcion"=>"DOCUMENTO"];
  // 176
  $widths = ["nombre"=>108,"nivel"=>38,"descripcion"=>30];
  // 95
  $length = ["nombre"=>50,"nivel"=>50,"descripcion"=>50];

  $data = $pdf->formaciones;
  $pdf->Tabla($headers,$data,$widths,0,$length);

  $pdf->Ln( 5 );

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("EXPERIENCIA DOCENTE"), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );

  $headers = ["nombre"=>"ASIGNATURA O PROYECTO","funcion"=>"FUNCIÓN","institucion"=>"INSTITUCIÓN","periodo"=>"PERIODO"];
  // 176
  $widths = ["nombre"=>44,"funcion"=>44,"institucion"=>44,"periodo"=>44];
  // 95
  $length = ["nombre"=>50,"funcion"=>50,"institucion"=>22,"periodo"=>30];

  $data = $pdf->experienciaDocente;
  $pdf->Tabla($headers,$data,$widths,0,$length);

  $pdf->Ln( 5 );

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("EXPERIENCIA DIRECTIVA O PROFESIONAL"), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );

  $headers = ["nombre"=>"PUESTO","funcion"=>"FUNCIÓN","institucion"=>"INSTITUCIÓN","periodo"=>"PERIODO"];
  // 176
  $widths = ["nombre"=>44,"funcion"=>44,"institucion"=>44,"periodo"=>44];
  // 95
  $length = ["nombre"=>22,"funcion"=>22,"institucion"=>22,"periodo"=>30];

  $data = $pdf->experienciaProDir;
  $pdf->Tabla($headers,$data,$widths,0,$length);

  $pdf->Ln( 5 );

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("PUBLICACIONES"), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );

  $headers = ["titulo"=>"TÍTULO","detalles"=>"DATOS DE LA PUBLICACION"];
  // 176
  $widths = ["titulo"=>68,"detalles"=>108];
  // 95
  $length = ["titulo"=>50,"detalles"=>50];

  $data = $pdf->publicaciones;
  $pdf->Tabla($headers,$data,$widths,0,$length);

  $pdf->Ln( 30 );

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  //$pdf->Cell( 88, 5, utf8_decode("REPRESENTANTE LEGAL"), 1, 0, "C", true );
  //$pdf->Cell( 88, 5, utf8_decode("DIRECTOR PROPUESTO"), 1, 1, "C", true );

  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 88, 5, utf8_decode("REPRESENTANTE LEGAL"), 0, 0, "C" );
  $pdf->Cell( 88, 5, utf8_decode("DIRECTOR PROPUESTO"), 0, 1, "C" );
  $pdf->Cell( 88, 5, utf8_decode(mb_strtoupper($pdf->representante["persona"]["nombre"]." ".$pdf->representante["persona"]["apellido_paterno"]." ".$pdf->representante["persona"]["apellido_materno"])), 0,0, "C");
  $pdf->Cell( 88, 5, utf8_decode(mb_strtoupper($pdf->director["nombre"]." ".$pdf->director["apellido_paterno"]." ".$pdf->director["apellido_materno"])), 0,1, "C");



  $pdf->Output( "I", "FDP08.pdf" );
?>
