<?php
require( "pdfoficio.php" );

session_start( );

if(!isset($_POST["id"]) || empty($_POST["id"])){
  header('Location: ../home.php');
}

if(!isset($_POST["oficio"]) || empty($_POST["oficio"])){
  header('Location: ../home.php');
}

class OficioPDF extends PDF
{

  function Footer(){
    $this->Cell( 0, 10, utf8_decode("Página ".$this->PageNo()." de {nb}"), 0, 1, "C" );
  }
}

$pdf = new OficioPDF();
$pdf->AliasNbPages( );
$pdf->AddPage( "P", "Letter" );
$pdf->SetFont( "Arial", "B", 12 );
$pdf->SetMargins(50, 20 , 20);

// Obtener datos
$pdf->getProgramaPorSolicitud($_POST["id"]);
$pdf->getPlantel($pdf->programa["plantel_id"]);
$pdf->getInstitucion($pdf->plantel["institucion_id"]);
$pdf->getRepresentante($pdf->institucion["usuario_id"]);
$pdf->getInspectores($pdf->programa["id"]);
$pdf->getInspecciones($pdf->programa["id"]);

$registro["solicitud_id"] = $_POST["id"];
$registro["oficio"] = $_POST["oficio"];
$registro["documento"] = "AcuerdoCambioRepresentanteLegal";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);

$detalles = isset($oficio["detalles"])?$oficio["detalles"]:"";
$actaNotariada = "";
$acuerdoRvoeAnterior = "";
$fechaAnterior = "";
$representanteAnterior = "";
if(!empty($detalles)){
  foreach ($detalles as $key => $detalle) {
    if("acta_notariada" == $detalle["propiedad"]){
      $actaNotariada = $detalle["detalle"];
    }
    if("acuerdo_rvoe_anterior" == $detalle["propiedad"]){
      $acuerdoRvoeAnterior = $detalle["detalle"];
    }
    if("fecha_anterior" == $detalle["propiedad"]){
      $fechaAnterior = $detalle["detalle"];
    }
    if("representante_anterior" == $detalle["propiedad"]){
      $representanteAnterior = $detalle["detalle"];
    }
  }
}

$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("                       ACUERDO DE RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIOS"), 0, 1, "C");
$pdf->Ln(10);
$pdf->SetFont( "Arial", "", 9 );

$pdf->MultiCell( 0, 5, utf8_decode("Acuerdo de Reconocimiento de Validez Oficial de Estudios que se expide con fundamento en el artículo 3° fracción VI de la Constitución Política de los Estados Unidos Mexicanos; artículo 14 fracción IV, 54, 55 y 57 de la Ley General de Educación; 13 fracción IV, 117, 118, 119 fracción II segundo párrafo, 120 fracciones I, II y IV de la Ley de Educación del Estado de Jalisco; 23 fracciones XXV y XXVII, transitorios quinto y sexto de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco; artículo 7 fracciones XIII, XIV, XV, artículo 14 fracción XXVI, transitorio segundo del Reglamento Interno de la Secretaría de Innovación, Ciencia y Tecnología; Acuerdo del Ciudadano Secretario de Innovación, Ciencia y Tecnología del Estado de Jalisco con fecha 18 de febrero de 2016, y"), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("CONSIDERANDO:"), 0, 1, "C");
$pdf->Ln(5);

$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"]? "el": "la";

$fecha = $pdf->convertirFecha($pdf->programa["updated_at"]);
$pdf->MultiCell( 0, 5, utf8_decode("1. Que el "
.$pdf->institucion["nombre"]
.", a través de su anterior representante legal ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
." obtuvo de la Secretaría de Educación del Estado de Jalisco el acuerdo de incorporación número "
.$pdf->programa["acuerdo_rvoe"]
." de fecha "
.$fecha
.", en el que se autoriza impartir la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
."."), 0, "J");
$pdf->Ln(5);



$actaNotariada = empty($actaNotariada)?$_POST["acta_notariada"]:$actaNotariada;
$pdf->MultiCell( 0, 5, utf8_decode("2. ".$actaNotariada), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("3. Que con fundamento en el artículo 23 fracción XXV, de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco, mediante la cual se faculta a la Secretaría de Innovación, Ciencia y Tecnología para ''Autorizar y Vigilar la prestación de los servicios de educación superior y tecnología a cargo de los particulares en el estado conforme a la Ley'' y una vez analizados los documentos probatorios anexo su solicitud, la Secretaría de Innovación, Ciencia y Tecnología autoriza que ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
." ocupe el cargo de representante legar del plantel educativo "
.$pdf->institucion["nombre"]
."."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("4. Que el propio establecimiento educativo cuenta con el material didáctico necesario para el correcto desarrollo de sus actividades educativas."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("5. Que por satisfacer los requisitos establecidos por la Secretaría se aceptó al personal directivo, docente y técnico propuestos."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("6. Que el inmueble que ocupa el establecimiento educativo reúne las condiciones higiénicas, de seguridad y pedagógicas determinadas por la Secretaría de Innovación, Ciencia y Tecnología, se acredita la posesión legal del mismo, mediante contrato de arrendamiento."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("7. Que en dicho establecimiento educativo se aplican los planes y programas de estudio previamente autorizados por la Secretaría de Educación del Estado de Jalisco."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("8. Que la Institución por medio de su representante legal, se ha comprometido a que el personal directivo y docente se ajustará a las disposiciones del artículo 3º de la Constitución Política de los Estados Unidos Mexicanos, la Ley General de Educación, la Ley de Educación del Estado de Jalisco, y demás disposiciones correlativas que se dicten en materia educativa."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("9. Que la Institución por medio de su representante legal, se ha comprometido a someter previamente a la aprobación de la Dirección General de Educación Superior, Investigación y Posgrado y a la Coordinación de Instituciones de Educación Superior Incorporadas, cualquier modificación o cambio relacionado con su denominación, domicilio, turno de trabajo, organización de alumnado, personal directivo, docente y técnico propuesto."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("10. Que la Institución por medio de su representante legal y en cuanto a las cuotas por los servicios educativos que presta, se ha comprometido a ajustarse a los lineamientos del ''Acuerdo Secretarial que Establece las Bases Mínimas de Información para la Comercialización de los Servicios Educativos que Prestan los Particulares'', publicado en el Diario Oficial de la Federación el 10 de marzo de 1992."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("11. Que la Institución por medio de su representante legal, se ha comprometido a integrar un equipo técnico pedagógico, el cual realizará en forma permanente la revisión de los planes y programas de estudio, así como la aplicación, seguimiento, evaluación y retroalimentación de la práctica docente."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("12. Que la Institución por medio de su representante legal, se ha comprometido a proporcionar becas en los términos señalados en la Ley de Educación del Estado de Jalisco, mismas que se asignarán a los alumnos basándose en los requisitos y lineamientos generales que determine la Secretaría de Educación."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("13. Que la Institución por medio de su presentante legal, se ha comprometido a construir en el plantel educativo el Comité de Seguridad Escolar, de conformidad con los lineamientos establecidos en el Decreto publicado en el Diario Oficial de la Federación del 4 de septiembre de 1986."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("14. Que la Institución por medio de su representante legal, tiene conocimiento de las causales de infracción establecidas en los artículos 140 y 142 de la Ley de Educación del Estado de Jalisco y que en el caso de incumplimiento se hará acreedor de las sanciones que establecen los artículos 141 y 144 de la Ley de Educación del Estado de Jalisco."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("15. Que la Institución por medio de su representante legal, se ha comprometido a dar aviso por escrito a la Dirección General de Educación Superior, Investigación y Posgrado y a la Coordinación de Instituciones de Educación Superior Incorporadas en caso de baja de la institución educativa, en un plazo mínimo de 90 días naturales antes de la terminación del ciclo escolar, así como hacer entrega de los archivos correspondientes y a no dejar ciclos inconclusos ni obligaciones pendientes por cumplir."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("16. Que la Institución por medio de su representante legal, se ha comprometido a informar de manera oportuna a la Dirección General de Educación Superior, Investigación y Posgrado y a la Coordinación de Instituciones de Educación Superior Incorporadas sobre las inscripciones, la actualización de esta información, presentar las calificaciones resultado del proceso de evaluación del aprendizaje, asimismo solicitar los certificados respectivos."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("Por lo que en atención a la expuesto y con fundamento en los artículos 3º, 5º, y 8º de la Constitución Política de los Estados Unidos Mexicanos; artículos 14 y 54 de la Ley General de Educación; los artículos 13 y 106 de la Ley de Educación del Estado de Jalisco, y el Instructivo Técnico de la Convocatoria 2016, No. III, Expedido;"), 0, "J");
$pdf->Ln(5);


$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("ACUERDO NÚMERO ".$pdf->programa["acuerdo_rvoe"]), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Ln(5);

$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_POST["id"],11));
$pdf->MultiCell( 0, 5, utf8_decode("PRIMERO.- Se autoriza el cambio de representante legal al "
.$pdf->institucion["nombre"]
.", para continuar impartiendo la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", en el domicilio "
.$pdf->plantel["domicilio"]["calle"]
.", "
.$pdf->plantel["domicilio"]["numero_exterior"]
." "
.$pdf->plantel["domicilio"]["numero_exterior"]
." colonia "
.$pdf->plantel["domicilio"]["colonia"]
." "
.$pdf->plantel["domicilio"]["municipio"]
.", "
.$pdf->plantel["domicilio"]["estado"]
.", a partir del "
.$fecha
."."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("SEGUNDO.- La Institución citada queda bajo la supervisión de la Secretaría de Innovación, Ciencia y Tecnología quien cuidará del cumplimiento de la Ley de Educación del Estado de Jalisco y las demás disposiciones reglamentarias en materia de educación."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("TERCERO.- La Institución citada queda obligada a sujetarse a los planes y programas de estudio que la Secretaría de Educación autorizó por considerarlos pertinentes."), 0, "J");
$pdf->Ln(5);

$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_POST["id"],11));
$pdf->MultiCell( 0, 5, utf8_decode("CUARTO.- "
.$pdf->institucion["nombre"]
.", a través de su representante legal, deberá mencionar en la documentación que expida y en la publicidad que haga, la referencia de los estudios aprobados del plan y programas de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", en su calidad de autorizado como parte del Sistema Educativo Nacional, estableciendo la Leyenda de RVOE AUTORIZADO, a la fecha "
.$fecha
." y número de Acuerdo "
.$pdf->programa["acuerdo_rvoe"]
.", así como, la autoridad que lo otorgó, la Secretaría de Innovación, Ciencia y Tecnología."), 0, "J");
$pdf->Ln(5);


$pdf->MultiCell( 0, 5, utf8_decode("QUINTO.- El presente Reconocimiento de Validez Oficial de Estudios es para efectos eminentemente educativos, por lo que ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", queda obligado a obtener de las autoridades competentes todos los permisos, dictámenes y licencias que procedan conforme a los ordenamientos aplicables y sus disposiciones reglamentarias."), 0, "J");
$pdf->Ln(5);

$acuerdoRvoeAnterior = empty($acuerdoRvoeAnterior)?$_POST["acuerdo_rvoe_anterior"]:$acuerdoRvoeAnterior;
$fechaAnterior = empty($fechaAnterior)?$_POST["fecha_anterior"]:$fechaAnterior;
$representanteAnterior = empty($representanteAnterior)?$_POST["representante_anterior"]:$representanteAnterior;
$pdf->MultiCell( 0, 5, utf8_decode("SEXTO.- El acuerdo de Incorporación "
.$acuerdoRvoeAnterior
." de fecha "
.$fechaAnterior
.", en el que se autoriza impartir la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", por C. "
.$representanteAnterior
.", Representante Legal del plantel educativo "
.$pdf->institucion["nombre"]
.", ubicado en la "
.$pdf->plantel["domicilio"]["calle"]
.", "
.$pdf->plantel["domicilio"]["numero_exterior"]
." "
.$pdf->plantel["domicilio"]["numero_exterior"]
." colonia "
.$pdf->plantel["domicilio"]["colonia"]
." "
.$pdf->plantel["domicilio"]["municipio"]
.", "
.$pdf->plantel["domicilio"]["estado"]
.", quedará sin efectos a partir de la fecha de expedición del presente acuerdo."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("SEPTIMO.- Notifíquese esta resolución a las direcciones y departamentos dependientes de la Secretaría de Innovación, Ciencia y Tecnología y los que dependan de la Secretaría de Educación Jalisco que correspondan, así como a la parte interesada para los efectos legales que dieran lugar."), 0, "J");
$pdf->Ln(5);

$fecha = $pdf->convertirFecha(date("Y-m-d"));
$pdf->Cell( 0, 5, utf8_decode("Expedido en la ciudad de Guadalajara, Jalisco, el día "
.$fecha
."."), 0, 1, "L");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR GENERAL DE EDUCACIÓN SUPERIOR, INVESTIGACIÓN Y POSGRADO"), 0, 1, "C");
$pdf->Ln(15);

$pdf->Cell( 0, 5, utf8_decode("LIC. LUIS GUSTAVO PADILLA MONTES"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );

if(!$oficio){
  $pdf->guardarOficio($registro);
  $id = $pdf->oficioG->id;
  $pdf->guardarOficioDetalles(["oficio_id"=>$id,"propiedad"=>"acta_notariada","detalle"=>$_POST["acta_notariada"]]);
  $pdf->guardarOficioDetalles(["oficio_id"=>$id,"propiedad"=>"acuerdo_rvoe_anterior","detalle"=>$_POST["acuerdo_rvoe_anterior"]]);
  $pdf->guardarOficioDetalles(["oficio_id"=>$id,"propiedad"=>"fecha_anterior","detalle"=>$_POST["fecha_anterior"]]);
  $pdf->guardarOficioDetalles(["oficio_id"=>$id,"propiedad"=>"representante_anterior","detalle"=>$_POST["representante_anterior"]]);
}

$pdf->Output( "I", "AcuerdoCambioRepresentanteLegal.pdf" );
?>
