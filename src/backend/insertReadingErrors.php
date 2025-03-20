<?php
@session_start();
require "../includes/config.inc.php";
include "../includes/mail.inc.php"; // Incluir o arquivo de envio de emails

$res = my_query("SELECT value FROM site_settings WHERE name LIKE 'error_check_time' ORDER BY last_edited_at DESC");
$checkTime = $res[0]['value'];

sscanf($checkTime, "%d:%d", $minutos, $segundos);
$totalSegundos = ($minutos * 60) + $segundos;
$checkTime = $totalSegundos;

$results = [["check_time" => $checkTime]];
$errors = []; // Todos os erros detectados
$errorsToEmail = []; // Apenas erros que devem disparar e-mail
$ignoredErrors = [1, 1004]; // Lista de erros que não devem gerar e-mail

$logFile = "../../tools/RS232Monitorization2.1/reading_errors.log";
$lastPositionFile = "../../tools/RS232Monitorization2.1/lastReadPosition.txt";

if (!file_exists($lastPositionFile)) {
    file_put_contents($lastPositionFile, '0');
}

$lastPosition = (int)file_get_contents($lastPositionFile);
if (!is_numeric($lastPosition) || $lastPosition < 0) {
    $lastPosition = 0;
}

$file = fopen($logFile, "r");
fseek($file, $lastPosition);

while (!feof($file)) {
    $line = fgets($file);

    if (preg_match('/(\d{4}\/\d{2}\/\d{2} \d{2}:\d{2}:\d{2}) Erro: (\d{4}) \((.*)\)/', $line, $matches)) {
        $errorDate = $matches[1];
        $idError = (int)$matches[2]; // Converter para inteiro
        $errorMessage = $matches[3];

        $errorDateTime = date('Y-m-d H:i:s', strtotime($errorDate));

        $sql = "SELECT COUNT(*) as count FROM error_log WHERE id_error = $idError AND error_date = '$errorDateTime'";
        $result = my_query($sql);
        $count = $result[0]['count'] ?? 0;

        $currentId = $_SESSION['username'] ?? NULL;
        $errorStateId = in_array($idError, $ignoredErrors) ? 2 : 1; // Define o estado conforme a lista de ignorados

        if ($count == 0) {
            $sql = "INSERT INTO error_log (id_error, error_date, id_user, error_state_id) 
                    VALUES ($idError, '$errorDateTime', ".($currentId !== NULL ? $currentId : "NULL").", $errorStateId)";
            $insertId = my_query($sql);

            if ($insertId) {
                $results[] = [
                    "status" => "added",
                    "id_error" => $idError,
                    "error_date" => $errorDateTime,
                    "check_time" => $checkTime,
                    "error_state_id" => $errorStateId
                ];

                // Adicionar o erro ao array de erros detectados
                $errors[] = [
                    "id" => $idError,
                    "date" => $errorDateTime,
                    "message" => $errorMessage
                ];

                // Só adiciona para envio de e-mail se NÃO estiver na lista de ignorados
                if (!in_array($idError, $ignoredErrors)) {
                    $errorsToEmail[] = [
                        "id" => $idError,
                        "date" => $errorDateTime,
                        "message" => $errorMessage
                    ];
                }
            }
        } else {
            $results[] = ["status" => "exists", "id_error" => $idError, "error_date" => $errorDateTime, "check_time" => $checkTime];
        }
    }
}

$newPosition = ftell($file);
file_put_contents($lastPositionFile, $newPosition);
fclose($file);

// Enviar e-mail apenas se houver erros que devem ser notificados
if (!empty($errorsToEmail)) {
    $adminEmail = "arturvicentecruz@proton.me"; // Substituir pelo e-mail do destinatário
    $subject = "Novos erros detectados no sistema";

    // Criar a mensagem do e-mail
    $message = "<h2>Foram detectados novos erros no sistema:</h2>";
    $message .= "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";
    $message .= "<tr><th>ID do Erro</th><th>Data</th><th>Descrição</th></tr>";

    foreach ($errorsToEmail as $error) {
        $message .= "<tr>
                        <td>{$error['id']}</td>
                        <td>{$error['date']}</td>
                        <td>{$error['message']}</td>
                    </tr>";
    }

    $message .= "</table>";
    
    my_send_email($adminEmail, $subject, $message);
}

header("Content-Type: application/json");
echo json_encode($results);
?>
