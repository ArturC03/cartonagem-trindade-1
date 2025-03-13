<?php
require '../includes/config.inc.php';

// Determina se é uma requisição AJAX
$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Função para tratar respostas de erro
function handleError($message, $is_ajax) {
    if ($is_ajax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $message]);
    } else {
        echo "Erro: " . $message;
        // Redireciona para a página anterior no caso de uma requisição não-AJAX
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    }
    exit;
}

// Verifica autenticação
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    handleError("Precisa estar autenticado para acessar esta funcionalidade.", $is_ajax);
}

// Verifica privilégios do usuário
$result = my_query("SELECT id_type FROM user WHERE id_user = '" . $_SESSION['username'] . "'");
$id_type = $result[0]['id_type'];

if ($id_type != 1) {
    handleError("Não tem permissões suficientes para realizar esta ação.", $is_ajax);
}

// Verificar os parâmetros passados via GET ou POST
if ((isset($_GET['id_log']) && is_numeric($_GET['id_log']) && isset($_GET['id_state']) && is_numeric($_GET['id_state'])) ||
    (isset($_POST['id_log']) && is_numeric($_POST['id_log']) && isset($_POST['id_state']) && is_numeric($_POST['id_state']))) {
    
    // Usa o GET ou POST, dependendo de qual está disponível
    $id_log = isset($_GET['id_log']) ? (int) $_GET['id_log'] : (int) $_POST['id_log'];
    $new_state_id = isset($_GET['id_state']) ? (int) $_GET['id_state'] : (int) $_POST['id_state'];
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
    
    // Retornar resposta JSON para requisições AJAX
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
        // Redirecionar de volta na versão não-AJAX
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
} 
// Caso 2: Se os parâmetros id_error, date e id_state forem passados via GET ou POST
elseif ((isset($_GET['id_error']) && is_numeric($_GET['id_error']) &&
         isset($_GET['date']) && !empty($_GET['date']) &&
         isset($_GET['id_state']) && is_numeric($_GET['id_state'])) ||
        (isset($_POST['id_error']) && is_numeric($_POST['id_error']) &&
         isset($_POST['date']) && !empty($_POST['date']) &&
         isset($_POST['id_state']) && is_numeric($_POST['id_state']))) {
    
    // Usa o GET ou POST, dependendo de qual está disponível
    $id_error = isset($_GET['id_error']) ? (int) $_GET['id_error'] : (int) $_POST['id_error'];
    $error_date = isset($_GET['date']) ? $_GET['date'] : $_POST['date'];
    $new_state_id = isset($_GET['id_state']) ? (int) $_GET['id_state'] : (int) $_POST['id_state'];
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
    
    // Retornar resposta JSON para requisições AJAX
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
        // Redirecionar de volta na versão não-AJAX
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
} else {
    handleError("Parâmetros inválidos ou não fornecidos.", $is_ajax);
}
?>
