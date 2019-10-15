<?php

require_once "base-catalogo.php";

define("TABLA_PREGUNTAS", "evaluacion_preguntas");

class Preguntas extends Catalogo{
  protected $id;
  protected $categoria_evaluacion_pregunta_id;
  protected $evaluacion_apartado_id;
  protected $modalidad_id;
  protected $escala_id;
  protected $nombre;
  protected $item;
  protected $evidencia;

    //constructor
    public function __construct(){
        parent::__construct();
    }

    //funcion para asignar atributos de la clase
    public function setAttributes($parametros = array()){
        foreach($parametros as $atributo => $valor){
            $this ->{$atributo} = $valor;
        }
    }

    // Método para guardar registro
    public function guardar( ) {
        $resultado = parent::guardarCatalogo( TABLA_PREGUNTAS );
    return $resultado;
    }

  }

  ?>
