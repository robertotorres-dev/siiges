<?php
  require( "pdf.php" );

  session_start( );

  if(!isset($_GET["id"]) && !$_GET["id"]){
    header("../home.php");
  }

  $pdf = new PDF();
  $pdf->getData($_GET["id"]);
  $pdf->getDataPlantel($pdf->plantel["id"]);

  $pdf->AliasNbPages( );
  $pdf->AddPage( "P", "Letter" );
  $pdf->SetFont( "Arial", "B", 10 );
  $pdf->SetMargins(20, 35 , 20);

// Nombre del formato
  $pdf->SetFont( "Arial", "B", 11 );
  $pdf->Ln( 25 );
  $pdf->SetTextColor( 255, 255, 255 );
  $pdf->SetFillColor( 0, 127, 204 );
  $pdf->Cell( 140, 5, "", 0, 0, "L");
  $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
  $pdf->Ln( 10 );

  $pdf->SetTextColor( 0, 127, 204 );
  $pdf->Cell( 0, 5, utf8_decode("DESCRIPCIÓN DE INSTALACIONES"), 0, 1, "R");
  $pdf->SetTextColor( 0, 0, 0 );
  $pdf->Ln( 10 );

  // Institucion
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 70, 5, utf8_decode("1.	NOMBRE DE LA INSTITUCIÓN "), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  if($pdf->institucion["es_nombre_autorizado"]){
    $pdf->Cell( 105, 5, utf8_decode($pdf->nombreInstitucion), 1, 1, "L", true );
  }else{
    $pdf->Cell( 105, 5, "", 1, 1, "L", true );

  }
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 70, 5, utf8_decode("NIVEL Y NOMBRE DEL PLAN DE ESTUDIOS "), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 105, 5, utf8_decode($pdf->nivel["descripcion"]." en ".$pdf->programa["nombre"]), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 70, 5, utf8_decode("MODALIDAD "), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 105, 5, utf8_decode($pdf->modalidad["nombre"]), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 70, 5, utf8_decode("DURACIÓN DEL PROGRAMA "), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 105, 5, utf8_decode($pdf->programa["duracion"]), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->MultiCell( 70, 5, utf8_decode("NOMBRE COMPLETO DE LA PERSONA FÍSICA O JURIDICA"), 1, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->SetY(80);
  $pdf->SetX(90);
  $pdf->Cell( 105, 10, utf8_decode($pdf->nombreRepresentante), 1, 1, "L", true );

  $pdf->Ln( 5 );

  // Domicilio de la institucion
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2.	DOMICILIO DE LA INSTITUCIÓN"), 1, 1, "L", true );

  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 116, 5, utf8_decode("CALLE Y NÚMERO"), 1, 0, "C", true );
  $pdf->Cell( 60, 5, utf8_decode("COLONIA"), 1, 1, "C", true );

  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 116, 5, utf8_decode($pdf->domicilioPlantel["calle"]." ".$pdf->domicilioPlantel["numero_exterior"]." ".$pdf->domicilioPlantel["numero_interior"]), 1, 0, "L", true );
  $pdf->Cell( 60, 5, utf8_decode($pdf->domicilioPlantel["colonia"]), 1, 1, "L", true );

  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 58, 5, utf8_decode("CÓDIGO POSTAL"), 1, 0, "C", true );
  $pdf->Cell( 58, 5, utf8_decode("DELEGACIÓN O MUNICIPIO"), 1, 0, "C", true );
  $pdf->Cell( 60, 5, utf8_decode("ENTIDAD FEDERATIVA"), 1, 1, "C", true );

  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 58, 5, utf8_decode($pdf->domicilioPlantel["codigo_postal"]), 1, 0, "L", true );
  $pdf->Cell( 58, 5, utf8_decode($pdf->domicilioPlantel["municipio"]), 1, 0, "L", true );
  $pdf->Cell( 60, 5, utf8_decode($pdf->domicilioPlantel["estado"]), 1, 1, "L", true );

  $pdf->SetFillColor( 191, 191, 191 );
  $headers = ["correo"=>"CORREO ELECTRÓNICO","telefono"=>"TELÉFONO","redes_sociales"=>"REDES SOCIALES"];
  $data = [
        [
            "correo"=>utf8_decode($pdf->plantel["email1"].", ".$pdf->plantel["email2"].", ".$pdf->plantel["email3"]),
            "telefono"=>utf8_decode($pdf->plantel["telefono1"].", ".$pdf->plantel["telefono2"].", ".$pdf->plantel["telefono3"]),
            "redes_sociales"=>$pdf->plantel["redes_sociales"]
        ]
  ];
  $widths = ["correo"=>58,"telefono"=>58,"redes_sociales"=>60];
  $length = ["correo"=>30,"telefono"=>30,"redes_sociales"=>35];

  $pdf->Tabla($headers,$data,$widths,0,$length);
  $pdf->Ln(5 );

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("3.	DICTÁMENES EXPEDIDOS"), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "", 9 );

  // Dictamenes del plantel
  $headersD = ["nombre"=>"NOMBRE DEL DICTAMEN","autoridad"=>"AUTORIDAD QUE LO EMITIÓ","fecha_emision"=>"FECHA"];
  $dataD = $pdf->plantelDictamenes;
  $widthsD = ["nombre"=>60,"autoridad"=>91,"fecha_emision"=>25];
  $lengthD = ["nombre"=>30,"autoridad"=>55,"fecha_emision"=>15];

  $pdf->Tabla($headersD,$dataD,$widthsD,0,$lengthD);
  $pdf->Ln( 5 );

  //Descripcion del plantel
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("4.	DESCRIPCIÓN DEL PLANTEL"), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 70, 5, utf8_decode("CARACTERISTICAS DEL INMUEBLE"), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 106, 5, utf8_decode($pdf->plantel["caracteristica_inmueble"]), 1, 1, "L", true );
  $pdf->Ln( 5);

  //Niveles
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 70, 5, utf8_decode("EDIFICIOS Y/O NIVELES"), 1, 1, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  foreach ($pdf->edificioNiveles as $nivel) {
    $pdf->Cell( 70, 5, utf8_decode($nivel["nivel"]), 1, 1, "L", true );
  }
  $pdf->Ln( 5);


  if($pdf->checkNewPage()){
    // Nombre del formato
      $pdf->SetFont( "Arial", "B", 11 );
      $pdf->Ln( 10);
      $pdf->SetTextColor( 255, 255, 255 );
      $pdf->SetFillColor( 0, 127, 204 );
      $pdf->Cell( 140, 5, "", 0, 0, "L");
      $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
      $pdf->Ln( 10 );
      $pdf->SetTextColor( 0, 0, 0 );

  }


  // Seguridad
  $ejeX = $pdf->GetX();
  $ejeY = $pdf->GetY();
  $pdf->SetY($ejeY);
  //$pdf->SetY(-84.5);
  $pdf->SetX($ejeX);
  //$pdf->SetX(90);
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 106, 5, utf8_decode("SISTEMA DE SEGURIDAD"), 1, 1, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->SetY($ejeY += 5);
  //$pdf->SetY(-80);
  $pdf->SetX($ejeX);
  //$pdf->SetX(90);
  $pdf->Cell( 76, 5, utf8_decode("DESCRIPCIÓN"), 1, 0, "L", true );
  $pdf->Cell( 30, 5, utf8_decode("CANTIDAD"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $ejeY += 5;
  foreach ($pdf->seguridadSistemas as $seguridad) {
    $pdf->SetY($ejeY);
    $pdf->SetX($ejeX);
    $pdf->Cell( 76, 5, utf8_decode($seguridad["sistema"]), 1, 0, "L", true );
    $pdf->Cell( 30, 5, utf8_decode($seguridad["cantidad"]), 1, 1, "L", true );
    $ejeY +=5;
  }

  if($pdf->checkNewPage()){
    // Nombre del formato
      $pdf->SetFont( "Arial", "B", 11 );
      $pdf->Ln( 10);
      $pdf->SetTextColor( 255, 255, 255 );
      $pdf->SetFillColor( 0, 127, 204 );
      $pdf->Cell( 140, 5, "", 0, 0, "L");
      $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
      $pdf->Ln( 10 );
      $pdf->SetTextColor( 0, 0, 0 );

  }
  // Seguridad
  /*//$yS = 50;
  $xS = 20;
  //$pdf->SetY($yS);
  $pdf->SetX($xS);
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 106, 5, utf8_decode("SISTEMA DE SEGURIDAD"), 1, 1, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "B", 9 );
  //$pdf->SetY($yS += 5);
  $pdf->SetX($xS);
  $pdf->Cell( 76, 5, utf8_decode("DESCRIPCIÓN"), 1, 0, "L", true );
  $pdf->Cell( 30, 5, utf8_decode("CANTIDAD"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  //$yS = 50;
  foreach ($pdf->seguridadSistemas as $seguridad) {
    //$pdf->SetY($yS += 5);
    $pdf->SetX($xS);
    $pdf->Cell( 76, 5, utf8_decode($seguridad["sistema"]), 1, 0, "L", true );
    $pdf->Cell( 30, 5, utf8_decode($seguridad["cantidad"]), 1, 1, "L", true );
    //$yS +=5;
  }*/
  $pdf->Ln( 10);

  // Higienes
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetTextColor( 0, 0, 0 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("5.	HIGIENE DEL PLANTEL"), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );

  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 146, 5, utf8_decode("CONCEPTO"), 1, 0, "C", true );
  $pdf->Cell( 30, 5, utf8_decode("CANTIDAD"), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->SetFillColor( 255, 255, 255 );

  foreach ($pdf->higienes as $higiene) {
    $pdf->Cell( 146, 5, utf8_decode($higiene["higiene"]), 1, 0, "L", true );
    $pdf->Cell( 30, 5, utf8_decode($higiene["cantidad"]), 1, 1, "L", true );
  }
  $pdf->Ln( 10 );
  // Infraestructura
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetTextColor( 0, 0, 0 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("6.	INFRAESTRUCTURA PARA EL PROGRAMA"), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191);
  $pdf->Cell( 0, 5, utf8_decode("ESPACIOS Y EQUIPAMIENTO"), 1, 1, "C", true );

  $headersI = ["asignaturas"=>"ASIGNATURAS QUE ATIENDE","instalacion"=>"INSTALACIONES",
              "capacidad"=>"CAPACIDAD PROMEDIO (No. ALUMNOS)","metros"=>"METROS",
                "recursos"=>"RECURSOS MATERIALES","ubicacion"=>"UBICACIÓN"];
  $dataI = $pdf->tiposInstalacion;
  //print_r($dataI);
  $widthsI = ["asignaturas"=>35,"instalacion"=>28,"capacidad"=>28,"metros"=>15,"recursos"=>46,"ubicacion"=>24];
  $lengthI = ["asignaturas"=>15,"instalacion"=>19,"capacidad"=>20,"metros"=>15,"recursos"=>39,"ubicacion"=>15];
  // Headers

  $ejeX = $pdf->GetX();
  $ejeY = $pdf->GetY();
  $pdf->MultiCell( 35, 6, utf8_decode($headersI["asignaturas"]), 1, "C", true );
  $pdf->SetY($ejeY);
  //$pdf->SetY(125);
  $pdf->SetX(55);
  $pdf->Cell( 28, 12, utf8_decode($headersI["instalacion"]), 1, 1, "C", true );
  $pdf->SetY($ejeY);
  //$pdf->SetY(125);
  $pdf->SetX(83);
  $pdf->MultiCell( 28, 4, utf8_decode($headersI["capacidad"]), 1, "C", true );
  $pdf->SetY($ejeY);
  //$pdf->SetY(125);
  $pdf->SetX(111);
  $pdf->Cell( 15, 12, utf8_decode($headersI["metros"]), 1,1, "C", true );
  $pdf->SetY($ejeY);
  //$pdf->SetY(125);
  $pdf->SetX(126);
  $pdf->MultiCell( 46, 12, utf8_decode($headersI["recursos"]), 1, "C", true );
  $pdf->SetY($ejeY);
  //$pdf->SetY(125);
  $pdf->SetX(172);
  $pdf->Cell( 24, 12, utf8_decode($headersI["ubicacion"]), 1,1, "C", true );

  $pdf->Tabla($headersI,$dataI,$widthsI,0,$lengthI,false);
  $pdf->Ln( 5 );

  if($pdf->checkNewPage()){
    // Nombre del formato
      $pdf->SetFont( "Arial", "B", 11 );
      $pdf->Ln( 10);
      $pdf->SetTextColor( 255, 255, 255 );
      $pdf->SetFillColor( 0, 127, 204 );
      $pdf->Cell( 140, 5, "", 0, 0, "L");
      $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
      $pdf->Ln( 10 );
      $pdf->SetTextColor( 0, 0, 0 );

  }

  // otros RVOES
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetTextColor( 0, 0, 00 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("7.	PROGRAMAS IMPARTIDOS EN EL PLANTEL (OTROS RVOE)"), 1, 1, "L", true );

  $headersO = ["nombre"=>"Nombre del programa","nivel"=>"Nivel","acuerdo"=>"No. de Acuerdo","numero_alumnos"=>"Total de Alumnos"];
  $dataO =  json_decode($pdf->programa["otros_rvoes"]);
  $widthsO = ["nombre"=>47,"nivel"=>43,"acuerdo"=>43,"numero_alumnos"=>43];
  $lengthO = ["nombre"=>20,"nivel"=>20,"acuerdo"=>20,"numero_alumnos"=>20];
  $pdf->Tabla($headersO,$dataO,$widthsO,0,$lengthO);

  $pdf->Ln( 5 );

  if($pdf->checkNewPage()){
    // Nombre del formato
      $pdf->SetFont( "Arial", "B", 11 );
      $pdf->Ln( 10);
      $pdf->SetTextColor( 255, 255, 255 );
      $pdf->SetFillColor( 0, 127, 204 );
      $pdf->Cell( 140, 5, "", 0, 0, "L");
      $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
      $pdf->Ln( 10 );
      $pdf->SetTextColor( 0, 0, 0 );

  }
  // Instituciones de salud aledañas
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetTextColor( 0, 0, 00 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode("8.	RELACIÓN DE INSTITUCIONES DE SALUD ALEDAÑAS, SERVICIOS DE AMBULANCIA U OTROS SERVICIOS DE EMERGENCIA A LOS CUALES RECURRIRÁ LA INSTITUCIÓN EN CASO DE ALGUNA CONTINGENCIA "), 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191);
  $pdf->Cell( 88, 10, utf8_decode("NOMBRE DE LA INSTITUCIÓN"), 1, 0, "C", true );
  $pdf->MultiCell( 88, 5, utf8_decode("TIEMPO APROXIMADO REQUERIDO PARA LLEGAR A LA ESCUELA (EN MINUTOS)"), 1, 1, "C", true );
$pdf->SetFont( "Arial", "", 9 );
  foreach ($pdf->salud as $salud) {
    $pdf->SetFillColor( 255, 255, 255);
    $pdf->Cell( 88, 5, utf8_decode($salud["nombre"]), 1, 0, "C", true );
    $pdf->Cell( 88, 5, utf8_decode($salud["tiempo"]), 1, 1, "C", true );

  }
  $pdf->Ln( 10 );
  $pdf->SetFont( "Arial", "", 11 );
  $pdf->Cell(0,5, utf8_decode("BAJO PROTESTA DE DECIR VERDAD"), 0, 1, "C");
  $pdf->SetFont( "Arial", "B", 11 );
  $pdf->Cell( 0, 5, utf8_decode(mb_strtoupper($pdf->nombreRepresentante)), 0, 1, "C");

  if($pdf->checkNewPage()){
    // Nombre del formato
      $pdf->SetFont( "Arial", "B", 11 );
      $pdf->Ln( 10);
      $pdf->SetTextColor( 255, 255, 255 );
      $pdf->SetFillColor( 0, 127, 204 );
      $pdf->Cell( 140, 5, "", 0, 0, "L");
      $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
      $pdf->Ln( 10 );
      $pdf->SetTextColor( 0, 0, 0 );

  }

  if($pdf->programa["modalidad_id"] != Modalidad::ESCOLARIZADA){
    $pdf->getDataMixta($pdf->programa["id"]);
    // Instituciones de salud aledañas
    $pdf->SetTextColor( 0, 0, 0 );
    $pdf->SetFillColor( 166, 166, 166 );
    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->Cell( 0, 5, utf8_decode("9.	SÓLO PARA LA MODALIDAD MIXTA Y NO ESCOLARIZADA"), 1, 1, "L", true );
    $pdf->SetFillColor( 191, 191, 191);
    $pdf->Cell( 0, 5, utf8_decode("LICENCIAS DE SOFTWARE "), 1, 1, "C", true );
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode($pdf->licencias_software), 1, "L");
    $pdf->Ln( 5 );
    if($pdf->checkNewPage()){
      // Nombre del formato
        $pdf->SetFont( "Arial", "B", 11 );
        $pdf->Ln( 10);
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->SetFillColor( 0, 127, 204 );
        $pdf->Cell( 140, 5, "", 0, 0, "L");
        $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
        $pdf->Ln( 10 );
        $pdf->SetTextColor( 0, 0, 0 );

    }

    $pdf->SetTextColor( 0, 0, 0 );
    $pdf->SetFillColor( 191, 191, 191);
    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode("MENCIONE LOS SERVICIOS Y HERRAMIENTAS EDUCATIVAS DE APRENDIZAJE CON LAS QUE CUENTA EL SISTEMA"), 1, "C", true );
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode($pdf->mixta["servicios_herramientas_educativas"]), 1, "L");
    $pdf->Ln( 5 );
    if($pdf->checkNewPage()){
      // Nombre del formato
        $pdf->SetFont( "Arial", "B", 11 );
        $pdf->Ln( 10);
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->SetFillColor( 0, 127, 204 );
        $pdf->Cell( 140, 5, "", 0, 0, "L");
        $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
        $pdf->Ln( 10 );
        $pdf->SetTextColor( 0, 0, 0 );

    }

    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->SetFillColor( 191, 191, 191);
    $pdf->Cell( 0, 5, utf8_decode("SISTEMAS DE SEGURDAD"), 1,1, "C", true );
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode($pdf->mixta["sistemas_seguridad"]), 1, "L");
    $pdf->Ln( 5 );
    if($pdf->checkNewPage()){
      // Nombre del formato
        $pdf->SetFont( "Arial", "B", 11 );
        $pdf->Ln( 10);
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->SetFillColor( 0, 127, 204 );
        $pdf->Cell( 140, 5, "", 0, 0, "L");
        $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
        $pdf->Ln( 10 );
        $pdf->SetTextColor( 0, 0, 0 );

    }

    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->SetFillColor( 191, 191, 191);
    $pdf->Cell( 0, 5, utf8_decode("DIRECCIONAMIENTO IP PÚBLICO"), 1,1, "C", true );
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode($pdf->mixta["direccionamiento_ip_publico"]), 1, "L");
    $pdf->Ln( 5 );
    if($pdf->checkNewPage()){
      // Nombre del formato
        $pdf->SetFont( "Arial", "B", 11 );
        $pdf->Ln( 10);
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->SetFillColor( 0, 127, 204 );
        $pdf->Cell( 140, 5, "", 0, 0, "L");
        $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
        $pdf->Ln( 10 );
        $pdf->SetTextColor( 0, 0, 0 );

    }

    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->SetFillColor( 191, 191, 191);
    $pdf->Cell( 0, 5, utf8_decode("TECNOLOGÍAS DE LA INFORMACIÓN Y COMUNICACIÓN"), 1,1, "C", true );
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode($pdf->mixta["tecnologias_informacion_comunicacion"]), 1, "L");
    $pdf->Ln( 5 );
    if($pdf->checkNewPage()){
      // Nombre del formato
        $pdf->SetFont( "Arial", "B", 11 );
        $pdf->Ln( 10);
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->SetFillColor( 0, 127, 204 );
        $pdf->Cell( 140, 5, "", 0, 0, "L");
        $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
        $pdf->Ln( 10 );
        $pdf->SetTextColor( 0, 0, 0 );
    }

    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->SetFillColor( 191, 191, 191);
    $pdf->Cell( 0, 5, utf8_decode("ACCESO A INTERNET"), 1,1, "C", true );
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode($pdf->mixta["acceso_internet"]), 1, "L");
    $pdf->Ln( 5 );
    if($pdf->checkNewPage()){
      // Nombre del formato
        $pdf->SetFont( "Arial", "B", 11 );
        $pdf->Ln( 10);
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->SetFillColor( 0, 127, 204 );
        $pdf->Cell( 140, 5, "", 0, 0, "L");
        $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
        $pdf->Ln( 10 );
        $pdf->SetTextColor( 0, 0, 0 );

    }

    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->SetFillColor( 191, 191, 191);
    $pdf->Cell( 0, 5, utf8_decode("MANTENIMIENTO DE LA PLATAFORMA"), 1,1, "C", true );
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode($pdf->mixta["mantenimiento_plataforma"]), 1, "L");
    $pdf->Ln( 5 );
    if($pdf->checkNewPage()){
      // Nombre del formato
        $pdf->SetFont( "Arial", "B", 11 );
        $pdf->Ln( 10);
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->SetFillColor( 0, 127, 204 );
        $pdf->Cell( 140, 5, "", 0, 0, "L");
        $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
        $pdf->Ln( 10 );
        $pdf->SetTextColor( 0, 0, 0 );

    }

    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->SetFillColor( 191, 191, 191);
    $pdf->Cell( 0, 5, utf8_decode("DESCRIPCIÓN DEL DIAGRAMA DE RESPALDOS"), 1,1, "C", true );
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode($pdf->mixta["mantenimiento_plataforma"]), 1, "L");
    $pdf->Ln( 5 );
    if($pdf->checkNewPage()){
      // Nombre del formato
        $pdf->SetFont( "Arial", "B", 11 );
        $pdf->Ln( 10);
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->SetFillColor( 0, 127, 204 );
        $pdf->Cell( 140, 5, "", 0, 0, "L");
        $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
        $pdf->Ln( 10 );
        $pdf->SetTextColor( 0, 0, 0 );

    }

    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->SetFillColor( 191, 191, 191);
    $pdf->Cell( 0, 5, utf8_decode("DIAGRAMA DE PROCESO"), 1,1, "C", true );
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode($pdf->mixta["diagrama_plataforma"]), 1, "L");
    $pdf->Ln( 5 );
    if($pdf->checkNewPage()){
      // Nombre del formato
        $pdf->SetFont( "Arial", "B", 11 );
        $pdf->Ln( 10);
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->SetFillColor( 0, 127, 204 );
        $pdf->Cell( 140, 5, "", 0, 0, "L");
        $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
        $pdf->Ln( 10 );
        $pdf->SetTextColor( 0, 0, 0 );

    }

    $pdf->SetFillColor( 191, 191, 191);
    $headersR = ["descripcion"=>"DESCRIPCIÓN DEL SERVICIO DE DATOS RESPALDADOS","proceso"=>"PROCESO DE RESPALDO",
                "periodicidad"=>"PERIODICIDAD",
                "medios_almacenamiento"=>"MEDIOS DE ALMACENAMIENTO"];
    $dataR = $pdf->respaldos;
    $widthsR = ["descripcion"=>50,"proceso"=>50,"periodicidad"=>36,"medios_almacenamiento"=>40];
    $lengthR = ["descripcion"=>30,"proceso"=>30,"periodicidad"=>15,"medios_almacenamiento"=>20];
    // Headers
    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->Cell( 0.1, 5, "", 0, 0, "L");
    $pdf->MultiCell( 50, 4, utf8_decode($headersR["descripcion"]), 1, "C", true );

    $pdf->SetY($pdf->GetY()-8);
    $pdf->Cell( 50, 5, "", 0, 0, "L");
    $pdf->MultiCell( 50, 8, utf8_decode($headersR["proceso"]), 1, "C", true );

    $pdf->SetY($pdf->GetY()-8);
    $pdf->Cell( 100, 5, "", 0, 0, "L");
    $pdf->MultiCell( 36, 8, utf8_decode($headersR["periodicidad"]), 1, "C", true );

    $pdf->SetY($pdf->GetY()-8);
    $pdf->Cell( 136, 5, "", 0, 0, "L");
    $pdf->MultiCell( 40, 4, utf8_decode($headersR["medios_almacenamiento"]), 1, "C", true );


    $pdf->Tabla($headersR,$dataR,$widthsR,0,$lengthR,false);
    $pdf->Ln( 5 );

    if($pdf->checkNewPage()){
      // Nombre del formato
        $pdf->SetFont( "Arial", "B", 11 );
        $pdf->Ln( 10);
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->SetFillColor( 0, 127, 204 );
        $pdf->Cell( 140, 5, "", 0, 0, "L");
        $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
        $pdf->Ln( 10 );
        $pdf->SetTextColor( 0, 0, 0 );

    }

    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->SetFillColor( 166, 166, 166);
    $pdf->Cell( 0, 5, utf8_decode("SITIO DE RESPALDO DESCENTRALIZADO PARA CONTIGENCIAS (ESPEJO)"), 1,1, "C", true );
    $pdf->Cell( 76, 5, utf8_decode("Proveedor"), 1,0, "L");
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->Cell( 100, 5, utf8_decode($pdf->espejos["proveedor"]), 1,1, "L");

    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->Cell( 76, 5, utf8_decode("Ancho de banda de la ubicación espejo"), 1,0, "L");
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->Cell( 100, 5, utf8_decode($pdf->espejos["ancho_banda"]), 1,1, "L");

    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->Cell( 76, 5, utf8_decode("Ubicacón física de las instalaciones del espejo"), 1,0, "L");
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->Cell( 100, 5, utf8_decode($pdf->espejos["ubicacion"]), 1,1, "L");

    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->Cell( 76, 5, utf8_decode("URL (sólo si tiene)"), 1,0, "L");
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->Cell( 100, 5, utf8_decode($pdf->espejos["url_espejo"]), 1,1, "L");
    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->Cell( 76, 5, utf8_decode("Periodicidad"), 1,0, "L");
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->Cell( 100, 5, utf8_decode($pdf->espejos["periodicidad"]), 1,1, "L");

  }

  $pdf->Output( "I", "FDA04.pdf" );
?>
