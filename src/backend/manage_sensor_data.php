<?php
@session_start();
require "../includes/config.inc.php"; // Certifique-se de incluir a configuração do banco de dados e a conexão

// Obter o valor de tempo de verificação configurado
$res = my_query("SELECT value FROM site_settings WHERE name LIKE 'check_validade_time' ORDER BY last_edited_at DESC");
$checkValidadeTime = $res[0]['value']; // O valor que deve ser no formato "MM:SS"

// Converter para minutos e segundos
sscanf($checkValidadeTime, "%d:%d", $minutos, $segundos);

// Converter para segundos
$totalSegundos = ($minutos * 60) + $segundos;

// Valor total em segundos
$checkValidadeTime = $totalSegundos;

// Função para obter o tempo de validade configurado no banco de dados
function getValidityTime() {
    $dias = my_query("SELECT value FROM site_settings WHERE name = 'data_life_time_dias' ORDER BY last_edited_at DESC LIMIT 1")[0]["value"] ?? 1;
    $horas = my_query("SELECT value FROM site_settings WHERE name = 'data_life_time_horas' ORDER BY last_edited_at DESC LIMIT 1")[0]["value"] ?? 0;
    $minutos = my_query("SELECT value FROM site_settings WHERE name = 'data_life_time_minutos' ORDER BY last_edited_at DESC LIMIT 1")[0]["value"] ?? 0;
    $segundos = my_query("SELECT value FROM site_settings WHERE name = 'data_life_time_segundos' ORDER BY last_edited_at DESC LIMIT 1")[0]["value"] ?? 0;

    return ($dias * 86400) + ($horas * 3600) + ($minutos * 60) + $segundos; // tempo de validade em segundos
}

// Função para mover registros expirados para o histórico
function moveExpiredReadingsToHistory() {
    $validityTotalSeconds = getValidityTime();
    $timeThreshold = time() - $validityTotalSeconds; // Tempo limite para considerar um registro expirado

    // Selecionar registros expirados
    $query = "SELECT * FROM sensor_reading WHERE UNIX_TIMESTAMP(CONCAT(date, ' ', time)) < $timeThreshold";
    $result = my_query($query);

    if ($result && count($result) > 0) {
        // Obter colunas dinamicamente para garantir compatibilidade
        $columns = array_keys($result[0]);
        $columnsList = implode(", ", $columns);

        // Inserir registros expirados no histórico
        $insertQuery = "INSERT INTO sensor_reading_history ($columnsList) VALUES ";
        $values = [];
        
        foreach ($result as $row) {
            $rowValues = array_map(fn($value) => "'" . addslashes($value) . "'", array_values($row));
            $values[] = "(" . implode(", ", $rowValues) . ")";
        }
        
        $insertQuery .= implode(",", $values);
        my_query($insertQuery);

        // Remover os registros expirados da tabela principal
        my_query("DELETE FROM sensor_reading WHERE UNIX_TIMESTAMP(CONCAT(date, ' ', time)) < $timeThreshold");
        
        echo "Registros expirados movidos para o histórico.\n";
    } else {
        echo "Nenhum registro expirado encontrado.\n";
    }
}

// Chamar a função para processar os registros expirados
moveExpiredReadingsToHistory();

// Retornar o intervalo de tempo para o front-end (em segundos)
$results[] = ["check_time" => $checkValidadeTime];

// Enviar resposta para o front-end
header("Content-Type: application/json");
echo json_encode($results);
?>
