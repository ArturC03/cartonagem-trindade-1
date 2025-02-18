<?php
include('config.inc.php');

$grupo = $_POST['grupo']; // Recupere o grupo selecionado

// Consulta SQL para obter a lista de sensores com base no grupo
$sql = "SELECT location.id_sensor
        FROM location
        WHERE location.grupo = $grupo
        GROUP BY location.id_sensor";

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
?>
