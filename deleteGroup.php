<?php
include('config.inc.php');
$id = $_GET['id'];

if (my_query("DELETE FROM grupos WHERE id_grupo = $id") == TRUE) {
    header('Location: manageGroup.php'); 
    exit;
} else {
    echo "Erro a eliminar grupo! Tente outra vez!";
}