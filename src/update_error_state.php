<?php
require 'includes/config.inc.php';

// Determine if it's an AJAX request
$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Function to handle error responses
function handleError($message, $is_ajax) {
    if ($is_ajax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $message]);
    } else {
        echo "Erro: " . $message;
        // Redirect back in non-AJAX case
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    }
    exit;
}

// Check authentication
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    handleError("Precisa estar autenticado para acessar esta funcionalidade.", $is_ajax);
}

// Check user privileges
$result = my_query("SELECT id_type FROM user WHERE id_user = '" . $_SESSION['username'] . "'");
$id_type = $result[0]['id_type'];

if ($id_type != 1) {
    handleError("Não tem permissões suficientes para realizar esta ação.", $is_ajax);
}

// Caso 1: Se os parâmetros id_log e id_state forem passados via GET
if (isset($_GET['id_log']) && is_numeric($_GET['id_log']) && isset($_GET['id_state']) && is_numeric($_GET['id_state'])) {
    $id_log = (int) $_GET['id_log'];
    $new_state_id = (int) $_GET['id_state'];
    $id_user_state_change = $_SESSION['username']; // Utilizador que está a efetuar a alteração
    
    // Obter o estado atual do erro baseado em id_log
    $sql = "SELECT error_state_id FROM error_log WHERE id_log = $id_log";
    $current_state = my_query($sql);
    
    // Verificar se o erro existe
    if (empty($current_state)) {
        handleError("O erro especificado não foi encontrado.", $is_ajax);
    }
    
    // Registrar a alteração no histórico
    $sql_insert_history = "INSERT INTO error_state_history (id_log, error_state_id, id_user_state_change, change_date)
                           VALUES ($id_log, {$current_state[0]['error_state_id']}, '" . $_SESSION['username'] . "', NOW())";
    my_query($sql_insert_history);
    
    // Atualizar o estado do erro
    $sql_update_state = "UPDATE error_log SET error_state_id = $new_state_id WHERE id_log = $id_log";
    my_query($sql_update_state);
    
    // Obter o nome do estado para retornar no JSON
    $sql_state_name = "SELECT state FROM error_state WHERE id = $new_state_id";
    $state_result = my_query($sql_state_name);
    $state_name = !empty($state_result) ? $state_result[0]['state'] : '';
    
    // Return JSON response for AJAX requests
    if ($is_ajax) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true, 
            'message' => 'Estado atualizado com sucesso',
            'state_id' => $new_state_id,
            'state_name' => $state_name
        ]);
        exit;
    } else {
        // Redirect back in non-AJAX case for backward compatibility
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
// Caso 2: Se os parâmetros id_error, date e id_state forem passados via GET
elseif (isset($_GET['id_error']) && is_numeric($_GET['id_error']) &&
        isset($_GET['date']) && !empty($_GET['date']) &&
        isset($_GET['id_state']) && is_numeric($_GET['id_state'])) {
    $id_error = (int) $_GET['id_error'];
    $error_date = $_GET['date'];
    $new_state_id = (int) $_GET['id_state'];
    $id_user_state_change = $_SESSION['username'];
    
    // Obter o erro utilizando id_error e error_date
    $sql = "SELECT id_log, error_state_id FROM error_log WHERE id_error = $id_error AND error_date = '$error_date'";
    $current_error = my_query($sql);
    
    // Verificar se o erro foi encontrado
    if (empty($current_error)) {
        handleError("O erro especificado não foi encontrado.", $is_ajax);
    }
    
    // Se necessário, obtenha o id_log do registro encontrado
    $id_log = $current_error[0]['id_log'];
    
    // Registrar a alteração no histórico
    $sql_insert_history = "INSERT INTO error_state_history (id_log, error_state_id, id_user_state_change, change_date)
                           VALUES ($id_log, {$current_error[0]['error_state_id']}, '" . $_SESSION['username'] . "', NOW())";
    my_query($sql_insert_history);
    
    // Atualizar o estado do erro utilizando id_error e error_date
    $sql_update_state = "UPDATE error_log SET error_state_id = $new_state_id WHERE id_error = $id_error AND error_date = '$error_date'";
    my_query($sql_update_state);
    
    // Obter o nome do estado para retornar no JSON
    $sql_state_name = "SELECT state FROM error_state WHERE id = $new_state_id";
    $state_result = my_query($sql_state_name);
    $state_name = !empty($state_result) ? $state_result[0]['state'] : '';
    
    // Return JSON response for AJAX requests
    if ($is_ajax) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true, 
            'message' => 'Estado atualizado com sucesso',
            'state_id' => $new_state_id,
            'state_name' => $state_name,
            'id_log' => $id_log
        ]);
        exit;
    } else {
        // Redirect back in non-AJAX case for backward compatibility
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
} else {
    handleError("Parâmetros inválidos ou não fornecidos.", $is_ajax);
}
?>