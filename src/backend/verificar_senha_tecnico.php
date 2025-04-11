<?php
// Senha correta (no caso, pode ser um hash)
$senhaCorreta = 'carTrindade'; // Aqui você pode usar password_hash e password_verify, se quiser mais segurança
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['senha'])) {

    $senha = $_POST['senha'];
    if ($senha === $senhaCorreta) {
        echo json_encode(['status' => 'sucesso']);
    } else {
        echo json_encode(['status' => 'erro', 'message' => 'Password incorreta']);
    }
} else {
    echo json_encode(['status' => 'erro', 'message' => 'Password não fornecida']);
}
?>

