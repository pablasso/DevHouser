<?php
if ( empty($_POST['name']) || empty($_POST['work']) )
{
	echo "Por lo menos dinos quien eres y que planeas hacer anda :)";
	exit();
}

require_once 'class.phpmailer.php';

$mail = new PHPMailer();

$body  = "<p>Nombre: {$_POST['name']}</p>";
$body .= "<p>Twitter: {$_POST['twitter']}</p>";
$body .= "<p>Va a trabajar: {$_POST['work']}</p>";
$body  = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only

$mail->SMTPAuth = true;
$mail->Host     = "minube.smtp.com"; // SMTP server
$mail->Username = "tech@minube.com"; 
$mail->Password = "b49Dk6lq";

$mail->SetFrom('pablasso@minube.com', 'Juan Pablo Ortiz Arechiga');
$mail->Subject  = "Registro para Guadalajara DevHouse #2";
$mail->AltBody .= "No HTML: {$_POST['name']}, {$_POST['twitter']}, {$_POST['work']}";

$mail->MsgHTML($body);

$address = "pablasso@gmail.com";
$mail->AddAddress($address, "Juan Pablo Ortiz Arechiga");

if( !$mail->Send() ) {
	echo "Oops, ocurrió un problema al enviar tus datos por lo pronto puedes enviarlos a pablasso@gmail.com";
} else {
	echo "¡Gracias! En cuanto lo revisemos te agregamos a la lista.";
}

?>