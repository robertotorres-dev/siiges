<?php
  /**
  * Clase que gestiona métodos de la tabla evaluacion_preguntas
  */

  require_once "base-catalogo.php";
  require_once "../models/modelo-categorias-evaluacion-pregunta.php";
  require_once "../models/modelo-evaluacion-apartado.php";

	define( "TABLA_EVALUACION_PREGUNTAS", "evaluacion_preguntas" );

  class EvaluacionPregunta extends Catalogo
  {
    protected $id;
    protected $categoria_evaluacion_pregunta_id;
    protected $evaluacion_apartado_id;
    protected $modalidad_id;
    protected $escala_id;
    protected $nombre;
    protected $item;
    protected $evidencia;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_EVALUACION_PREGUNTAS );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_EVALUACION_PREGUNTAS );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_EVALUACION_PREGUNTAS );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_EVALUACION_PREGUNTAS );
			return $resultado;
    }

    //Método para obtener las preguntas y sus relaciones por medio de la modalidad
    public function informacionRelacionada( $modalidad , $evaluacion_id)
    {
        if( $modalidad == 3 ){
          $modalidad = 2;
        }
        //Consultar apartados
        $consulta = "SELECT DISTINCT evaluacion_apartado_id FROM ". TABLA_EVALUACION_PREGUNTAS . " WHERE deleted_at is null AND modalidad_id =?";

        $stmt = $this->mysqli->prepare($consulta);
        $stmt->bind_param( "i", $modalidad );
        if( $stmt->execute( ) )
        {
          //$res = $stmt->get_result( );
          $stmt->close( );
          unset( $stmt );
          $consulta = "SELECT DISTINCT evaluacion_apartado_id FROM ". TABLA_EVALUACION_PREGUNTAS . " WHERE deleted_at is null AND modalidad_id ='$modalidad'";
          $res = $this->mysqli->query($consulta);
          if( $res->num_rows > 0 ){
            $max = $res->num_rows;
            $ids_apartados = array( );
            while ($fila = $res->fetch_assoc())
            {
              array_push($ids_apartados, $fila);
            }
            //Consultar Categorias de los apartados
            if( sizeof($ids_apartados) > 0)
            {
              $resultado["id_evaluacion"] = $evaluacion_id;
              $apartados = array();
              $preguntas_guia = array();
              foreach ($ids_apartados as $value)
              {
                $apartado = new EvaluacionApartado();
                $apartado->setAttributes(array("id"=>$value["evaluacion_apartado_id"]));
                $res_temp = $apartado->consultarId();
                $temp["apartado_id"] = $value["evaluacion_apartado_id"];
                $temp["nombre"] = $res_temp["data"]["nombre"];
                $consulta_temp = "SELECT DISTINCT categoria_evaluacion_pregunta_id FROM ".TABLA_EVALUACION_PREGUNTAS." WHERE deleted_at is null AND evaluacion_apartado_id = ". $value["evaluacion_apartado_id"]." AND modalidad_id = ". $modalidad ."  ORDER BY categoria_evaluacion_pregunta_id ASC";
                $res_temp = $this->mysqli->query($consulta_temp);
                $temp_categorias = array();
                //Consultar los datos de las categorias
                while ($fila_temp = $res_temp->fetch_assoc())
                {
                  $obj_categoria = new CategoriaEvaluacionPregunta();
                  $obj_categoria->setAttributes(array("id"=>$fila_temp["categoria_evaluacion_pregunta_id"]));
                  $res_obj_categoria = $obj_categoria->consultarId();
                  $temp_obj_categoria["id"] = $fila_temp["categoria_evaluacion_pregunta_id"];
                  $temp_obj_categoria["nombre"] = $res_obj_categoria["data"]["nombre"];
                  //Consultar las preguntas de la categoria
                  $consulta_preguntas = "SELECT id,escala_id,nombre,item,evidencia FROM ".TABLA_EVALUACION_PREGUNTAS. " WHERE categoria_evaluacion_pregunta_id = ".$fila_temp["categoria_evaluacion_pregunta_id"] ." AND evaluacion_apartado_id =".$value["evaluacion_apartado_id"]. " AND modalidad_id=".$modalidad." AND deleted_at is null";
                  $res_preguntas = $this->mysqli->query(  $consulta_preguntas );
                  $array_preguntas= array();
                  while ($fila_preguntas = $res_preguntas->fetch_assoc()) {
                      $consulta = "SELECT puntos FROM escalas WHERE id =". $fila_preguntas["escala_id"];
                      $id_pregunta = $fila_preguntas["id"];
                      $res_escala = $this->mysqli->query($consulta);
                      $res_escala = $res_escala->fetch_assoc();
                      $fila_preguntas["escala"] = json_decode($res_escala["puntos"]);
                       $fila_preguntas["respuesta"] = null;
                      $consultar_respuesta = "SELECT id,respuesta,comentarios FROM evaluaciones_evaluacion_preguntas WHERE programa_evaluacion_id='$evaluacion_id' AND evaluacion_pregunta_id ='$id_pregunta'";
                      $respuesta_pregunta = $this->mysqli->query($consultar_respuesta );
                      //Comprueba que exista una respuesta para la pregunta
                      if( $respuesta_pregunta->num_rows >= 1)
                      {
                         $fila_preguntas["respuesta"] = $respuesta_pregunta->fetch_assoc();
                      }
                      array_push($array_preguntas,$fila_preguntas);
                  }

                  $temp_obj_categoria["reactivos"] = $array_preguntas;
                  array_push($temp_categorias,$temp_obj_categoria);
                }
                if( sizeof(  $temp_categorias) > 0)
                {
                  $temp["categorias"] = $temp_categorias;
                }
                //Arreglo para las preguntas
                array_push($preguntas_guia,$temp);
                //Arrgelo de apartados
                $apartado_temp = array("id"=>$value["evaluacion_apartado_id"],"apartado"=>$temp["nombre"]);
                array_push($apartados,$apartado_temp);
              }

              if( sizeof($preguntas_guia)>0)
              {
              $resultado["preguntas"] = $preguntas_guia;
              }
              if( sizeof($apartados)>0)
              {
                $resultado["apartados"] = $apartados;
              }

            }
          }else{
            $resultado = null;
          }

        }

        $this->mysqli->close( );
        return $resultado;


    }

  }
?>
