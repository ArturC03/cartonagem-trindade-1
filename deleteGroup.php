<?php
include('config.inc.php');
$id = $_GET['id'];

if (my_query("DELETE FROM grupos WHERE id_grupo = $id") == 1) {
    header('Location: manageGroup.php'); 
    exit;
} else {
    echo "<script>alert(Erro a eliminar grupo! Tente outra vez!); window.location = 'manageGroup.php'</script>";
}