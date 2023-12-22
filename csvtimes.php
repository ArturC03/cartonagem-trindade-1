<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');
    require 'connect.inc.php';
?>
<div class="container">   
    <div class="sensor-container">
        <h2>Grupos</h2>
        <section class="table_body">
            <?php
            $sql = "SELECT grupo+1 AS grupo, GROUP_CONCAT(DISTINCT id_sensor) AS id_sensors FROM location GROUP BY grupo;";
            
            $result = $mysqli->query($sql);
            
            $gruposSensores = array();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $grupo = $row["grupo"];
                    $sensors = $row["id_sensors"];
                    
                    if (!isset($gruposSensores[$grupo])) {
                        $gruposSensores[$grupo] = array();
                    }
                    
                    $sensor = explode(",", $sensors);
                    
                    foreach ($sensor as $s) {
                        if (!in_array($s, $gruposSensores[$grupo])) {
                            $gruposSensores[$grupo][] = $s;
                        }
                    }
                }
            }
            
            echo '<table>';
            echo '<thead>';
            echo '<tr><th>Grupo</th><th>Sensores</th></tr>';
            echo '</thead>';
            
            echo '<tbody>';
            foreach ($gruposSensores as $grupo => $sensores) {
                echo '<tr>';
                echo '<td>' . $grupo . '</td>';
                echo '<td>' . implode(", ", $sensores) . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
            
            ?>    
        </section>
    </div> 
    <form action="gerar_csv.php" method="post">
        <div class="sensor-container">
            <h2>Selecione o grupo</h2>
            <select name="grupo">
                <?php
            foreach ($gruposSensores as $grupo => $sensores) {
                echo '<option value="' . $grupo . '">Grupo ' . $grupo . '</option>';
            }
            ?>
            </select>
            <div class="sensor-update">
            <?php
            $sql = "SELECT location.id_sensor, location.location_x,location.location_y, CAST(CONV(RIGHT(sensors.id_sensor, 2), 16, 10) AS SIGNED) AS id_sensor_decimal,sensors.Active
            FROM location
            INNER JOIN sensors ON 
            location.id_sensor = sensors.id_sensor
            where location.grupo=$grupo GROUP BY location.id_sensor";

            $result = $mysqli->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div>';
                    echo '<input type="checkbox" class="checkbox" name="sensores[]" value="' . $row['id_sensor'] . '">';
                    echo '<label class="sensor-name">' . $row['id_sensor'] . '</label>';
                    echo '</div>';
                }
            } else {
                echo "Nenhum sensor encontrado.";
            }
            ?>          
        </div>
        <p>Hora a definir</p>
        <input type="datetime-local" name="horaSelecionada" id="horaSelecionada" step="1">  
        <button type="submit" class="btn-success" id="meuBotao">Agendar CSV</button>      
    </form>
</div>
<script src="js/csvtools.js"></script>
<?php
    include('footer.inc.php');
}else{
    header('Location: login.php');
}