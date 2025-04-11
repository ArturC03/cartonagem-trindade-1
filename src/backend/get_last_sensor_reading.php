<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../includes/config.inc.php';

header("Content-Type: application/json");

try {
    // Tempo entre verificações
    $check_time = 1;

    // Recebe o last_date e last_time via GET
    $last_date = isset($_GET['last_date']) ? $_GET['last_date'] : null;
    $last_time = isset($_GET['last_time']) ? $_GET['last_time'] : null;

    // Se não receber os parâmetros, pegar o primeiro registro
    if (!$last_date || !$last_time) {
        $query = "SELECT * FROM sensor_reading ORDER BY `date` DESC, `time` DESC LIMIT 20";
    } else {
        // Pega os próximos 20 registros após o último data/horário
        $query = "SELECT * FROM sensor_reading 
                  WHERE (`date` > '$last_date') OR (`date` = '$last_date' AND `time` > '$last_time')
                  ORDER BY `date` DESC, `time` DESC LIMIT 20";
    }

    $result = my_query($query);

    if (!empty($result)) {
        $next_readings = $result;
        echo json_encode([
            'success' => true,
            'check_time' => $check_time,
            'data' => $next_readings
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'check_time' => $check_time,
            'message' => 'Nenhum novo dado encontrado'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao obter leitura: ' . $e->getMessage()
    ]);
}
