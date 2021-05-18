<?php
  /**
  * Archivo que gestiona los web services de la clase Equivalencia
  */

  require_once "../models/modelo-equivalencia.php";
  require_once "../models/modelo-bitacora.php";
  require_once "../models/modelo-documento.php";
  require_once "../models/modelo-alumno.php";
  require_once "../utilities/utileria-general.php";

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
  if( $_POST["webService"]=="consultarTodos" )
  {
    $obj = new Equivalencia( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"equivalencias","accion"=>"consultarTodos","lugar"=>"control-equivalencia"]);
    $result = $bitacora->guardar();

		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Equivalencia();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"equivalencia","accion"=>"consultarId","lugar"=>"control-equivalencia"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para guardar registro
  if( $_POST["webService"]=="guardar" )
  {
    $exito = 0;
		if( is_uploaded_file( $_FILES["archivo_certificado"]["tmp_name"] ) )
		{
			if( $_FILES["archivo_certificado"]["size"]<2000000 )
			{
				if( $_FILES["archivo_certificado"]["type"]=="application/pdf" )
				{
					$dir_certificados = '/certificados';
          $directorio = Documento::$dir_subida.$dir_certificados;
					!is_dir($directorio)?mkdir($directorio, 0755, true):false;
					move_uploaded_file( $_FILES["archivo_certificado"]["tmp_name"], $directorio."/documento1_".$_POST["alumno_id"].".pdf" );
					$exito = 1;
				}
			}
		}

		if( $_FILES["archivo_certificado"]["name"]!=null && $exito==0 )
		{
			header( "Location: ../views/ce-equivalencia-expediente.php?programa_id=".$_POST["programa_id"]."&alumno_id=".$_POST["alumno_id"]."&proceso=edicion"."&codigo=404" );
      exit( );
		}

		$exito = 0;
		if( is_uploaded_file( $_FILES["archivo_nacimiento"]["tmp_name"] ) )
		{
			if( $_FILES["archivo_nacimiento"]["size"]<2000000 )
			{
				if( $_FILES["archivo_nacimiento"]["type"]=="application/pdf" )
				{
					$dir_certificados = '/certificados';
          $directorio = Documento::$dir_subida.$dir_certificados;
					!is_dir($directorio)?mkdir($directorio, 0755, true):false;
					move_uploaded_file( $_FILES["archivo_nacimiento"]["tmp_name"], $directorio."/documento2_".$_POST["alumno_id"].".pdf" );
					$exito = 1;
				}
			}
		}

		if( $_FILES["archivo_nacimiento"]["name"]!=null && $exito==0 )
		{
			header( "Location: ../views/ce-equivalencia-expediente.php?programa_id=".$_POST["programa_id"]."&alumno_id=".$_POST["alumno_id"]."&proceso=edicion"."&codigo=404" );
      exit( );
		}

		$exito = 0;
		if( is_uploaded_file( $_FILES["archivo_curp"]["tmp_name"] ) )
		{
			if( $_FILES["archivo_curp"]["size"]<2000000 )
			{
				if( $_FILES["archivo_curp"]["type"]=="application/pdf" )
				{
					$dir_certificados = '/certificados';
          $directorio = Documento::$dir_subida.$dir_certificados;
					!is_dir($directorio)?mkdir($directorio, 0755, true):false;
					move_uploaded_file( $_FILES["archivo_curp"]["tmp_name"], $directorio."/documento3_".$_POST["alumno_id"].".pdf" );
					$exito = 1;
				}
			}
		}

		if( $_FILES["archivo_curp"]["name"]!=null && $exito==0 )
		{
			header( "Location: ../views/ce-equivalencia-expediente.php?programa_id=".$_POST["programa_id"]."&alumno_id=".$_POST["alumno_id"]."&proceso=edicion"."&codigo=404" );
      exit( );
		}

		if( !isset($_POST["estatus_certificado"]) ){ $_POST["estatus_certificado"] = -1; }
		if( !isset($_POST["estatus_nacimiento"]) ){ $_POST["estatus_nacimiento"] = -1; }
		if( !isset($_POST["estatus_curp"]) ){ $_POST["estatus_curp"] = -1; }

		$parametrosAlumno = array( );
		$parametrosAlumno["id"] = $_POST["alumno_id"];
		if( $_FILES["archivo_certificado"]["name"]!=null ){ $parametrosAlumno["archivo_certificado"] = "documento1_".$_POST["alumno_id"].".pdf"; }
		if( $_FILES["archivo_nacimiento"]["name"]!=null ){ $parametrosAlumno["archivo_nacimiento"] = "documento2_".$_POST["alumno_id"].".pdf"; }
		if( $_FILES["archivo_curp"]["name"]!=null ){ $parametrosAlumno["archivo_curp"] = "documento3_".$_POST["alumno_id"].".pdf"; }
		$parametrosAlumno["estatus_certificado"] = $_POST["estatus_certificado"];
		$parametrosAlumno["estatus_nacimiento"] = $_POST["estatus_nacimiento"];
		$parametrosAlumno["estatus_curp"] = $_POST["estatus_curp"];

		$alumno = new Alumno( );
		$alumno->setAttributes( $parametrosAlumno );
    $resultadoAlumno = $alumno->guardar( );


    if ($_FILES) {
      $exito = 0;
      if( is_uploaded_file( $_FILES["archivo_certificado_parcial"]["tmp_name"] ) )
      {
        if( $_FILES["archivo_certificado_parcial"]["size"]<2000000 )
        {
          if( $_FILES["archivo_certificado_parcial"]["type"]=="application/pdf" )
          {
            $dir_institucion = 'Institucion'.$_POST["institucion_id"];
            $dir_plantel = '/PLANTEL'.$_POST["plantel_id"];
            $dir_equivalencia = '/equivalencias';
            $directorio = Documento::$dir_subida.$dir_institucion.$dir_plantel.$dir_equivalencia;
            !is_dir($directorio)?mkdir($directorio, 0755, true):false;
            move_uploaded_file( $_FILES["archivo_certificado_parcial"]["tmp_name"], $directorio."/archivo_certificado_parcial_".$_POST["alumno_id"].".pdf" );
            $exito = 1;
          }
        }
      }

      if( $_FILES["archivo_certificado_parcial"]["name"]!=null && $exito==0 )
      {
        header( "Location: ../views/ce-equivalencia-expediente.php?programa_id=".$_POST["programa_id"]."&alumno_id=".$_POST["alumno_id"]."&proceso=edicion"."&codigo=404" );
        exit( );
      }

      $exito = 0;
      if( is_uploaded_file( $_FILES["archivo_resolucion"]["tmp_name"] ) )
      {
        if( $_FILES["archivo_resolucion"]["size"]<2000000 )
        {
          if( $_FILES["archivo_resolucion"]["type"]=="application/pdf" )
          {
            $dir_institucion = 'Institucion'.$_POST["institucion_id"];
            $dir_plantel = '/PLANTEL'.$_POST["plantel_id"];
            $dir_equivalencia = '/equivalencias';
            $directorio = Documento::$dir_subida.$dir_institucion.$dir_plantel.$dir_equivalencia;
            !is_dir($directorio)?mkdir($directorio, 0755, true):false;
            move_uploaded_file( $_FILES["archivo_resolucion"]["tmp_name"], $directorio."/archivo_resolucion_".$_POST["alumno_id"].".pdf" );
            $exito = 1;
          }
        }
      }

      if( $_FILES["archivo_resolucion"]["name"]!=null && $exito==0 )
      {
        header( "Location: ../views/ce-equivalencia-expediente.php?programa_id=".$_POST["programa_id"]."&alumno_id=".$_POST["alumno_id"]."&proceso=edicion"."&codigo=404" );
        exit( );
      }
    }

		$parametros = array( );
		$parametros["id"] = $_POST["id"];
    if ($_FILES) {
      if( $_FILES["archivo_certificado_parcial"]["name"]!=null ){ $parametros["archivo_certificado_parcial"] = "archivo_certificado_parcial_".$_POST["alumno_id"].".pdf"; }
      if( $_FILES["archivo_resolucion"]["name"]!=null ){ $parametros["archivo_resolucion"] = "archivo_resolucion_".$_POST["alumno_id"].".pdf"; }
    }

    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    foreach( $_POST as $atributo=>$valor )
		{
			$parametros[$atributo] = $valor;
		}

		$obj = new Equivalencia( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    /*
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"equivalencia","accion"=>"guardar","lugar"=>"control-equivalencia"]);
    $result = $bitacora->guardar();*/
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Equivalencia( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"equivalencia","accion"=>"eliminar","lugar"=>"control-equivalencia"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }


?>
