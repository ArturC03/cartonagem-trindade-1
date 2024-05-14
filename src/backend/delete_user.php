<?php
require "../includes/config.inc.php";

$id = $_GET['id'];

if ($id == $_SESSION['username']) {
    echo "<script>alert('Não pode apagar a sua própria conta!'); window.location = '../manageUser.php';</script>";
} else {
    if (my_query("SELECT COUNT(*) AS user_num FROM user WHERE id_type = 1")[0]['user_num'] == 1 && my_query("SELECT id_type FROM user WHERE id_user = '$id'")[0]['id_type'] == 1) {
        echo "<script>alert('Apenas existe um administrador! Crie primeiro um administrador e depois apague o utilizador.'); window.location = '../manageUser.php';</script>";
    } else {
        if (my_query("DELETE FROM user WHERE id_user = '$id'") == 1) {
            header('Location: ../manageUser.php'); 
            exit;
        } else {
            echo "<script>alert('Erro a eliminar utilizador! Tente outra vez!'); window.location = '../manageUser.php'</script>";
        }
    }
}