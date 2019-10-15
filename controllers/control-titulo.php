<?php
  /**
  * Archivo que gestiona los web services de la clase Turno
  */



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
    $obj = new Turno( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"turnos","accion"=>"consultarTodos","lugar"=>"control-turno"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Turno();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"turnos","accion"=>"consultarId","lugar"=>"control-turno"]);
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
		$obj = new Turno( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"turnos","accion"=>"guardar","lugar"=>"control-turno"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Turno( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"turnos","accion"=>"eliminar","lugar"=>"control-turno"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  if( $_POST["webService"]=="registro" )
  {
		
    //echo "ESTAS REGISTRANDO UN TITULO ELECTRONICO";
    //print_r($_POST);
    $obj = (object)$_POST;
    //echo "<br>";
    //print_r($obj);
    //echo $obj->webService;

		try {
		   $dasxml = SDO_DAS_XML::create("../views/plantillas/SEP_XSDTiruloElectronico.xsd");
		   $documento = $dasxml->loadFile("../views/plantillas/SEP_XSDTiruloElectronico.xml");
		   $objeto_datos_raíz = $documento->getRootDataObject();
		   //$objeto_datos_raíz->fecha = "September 03, 2004";
		   //$objeto_datos_raíz->nombre = "Anantoju";
		   //$objeto_datos_raíz->apellido = "Madhu";
		   $dasxml->saveFile($documento, "salida-carta.xml");
		   echo "Se ha escrito un nuevo fichero:\n";
		   print file_get_contents("salida-carta.xml");
		} catch (SDO_Exception $e) {
		   print($e->getMessage());
		}
  }
?>
