<?php
  /**
  * Archivo que gestiona los web services de la clase Validacion
  */

  require_once "../models/modelo-validacion.php";
  require_once "../models/modelo-bitacora.php";
  require_once "../models/modelo-documento.php";
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
    $obj = new Validacion( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"validaciones","accion"=>"consultarTodos","lugar"=>"control-validacion"]);
    $result = $bitacora->guardar();

		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Validacion();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"validacion","accion"=>"consultarId","lugar"=>"control-validacion"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para guardar registro
  if( $_POST["webService"]=="guardar" )
  {
    if ($_FILES) {
      $exito = 0;
      if( is_uploaded_file( $_FILES["archivo_validacion"]["tmp_name"] ) )
      {
        if( $_FILES["archivo_validacion"]["size"]<2000000 )
        {
          if( $_FILES["archivo_validacion"]["type"]=="application/pdf" )
          {
            $dir_institucion = 'Institucion'.$_POST["institucion_id"];
            $dir_plantel = '/PLANTEL'.$_POST["plantel_id"];
            $dir_validacion = '/validaciones';
            $directorio = Documento::$dir_subida.$dir_institucion.$dir_plantel.$dir_validacion;
            !is_dir($directorio)?mkdir($directorio, 0755, true):false;
            move_uploaded_file( $_FILES["archivo_validacion"]["tmp_name"], $directorio."/archivo_validacion".$_POST["alumno_id"].".pdf" );
            $exito = 1;
          }
        }
      }

      if( $_FILES["archivo_validacion"]["name"]!=null && $exito==0 )
      {
        header( "Location: ../views/ce-validacion-alumno.php?programa_id=".$_POST["programa_id"]."&alumno_id=".$_POST["alumno_id"]."&proceso=edicion"."&codigo=404" );
        exit( );
      }
    }

		$parametros = array( );
		$parametros["id"] = $_POST["id"];
    if ($_FILES) {
      if( $_FILES["archivo_validacion"]["name"]!=null ){ $parametros["archivo_validacion"] = "archivo_validacion".$_POST["alumno_id"].".pdf"; }
    }

    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    print_r($_POST);
    foreach( $_POST as $atributo=>$valor )
		{
			$parametros[$atributo] = $valor;
		}

		$obj = new Validacion( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    /*
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"validacion","accion"=>"guardar","lugar"=>"control-validacion"]);
    $result = $bitacora->guardar();*/
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Validacion( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"validacion","accion"=>"eliminar","lugar"=>"control-validacion"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }


?>
