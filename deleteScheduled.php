<?php
include('config.inc.php');

$id = $_GET['id'];

$agendamento = my_query("SELECT * FROM hora WHERE id_hora = " . $id . ";");
$result = my_query("DELETE FROM hora WHERE id_hora = " . $id . ";");

if ($result) {
    if ($agendamento[0]['periodo_geracao'] != "ONCE" || date("Y-m-d", $agendamento[0]['data_geracao']) >= date("Y-m-d")) {
        if (exec('schtasks /delete /tn "Exportação Agendada ' . $id . '" /f 2>&1', $output)) {
            array_map('unlink', glob(__DIR__ . "/download/scheduled/" . $id . "/*.*"));
            rmdir(__DIR__ . "/download/scheduled/" . $id);
    
            header('Location: csvtimes.php');
        } else {
            my_query("INSERT INTO hora (id_hora, periodo_geracao, data_geracao, sensores, tipo_geracao) VALUES (" . $agendamento[0]['id_hora'] . " ,' " . $agendamento[0]['periodo_geracao'] . "', '" . $agendamento[0]['data_geracao'] . "', '" . $agendamento[0]['sensores'] . "', " . $agendamento[0]['tipo_geracao'] . ");");
            echo $output;
            echo "<script>alert(Não foi possível eliminar a tarefa. Tente outra vez.); window.location = 'csvtimes.php'</script>";
        }
    } else {
        array_map('unlink', glob(__DIR__ . "/download/scheduled/" . $id . "/*.*"));
        rmdir(__DIR__ . "/download/scheduled/" . $id);

        header('Location: csvtimes.php');
    }
} else {
    echo "<script>alert(Não foi possível eliminar a tarefa. Tente outra vez.); window.location = 'csvtimes.php'</script>";
}