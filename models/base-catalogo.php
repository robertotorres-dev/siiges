<?php
  /**
  * Clase que gestiona métodos a nivel catálogo
  */

  require_once "base-registro.php";

  class Catalogo extends Registro
  {
    protected $created_at;
		protected $updated_at;
		protected $deleted_at;


		// Constructor
		public function __construct( )
    {
      parent::__construct( );
    }


		// Método para consultar todos los registros
    public function consultarTodosCatalogo( $tabla )
    {
      /*
			$consulta = "select * from $tabla where deleted_at is null order by id";
      $sql = $this->mysqli->prepare( $consulta );

			if( $sql->execute( ) )
			{
        $res = $sql->get_result( );
				$max = $res->num_rows;
				$sql->close( );
				unset( $sql );
      }
			*/

			$sql = "select * from $tabla where deleted_at is null order by id";
			$res = $this->mysqli->query( $sql );
      $max = $res->num_rows;

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
			"status"=>"200",
			"message"=>"OK",
			"data"=>$resultado );
    }


		// Método para consultar registro por id
		public function consultarIdCatalogo( $tabla )
    {
      /*
			$consulta = "select * from  $tabla where id=?";
      $sql = $this->mysqli->prepare( $consulta );
      $sql->bind_param( "i", $this->id );

			if( $sql->execute( ) )
			{
        $res = $sql->get_result( );
				$max = $res->num_rows;
				$sql->close( );
				unset( $sql );
      }
			*/

			$sql = "select * from  $tabla where id='$this->id'";
			$res = $this->mysqli->query( $sql );
      $max = $res->num_rows;

			$this->id = null;
			$resultado = array( );

      if( $max>0 )
      {
				$res->data_seek( 0 );
        $obj = $res->fetch_object( );

				foreach( $res->fetch_fields( ) as $valor )
				{
          $this->{$valor->name} = $obj->{$valor->name};
					$resultado["{$valor->name}"] = $this->{$valor->name};
        }

				$resultado = array(
				"status"=>"200",
				"message"=>"OK",
				"data"=>$resultado );
      }
			else
			{
        $resultado = array(
				"status"=>"404",
				"message"=>"No existe el id.",
				"data"=>"" );
      }

			$res->close( );
      $this->mysqli->close( );

			return $resultado;
    }


		// Método para guardar registro
		public function guardarCatalogo( $tabla )
    {
      if( $this->id==null )
			{
				$this->created_at = date( "Y-m-d H:i:s" );

				$sqlAux = "select * from $tabla";
				$resAux = $this->mysqli->query( $sqlAux );

				$sql = "insert into $tabla ( id";
        foreach( $resAux->fetch_fields( ) as $valor )
				{
					if( !is_array( $this->{$valor->name} ) && !is_object( $this->{$valor->name} ) && $this->{$valor->name}!=null )
					{
						$sql = $sql . ", " . $valor->name;
					}
				}
        $sql = $sql . " ) values ( null";
				foreach( $resAux->fetch_fields( ) as $valor )
				{
					if( $valor->name!="id" && !is_array( $this->{$valor->name} ) && !is_object( $this->{$valor->name} ) && $this->{$valor->name}!=null )
					{
						$sql = $sql . ", '" . $this->{$valor->name} . "'";
					}
				}
				$sql = $sql . " )";

				$res = $this->mysqli->query( $sql );
				$this->id = $this->mysqli->insert_id;
      }
			else
			{
				$this->updated_at = date( "Y-m-d H:i:s" );

				$sqlAux = "select * from $tabla";
				$resAux = $this->mysqli->query( $sqlAux );

				$coma = "";
				$sql = "update $tabla set";
				foreach( $resAux->fetch_fields( ) as $valor )
				{
					if( $valor->name!="id" && $valor->name!="created_at" && $valor->name!="deleted_at" && isset($this->{$valor->name}) && $this->{$valor->name}!=null )
					{
						$sql = $sql . "$coma $valor->name='" . $this->{$valor->name} . "'";
						$coma = ",";
					}
				}
				$sql = $sql . " where id='$this->id'";
				$res = $this->mysqli->query( $sql );
      }

			$this->mysqli->close( );

			return array(
			"status"=>"200",
			"message"=>"OK",
			"data"=>array(
				"id"=>$this->id,
				"created_at"=>$this->created_at,
				"updated_at"=>$this->updated_at,
				"deleted_at"=>$this->deleted_at ) );
    }


		// Método para eliminar registro
		public function eliminarCatalogo( $tabla )
    {
			$this->deleted_at = date( "Y-m-d H:i:s" );

			$consulta = "update $tabla set deleted_at='$this->deleted_at' where id=?";
      $sql = $this->mysqli->prepare( $consulta );
      $sql->bind_param( "i", $this->id );

      if( $sql->execute( ) )
			{
				$sql->close( );
				unset( $sql );
      }

			$this->mysqli->close( );

			return array(
			"status"=>"200",
			"message"=>"OK",
			"data"=>array(
				"id"=>$this->id,
				"created_at"=>$this->created_at,
				"updated_at"=>$this->updated_at,
				"deleted_at"=>$this->deleted_at ) );
    }


		// Método para consultar registros por parámetro sql
		public function consultarSQLCatalogo( $sql )
    {
			$res = $this->mysqli->query( $sql );
      $max = $res->num_rows;
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
			"status"=>"200",
			"message"=>"OK",
			"data"=>$resultado );
    }


    //Método para consulta generico $tabla = nombre de la tabla, $condicionantes = ejemplo where id = 5 (puede ser array)
    //$campos = columnas de la tabla
    public function consultarPor($tabla,$condicionantes,$columnas)
    {
      if(is_array($columnas)){
        $campos_consultar = "";
        //Campos que solicitamos como respuesta
        foreach ($columnas as $campo) {
        $campos_consultar .= $campo . ",";
        }
        $campos_consultar = substr($campos_consultar, 0, -1);
        $consulta = "SELECT ".$campos_consultar." FROM ".$tabla." WHERE ";
      }else{
        $consulta = "SELECT ".$columnas." FROM ".$tabla. " WHERE ";
      }
      $where="";
      // $tipos = ["string"=>"s","integer"=>"i"];
      // $tipos_datos = "";
      // $valores = array();
      // $parametros =  array( );
      //Recorrer arreglo para formar sentencia where, determinar tipo de dato y se obtienen valores de cada parametro
      foreach ($condicionantes as $campo => $valor) {
        if($campo == "deleted_at"){
          $where .= "deleted_at is null AND ";
          break;
        }
				if($campo == "acuerdo_rvoe_lleno"){
					$where .= "acuerdo_rvoe !='' AND  deleted_at is null AND ";
					break;
				}
        $where .= $campo."='$valor' AND ";
        // $tipos_datos .= $tipos[gettype($valor)];
        // array_push($valores,$valor);
      }
      // //Se preparan los valores para bind_param
      // foreach ( $valores as $key => $value )
      // {
      //   $parametros[]=&$valores[$key];
      // }
      //Se completa los parametros para bind variables con valores y tipos de datos
      // array_unshift($parametros,$tipos_datos);
      $where = substr($where, 0, -5);
      $consulta = $consulta . $where;
      $res = $this->mysqli->query( $consulta);
     //  $stmt = $this->mysqli->prepare($consulta);
     //  //Se ejecuta la función bind
     //  call_user_func_array(array($stmt,'bind_param'),$parametros);
     // if( $stmt->execute( ) )
     // {
     //   $res = $stmt->get_result( );
     //   $max = $res->num_rows;
     //   $stmt->close( );
     //   unset( $stmt );
     // }

      $resultado = array( );
      while ($fila = $res->fetch_assoc()) {
				array_push($resultado, $fila);
      }
      $this->mysqli->close( );

      return array(
			"status"=>"200",
			"message"=>"OK",
			"data"=>$resultado );
    }
  }
?>
