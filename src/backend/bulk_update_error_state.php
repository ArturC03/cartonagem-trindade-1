<?php
// Configurações e conexão com BD
require '../includes/config.inc.php';

// Verificar se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
    exit;
}

// Verificar se o usuário está autenticado e tem permissões
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

// Recuperar parâmetros
$id_logs = isset($_POST['id_logs']) ? $_POST['id_logs'] : [];
$id_state = isset($_POST['id_state']) ? (int)$_POST['id_state'] : 0;

// Validar parâmetros
if (empty($id_logs) || !is_array($id_logs)) {
    echo json_encode(['success' => false, 'message' => 'Nenhum item selecionado']);
    exit;
}

// Verificar se o estado é válido
if (!in_array($id_state, [0, 1, 2, 3])) {
    echo json_encode(['success' => false, 'message' => 'Estado inválido']);
    exit;
}

try {
    // Iniciar transação
    my_query("START TRANSACTION");
    
    $id_user = $_SESSION['username'];
    $success_count = 0;
    
    // Processar cada item
    foreach ($id_logs as $id_log) {
        $id_log = (int)$id_log;
        
        // Atualizar o estado do erro
        $update_result = my_query("
            UPDATE error_log 
            SET error_state_id = $id_state 
            WHERE id_log = $id_log
        ");
        
        if ($update_result !== false) {
            // Registrar alteração no histórico
            my_query("
                INSERT INTO error_state_history 
                (id_log, error_state_id, id_user_state_change, change_date) 
                VALUES ($id_log, $id_state, $id_user, NOW())
            ");
            
            $success_count++;
        }
    }
    
    // Se tudo correu bem, confirmar transação
    if ($success_count == count($id_logs)) {
        my_query("COMMIT");
        
        // Obter o nome do estado
        $state_result = my_query("SELECT state FROM error_state WHERE id = $id_state");
        $state_name = isset($state_result[0]['state']) ? $state_result[0]['state'] : getStateNameById($id_state);
        
        echo json_encode([
            'success' => true, 
            'message' => "$success_count itens atualizados com sucesso",
            'state_name' => $state_name
        ]);
    } else {
        // Se algo deu errado, reverter
        my_query("ROLLBACK");
        echo json_encode([
            'success' => false, 
            'message' => "Apenas $success_count de " . count($id_logs) . " itens foram atualizados"
        ]);
    }
} catch (Exception $e) {
    // Em caso de exceção, reverter
    my_query("ROLLBACK");
    echo json_encode([
        'success' => false, 
        'message' => 'Erro: ' . $e->getMessage()
    ]);
}

// Função auxiliar para obter nome do estado pelo ID
function getStateNameById($state_id) {
    $stateNames = [
        0 => 'Resolvido',
        1 => 'Novo',
        2 => 'Ignorado',
        3 => 'Não Resolvido'
    ];
    
    return isset($stateNames[$state_id]) ? $stateNames[$state_id] : 'Desconhecido';
}
?>