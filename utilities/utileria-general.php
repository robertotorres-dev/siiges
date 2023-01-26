<?php

/**
 * Clase que gestiona utilerias a nivel general
 */

require_once "../models/base-general.php";

class Utileria extends General
{
	// Constructor
	public function __construct()
	{
		parent::__construct();
	}


	// M�todo para validar sesi�n
	public static function validarSesion($file)
	{
		session_start(['cookie_lifetime' => 86400,]);

		if (!isset($_SESSION["id"]) || $_SESSION["id"] == null || $_SESSION["id"] == "") {
			header("Location: ../index.php?error=1");
			exit();
		}

		// Programar validaci�n de $file...
	}

	// Metodo para validar el acceso a modulos segun rol de usuario
	public static function validarAccesoModulo($file)
	{
		// echo "ARCHIVO: ";var_dump($file);
		// echo "modulos: ";var_dump($_SESSION["modulos"]);
		if (!isset($_SESSION["modulos"]) || !$_SESSION["modulos"] || empty($_SESSION["modulos"])) {
			$_SESSION["resultado"] = json_encode(["status" => "404", "message" => "Accesos de usuario no existen"]);
			header("Location: ../views/home.php");
			exit();
		}

		$modulos = $_SESSION["modulos"];

		// echo "ARCHIVO:"; var_dump($file);

		$acceso = false;
		foreach ($modulos as $modulo) {
			$nombre = $modulo["modulo"]["nombre"];
			/* 	echo strpos($file,$nombre);
				echo "<br>MODULO:"; var_dump($nombre);
				echo " Comparacion:"; var_dump(strpos($file,$nombre)); */
			if (strpos($file, $nombre) !== false) {
				$acceso = true;
				break;
			}
			// echo " Acceso:"; var_dump($acceso);
		}

		// exit();
		if (!$acceso) {
			$_SESSION["resultado"] = json_encode(["status" => "403", "message" => "Accesos Restringido!"]);
			header("Location: ../views/home.php");
			exit();
		}
	}


	// M�todo para limpiar texto nocivo
	function limpiarTexto($entrada)
	{
		$buscar = array(
			'@<script[^>]*?>.*?</script>@si', // Elimina javascript
			'@<[\/\!]*?[^<>]*?>@si',          // Elimina las etiquetas HTML
			'@<style[^>]*?>.*?</style>@siU',  // Elimina las etiquetas de estilo
			'@<![\s\S]*?--[ \t\n\r]*>@'       // Elimina los comentarios multi-l�nea revisar para la app m�vil
		);

		$salida = preg_replace($buscar, '', $entrada);
		return $salida;
	}


	// M�todo para limpiar entrada (input)
	function limpiarEntrada($entrada)
	{
		if (is_array($entrada)) {
			foreach ($entrada as $var => $val) {
				$salida[$var] = $this->limpiarEntrada($val);
			}
		} else {
			if(!function_exists("get_magic_quotes_gpc")) {
                function get_magic_quotes_gpc() { return 0; }
          }
			$entrada  = $this->limpiarTexto($entrada);
			$salida = mysqli_real_escape_string($this->mysqli, $entrada);
		}
		return $salida;
	}


	// M�todo para enviar correo electr�nico
	public static function enviarCorreo($destino, $asunto, $mensaje)
	{
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: no-replay@serverappsiiges.siiges.gob.mx";
		$resultado = mail($destino, $asunto, $mensaje, $headers);
		return $resultado;
	}

	// M�todo para orden ascendente o descendente
	public static function array_sort($array, $on, $order = SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();

		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}

			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
					break;
				case SORT_DESC:
					arsort($sortable_array);
					break;
			}

			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}

		return $new_array;
	}
}
