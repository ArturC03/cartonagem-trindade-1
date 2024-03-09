<?php
include('config.inc.php');

$id = $_GET['id'];

if (my_query("DELETE FROM export WHERE id_export = '$id';") == 1) {
    header('Location: csvtimes.php');
} else {
    echo "<script>alert(Não foi possível eliminar a tarefa. Tente outra vez.); window.location = 'csvtimes.php'</script>";
}