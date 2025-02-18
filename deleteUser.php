<?php
include('config.inc.php');
$id = $_GET['id'];

if (my_query("SELECT COUNT(*) FROM users WHERE user_type = 1") == 1) {
    if (my_query("DELETE FROM users WHERE user_id = $id") == TRUE) {
        header('Location: manageUser.php'); 
        exit;
    } else {
        echo "Erro a eliminar utilizador! Tente outra vez!";
    }
} else {
    echo "Apenas existe um administrador! Crie primeiro um administrador e depois apague o utilizador.";
}