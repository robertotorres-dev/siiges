<?php
require_once "../models/modelo-preguntas.php";
require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );

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

 //print_r($_POST);
 //echo "<br>";

if( $_POST["webService"]=="guardar" )
  {

		$aux = new Utileria( );
		$_POST = $aux->limpiarEntrada( $_POST );

		$id = $_POST['id'];
		$categoria = $_POST['categoria_evaluacion_pregunta_id'];
		$apartado = $_POST['evaluacion_apartado_id'];
		$modalidad = $_POST['modalidad_id'];
		$escala = $_POST['escala_id'];
		$descripcion = $_POST['nombre'];
		$item = $_POST['item'];
		$evidencia = $_POST['evidencia'];

		for ($i=0; $i < sizeof($id); $i++) {
			/*echo "<br>";
			echo "<br>". $categoria[$i];
			echo "<br>". $apartado[$i];
			echo "<br>". $modalidad[$i];
			echo "<br>". $escala[$i];
			echo "<br>". $descripcion[$i];
			echo "<br>". $item[$i];
			echo "<br>". $evidencia[$i];
			echo "<br>";*/

			$parametros = array(
			'id' => $id[$i],
			'categoria_evaluacion_pregunta_id' => $categoria[$i],
			'evaluacion_apartado_id' => $apartado[$i],
			'modalidad_id' => $modalidad[$i],
			'escala_id' => $escala[$i],
			'nombre' => $descripcion[$i],
			'item' => $item[$i],
			'evidencia' => $evidencia[$i],
		 );

	    //print_r($parametros);
			$obj = new Preguntas( );
			$obj->setAttributes( $parametros );
	    //echo "<br>";
	    //echo "<br>";
	    //print_r( $obj);
			$resultado = $obj->guardar( );
			//print_r($resultado);
		}
    /* Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"programas","accion"=>"guardar","lugar"=>"control-programa"]);
      $result = $bitacora->guardar();*/
			//echo $_POST["url"];
		retornarWebService( $_POST["url"], $resultado );
  }

?>
