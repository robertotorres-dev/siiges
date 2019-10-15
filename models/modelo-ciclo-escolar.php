<?php
  /**
  * Clase que gestiona métodos de la tabla ciclos_escolares
  */

  require_once "base-catalogo.php";

	define( "TABLA_CICLOS_ESCOLARES", "ciclos_escolares" );

  class CicloEscolar extends Catalogo
  {
    protected $id;
		protected $programa_id;
    protected $nombre;
    protected $descripcion;


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
      $resultado = parent::consultarTodosCatalogo( TABLA_CICLOS_ESCOLARES );
			return $resultado;
    }


		// Método para consultar registro por id
		public function consultarId( )
    {
      $resultado = parent::consultarIdCatalogo( TABLA_CICLOS_ESCOLARES );
			return $resultado;
    }


		// Método para guardar registro
		public function guardar( )
    {
			$resultado = parent::guardarCatalogo( TABLA_CICLOS_ESCOLARES );
			return $resultado;
    }


		// Método para eliminar registro
		public function eliminar( )
    {
			$resultado = parent::eliminarCatalogo( TABLA_CICLOS_ESCOLARES );
			return $resultado;
    }


		// Método para consultar ciclos escolares por programa
    public function consultarCiclosEscolaresPrograma( )
    {
      $sql = "select * from " . TABLA_CICLOS_ESCOLARES . " where programa_id='$this->programa_id' and deleted_at is null order by id";
			
			$resultado = parent::consultarSQLCatalogo( $sql );
			return $resultado;
    }
  }
?>
