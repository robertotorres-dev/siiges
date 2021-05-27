<?php
  require( "pdftitulo.php" );

  session_start( );

  /* if(!isset($_GET["id"]) && !$_GET["id"]){
    header("../home.php");
  } */

  $pdf = new PDF();
  $pdf->getData($_GET["id"]);
  
  $pdf->AliasNbPages( );
  $pdf->AddPage( "P", "Letter" );
  $pdf->AddFont('Nutmeg', '', 'Nutmeg-Regular.php');
  $pdf->AddFont('Nutmegb', '', 'Nutmeg-Bold.php');
  $pdf->AddFont('Nutmegbk', '', 'Nutmeg-Book.php');
  $pdf->SetMargins(18, 35 , 18);

  // Leyenda de artículo
  $pdf->Ln(15);  
  $pdf->SetFont( "Nutmegbk", "", 8.5 );
  $pdf->Cell( 0, 0, utf8_decode("Con base en el capítulo 2 artículo 71 de la ley General de Educación Superior, se expide el presente título a:"), 0, 0, "L", false);
  $pdf->Ln(5);

  //Datos del titulado
  $pdf->SetFillColor( 255, 166, 166 );
  $pdf->SetFont( "Nutmegb", "", 9 );
  $pdf->Cell( 0, 5, utf8_decode("Datos del titulado"), 0, 1, "C", true );
  $pdf->Ln(8);
  
  $pdf->SetFont( "Nutmegbk", "", 8.5 );
  $pdf->Cell( 60, 5, utf8_decode($pdf->titulo["nombre"]), 0, 0, "C", false );
  $pdf->Cell( 60, 5, utf8_decode($pdf->titulo["primer_apellido"]), 0, 0, "C", false );
  $pdf->Cell( 60, 5, utf8_decode($pdf->titulo["segundo_apellido"]), 0, 1, "C", false );
  $pdf->Ln(2);
  $pdf->Line(18, 82, 198, 82);
  $pdf->Cell( 60, 5, utf8_decode("Nombre(s)"), 0, 0, "C", false );
  $pdf->Cell( 60, 5, utf8_decode("Primer apellido"), 0, 0, "C", false );
  $pdf->Cell( 60, 5, utf8_decode("Segundo apellido"), 0, 1, "C", false );
  
  $pdf->Ln(10);

  $pdf->SetFont( "Nutmegbk", "", 8.5 );
  $pdf->Cell( 90, 5, utf8_decode($pdf->titulo["nombre_carrera"]), 0, 0, "C", false );
  $pdf->Cell( 90, 5, utf8_decode($pdf->titulo["numero_rvoe"]), 0, 1, "C", false );
  $pdf->Ln(2);
  $pdf->Line(18, 104, 198, 104);
  $pdf->Cell( 90, 5, utf8_decode("Nombre del programa"), 0, 0, "C", false );
  $pdf->Cell( 90, 5, utf8_decode("RVOE"), 0, 1, "C", false );

  $pdf->Ln(10);

  //Datos de la institucion educativa
  $pdf->SetFillColor( 255, 166, 166 );
  $pdf->SetFont( "Nutmegb", "", 9 );
  $pdf->Cell( 0, 5, utf8_decode("Datos de la institución educativa"), 0, 1, "C", true );
  $pdf->Ln(8);

  $pdf->SetFont( "Nutmegbk", "", 8.5 );
  $pdf->Cell( 180, 5, utf8_decode($pdf->titulo["nombre_institucion"]), 0, 1, "C", false );
  $pdf->Ln(2);
  $pdf->Line(18, 139, 198, 139);
  $pdf->Cell( 180, 5, utf8_decode("Nombre o denominación"), 0, 0, "C", false );

  $pdf->Ln(15);

  //Datos de la institucion educativa
  $pdf->SetFillColor( 255, 166, 166 );
  $pdf->SetFont( "Nutmegb", "", 9 );
  $pdf->Cell( 0, 5, utf8_decode("Datos de expedición"), 0, 1, "C", true );
  $pdf->Ln(8);

  $pdf->SetFont( "Nutmegbk", "", 8.5 );
  $pdf->Cell( 90, 5, utf8_decode($pdf->titulo["nombre"]), 0, 0, "C", false );
  $pdf->Cell( 90, 5, utf8_decode($newDate = date("d/m/Y", strtotime($pdf->titulo["fecha_expedicion"]))), 0, 1, "C", false );
  $pdf->Ln(2);
  $pdf->Line(18, 174, 198, 174);
  $pdf->Cell( 90, 5, utf8_decode("Lugar"), 0, 0, "C", false );
  $pdf->Cell( 90, 5, utf8_decode("Fecha"), 0, 1, "C", false );
  
  
  
  $pdf->Ln(50);
  
  // Institucion
  $pdf->SetFont( "Arial", "", 9 );
  /* if($pdf->institucion["es_nombre_autorizado"]){
    $pdf->Cell( 105, 5, utf8_decode($pdf->nombreInstitucion), 1, 1, "L", true );
  }else{
    $pdf->Cell( 105, 5, "", 1, 1, "L", true );

  } */
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 70, 5, utf8_decode("NIVEL Y NOMBRE DEL PLAN DE ESTUDIOS "), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  /* $pdf->Cell( 105, 5, utf8_decode($pdf->nivel["descripcion"]." en ".$pdf->programa["nombre"]), 1, 1, "L", true );
   */$pdf->SetFont( "Arial", "B", 9 );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 70, 5, utf8_decode("MODALIDAD "), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  /* $pdf->Cell( 105, 5, utf8_decode($pdf->modalidad["nombre"]), 1, 1, "L", true );
  */ $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 70, 5, utf8_decode("DURACIÓN DEL PROGRAMA "), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  /* $pdf->Cell( 105, 5, utf8_decode($pdf->programa["duracion"]), 1, 1, "L", true );
   */$pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->MultiCell( 70, 5, utf8_decode("NOMBRE COMPLETO DE LA PERSONA FÍSICA O JURIDICA"), 1, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  /* $pdf->Cell( 105, 10, utf8_decode($pdf->nombreRepresentante), 1, 1, "L", true );
 */
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
  /* $pdf->Cell( 116, 5, utf8_decode($pdf->domicilioPlantel["calle"]." ".$pdf->domicilioPlantel["numero_exterior"]." ".$pdf->domicilioPlantel["numero_interior"]), 1, 0, "L", true );
  $pdf->Cell( 60, 5, utf8_decode($pdf->domicilioPlantel["colonia"]), 1, 1, "L", true );
 */
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 58, 5, utf8_decode("CÓDIGO POSTAL"), 1, 0, "C", true );
  $pdf->Cell( 58, 5, utf8_decode("DELEGACIÓN O MUNICIPIO"), 1, 0, "C", true );
  $pdf->Cell( 60, 5, utf8_decode("ENTIDAD FEDERATIVA"), 1, 1, "C", true );

  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  /* $pdf->Cell( 58, 5, utf8_decode($pdf->domicilioPlantel["codigo_postal"]), 1, 0, "L", true );
  $pdf->Cell( 58, 5, utf8_decode($pdf->domicilioPlantel["municipio"]), 1, 0, "L", true );
  $pdf->Cell( 60, 5, utf8_decode($pdf->domicilioPlantel["estado"]), 1, 1, "L", true );
 */
  $pdf->SetFillColor( 191, 191, 191 );
  $headers = ["correo"=>"CORREO ELECTRÓNICO","telefono"=>"TELÉFONO","redes_sociales"=>"REDES SOCIALES"];
  /* $data = [
        [
            "correo"=>utf8_decode($pdf->plantel["email1"].", ".$pdf->plantel["email2"].", ".$pdf->plantel["email3"]),
            "telefono"=>utf8_decode($pdf->plantel["telefono1"].", ".$pdf->plantel["telefono2"].", ".$pdf->plantel["telefono3"]),
            "redes_sociales"=>$pdf->plantel["redes_sociales"]
        ]
  ]; */
  $widths = ["correo"=>58,"telefono"=>58,"redes_sociales"=>60];
  $length = ["correo"=>30,"telefono"=>30,"redes_sociales"=>35];

 $pdf->Ln(5 );

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("3.	DICTÁMENES EXPEDIDOS"), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "", 9 );

  // Dictamenes del plantel
  $headersD = ["nombre"=>"NOMBRE DEL DICTAMEN","autoridad"=>"AUTORIDAD QUE LO EMITIÓ","fecha_emision"=>"FECHA"];
  /* $dataD = $pdf->plantelDictamenes;
   */$widthsD = ["nombre"=>60,"autoridad"=>91,"fecha_emision"=>25];
  $lengthD = ["nombre"=>30,"autoridad"=>55,"fecha_emision"=>15];

 /*  $pdf->Tabla($headersD,$dataD,$widthsD,0,$lengthD);
  */ $pdf->Ln( 5 );

  //Descripcion del plantel
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("4.	DESCRIPCIÓN DEL PLANTEL"), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 70, 5, utf8_decode("CARACTERISTICAS DEL INMUEBLE"), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  /* $pdf->Cell( 106, 5, utf8_decode($pdf->plantel["caracteristica_inmueble"]), 1, 1, "L", true );
   */$pdf->Ln( 5);

  //Niveles
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 70, 5, utf8_decode("EDIFICIOS Y/O NIVELES"), 1, 1, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  /* foreach ($pdf->edificioNiveles as $nivel) {
    $pdf->Cell( 70, 5, utf8_decode($nivel["nivel"]), 1, 1, "L", true );
  }
   */$pdf->Ln( 5);


  if($pdf->checkNewPage()){
    // Nombre del formato
      $pdf->SetFont( "Arial", "B", 11 );
      $pdf->Ln( 10);
      $pdf->SetTextColor( 255, 255, 255 );
      $pdf->SetFillColor( 0, 127, 204 );
      $pdf->Cell( 140, 5, "", 0, 0, "L");
      $pdf->Cell( 35, 6, "FDA05", 0, 0, "R", true);
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
  /* foreach ($pdf->seguridadSistemas as $seguridad) {
    $pdf->SetY($ejeY);
    $pdf->SetX($ejeX);
    $pdf->Cell( 76, 5, utf8_decode($seguridad["sistema"]), 1, 0, "L", true );
    $pdf->Cell( 30, 5, utf8_decode($seguridad["cantidad"]), 1, 1, "L", true );
    $ejeY +=5;
  } */

  if($pdf->checkNewPage()){
    // Nombre del formato
      $pdf->SetFont( "Arial", "B", 11 );
      $pdf->Ln( 10);
      $pdf->SetTextColor( 255, 255, 255 );
      $pdf->SetFillColor( 0, 127, 204 );
      $pdf->Cell( 140, 5, "", 0, 0, "L");
      $pdf->Cell( 35, 6, "FDA05", 0, 0, "R", true);
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

  /* foreach ($pdf->higienes as $higiene) {
    $pdf->Cell( 146, 5, utf8_decode($higiene["higiene"]), 1, 0, "L", true );
    $pdf->Cell( 30, 5, utf8_decode($higiene["cantidad"]), 1, 1, "L", true );
  } */
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
  /* $dataI = $pdf->tiposInstalacion;
   *///print_r($dataI);
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

  /* $pdf->Tabla($headersI,$dataI,$widthsI,0,$lengthI,false);
   */$pdf->Ln( 5 );

  if($pdf->checkNewPage()){
    // Nombre del formato
      $pdf->SetFont( "Arial", "B", 11 );
      $pdf->Ln( 10);
      $pdf->SetTextColor( 255, 255, 255 );
      $pdf->SetFillColor( 0, 127, 204 );
      $pdf->Cell( 140, 5, "", 0, 0, "L");
      $pdf->Cell( 35, 6, "FDA05", 0, 0, "R", true);
      $pdf->Ln( 10 );
      $pdf->SetTextColor( 0, 0, 0 );

  }

  // otros RVOES
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetTextColor( 0, 0, 00 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("7.	PROGRAMAS IMPARTIDOS EN EL PLANTEL (OTROS RVOE)"), 1, 1, "L", true );

  $headersO = ["nombre"=>"Nombre del programa","nivel"=>"Nivel","acuerdo"=>"No. de Acuerdo","numero_alumnos"=>"Total de Alumnos"];
  /* $dataO =  json_decode($pdf->programa["otros_rvoes"]);
   */$widthsO = ["nombre"=>47,"nivel"=>43,"acuerdo"=>43,"numero_alumnos"=>43];
  $lengthO = ["nombre"=>20,"nivel"=>20,"acuerdo"=>20,"numero_alumnos"=>20];
 /*  $pdf->Tabla($headersO,$dataO,$widthsO,0,$lengthO);
 */
  $pdf->Ln( 5 );

  if($pdf->checkNewPage()){
    // Nombre del formato
      $pdf->SetFont( "Arial", "B", 11 );
      $pdf->Ln( 10);
      $pdf->SetTextColor( 255, 255, 255 );
      $pdf->SetFillColor( 0, 127, 204 );
      $pdf->Cell( 140, 5, "", 0, 0, "L");
      $pdf->Cell( 35, 6, "FDA05", 0, 0, "R", true);
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
  /* foreach ($pdf->salud as $salud) {
    $pdf->SetFillColor( 255, 255, 255);
    $pdf->Cell( 88, 5, utf8_decode($salud["nombre"]), 1, 0, "C", true );
    $pdf->Cell( 88, 5, utf8_decode($salud["tiempo"]), 1, 1, "C", true );

  } */
  $pdf->Ln( 10 );
  $pdf->SetFont( "Arial", "", 11 );
  $pdf->Cell(0,5, utf8_decode("BAJO PROTESTA DE DECIR VERDAD"), 0, 1, "C");
  $pdf->SetFont( "Arial", "B", 11 );
  /* $pdf->Cell( 0, 5, utf8_decode(mb_strtoupper($pdf->nombreRepresentante)), 0, 1, "C");
 */
  if($pdf->checkNewPage()){
    // Nombre del formato
      $pdf->SetFont( "Arial", "B", 11 );
      $pdf->Ln( 10);
      $pdf->SetTextColor( 255, 255, 255 );
      $pdf->SetFillColor( 0, 127, 204 );
      $pdf->Cell( 140, 5, "", 0, 0, "L");
      $pdf->Cell( 35, 6, "FDA05", 0, 0, "R", true);
      $pdf->Ln( 10 );
      $pdf->SetTextColor( 0, 0, 0 );

  }

  /*  */

  $pdf->Output( "I", "FDA05.pdf" );
?>
