<?php
include('config.inc.php');
$id = $_GET['id'];

if (my_query("SELECT COUNT(*) AS user_num FROM users WHERE user_type = 1")[0]['user_num'] == 1 && my_query("SELECT user_type FROM users WHERE user_id = $id")[0]['user_type'] == 1) {
    echo "Apenas existe um administrador! Crie primeiro um administrador e depois apague o utilizador.";
} else {
    if (my_query("DELETE FROM users WHERE user_id = $id") == 1) {
        header('Location: manageUser.php'); 
        exit;
    } else {
        echo "Erro a eliminar utilizador! Tente outra vez!";
    }
}