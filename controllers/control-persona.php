<?php
  /**
  * Archivo que gestiona los web services de la clase Persona
  */

  require_once "../models/modelo-persona.php";
  require_once "../utilities/utileria-general.php";
  require_once "../models/modelo-bitacora.php";


	function retornarWebService( $url, $resultado )
	{
    if( $url!="" )
		{
      session_start( );
      $_SESSION["resultado"] = json_encode($resultado);
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
    $obj = new Persona( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"personas","accion"=>"consultarTodos","lugar"=>"control-persona"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Persona();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"personas","accion"=>"consultarId","lugar"=>"control-persona"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para guardar registro
  if( $_POST["webService"]=="guardar" )
  {
    $parametros = array( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		foreach( $_POST as $atributo=>$valor )
		{
			$parametros[$atributo] = $valor;
		}

		$obj = new Persona( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    if(isset($resultado["data"]["id"])){
      if( sizeof($_FILES) > 0){
        $path = "uploads/fotos/persona-".$resultado["data"]["id"].".jpg";
         if(move_uploaded_file($_FILES["fotografia"]['tmp_name'],"../".$path)){
           unset($obj);
           $obj = new Persona();
           $obj->setAttributes( array( "id"=>$resultado["data"]["id"], "fotografia"=>$path) );
           $resultado = $obj->guardar();
         }
      }
    }

    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"personas","accion"=>"guardar","lugar"=>"control-persona"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Persona( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"personas","accion"=>"eliminar","lugar"=>"control-persona"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }


?>
