<?php
  /**
  * Clase que gestiona métodos de la tabla modulos
  */

  require_once "base-catalogo.php";

	define( "TABLA_PAGOS", "pagos" );

  class PAGO extends Catalogo
  {
    protected $id;
    protected $solicitud_id;
    protected $monto;
    protected $concepto;
    protected $cobertura;
    protected $fecha_pago;

		// Constructor
		public function __construct( )
    {
      parent::__construct( );
    }


		// Función para asignar atributos de la clase
    public function setAttributes( $parametros = array( ) )
    {
      foreach( $parametros as $atributo=>$valor )
			{
        $this->{$atributo} = $valor;
      }
    }


		// Método para consultar todos los registros
    public function consultarTodos( )
    {
      $resultado = parent::consultarTodosCatalogo( TABLA_PAGOS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_PAGOS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_PAGOS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_PAGOS );
			return $resultado;
    }

    // Método para consultar institucions con pago de solicitudes
		public function consultarInstitucionesSolicitudesPago( )
    {
      $vista = "vpagos_instituciones_solicitudes";
      $message = "OK";
      $status = "200";

      $consulta = "SELECT DISTINCT institucion_id,nombre_institucion FROM $vista";
      //$sql = $this->mysqli->prepare( $consulta );
      $res = $this->mysqli->query($consulta);
      $max = $res?$res->num_rows:0;
			// if( $sql->execute( ) )
			// {
      //   $sql->close( );
      //   unset( $sql );
      //   //$res = $sql->get_result( );
      //   $res = $this->mysqli->query($consulta);
      //   $max = $res?$res->num_rows:0;
      //
      // }else{
      //   $message = "Error en la consulta";
      //   $status = "400";
      // }

			$resultado = array( );

      for( $i=0; $i<$max; $i++ )
      {
				$res->data_seek( $i );
        $obj = $res->fetch_object( );

				foreach( $res->fetch_fields( ) as $valor )
				{
          $this->{$valor->name} = $obj->{$valor->name};
					$resultado[$i]["{$valor->name}"] = $this->{$valor->name};
        }
      }

			$res->close( );
      $this->mysqli->close( );

			return array(
			"status"=>$status,
			"message"=>$message,
			"data"=>$resultado );
    }

    // Método para consultar institucions con pago de solicitudes del representante legal
		public function consultarInstitucionesSolicitudesPagoUsuario( )
    {
      $vista = "vpagos_instituciones_solicitudes";
      $message = "OK";
      $status = "200";

      $consulta = "SELECT DISTINCT institucion_id,nombre_institucion FROM $vista WHERE usuario_id = '$this->usuario_id'";
      $res = $this->mysqli->query($consulta);
      $max = $res?$res->num_rows:0;
      // $sql = $this->mysqli->prepare( $consulta );
      // $sql->bind_param( "i", $this->usuario_id );
			// if( $sql->execute( ) )
			// {
      //   $sql->close( );
      //   unset( $sql );
      //   //$res = $sql->get_result( );
      //   $res = $this->mysqli->query($consulta);
      //   $max = $res?$res->num_rows:0;
      //
      // }else{
      //   $message = "Error en la consulta";
      //   $status = "400";
      // }

			$resultado = array( );

      for( $i=0; $i<$max; $i++ )
      {
				$res->data_seek( $i );
        $obj = $res->fetch_object( );

				foreach( $res->fetch_fields( ) as $valor )
				{
          $this->{$valor->name} = $obj->{$valor->name};
					$resultado[$i]["{$valor->name}"] = $this->{$valor->name};
        }
      }

			$res->close( );
      $this->mysqli->close( );

			return array(
			"status"=>$status,
			"message"=>$message,
			"data"=>$resultado );
    }

    // Método para consultar los folios de las solicitudes por institucion
		public function consultarFoliosSolicitudesPago( )
    {
      $vista = "vpagos_instituciones_solicitudes";
      $message = "OK";
      $status = "200";

      $consulta = "SELECT DISTINCT solicitud_id,folio_solicitud FROM $vista WHERE institucion_id='$this->institucion_id'";
      $res = $this->mysqli->query($consulta);
      $max = $res?$res->num_rows:0;
      // $sql = $this->mysqli->prepare( $consulta );
      // $sql->bind_param( "i", $this->institucion_id );
      //
			// if( $sql->execute( ) )
			// {
      //   $sql->close( );
      //   unset( $sql );
      //   //$res = $sql->get_result( );
      //   $res = $this->mysqli->query($consulta);
      //   $max = $res?$res->num_rows:0;
      //
      // }else{
      //   $message = "Error en la consulta";
      //   $status = "400";
      // }

			$resultado = array( );

      for( $i=0; $i<$max; $i++ )
      {
				$res->data_seek( $i );
        $obj = $res->fetch_object( );

				foreach( $res->fetch_fields( ) as $valor )
				{
          $this->{$valor->name} = $obj->{$valor->name};
					$resultado[$i]["{$valor->name}"] = $this->{$valor->name};
        }
      }

			$res->close( );
      $this->mysqli->close( );

			return array(
			"status"=>$status,
			"message"=>$message,
			"data"=>$resultado );
    }

    // Método para consultar los pagos por solicitud
		public function consultarPagosSolicitud( )
    {
      $vista = "vpagos_instituciones_solicitudes";
      $message = "OK";
      $status = "200";

      $consulta = "SELECT * FROM $vista WHERE solicitud_id='$this->solicitud_id'";
      $res = $this->mysqli->query($consulta);
      $max = $res?$res->num_rows:0;
      // $sql = $this->mysqli->prepare( $consulta );
      // $sql->bind_param( "i", $this->solicitud_id );
      //
			// if( $sql->execute( ) )
			// {
      //   $sql->close( );
      //   unset( $sql );
      //   //$res = $sql->get_result( );
      //   $res = $this->mysqli->query($consulta);
      //   $max = $res?$res->num_rows:0;
      //
      // }else{
      //   $message = "Error en la consulta";
      //   $status = "400";
      // }

			$resultado = array( );

      for( $i=0; $i<$max; $i++ )
      {
				$res->data_seek( $i );
        $obj = $res->fetch_object( );

				foreach( $res->fetch_fields( ) as $valor )
				{
          $this->{$valor->name} = $obj->{$valor->name};
					$resultado[$i]["{$valor->name}"] = $this->{$valor->name};
        }
      }

			$res->close( );
      $this->mysqli->close( );

			return array(
			"status"=>$status,
			"message"=>$message,
			"data"=>$resultado );
    }

  }
?>
