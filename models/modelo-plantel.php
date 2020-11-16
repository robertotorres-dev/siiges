<?php
  /**
  * Clase que gestiona métodos de la tabla planteles
  */

  require_once "base-catalogo.php";
  require_once "modelo-persona.php";
  require_once "modelo-nivel.php";

	define( "TABLA_PLANTELES", "planteles" );

  class Plantel extends Catalogo
  {
    protected $id;
    protected $institucion_id;
    protected $domicilio_id;
    protected $persona_id;
    protected $rector_id;
    protected $email1;
    protected $email2;
    protected $email3;
    protected $dimensiones;
    protected $redes_sociales;
    protected $convenios_bibliotecas_virtuales;
    protected $especificaciones;
    protected $clave_centro_trabajo;
    protected $telefono1;
    protected $telefono2;
    protected $telefono3;
    protected $paginaweb;
    protected $caracteristica_inmueble;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_PLANTELES );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_PLANTELES );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_PLANTELES );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_PLANTELES );
			return $resultado;
    }


    //Método para consultar información del plantel con sus respectivas relaciones
    public function informacionRelacionada()
    {
      //Construir consulta
      $consulta = "select * from ".TABLA_PLANTELES. " where id=?";
      //Preparar la consulta
      $stmt = $this->mysqli->prepare( $consulta );
      if($stmt){
        //Obligar la consulta con numero de parametros
        $stmt->bind_param( "s", $this->id);
        //Ejecutar la consulta
        $stmt->execute( );
        if($stmt){
          //Obtener resultado
          //$result = $stmt->get_result();
          //Terminar la consulta
          $stmt->close();
          $consulta = "select * from ".TABLA_PLANTELES. " where id='$this->id'";
          $result = $this->mysqli->query( $consulta );
          if($result->num_rows > 0 ){
            $resultado["status"]="200";
            $resultado["message"]="OK";
            $resultado["data"]= $result->fetch_assoc();
            /* liberar el conjunto de resultados */
            $result->free();
            //Agregar domicilio
            $result = $this->mysqli->query("select * from domicilios where id=".$resultado['data']['domicilio_id']."");
            if($result->num_rows > 0){
              $resultado["data"]["domicilio"]=$result->fetch_assoc();
               $result->free();
            }
            //Agregar director
            $result = $this->mysqli->query("select * from personas where id=".$resultado['data']['persona_id']."");
            if($result->num_rows > 0){
              $resultado["data"]["director"]=$result->fetch_assoc();
              $result->free();
            }
            //Formaciones de director
            $formacion = new Persona();
            $formaciones = $formacion->consultarPor("formaciones",array("persona_id"=>$resultado["data"]["director"]["id"],"deleted_at"),"*");
            if( sizeof($formaciones["data"]) > 0 ){
              foreach ($formaciones["data"] as $posicionFormacion => $arregloformacion) {
                  $nivel_temp = new Nivel();
                  $nivel_temp->setAttributes( array( 'id' => $arregloformacion["nivel"] )  );
                  $respuesta_temp = $nivel_temp->consultarId();
                  $formaciones["data"][$posicionFormacion]["grado"] = $respuesta_temp["data"];
              }
              $resultado["data"]["director"]["formaciones"] = $formaciones["data"];
            }
            //Experiencias de director
            $experiencia = new Persona();
            $experiencias = $experiencia->consultarPor("experiencias",array("persona_id"=>$resultado["data"]["director"]["id"],"deleted_at"),"*");
            if( sizeof($experiencias["data"]) > 0 ){
              $resultado["data"]["director"]["experiencias"] = $experiencias["data"];
            }
            //Experiencias de director
            $publicacion = new Persona();
            $publicaciones = $publicacion->consultarPor("publicaciones",array("persona_id"=>$resultado["data"]["director"]["id"],"deleted_at"),"*");
            if( sizeof($publicaciones["data"]) > 0 ){
              $resultado["data"]["director"]["publicaciones"] = $publicaciones["data"];
            }

            //Agregar Director domicilio
            $result = $this->mysqli->query("select * from domicilios where id=".$resultado['data']['director']['domicilio_id']."");
            if($result->num_rows > 0){
              $resultado["data"]["director"]["domicilio"]=$result->fetch_assoc();
              $result->free();
            }

          }else{
            $resultado["status"]="404";
            $resultado["message"]="Error";
            $resultado["data"]="No se cumple la consulta ".$consulta."o No existe el id:".$this->id;
          }

        }else{
          $resultado["status"]="404";
          $resultado["message"]="Error";
          $resultado["data"]="No se puede ejecutar la consulta";
        }
      }else{
        $resultado["status"]="404";
        $resultado["message"]="Error";
        $resultado["data"]=  "Existe un error en la consulta: ".$consulta;
      }

      //Cerrar la conexion
      $this->mysqli->close( );
      return $resultado;
    }


		// Método para consultar planteles por institución
    public function consultarPlantelesInstitucion( )
    {
      $sql = "select * from " . TABLA_PLANTELES . " where institucion_id='$this->institucion_id' and deleted_at is null order by id";

			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }
  }
?>
