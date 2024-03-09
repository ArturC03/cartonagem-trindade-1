<?php
include('config.inc.php');

$grupo = $_POST['grupo']; // Recupere o grupo selecionado

// Consulta SQL para obter a lista de sensores com base no grupo
$sql = "SELECT id_sensor
        FROM sensor
        WHERE id_group = $grupo
        ORDER BY LPAD(CAST(CONV(RIGHT(id_sensor, 2), 16, 10) AS SIGNED), 2, '0') ASC";

$result = my_query($sql);

if (count($result) > 0) {
    echo '<label class="check-container">';
    echo '<input type="checkbox" name="todos" id="todos" value="Selecionar Tudo">';
    echo '<div class="checkmark"></div>';
    echo '<span>Selecionar todos</span>';
    echo '</label>';
    
    foreach ($result as $row) {
        echo '<label class="check-container">';
        echo '<input type="checkbox" class="checkbox" name="sensores[]" value="' . $row['id_sensor'] . '">';
        echo '<div class="checkmark"></div>';
        echo '<span>' . $row['id_sensor'] . '</span>';
        echo '</label>';
    }
} else {
    echo "Nenhum sensor encontrado para este grupo.";
}
