<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/directorio.php');
include_once(LIB_PATH."phpMailer/phpMailer.php");
include_once(LIB_PATH."phpMailer/smtp.php");
include_once(MODEL_PATH."cliente.php");
class  mail{

public function correo(cliente $cliente,$de,$para,$asuntoh,$mensajeh,$correo,$clave){
 /*correo("hernan@grupoipx.com",
 "hhgomez@unipacifico.edu.co",
 "Reporte de Minuta",
"Reporte de Minuta",
"hernan@grupoipx.com",
"hernan123")
*/
  $cabeceras = "MIME-Version: 1.0\r\n";
  $cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $cabeceras .= "From: $de \r\n";
   $destino=$_SERVER['DOCUMENT_ROOT'] .RECURSOS_PATH.$idservicio.'/reporte.pdf';;
   $mail = new PHPMailer();
  	if($mail->AddAttachment($destino)){
  	//incluyo la clase phpmailer
  	//$mail = new PHPMailer(); //creo un objeto de tipo PHPMailer
  	$mail->IsSMTP(); //protocolo SMTP
  	$mail->SMTPAuth = true;//autenticaci�n en el SMTP
  	$mail->SMTPSecure = "ssl";//SSL security socket layer
  	$mail->Host = "p3plcpnl0781.prod.phx3.secureserver.net";//servidor de SMTP de gmail
  	$mail->Port = 465;//puerto seguro del servidor SMTP de gmail
  	$mail->setFrom($de); //Remitente del correo
    $destinatarios=array($modelCliente->getEmail(),
    $modelCliente->getEmail(),
    $modelCliente->getEmail2(),
    $modelCliente->getEmail3(),
    $modelCliente->getEmail4(),
    $modelCliente->getEmail5(),
    $modelCliente->getEmail6(),
    $modelCliente->getEmail7(),
    $modelCliente->getEmail8());
    foreach ($destinatarios as $email) {if ( is_null($email) == false){$mail->AddAddress($email);}}
  	$mail->Username = $correo;//Aqui pon tu correo de gmail
  	$mail->Password = $clave;//Aqui pon tu contrase�a de gmail
  	$mail->Subject = $asuntoh; //Asunto del correo
  	$mail->Body = $mensajeh; //Contenido del correo
  	$mail->WordWrap = 50; //No. de columnas
  	$mail->MsgHTML($mensajeh);//Se indica que el cuerpo del correo tendr� formato html
  	//$mail->AddAttachment($destino); //accedemos al archivo que se subio al servidor y lo adjuntamos
  	if($mail->Send()){ //enviamos el correo por PHPMailer
  		$respuesta = "Mensaje enviado";
  	} else{
  		$respuesta = "El mensaje no se pudo enviar con la clase PHPMailer y tu cuenta de gmail =(";
  	  $respuesta .= " Error: ".$mail->ErrorInfo;
  	}
  } else {
   	$respuesta = "Ocurrio un error al subir el archivo adjunto =(";
  }

}

}

 ?>
