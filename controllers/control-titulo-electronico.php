<?php
  /**
  * Archivo que gestiona los web services de la clase Equivalencia
  */

  require_once "../models/modelo-bitacora.php";
  require_once "../models/modelo-documento.php";
  require_once "../models/modelo-institucion.php";
  require_once "../models/modelo-titulo-electronico.php";
  require_once "../utilities/utileria-general.php";
	
	session_start( );

	function retornarWebService( $url, $resultado )
	{
    if( $url!="" )
		{
			header( "Location: $url" );
			exit( );
		}
		else
		{
			echo json_encode( $resultado );
			exit( );
		}
	}

	//====================================================================================================

  // Web service para consultar todos los registros
  if( $_POST["webService"]=="guardar" )
  {
    
    $file_xml = $_FILES["archivo-xml"];

    //print_r($_POST);
		
		// En caso de no subir nungún archivo, mostrar error
    if ($file_xml["error"] == 4) {
			$_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Archivo no seleccionado.","data"=>[]]);
			$resultado["error"] = 1;
			$resultado["url"] = $_POST["url"];
      retornarWebService( "", $resultado );
    }

		//En caso de no tener la extensión XML, mostrar error
		$ext = pathinfo($file_xml["name"], PATHINFO_EXTENSION);
		if ($ext != "xml") {
			$_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Extención de archivo incorrecta.","data"=>[]]);
			$resultado["error"] = 1;
			$resultado["url"] = $_POST["url"];
      retornarWebService( "", $resultado );
		}

    // En caso de no seleccionar nunguna institución, mostrar error
    if (!($_POST["institucion_id"])) {
			$_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Institución no seleccionada.","data"=>[]]);
			$resultado["error"] = 1;
			$resultado["url"] = $_POST["url"];
      retornarWebService( "", $resultado );
    }
		
    
    $xml_content = file_get_contents($file_xml["tmp_name"]);
		$xml_content = str_replace("@attributes", "attributes", $xml_content);
    
		
		$xml_content = simplexml_load_string($xml_content);
    
		$xml_content = (array) $xml_content;
    
    // En caso de encontrarse ya registrado el folio de titulo, mostrar error
    $titulo = new TitulosElectronicos();
    $res_titulo = $titulo->consultarPor("titulo_electronico",array("folio_control"=>$xml_content["@attributes"]["folioControl"], "delete_at"), "*");
    if (sizeof( $res_titulo["data"] ) > 0) {
			$_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"El folio de control ya se encuentra registrado.","data"=>[]]);
			$resultado["error"] = 1;
			$resultado["url"] = $_POST["url"];
      retornarWebService( "", $resultado );
    }


    $xml_data["folio_control"] = $xml_content["@attributes"]["folioControl"];
    $xml_data["version"] = $xml_content["@attributes"]["version"];
    
    // Responsable
		$xml_content["FirmaResponsables"] = (array) $xml_content["FirmaResponsables"];
		$xml_content["FirmaResponsables"]["FirmaResponsable"] = (array) $xml_content["FirmaResponsables"]["FirmaResponsable"];
    $xml_data["nombre_responsable"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["nombre"];
    $xml_data["primer_apellido_responsable"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["primerApellido"];
    $xml_data["segundo_apellido_responsable"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["segundoApellido"];
    $xml_data["curp_responsable"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["curp"];
    $xml_data["cargo_id"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["idCargo"];
    $xml_data["sello"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["sello"];
    $xml_data["certificado_responsable"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["certificadoResponsable"];
    $xml_data["no_certificado_responsable"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["noCertificadoResponsable"];

    // Institución
    $xml_content["Institucion"] = (array) $xml_content["Institucion"];
    $xml_data["nombre_institucion"] = $xml_content["Institucion"]["@attributes"]["nombreInstitucion"];
    $xml_data["cve_institucion"] = $xml_content["Institucion"]["@attributes"]["cveInstitucion"];
    $xml_data["institucion_id"] = $_POST["institucion_id"];
    $xml_data["nombre_institucion"] = $xml_content["Institucion"]["@attributes"]["nombreInstitucion"];;
    
    // Carrera
    $xml_content["Carrera"] = (array) $xml_content["Carrera"];
    $xml_data["cve_carrera"] = $xml_content["Carrera"]["@attributes"]["cveCarrera"];
    $xml_data["nombre_carrera"] = $xml_content["Carrera"]["@attributes"]["nombreCarrera"];
    $xml_data["fecha_inicio"] = $xml_content["Carrera"]["@attributes"]["fechaInicio"];
    $xml_data["fecha_terminacion"] = $xml_content["Carrera"]["@attributes"]["fechaTerminacion"];
    $xml_data["autorizacion_reconocimiento_id"] = $xml_content["Carrera"]["@attributes"]["idAutorizacionReconocimiento"];
    $xml_data["numero_rvoe"] = $xml_content["Carrera"]["@attributes"]["numeroRvoe"];
    
    // Profesionista
    $xml_content["Profesionista"] = (array) $xml_content["Profesionista"];
    $xml_data["curp"] = $xml_content["Profesionista"]["@attributes"]["curp"];
    $xml_data["nombre"] = $xml_content["Profesionista"]["@attributes"]["nombre"];
    $xml_data["primer_apellido"] = $xml_content["Profesionista"]["@attributes"]["primerApellido"];
    $xml_data["segundo_apellido"] = $xml_content["Profesionista"]["@attributes"]["segundoApellido"];
    $xml_data["correo_electronico"] = $xml_content["Profesionista"]["@attributes"]["correoElectronico"];

    // Expedición
    $xml_content["Expedicion"] = (array) $xml_content["Expedicion"];
    $xml_data["fecha_expedicion"] = $xml_content["Expedicion"]["@attributes"]["fechaExpedicion"];
    $xml_data["modalidad_titulacion_id"] = $xml_content["Expedicion"]["@attributes"]["idModalidadTitulacion"];
    $xml_data["fecha_exencion_examen_profesional"] = $xml_content["Expedicion"]["@attributes"]["fechaExencionExamenProfesional"];
    $xml_data["cumplio_servicio_social"] = $xml_content["Expedicion"]["@attributes"]["cumplioServicioSocial"];
    $xml_data["fundamento_legal_servicio_social_id"] = $xml_content["Expedicion"]["@attributes"]["idFundamentoLegalServicioSocial"];
    $xml_data["estado_id"] = $xml_content["Expedicion"]["@attributes"]["idEntidadFederativa"];

    // Antecedente
    $xml_content["Antecedente"] = (array) $xml_content["Antecedente"];
    $xml_data["institucion_procedencia"] = $xml_content["Antecedente"]["@attributes"]["institucionProcedencia"];
    $xml_data["tipo_estudio_antecedente_id"] = $xml_content["Antecedente"]["@attributes"]["idTipoEstudioAntecedente"];
    $xml_data["estado_antecedente_id"] = $xml_content["Antecedente"]["@attributes"]["idEntidadFederativa"];
    $xml_data["fecha_inicio_antecedente"] = $xml_content["Antecedente"]["@attributes"]["fechaInicio"];
    $xml_data["fecha_terminacion_antecedente"] = $xml_content["Antecedente"]["@attributes"]["fechaTerminacion"];
    $xml_data["no_cedula"] = $xml_content["Antecedente"]["@attributes"]["noCedula"];

    // Autenticación
    $xml_content["Autenticacion"] = (array) $xml_content["Autenticacion"];
    $xml_data["folio_digital"] = $xml_content["Autenticacion"]["@attributes"]["folioDigital"];
    $xml_data["fecha_autenticacion"] = $xml_content["Autenticacion"]["@attributes"]["fechaAutenticacion"];
    $xml_data["sello_titulo"] = $xml_content["Autenticacion"]["@attributes"]["selloTitulo"];
    $xml_data["no_certificado_autoridad"] = $xml_content["Autenticacion"]["@attributes"]["noCertificadoAutoridad"];
    $xml_data["sello_autenticacion"] = $xml_content["Autenticacion"]["@attributes"]["selloAutenticacion"];

		$xml_data = (array) $xml_data;
    $aux = new Utileria( );
    $xml_data = $aux->limpiarEntrada( $xml_data );
		$obj = new TitulosElectronicos( );
		$obj->setAttributes( $xml_data );
    $resultado = $obj->guardar( );

    $exito = 0;
    if( is_uploaded_file( $_FILES["archivo-xml"]["tmp_name"] ) )
		{
			if( $_FILES["archivo-xml"]["size"]<2000000 )
			{
				if( $_FILES["archivo-xml"]["type"]=="text/xml" )
				{
					$dir_titulacion = '/titulacion_electronica';
          $dir_institucion = '/Institucion'.$xml_data['institucion_id'];
          $directorio = Documento::$dir_subida.$dir_institucion.$dir_titulacion;
					!is_dir($directorio)?mkdir($directorio, 0755, true):false;
					move_uploaded_file( $_FILES["archivo-xml"]["tmp_name"], $directorio."/titulo_electronico_".$xml_data["folio_control"].".xml" );
					$exito = 1;
				}
			}
		}

      $_SESSION["resultado"] = json_encode(["status"=>"200","message"=>"El folio ".$xml_data["folio_control"]." se ha registrado con éxito.","data"=>[]]);
			$resultado["url"] = $_POST["url"];
      retornarWebService( "", $resultado );
  }
  ?>