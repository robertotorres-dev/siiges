<?php
  /**
  * Archivo que gestiona los web services de la clase Validacion
  */

  require_once "../models/modelo-validacion.php";
    require_once "../models/modelo-bitacora.php";
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

    print_r($_FILES["oficio_envio"]["tmp_name"]);
    echo "<br>";
    print_r($_POST);
    echo "<br>";
    if ($_FILES) {
      $exito = 0;
      if( is_uploaded_file( $_FILES["oficio_envio"]["tmp_name"] ) )
      {
        if( $_FILES["oficio_envio"]["size"]<2000000 )
        {
          if( $_FILES["oficio_envio"]["type"]=="application/pdf" )
          {
            move_uploaded_file( $_FILES["oficio_envio"]["tmp_name"], "../uploads/validaciones/oficio_envio_".$_POST["alumno_id"].".pdf" );
            $exito = 1;
          }
        }
      }

      if( $_FILES["oficio_envio"]["name"]!=null && $exito==0 )
      {
        header( "Location: ../views/ce-validacion-alumno.php?programa_id=".$_POST["programa_id"]."&alumno_id=".$_POST["alumno_id"]."&proceso=edicion"."&codigo=404" );
        exit( );
      }

      $exito = 0;
      if( is_uploaded_file( $_FILES["oficio_respuesta"]["tmp_name"] ) )
      {
        if( $_FILES["oficio_respuesta"]["size"]<2000000 )
        {
          if( $_FILES["oficio_respuesta"]["type"]=="application/pdf" )
          {
            move_uploaded_file( $_FILES["oficio_respuesta"]["tmp_name"], "../uploads/validaciones/oficio_respuesta_".$_POST["alumno_id"].".pdf" );
            $exito = 1;
          }
        }
      }

      if( $_FILES["oficio_respuesta"]["name"]!=null && $exito==0 )
      {
        header( "Location: ../views/ce-validacion-alumno.php?programa_id=".$_POST["programa_id"]."&alumno_id=".$_POST["alumno_id"]."&proceso=edicion"."&codigo=404" );
        exit( );
      }
    }

		$parametros = array( );
		$parametros["id"] = $_POST["id"];
    if ($_FILES) {
      if( $_FILES["oficio_envio"]["name"]!=null ){ $parametros["oficio_envio"] = "oficio_envio_".$_POST["alumno_id"].".pdf"; }
      if( $_FILES["oficio_respuesta"]["name"]!=null ){ $parametros["oficio_respuesta"] = "oficio_respuesta_".$_POST["alumno_id"].".pdf"; }
    }

    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    foreach( $_POST as $atributo=>$valor )
		{
			$parametros[$atributo] = $valor;
		}

		$obj = new Validacion( );
		$obj->setAttributes( $parametros );
    print_r($parametros);
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
