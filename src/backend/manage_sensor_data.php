<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('memory_limit', '512M'); // Aumenta limite de memória se necessário
ini_set('max_execution_time', 300); // 300 segundos (5 minutos)

@session_start();
require "../includes/config.inc.php"; // Inclui a configuração do banco de dados

// Obter o tempo de verificação do banco de dados
$res = my_query("SELECT value FROM site_settings WHERE name LIKE 'check_validade_time' ORDER BY last_edited_at DESC");
$checkValidadeTime = $res[0]['value'] ?? "00:30"; // Valor padrão de segurança

// Converter para segundos
sscanf($checkValidadeTime, "%d:%d", $minutos, $segundos);
$checkValidadeTime = ($minutos * 60) + $segundos;

// Função para obter o tempo de validade configurado
function getValidityTime() {
    $dias = my_query("SELECT value FROM site_settings WHERE name = 'data_life_time_dias' ORDER BY last_edited_at DESC LIMIT 1")[0]["value"] ?? 1;
    $horas = my_query("SELECT value FROM site_settings WHERE name = 'data_life_time_horas' ORDER BY last_edited_at DESC LIMIT 1")[0]["value"] ?? 0;
    $minutos = my_query("SELECT value FROM site_settings WHERE name = 'data_life_time_minutos' ORDER BY last_edited_at DESC LIMIT 1")[0]["value"] ?? 0;
    $segundos = my_query("SELECT value FROM site_settings WHERE name = 'data_life_time_segundos' ORDER BY last_edited_at DESC LIMIT 1")[0]["value"] ?? 0;

    return ($dias * 86400) + ($horas * 3600) + ($minutos * 60) + $segundos;
}

// Função para mover registros expirados para o histórico em lotes
function moveExpiredReadingsToHistory($batchSize = 1000) {
    $validityTotalSeconds = getValidityTime();
    $timeThreshold = time() - $validityTotalSeconds; // Tempo limite para registros expirados

    do {
        // Selecionar um lote de registros expirados
        $query = "SELECT * FROM sensor_reading WHERE UNIX_TIMESTAMP(CONCAT(date, ' ', time)) < $timeThreshold LIMIT $batchSize";
        $result = my_query($query);

        if (!$result || count($result) === 0) {
            $results[] = ['error' => "Nenhum registro expirado encontrado."];
            return;
        }

        // Obter colunas dinamicamente
        $columns = array_keys($result[0]);
        
        // Alterar 'id_reading' para 'id_reading_history' ao mover para histórico
        $columns = array_map(function ($col) {
            return ($col === 'id_reading') ? 'id_reading_history' : $col;
        }, $columns);

        $columnsList = implode(", ", $columns);
        $values = [];

        // Preparar valores para inserção
        foreach ($result as $row) {
            $rowValues = array_map(fn($value) => "'" . addslashes($value) . "'", array_values($row));
            $values[] = "(" . implode(", ", $rowValues) . ")";
        }

        // Inserir registros no histórico e deletar os antigos
        if (!empty($values)) {
            my_query("START TRANSACTION"); // Iniciar transação

            $insertQuery = "INSERT INTO sensor_reading_history ($columnsList) VALUES " . implode(",", $values);
            my_query($insertQuery);

            $idsToDelete = implode(",", array_column($result, "id_reading")); // Pegar os IDs dos registros
            my_query("DELETE FROM sensor_reading WHERE id_reading IN ($idsToDelete)");

            my_query("COMMIT"); // Confirmar transação

            // echo count($result) . " registros movidos para o histórico.\n";
        }

    } while (count($result) === $batchSize); // Continua enquanto ainda houver registros a processar
}

// Executar a função
moveExpiredReadingsToHistory();

// Retornar tempo de verificação para o front-end
$results[] = ["check_time" => $checkValidadeTime];

// Enviar resposta JSON para o front-end
header("Content-Type: application/json");
echo json_encode($results);
die();
?>
