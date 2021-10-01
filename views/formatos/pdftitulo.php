<?php
require("../../fpdf181/fpdf.php");
require_once "../../models/modelo-titulo-electronico.php";
require_once "../../models/modelo-estado.php";

class PDF extends FPDF
{
  // Cabecera de p�gina
  function Header()
  {
  }

  // Pie de p�gina
  function Footer()
  {
  }


  function vcell($c_width, $c_height, $x_axis, $text, $length)
  {

    $w_text = str_split($text, $length);
    $c_height = $c_height > sizeof($w_text) * 5 ? $c_height : sizeof($w_text) * 5;
    $w_w = sizeof($w_text);
    $len = strlen($text);
    if ($len > $length) {
      $w_w_1 = $w_w + 4;
      foreach ($w_text as $key => $value) {
        $this->SetX($x_axis);
        $this->Cell($c_width, $w_w_1, utf8_decode($value), '', '', 'L');
        if ($w_w > 4) {
          $w_w_1 += 7;
        } else {
          $w_w_1 += $w_w + 5;
        }
      }
      $this->SetX($x_axis);
      $this->Cell($c_width, $c_height, '', 'LTRB', 0, 'L', 0);
    } else {
      $this->SetX($x_axis);
      $this->Cell($c_width, $c_height, utf8_decode($text), 'LTRB', 0, 'L', 0);
    }
    return $c_height;
  }

  function Tabla($header, $datos, $width = 0, $height = 0, $length = 15, $sHeaders = true)
  {
    $c_width = $width;
    $c_height = $height;
    $this->SetLineWidth(.3);
    $this->SetFont('Arial', 'B', 9);
    //Cabecera
    if ($sHeaders) {
      foreach ($header as $key => $value) {

        $this->Cell($c_width[$key], 5, utf8_decode($value), 1, 0, 'C', true);
      }
      $this->Ln();
    }

    $this->SetFont('Arial', '', 7);
    if (is_array($datos) || is_object($datos)) {
      foreach ($datos as $registro) {
        $registro = (array) $registro;
        foreach ($header as $key => $value) {
          if ($this->checkNewPage()) {
            $this->Ln(25);
          }

          $x_axis = $this->getx();
          $c_height = $this->vcell($c_width[$key], $c_height, $x_axis, $registro[$key], $length[$key]);
        }

        $this->Ln();
      }
    }
  }


  function convertirFecha($fecha)
  {
    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    return date('d', strtotime($fecha)) . " de " . $meses[date('n', strtotime($fecha)) - 1] . " del " . date('Y');
  }

  function checkNewPage()
  {
    if ($this->GetY() > 220) {
      $this->AliasNbPages();
      $this->AddPage("P", "Letter");
      return true;
    }
  }

  //******************************************************//
  function getData($titulo_id)
  {
    $this->titulo = new TitulosElectronicos();
    $this->titulo->setAttributes(["folio_control" => $titulo_id]);
    $this->titulo = $this->titulo->consultarPor("titulos_electronicos", array("folio_control" => $titulo_id, "deleted_at"), "*");
    $this->titulo = !empty($this->titulo["data"]) ? $this->titulo["data"][0] : false;

    $estado_txt = new Estado();
    $estado_txt->setAttributes(array("id" => $this->titulo["estado_id"]));
    $estado_txt = $estado_txt->consultarId();
    $this->titulo["estado_txt"] = $estado_txt["data"]["estado"];
  }
}
