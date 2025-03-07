<?php
@session_start();
require "../includes/config.inc.php";

$res = my_query("SELECT value FROM site_settings WHERE name LIKE 'error_check_time' ORDER BY last_edited_at DESC");
$checkTime = $res[0]['value'];

sscanf($checkTime, "%d:%d", $minutos, $segundos);

// Converter para segundos
$totalSegundos = ($minutos * 60) + $segundos;

// Convertendo para segundos
$checkTime = $totalSegundos;

$results[] = ["check_time" => $checkTime];

// Caminho para o arquivo de logs
$logFile = "../../tools/RS232Monitorization2.0/reading_errors.log";

// Arquivo para armazenar a última posição processada
$lastPositionFile = "../../tools/RS232Monitorization2.0/lastReadPosition.txt";

// Verificar se o arquivo da última posição existe
if (!file_exists($lastPositionFile)) {
    // Se não existir, criar o arquivo e inicializar com 0
    file_put_contents($lastPositionFile, '0');
}

// Ler a última posição processada
$lastPosition = (int)file_get_contents($lastPositionFile);

// Verificar se a posição lida é um número válido
if (!is_numeric($lastPosition) || $lastPosition < 0) {
    $lastPosition = 0; // Definir como 0 se não for válido
}

// Abrir o arquivo de logs
$file = fopen($logFile, "r");

// Ir para a última posição processada
fseek($file, $lastPosition);


// Processar novas linhas
while (!feof($file)) {
    $line = fgets($file);

    // Usar expressão regular para capturar os dados
    if (preg_match('/(\d{4}\/\d{2}\/\d{2} \d{2}:\d{2}:\d{2}) Erro: (\d{4}) \((.*)\)/', $line, $matches)) {
        $errorDate = $matches[1];
        $idError = $matches[2];
        $errorMessage = $matches[3];

        // Converter a data para o formato DATETIME
        $errorDateTime = date('Y-m-d H:i:s', strtotime($errorDate));

        // Verificar se o erro já existe na tabela
        $sql = "SELECT COUNT(*) as count FROM error_log WHERE id_error = $idError AND error_date = '$errorDateTime'";
        $result = my_query($sql);
        $count = $result[0]['count'] ?? 0;

        // Encontrar o id do utilizador que está logado no momento
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            $currentId = $_SESSION['username'];
        } else {
            $currentId = NULL;
        }

        // Se o erro não existir, inseri-lo na tabela
        if ($count == 0) {
            $sql = "INSERT INTO error_log (id_error, error_date, id_user, error_state_id) VALUES ($idError, '$errorDateTime', ".($currentId !== NULL ? $currentId : "NULL").", 1)";

            $insertId = my_query($sql);
            // Se for inserido com sucesso
            if ($insertId) {
                $results[] = ["status" => "added", "id_error" => $idError, "error_date" => $errorDateTime, "check_time" => $checkTime];
            }
        } else {
            $results[] = ["status" => "exists", "id_error" => $idError, "error_date" => $errorDateTime, "check_time" => $checkTime];
        }
    }
}

// Atualizar a última posição processada
$newPosition = ftell($file);
file_put_contents($lastPositionFile, $newPosition);

// Fechar o ficheiro 
fclose($file);

// Retornar os resultados em JSON
header("Content-Type: application/json");
echo json_encode($results);
?>
