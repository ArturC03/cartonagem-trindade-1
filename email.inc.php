<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
function SendEmail($destinatario,$tipo, $token= null){
    try{
        $mail = new PHPMailer(true);
        $mail -> isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = ''; //Email de envio
        $mail->Password=''; //Chave para app
        $mail->SMTPSecure = 'ssl';
        $mail->Port=465;

        $mail->setFrom(''); //Email de envio
        $mail->addAddress($destinatario);


        $imagePath = __DIR__ . '/images/trindade.png';
    
        if($tipo==1){
            $mail->Subject = 'Recuperar a password';
            $mail->Body = '<img src="cid:logo" alt="Logo Cartonagem Trindade"><br>Clique no link para recuperar a sua password: <a href="http://localhost/cartonagem-trindade/recuperar_pass.php?token='.$token.'">Recuperar</a>';
        }

        $mail->AddEmbeddedImage($imagePath, 'logo');
        $mail->isHTML(true);
        $mail->send();
    }catch(Exception $e){
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}