<?php
  require( "pdf.php" );
  require_once "../../models/modelo-solicitud.php";


  session_start( );

  if(!isset($_GET["id"]) && !$_GET["id"]){
    header("../home.php");
  }

  class PDP02 extends PDF{

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
        $this->Cell( 35, 6, "FDP02", 0, 0, "R", true);
        $this->Ln( 10 );
        $this->SetTextColor( 0, 0, 0 );
    }
    public function footer(){
      $this->SetY(-20);
      $this->SetFont("Arial", "I", 9);
      $this->Cell( 0, 10, utf8_decode($this->PageNo()." de {nb}"), 0, 1, "R" );
      $this->Image( "../../images/jalisco.png",20,245,20);

    }
    public function header(){
      $this->Image("../../images/encabezado.jpg",0,15,75);
      $this->Image("../../images/direccion_sicyt.PNG",155,12,40);

    }
  }

  $pdf = new PDP02();
  $pdf->getData($_GET["id"]);
  $pdf->getDataPlantel($pdf->plantel["id"]);
  $pdf->getCoordinador();
  $pdf->getAsignaturas();

  $pdf->nuevaPagina();

  $pdf->SetFont( "Arial", "B", 10 );
  $pdf->SetMargins(20, 35 , 20);
  $pdf->SetAutoPageBreak(true, 30);
  //$pdf->Image( "../../images/encabezado.jpg",10,5,120);
  // Nombre del formato
  $pdf->Ln( 15 );
  $pdf->getNombreFormato();

  $pdf->SetTextColor( 0, 127, 204 );
  $pdf->Cell( 0, 5, utf8_decode("PLAN DE ESTUDIOS  "), 0, 1, "R");
  $pdf->SetTextColor( 0, 0, 0 );
  $pdf->Ln( 10 );

  $perfilIngreso =$pdf->programa["perfil_ingreso"];
  $perfilEgreso =$pdf->programa["perfil_egreso"];
  $perfilIngreso = json_decode($perfilIngreso);
  $perfilEgreso = json_decode($perfilEgreso);

  // Apartados del perfil de ingresp
  $ingresoConocimientos = $perfilIngreso->conocimientos;
  $ingresoHabilidades = $perfilIngreso->habilidades;
  $ingresoAptitudes = $perfilIngreso->aptitudes;

  // Apartados del perfil de egreso
  $egresoConocimientos = $perfilEgreso->conocimientos;
  $egresoHabilidades = $perfilEgreso->habilidades;
  $egresoAptitudes = $perfilEgreso->aptitudes;



  $programa = $pdf->nivel["descripcion"]."en ".$pdf->programa["nombre"];
  $modalidad = $pdf->modalidad["nombre"];
  $periodo = $pdf->ciclo["nombre"];

  // Asignaturas por academia
  $asignaturaAcademias = [];
  $asignaturaGrados = [];
  $asignaturaArea = [];
  //print_r($pdf->TodasAsignaturas);
  foreach ($pdf->TodasAsignaturas as $key => $asignatura) {
    if(isset($asignaturaAcademias[$asignatura["academia"]]) &&
        is_string($asignaturaAcademias[$asignatura["academia"]])){
      $asignaturaAcademias[$asignatura["academia"]] .= ", ".$asignatura["nombre"];
    }else{
      $asignaturaAcademias[$asignatura["academia"]] = $asignatura["nombre"];
    }
    // Asignaturas por Grado
    if(!isset($asignaturaGrados[$asignatura["grado"]])){
        $asignaturaGrados[$asignatura["grado"]] = [];
    }
    array_push($asignaturaGrados[$asignatura["grado"]],$asignatura);

    // Asignaturas por Área
    if(!isset($asignaturaArea[$asignatura["area"]])){
      $asignaturaArea[$asignatura["area"]] = [];
    }
    array_push($asignaturaArea[$asignatura["area"]],$asignatura);

  }



  $pdf->SetFont( "Arial", "", 10 );

  if ($pdf->nombreInstitucion) {
    $pdf->Cell( 0, 5,utf8_decode(mb_strtoupper($pdf->nombreInstitucion)), 0,1, "C");
  } else if($pdf->nombrePropuesto){
    $pdf->Cell( 0, 5,utf8_decode(mb_strtoupper($pdf->nombrePropuesto["nombre_propuesto1"])), 0,1, "C");
  }
  $pdf->Cell( 0, 5,utf8_decode(mb_strtoupper($programa)), 0,1, "C");
  $pdf->Ln( 10 );

  $pdf->Cell( 0, 5,utf8_decode(mb_strtoupper($pdf->coordinador["nombre"]." ".$pdf->coordinador["apellido_paterno"]." ".$pdf->coordinador["apellido_materno"])), 0,1, "C");
  $pdf->Cell( 50, 5,"", 0 ,0, "C");
  $pdf->Cell( 70, 5,utf8_decode(mb_strtoupper("Coordinador(a) - ".$pdf->coordinador["titulo_cargo"])), "T",1, "C");
  $pdf->Ln( 5 );

  $pdf->Cell( 0, 5,utf8_decode(mb_strtoupper($periodo.": ".$pdf->programa["duracion"])), 0,1, "R");
  $pdf->SetFont( "Arial", "B", 10 );
  $pdf->Cell( 0, 5,utf8_decode(mb_strtoupper("Duración del Plan de Estudios")), 0,1, "R");
  $pdf->Ln( 5 );


  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.1 ANTECEDENTES ACADÉMICOS DE INGRESO"), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["antecedente"]["descripcion"]), 1, "J");
  if($pdf->checkNewPage()){
    $pdf->Ln(15);
  }

  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("METODOS DE INDUCCIÓN"), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["metodos_induccion"]), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.2 PERFIL DE INGRESO "), 1, 1, "C", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 0, 5, utf8_decode("Conocimientos:"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($ingresoConocimientos), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("Habilidades:"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($ingresoHabilidades), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("Actitudes:"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($ingresoAptitudes), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.2.1 PROCESO DE SELECCIÓN DE ESTUDIANTES "), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["proceso_seleccion"]), 1, "J");
  if($pdf->checkNewPage()){
    $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.3 PERFIL DE EGRESO"), 1, 1, "C", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 0, 5, utf8_decode("Conocimientos:"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($egresoConocimientos), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("Habilidades:"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($egresoHabilidades), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("Actitudes:"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($egresoAptitudes), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.4 MAPA CURRICULAR "), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["mapa_curricular"]), 1, "J");
  if($pdf->checkNewPage()){
    $pdf->Ln(15);
  }
  // $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.4.1 FLEXIBILIDAD CURRICULAR "), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["flexibilidad_curricular"]), 1, "J");
  if($pdf->checkNewPage()){
    $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.5 OBJETIVO GENERAL DEL PLAN DE ESTUDIOS "), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["objetivo_general"]), 1, "J");
  if($pdf->checkNewPage()){
    $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.6 OBJETIVOS PARTICULARES DEL PLAN DE ESTUDIOS"), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["objetivos_particulares"]), 1, "J");
  if($pdf->checkNewPage()){
    $pdf->Ln(15);
  }
 $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.7 ESTRUCTURA DEL PLAN DE ESTUDIOS"), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->SetFillColor( 192, 192, 192 );
  $total_docente = 0;
  $total_independiente = 0;
  $total_creditos = 0;
  $area_txt = "";
  foreach ($asignaturaArea as $area => $asignatura) {
    switch ($area) {
      case 1:
        $area_txt = "Formación general"; 
        break;
      case 2:
        $area_txt = "Formación Integral"; 
        break;
      case 3:
        $area_txt = "Profesionalizante"; 
        break;
      case 4:
        $area_txt = "Optativa especializante"; 
        break;
    }
    $pdf->Cell( 0, 5, utf8_decode($area_txt), 1, 1, "C", true );
    $headersA = ["nombre"=>"Asignatura","clave"=>"Clave","seriacion"=>"Seriación","horas_docente"=>"Con Docente","horas_independiente"=>"Independiente","creditos"=>"Créditos","infraestructura_nombre"=>"Instalaciones"];
    $dataA = $asignatura;
    $horas_docente = 0;
    $horas_independiente = 0;
    $creditos = 0;
    foreach ($asignatura as $asignatura => $detalle) {
      $total_docente = $total_docente + $detalle["horas_docente"];
      $horas_docente = $horas_docente + $detalle["horas_docente"];
      $total_independiente = $total_independiente + $detalle["horas_independiente"];
      $horas_independiente = $horas_independiente + $detalle["horas_independiente"];
      $total_creditos = $total_creditos + $detalle["creditos"];
      $creditos = $creditos + $detalle["creditos"];
    }
    $widthsA = ["nombre"=>35,"clave"=>21,"seriacion"=>25,"horas_docente"=>25,"horas_independiente"=>25,"creditos"=>20,"infraestructura_nombre"=>25];
    $lengthA = ["nombre"=>28,"clave"=>15,"seriacion"=>15,"horas_docente"=>15,"horas_independiente"=>15,"creditos"=>15,"infraestructura_nombre"=>12];
    $pdf->Tabla($headersA,$dataA,$widthsA,0,$lengthA);
    $pdf->SetFillColor( 255, 255, 255 );
    $pdf->Cell( 81, 5, utf8_decode(""), 0, 0, "R", true );
    $pdf->SetFillColor( 191, 191, 191 );
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->Cell( 25, 5, utf8_decode($horas_docente), 1, 0, "C", true );
    $pdf->Cell( 25, 5, utf8_decode($horas_independiente), 1, 0, "C", true );
    $pdf->Cell( 20, 5, utf8_decode($creditos), 1, 1, "C", true );
    $pdf->Ln(5);
    if($pdf->checkNewPage()){
      $pdf->Ln(5);
    }
  }
  $pdf->Ln(-5);
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->Cell( 81, 10, utf8_decode("SUMA TOTAL"), 0, 0, "R", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 11 );
  $pdf->Cell( 25, 10, utf8_decode($total_docente), 1, 0, "C", true );
  $pdf->Cell( 25, 10, utf8_decode($total_independiente), 1, 0, "C", true );
  $pdf->Cell( 20, 10, utf8_decode($total_creditos), 1, 1, "C", true );

  if($pdf->checkNewPage()){
    $pdf->Ln(5);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.8 OPERACIÓN DEL PLAN DE ESTUDIOS A TRAVÉS DE SUS ACADEMIAS"), 1, 1, "C", true );

  foreach ($asignaturaAcademias as $academia => $asignaturas) {
    $pdf->SetFillColor( 191, 191, 191 );
    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->Cell( 0, 5, utf8_decode($academia), 1, 1, "L", true );
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode($asignaturas), 1, "J");
    if($pdf->checkNewPage()){
    $pdf->Ln(15);
    }
  }

  $pdf->SetFont( "Arial", "", 8 );
  $pdf->MultiCell( 0, 5, utf8_decode("REGLAS DE OPERACIÓN: ADJUNTAR REGLAMENTO DE ACADEMIAS O DOCUMENTO QUE CONTENGA LAS REGLAS DE OPERACIÓN DE DICHOS CUERPOS COLEGIADOS"), 0, "L");
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.9 LÍNEAS DE GENERACIÓN Y/O APLICACIÓN DEL CONOCIMIENTO "), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["lineas_generacion_aplicacion_conocimiento"]), 1, "J");
  if($pdf->checkNewPage()){
    $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.10 ACTUALIZACIÓN DEL PLAN DE ESTUDIOS"), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["actualizacion"]), 1, "J");
  if($pdf->checkNewPage()){
    $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.11 PROYECTO DE SEGUIMIENTO DE EGRESADOS "), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["seguimiento_egresados"]), 1, "J");
  if($pdf->checkNewPage()){
    $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.12 VINCULACIÓN CON COLEGIOS DE PROFESIONISTAS, ACADEMIAS, ASOCIACIONES PROFESIONALES,ETC."), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["convenios_vinculacion"]), 1, "J");

  $pdf->Ln(20);
  if($pdf->checkNewPage()){
    //$pdf->Ln(15);
  }

  if ($pdf->programa["acuerdo_rvoe"]) {
    $pdf->Cell( 60, 10, utf8_decode(mb_strtoupper($pdf->nombreRepresentante)), 0, 0, "C");
    $pdf->Cell( 50, 10, Solicitud::convertirFecha(date("d-m-y")), 0, 0, "C");
    $pdf->MultiCell( 65, 5, utf8_decode("AUTORIZÓ\nDIRECTOR DE EDUCACIÓN SUPERIOR"), 0, "C");
  } else {
    $pdf->SetFont( "Arial", "", 11 );
    $pdf->Cell( 0, 5, "BAJO PROTESTA DE DECIR VERDAD", 0, 0, "C");
    $pdf->Ln( 5);
    $pdf->SetFont( "Arial", "B", 11 );
    $pdf->Cell( 0, 5, utf8_decode(mb_strtoupper($pdf->nombreRepresentante)), 0, 0, "C");

  }
  $pdf->Ln(10);


  $pdf->Output( "I", "PDP02.pdf" );
?>
