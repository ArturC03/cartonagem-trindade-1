<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../includes/config.inc.php';

// Verificação de autenticação (descomentado, se necessário)
// if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
//     header('Content-Type: application/json');
//     echo json_encode(['success' => false, 'message' => 'Não autenticado']);
//     exit;
// }

$last_checked_id = isset($_GET['last_checked_id']) ? (int)$_GET['last_checked_id'] : 0;

try {
    // Obtendo o tempo de verificação do erro configurado
    $check_time_query = "SELECT value FROM site_settings WHERE name = 'error_check_interval'";
    $check_time_result = my_query($check_time_query);
    $check_time = !empty($check_time_result) ? (int)$check_time_result[0]['value'] : 10;

    // Query para pegar os erros pendentes, incluindo a descrição do erro e a data
    $query = "SELECT l.id_log, l.id_error, l.error_date, s.state AS error_state, e.error
              FROM error_log AS l
              LEFT JOIN error_state AS s ON l.error_state_id = s.id
              LEFT JOIN error AS e ON l.id_error = e.id_error
              WHERE l.error_state_id = 1";  // Filtra apenas os erros com estado '1' (pendentes)

    if ($last_checked_id > 0) {
        $query .= " AND l.id_log > $last_checked_id ";
    }

    $query .= " ORDER BY l.error_date DESC LIMIT 10";

    $errors = my_query($query);

    // Resposta com os erros encontrados
    $response = [
        'isAuthenticated' => $_SESSION['username'] ?? false,
        'success' => true,
        'check_time' => $check_time,
        'last_checked_id' => $last_checked_id,
        'errors' => $errors,
        'count' => count($errors)
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    
} catch (Exception $e) {
    // Em caso de erro na consulta
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false, 
        'message' => 'Erro ao buscar erros pendentes: ' . $e->getMessage()
    ]);
}
?>
