 <?php
$remitente = 'operaciongps2@gmail.com';
$destinatario = 'segcontrolgps@gmail.com';
 // segcontrolgps@gmail.com
$asunto = $_POST['Motivo']; // acá se puede modificar el asunto del mail
if (!$_POST){
    echo "fallo del sistema";
}else{
	 
    $cuerpo = "Nombre : " . $_POST["Nombre"] . "\r\n"; 
    $cuerpo .= "Email: " . $_POST["Correo"] . "\r\n";
	$cuerpo .= "Consulta: " . $_POST["Mensaje"] . "\r\n";
	//las líneas de arriba definen el contenido del mail. Las palabras que están dentro de $_POST[""] deben coincidir con el "name" de cada campo. 
	// Si se agrega un campo al formulario, hay que agregarlo acá.

    $headers  = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/plain; charset=utf-8\n";
    $headers .= "X-Priority: 3\n";
    $headers .= "X-MSMail-Priority: Normal\n";
    $headers .= "X-Mailer: php\n";
    $headers .= "From: \"".$_POST['Nombre']." - ".$_POST['Empresa']."\" <".$remitente.">\n";

    mail($destinatario, $asunto, $cuerpo, $headers);
    header('Location: http://www.segcontrol.com.co');
    exit();
    
}
?>
