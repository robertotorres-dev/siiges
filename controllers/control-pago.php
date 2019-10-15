<?php
  /**
  * Archivo que gestiona los web services de la clase Pago
  */

  require_once "../models/modelo-pago.php";
  require_once "../models/modelo-rol.php";
  require_once "../models/modelo-usuario.php";
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
    $obj = new Pago( );
		$obj->setAttributes( array( ) );
		$resultado = $obj->consultarTodos( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"pagos","accion"=>"consultarTodos","lugar"=>"control-pago"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para consultar registro por id
  if( $_POST["webService"]=="consultarId" )
  {
    $obj = new Pago();
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->consultarId( );
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"pagos","accion"=>"consultarId","lugar"=>"control-pago"]);
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
		$obj = new Pago( );
		$obj->setAttributes( $parametros );
    $resultado = $obj->guardar( );
    $resultado["message"] = !empty($resultado["data"])?"Pago guardado exitosamente!":$resultado["message"];
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"pagos","accion"=>"guardar","lugar"=>"control-pago"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para eliminar registro
  if( $_POST["webService"]=="eliminar" )
  {
    $obj = new Pago( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
		$obj->setAttributes( array( "id"=>$_POST["id"] ) );
    $resultado = $obj->eliminar( );
    $resultado["message"] = !empty($resultado["data"]["deleted_at"])?"Pago eliminado exitosamente!":$resultado["message"];
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"pagos","accion"=>"eliminar","lugar"=>"control-pago"]);
      $result = $bitacora->guardar();
		retornarWebService( $_POST["url"], $resultado );
  }
  // Web service para obtener las solicitudes
  if( $_POST["webService"]=="consultarSolucitudesUsuario" )
  {
    $pago = new Pago( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $solicitudes = $pago->consultarPor("solicitudes",["usuario_id"=>$_POST["usuario_id"]],"*");
    $resultado = sizeof($solicitudes) > 0? $solicitudes:[];
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"pagos","accion"=>"consultarSolucitudesUsuario","lugar"=>"control-pago"]);
      $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );
  }

  // Web service para obtener las el pago con sus respectivos datos
  if( $_POST["webService"]=="consultarPago" )
  {
    $pago = new Pago( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $pago->setAttributes( array( "id"=>$_POST["id"] ) );
    $pago = $pago->consultarId( );
    $pagoAux = !empty($pago["data"])?$pago["data"]:false;

    $auxPago = new Pago( );
    $solicitud = $auxPago->consultarPor("solicitudes",["id"=>$pagoAux["solicitud_id"]],"*");
    $solicitud = sizeof($solicitud) > 0? $solicitud["data"][0]:false;

    $solicitud_id = $solicitud?$solicitud["id"]:"";
    $usuario_id = $solicitud?$solicitud["usuario_id"]:"";

    $pago["data"]["usuario_id"] = $usuario_id;
    $pago["data"]["solicitud_id"] = $solicitud_id;

    $resultado = $pago;
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"pagos","accion"=>"consultarPago","lugar"=>"control-pago"]);
      $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );
  }


  //Web service para obtener la tabla de todos lo pagos
  if ($_POST["webService"]=="consultarTodosTabla")
  {
    $pago = new Pago( );
    $pagos = $pago->consultarTodos();
    $tabla = "";
    foreach ($pagos["data"] as $p) {
      $id = $p["id"];
      $solicitud_id = $p["solicitud_id"];

      $auxPago = new Pago( );
      $solicitud = $auxPago->consultarPor("solicitudes",["id"=>$solicitud_id],"*");
      $solicitud = sizeof($solicitud) > 0? $solicitud["data"][0]:false;

      $auxPago = new Pago( );
      $institucion = $auxPago->consultarPor("instituciones",["usuario_id"=>$solicitud["usuario_id"]],"*");
      $institucion = sizeof($institucion) > 0? $institucion["data"][0]:false;

      $folio = $solicitud?$solicitud["folio"]:"";
      $nombreInstitucion = $institucion?$institucion["nombre"]:"";

      $espacio = "&nbsp;&nbsp;&nbsp;";
      $editar = "<a href='alta-pagos.php?id=".$id."'><span class='glyphicon glyphicon-pencil'></span></a>";

      $eliminarDatos = ["id"=>$id,"institucion"=>$nombreInstitucion,"folio"=>$folio,"concepto"=>$p["concepto"],"monto"=>$p["monto"]];
      $eliminar = "<a href='#' onclick='Pago.datosModal(".htmlentities(json_encode($eliminarDatos)).")'><span class='glyphicon glyphicon-trash'></span></a>";

      $tabla.='{
        "institucion":"'.$nombreInstitucion.'",
        "folio":"'.$folio.'",
        "concepto":"'.$p["concepto"].'",
        "monto":"'.$p["monto"].'",
        "cobertura":"'.$p["cobertura"].'",
        "fecha_pago":"'.$p["fecha_pago"].'",
        "acciones":"'.$editar.$espacio.$eliminar.'"
      },';
    }

    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"pagos","accion"=>"consultarTodosTabla","lugar"=>"control-pago"]);
      $result = $bitacora->guardar();
    $tabla = substr($tabla,0, strlen($tabla) - 1);
    echo '{"data":['.$tabla.']}';
  }
  //Web service para obtener las instituciones para apps
  if ($_POST["webService"]=="obtenerInstituciones")
  {
    $pago = new Pago( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );

    $resultado["data"] = [];
    if(isset($_POST["usuario_id"])){
      $usuario = new Usuario();
      $usuario->setAttributes(["id"=>$_POST["usuario_id"]]);
      $usuario = $usuario->consultarId();
      $usuario = (is_Array($usuario["data"]) && sizeof($usuario["data"]) > 0) ||
                  (is_string($usuario["data"]) && strlen($usuario["data"]) > 0) ?$usuario["data"]:false;

      if($usuario){
        if(Rol::ROL_ADMIN == $usuario["rol_id"] ||
            Rol::ROL_SICYT_EDITAR == $usuario["rol_id"] ||
            Rol::ROL_SICYT_LECTURA == $usuario["rol_id"]){
          $resultado = $pago->consultarInstitucionesSolicitudesPago();
        }else{
          $pago->setAttributes( array( "usuario_id"=>$_POST["usuario_id"] ) );
          $resultado = $pago->consultarInstitucionesSolicitudesPagoUsuario();
        }
      }else{
        $resultado["message"] = "No se encotraron instituciones";
        $resultado["status"] = "404";
      }
    }else{
      $resultado["message"] = "Acceso Restringido!";
      $resultado["status"] = "403";
    }

    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"pagos","accion"=>"obtenerInstituciones","lugar"=>"control-pago"]);
      $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );
  }
  //Web service para obtener los folios de la solicitud por institucion para apps
  if ($_POST["webService"]=="obtenerFoliosSolicitudes")
  {
    $pago = new Pago( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $pago->setAttributes( array( "institucion_id"=>$_POST["institucion_id"] ) );
    $resultado = $pago->consultarFoliosSolicitudesPago();
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"pagos","accion"=>"obtenerFoliosSolicitudes","lugar"=>"control-pago"]);
      $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );
  }
  //Web service para obtener los pagos por folio de la solicitud para apps
  if ($_POST["webService"]=="obtenerPagosSolicitud")
  {
    $pago = new Pago( );
    $aux = new Utileria( );
    $_POST = $aux->limpiarEntrada( $_POST );
    $pago->setAttributes( array( "solicitud_id"=>$_POST["solicitud_id"] ) );
    $pagos = $pago->consultarPagosSolicitud();
    $tempPagos = [];
    $instituciones = [];
    $iRegistro = [];
    $indice = 0;
    // Agrupado de los pagos por institucion y solicitud
    foreach ($pagos["data"] as $registro) {
      $os = array("Mac", "NT", "Irix", "Linux");
      if (!in_array($registro["institucion_id"], $instituciones)) {
        array_push($instituciones,$registro["institucion_id"]);
        $iRegistro[$registro["institucion_id"]] = $indice;
        array_push($tempPagos,[
                              "institucion_id" => $registro["institucion_id"],
                              "nombre_institucion" => $registro["nombre_institucion"],
                              "solicitud_id" => $registro["solicitud_id"],
                              "folio_solicitud" => $registro["folio_solicitud"],
                              "pagos" => []
        ]);
        $indice++;
      }
      array_push($tempPagos[$iRegistro[$registro["institucion_id"]]]["pagos"],[
                          "pago_id"=>$registro["pago_id"],
                          "concepto" => $registro["concepto"],
                          "monto" => $registro["monto"],
                          "cobertura" => $registro["cobertura"],
                          "fecha_pago" => $registro["fecha_pago"]
      ]);
    }
    $resultado = $pagos;
    $resultado["data"] = $tempPagos;
    // Registro en bitacora
      $bitacora = new Bitacora();
      $usuarioId= isset($_SESSION["id"])?$_SESSION["id"]:-1;
      $bitacora->setAttributes(["usuario_id"=>$usuarioId,"entidad"=>"pagos","accion"=>"obtenerPagosSolicitud","lugar"=>"control-pago"]);
      $result = $bitacora->guardar();
    retornarWebService( $_POST["url"], $resultado );
  }


?>
