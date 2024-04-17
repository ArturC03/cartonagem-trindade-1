<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../includes/config.inc.php';

$data = array();

try{
    $result = my_query("SELECT * from user WHERE email = '" . $_POST['email'] . "';");

    if (count($result) > 0) {
        $mail = new PHPMailer(true);
        $mail -> isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp-mail.outlook.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply1742@hotmail.com';
        $mail->Password='1R0_#y19i$sw';
        $mail->SMTPSecure = 'tls';
        $mail->Port=587;
        
        $mail->setFrom('no-reply1742@hotmail.com');
        $mail->addAddress($_POST['email']);
        
        $token = bin2hex(random_bytes(16));
        if (my_query("UPDATE user SET token = '" . $token . "' WHERE email = '" . $_POST['email'] . "';") == 0) {
            throw new Exception('Erro ao atualizar a base de dados');
        }
        
        $imagePath = __DIR__ . '/images/trindade.png';
        
        if ($_POST['tipo'] == '1') {
            $mail->Subject = 'Recuperar a password';
            $mail->Body = '<img src="cid:logo" alt="Logo Cartonagem Trindade"><br>Clique no link para recuperar a sua password: <a href="http://localhost/cartonagem-trindade/recuperar_pass.php?token='.$token.'">Recuperar</a>';
        }
        
        $mail->AddEmbeddedImage($imagePath, 'logo');
        $mail->isHTML(true);
        $mail->send();

    }
    $data['success'] = true;
}catch(Exception $e){
    $data['success'] = false;
    $data['error'] = $e->getMessage();
}
echo json_encode($data);