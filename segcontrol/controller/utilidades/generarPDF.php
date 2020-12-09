<?php

//sdate_default_timezone_set('UTC');s

//include_once '../libPDF/src/Cezpdf.php';
include_once ($_SERVER['DOCUMENT_ROOT'].'/directorio.php');
require_once(LIB_PATH."PDF/src/Cezpdf.php");
require_once(MODEL_PATH."servicios.php");

class GeneradorArchivo{



public function puntos_cm ($medida, $resolucion=72)
{
   //// 2.54 cm / pulgada
   return ($medida/(2.54))*$resolucion;
}



public function procesar($servicio, $datos)
{

$imagenSatelital=ROOT_PATH.'assets/images/slide_4.jpg';

if (strpos(PHP_OS, 'WIN') !== false) {
    $pdf->tempPath = 'C:/temp';
}
$pdf = new CezPDF('a4');



$pdf->selectFont('Helvetica');

// some general data used for table output
//
$id=$servicio[0]['id_servicio'];
echo "<br> id:".$servicio[0]['razon_social'] ;

$pdf->ezImage(ROOT_PATH.'assets/images/banner.jpg', 'none', 'center');
$pdf->ezText("<b>Cliente</b>:".$servicio[0]['razon_social']
  ."<b>Nit</b>:".$servicio[0]['nit'], 14, array('justification'=>'justification'));
$pdf->ezText("<b> Direccion:</b>:".$servicio[0]['direccion'] . "<b>Email</b>:".$servicio[0]['email1'], 14, array('justification'=>'justification'));


$pdf->setStrokeColor(0,0,0);
$pdf->setLineStyle(5,'round');
$pdf->line($this->puntos_cm(2),$this->puntos_cm(22),$this->puntos_cm(17),$this->puntos_cm(22));

$pdf->ezText("Novedad Satelital Actual", 14, array('justification'=>'justification'));

// verificacion de que imagen se coloca si es una primera minuta se coloca la default
if(count($datos)>1){

  $imagenSatelital=RECURSOS_PATH.$id."/" .$datos[0]['idservicio_novedad'].".jpg";
}
$pdf->ezImage($imagenSatelital,5,500,150, 'none', 'center');

$pdf->ezText("Registro Fotografico de instalación", 14, array('justification'=>'justification'));
$pdf->addJpegFromFile(RECURSOS_PATH.$id.'/carro1.jpg',
  $this->puntos_cm(2),$this->puntos_cm(2), $this->puntos_cm(8), $this->puntos_cm(8));
$pdf->addJpegFromFile(RECURSOS_PATH.$id.'/carro2.jpg',
  $this->puntos_cm(11),$this->puntos_cm(2), $this->puntos_cm(8),$this->puntos_cm(8));
$pdf->ezNewPage();
echo "<br>".$imagenSatelital;
//$pdf->ezImage('images/bg.jpg',5,100,100, 'none', 'center');
// $pdf->ezText("<b>Listado de Tod;as las Novedades<b>", 14, array('justification'=>'justification'));
// $pdf->ezSetY(puntos_cm(27));


//$d=array('num' => 1, 'name' => 'gandalf', 'type' => 'wizard');

$data = array();

for ($i=0; $i<count($datos);$i++){
 $fila=array('num' => $datos[$i]['fecha_novedad'], 'name' => $datos[$i]['observacion'],
  'type' => $datos[$i]['evento']);
array_push($data,$fila);
}
//   array('num' => 2, 'name' => 'bilbo', 'type' => 'hobbit', 'url' => 'http://www.ros.co.nz/pdf/'),
//   array('num' => '2018-05-12 04:56', 'name' => 'frodo', 'type' => 'hobbit'),
//   array('num' => 4, 'name' => 'saruman', 'type' => 'bad dude', 'url' => 'http://sourceforge.net/projects/pdf-php'),
//   array('num' => 5,
//   'name' => 'sauron fffffjose jose jose jose kps dso hijo te amo mucho no te desvies ni las tribulaiones ni le orgullo noi los desos perversos ffffffffffffffffff ffffffffffffff fffffffff fffffffff fffffffff fffffffffff fffffffffasfd ddddddd dffffffff',
//    'type' => 'really bad dude')
// );





$cols = array('num' => 'Fecha/Hora', 'type' => 'Evento', 'name' => '<i>Observacion</i>');
// $coloptions = array('num' => array('justification' => 'right'), 'name' => array('justification' => 'left'), 'type' => array('justification' => 'center'));

$optionsTable=array('gridlines'=> EZ_GRIDLINE_DEFAULT,
'shadeHeadingCol'=>array(0.6,0.6,0.5),
'width'=>450, 'cols'=>array('num' =>array('width'=>100)));

$pdf->ezTable($data, $cols,'HISTORIAL EVENTOS', $optionsTable);


if (isset($_GET['d']) && $_GET['d']) {
    $out=$pdf->ezOutput();
    //file_put_contents('file.pdf', $out);

    echo $pdf->ezOutput(true);
} else {

   $out=$pdf->ezOutput();
   $ruta= RECURSOS_PATH.$id.'/informe.pdf';
   $flujo=fopen($ruta, 'wb');
  if($flujo){
   echo"aqui en el flujo";
   fwrite($flujo,$out);

  fclose($flujo);
  }


}

}

}


 ?>
