<?php
require "../includes/config.inc.php";

$id = $_GET['id'];

if (my_query("DELETE FROM `group` WHERE id_group = '$id';") == 1) {
    header('Location: manageGroup.php'); 
    exit;
} else {
    echo "<script>alert('Erro a eliminar grupo! Tente outra vez!'); window.location = 'manageGroup.php'</script>";
}