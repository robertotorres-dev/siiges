<?php
  /**
  * Archivo que gestiona los web services de la clase Asignatura
  */

  require_once "../models/modelo-asignatura.php";
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
    $obj = new Asignatura( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
     // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"asignaturas","accion"=>"consultarTodos","lugar"=>"control-asignatura"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Asignatura();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
     // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"asignaturas","accion"=>"consultarId","lugar"=>"control-asignatura"]);
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
		$obj = new Asignatura( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"asignaturas","accion"=>"guardar","lugar"=>"control-asignatura"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Asignatura( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
     // Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"asignaturas","accion"=>"eliminar","lugar"=>"control-asignatura"]);
    $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para Asignaturas por Programa
  if( $_POST["webService"]=="guardarAsignaturaPrograma" )
  {

    $parametros = array( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );

    $asignaturaPrograma = new Asignatura( );
    $resultadoAsignaturaPrograma = $asignaturaPrograma->consultarPor('asignaturas', array("programa_id"=>$_POST['programa_id']), '*' );

    $max = count( $_POST["id"] );

    for( $i=0; $i<$max; $i++ )
    {
      $parametros3["id"] = $_POST["id"][$i];
      $parametros3["grado"] = $_POST["grado"][$i];
      $parametros3["nombre"] = $_POST["nombre"][$i];
      $parametros3["clave"] = $_POST["clave"][$i];
      $parametros3["seriacion"] = $_POST["seriacion"][$i];
      $parametros3["horas_docente"] = $_POST["horas_docente"][$i];
      $parametros3["horas_independiente"] = $_POST["horas_independiente"][$i];
      $parametros3["creditos"] = $_POST["creditos"][$i];
      
      $asignatura = new Asignatura( );
      $asignatura->setAttributes( $parametros3 );
      $resultadoAsignatura = $asignatura->guardar( );
    }

	// Registro en bitacora
    $bitacora = new Bitacora();
    $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
    $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"asignaturas","accion"=>"guardarAsignaturaPrograma","lugar"=>"control-calificacion"]);
    $result = $bitacora->guardar();

		header( "Location: ../views/ce-catalogo-asignaturas.php?programa_id=".$_POST["programa_id"]."&codigo=200" );
		exit( );
  }



?>
