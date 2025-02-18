<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'config.inc.php';

/**
 * Função que envia um email personalizado aueles que sabem
 * @param string $email
 * @param string $subject
 * @param string $message
 */
function my_send_email($email, $subject, $message) {
    $mail = new PHPMailer(true);
    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();                                            // Envia usando SMTP
        $mail->Host       = 'smtp.gmail.com';                // Servidor SMTP do Hotmail/Outlook
        $mail->SMTPAuth   = true;                                   // Habilita autenticação SMTP
        $mail->Username   = 'noreplyct4@gmail.com';         // O teu e-mail
        $mail->Password   = 'inhh dtmi zcfl cbbo';                         // Senha ou senha de aplicativo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;                                     // Porta para STARTTLS

        // Destinatários
        $mail->setFrom($mail->Username, "Cartonagem Trindade");
        $mail->addAddress($email);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
