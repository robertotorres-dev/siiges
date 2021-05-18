<?php
  /**
  * Archivo que gestiona los web services de la clase Equivalencia
  */

  require_once "../models/modelo-bitacora.php";
  require_once "../models/modelo-documento.php";
  require_once "../models/modelo-institucion.php";
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
		
		// En caso de no subir nungún archivo, mostrar error
    if ($file_xml["error"] == 4) {
			$_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Archivo no seleccionado.","data"=>[]]);
			$resultado["error"] = 1;
			$resultado["url"] = $_POST["url"];
      retornarWebService( "", $resultado );
    }

		$ext = pathinfo($file_xml["name"], PATHINFO_EXTENSION);
	
		//En caso de no tener la extensión XML, mostrar error
		if ($ext != "xml") {
			$_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"Extención de archivo incorrecta.","data"=>[]]);
			$resultado["error"] = 1;
			$resultado["url"] = $_POST["url"];
      retornarWebService( "", $resultado );
		}

    $obj = new Institucion( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    print_r($resultado["data"]);
		

    $xml_content = file_get_contents($file_xml["tmp_name"]);
		$xml_content = str_replace("@attributes", "attributes", $xml_content);
    
		
		$xml_content = simplexml_load_string(utf8_encode($xml_content));

		$xml_content = (array) $xml_content;

    $xml_data["folio_control"] = $xml_content["@attributes"]["folioControl"];
    
    // Responsable
		$xml_content["FirmaResponsables"] = (array) $xml_content["FirmaResponsables"];
		$xml_content["FirmaResponsables"]["FirmaResponsable"] = (array) $xml_content["FirmaResponsables"]["FirmaResponsable"];
    $xml_data["nombre_responsable"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["nombre"];
    $xml_data["primer_apellido_resposnable"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["primerApellido"];
    $xml_data["segundo_apellido_resposnable"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["segundoApellido"];
    $xml_data["curp_responsable"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["curp"];
    $xml_data["id_cargo"] = $xml_content["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["idCargo"];

    // Institución
    $xml_content["Institucion"] = (array) $xml_content["Institucion"];
    $xml_data["cve_institucion"] = $xml_content["Institucion"]["@attributes"]["cveInstitucion"];
    $xml_data["id_institucion"] = $xml_content["id_institucion"];
    $xml_data["nombre_institucion"] = $xml_content["Institucion"]["@attributes"]["nombreInstitucion"];;
    
    // Carrera
    $xml_content["Carrera"] = (array) $xml_content["Carrera"];
    $xml_data["cve_carrera"] = $xml_content["Carrera"]["@attributes"]["cveCarrera"];
    $xml_data["nombre_carrera"] = $xml_content["Carrera"]["@attributes"]["nombreCarrera"];
    $xml_data["fecha_inicio"] = $xml_content["Carrera"]["@attributes"]["fechaInicio"];
    $xml_data["fecha_terminacion"] = $xml_content["Carrera"]["@attributes"]["fechaTerminacion"];
    $xml_data["id_autorizacion_reconocimiento"] = $xml_content["Carrera"]["@attributes"]["idAutorizacionReconocimiento"];
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
    $xml_data["id_modalidad_titulacion"] = $xml_content["Expedicion"]["@attributes"]["idModalidadTitulacion"];
    $xml_data["fecha_exencion_examen_profesional"] = $xml_content["Expedicion"]["@attributes"]["fechaExencionExamenProfesional"];
    $xml_data["cumplio_servicio_social"] = $xml_content["Expedicion"]["@attributes"]["cumplioServicioSocial"];
    $xml_data["id_fundamento_legal_servicio_social"] = $xml_content["Expedicion"]["@attributes"]["idFundamentoLegalServicioSocial"];
    $xml_data["id_estado"] = $xml_content["Expedicion"]["@attributes"]["idEntidadFederativa"];

    // Antecedente
    $xml_content["Antecedente"] = (array) $xml_content["Antecedente"];
    $xml_data["instituto_procedencia"] = $xml_content["Antecedente"]["@attributes"]["institucionProcedencia"];
    $xml_data["id_tipo_estudio_antecedente"] = $xml_content["Antecedente"]["@attributes"]["idTipoEstudioAntecedente"];
    $xml_data["id_estado_antecedente"] = $xml_content["Antecedente"]["@attributes"]["idEntidadFederativa"];
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
		//print_r($xml_data);
		//print_r($xml_content);
		
		
    $resultado = $xml_content;

		
		//retornarWebService( "", $resultado );

    /* $exito = 0;
		if( is_uploaded_file( $_FILES["archivo_xml"]["tmp_name"] ) )
		{
			if( $_FILES["archivo_xml"]["size"]<2000000 )
			{
				if( $_FILES["archivo_xml"]["type"]=="application/pdf" )
				{
					$dir_titulacion = '/titulacion_electronica';
          $directorio = Documento::$dir_subida.$dir_titulacion;
					!is_dir($directorio)?mkdir($directorio, 0755, true):false;
					move_uploaded_file( $_FILES["archivo_xml"]["tmp_name"], $directorio."/titulo_electronico_".".pdf" );
					$exito = 1;
				}
			}
		} */
  }
  ?>