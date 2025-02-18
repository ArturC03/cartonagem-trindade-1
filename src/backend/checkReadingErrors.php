<?php

require "../includes/config.inc.php";

// Consulta para verificar erros não resolvidos (id_error_state = 2)
$sql = "SELECT id_log, id_error, error_date, id_user, error_state_id FROM error_log WHERE error_state_id = 1";
$errors = my_query($sql);

header('Content-Type: application/json');
// Verificar se há erros
if (!empty($errors)) {
    // Retornar os erros em formato JSON
    echo json_encode($errors);
} else {
    // Se não houver erros, retornar uma mensagem apropriada
    echo json_encode(["message" => "Nenhum erro não resolvido encontrado."]);
}

?>