<?php
require "../includes/config.inc.php";

// Verifica se o id_log foi passado e é numérico
if (!isset($_GET['id_log']) || !is_numeric($_GET['id_log'])) {
    echo json_encode(["error" => "ID de log inválido!"]);
    exit;
}

$id_log = (int)$_GET['id_log'];

// Consultar detalhes do erro
$error_details = my_query("SELECT l.id_log, l.id_error, err.error, l.error_date FROM error_log AS l LEFT JOIN error AS err ON l.id_error = err.id_error WHERE l.id_log = $id_log");
$error = $error_details[0] ?? null;

// Consultar histórico de mudanças
$log_changes = my_query("SELECT h.id_history, h.change_date, u.username, e.state FROM error_state_history AS h LEFT JOIN user AS u ON h.id_user_state_change = u.id_user LEFT JOIN error_state AS e ON h.error_state_id = e.id WHERE h.id_log = $id_log ORDER BY h.change_date ASC");

if (empty($error)) {
    echo json_encode(["error" => "Erro não encontrado!"]);
    exit;
}

$response = [
    "erro" => $error,
    "log_changes" => $log_changes
];
// Retornar os dados em formato JSON
echo json_encode($response);
?>