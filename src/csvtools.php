<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['sensores'])) {
            ob_clean();

            $sensoresSelecionados = $_POST['sensores'];
            $min_datetime = new DateTime($_POST['horaMinima']);
            $max_datetime = new DateTime($_POST['horaMaxima']);

            $result = my_query("
                SELECT id_sensor, date, time, temperature, humidity, pressure, altitude, eCO2, eTVOC 
                FROM sensor_reading
                WHERE id_sensor IN ('" . implode('\',\'', $sensoresSelecionados) . "')
                AND sensor_reading.date BETWEEN '" . $min_datetime->format('Y-m-d') . "' AND '" . $max_datetime->format('Y-m-d') . "';"
            );

            if (count($result) > 0) {
                if (isset($_POST['botaoCSV'])) {
                    $fileName = __DIR__ . "/download/dados_sensores.csv";
                    $file = fopen($fileName, 'w');
                    fputcsv($file, array('id_sensors', 'Data', 'Hora', 'Temperatura', 'Humidade','Pressão', 'Altitude', 'CO2','TVOC'),';');
                    $contentType = 'text/csv';
                } else if (isset($_POST['botaoJSON'])) {
                    $fileName = __DIR__ . "/download/dados_sensores.json";
                    $file = fopen($fileName, 'w');
                    $contentType = 'application/json';
                }

                foreach ($result as $row) {
                    $formattedTemperature = ltrim(sprintf("%.3f", $row['temperature']), '0');
                    $row['temperature'] = $formattedTemperature;
                    $formattedHumidity = ltrim(sprintf("%.3f", $row['humidity']), '0');
                    $row['humidity'] = $formattedHumidity;
                    $formattedPressure = ltrim(sprintf("%.3f", $row['pressure']), '0');
                    $row['pressure'] = $formattedPressure;
                    $formattedCo2 = ltrim(sprintf("%.3f", $row['eCO2']), '0');
                    $row['eCO2'] = $formattedCo2;
                    $formattedTvoc = ltrim(sprintf("%.3f", $row['eTVOC']), '0');
                    $row['eTVOC'] = $formattedTvoc;

                    if (isset($_POST['botaoCSV'])) {
                        fputcsv($file, $row, ';');
                    } else if (isset($_POST['botaoJSON'])) {
                        $data[] = $row;
                    }
                }

                if (isset($_POST['botaoJSON'])) {
                    fwrite($file, json_encode($data));
                }

                fclose($file);

                header('Content-Type: ' . $contentType);
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                readfile($fileName);
            } else {
                echo "<script>alert('Nenhum dado encontrado para os sensores selecionados.');</script>";
            }
            exit();
        } else {
            echo "<script>alert('Nenhum dado encontrado para os sensores selecionados.');</script>";
        }
        exit();
    } else {
?>
<div class="container">   
    <div class="sensor-container">
        <h2>Grupos</h2>
        <section class="table_body">
            <?php
            $result = my_query(
                "SELECT
                    `group`.id_group,
                    `group`.group_name,
                    GROUP_CONCAT(sensor.id_sensor SEPARATOR ', ') AS sensor_list
                FROM
                    `group`
                INNER JOIN
                    sensor ON `group`.id_group = sensor.id_group
                GROUP BY
                    `group`.group_name
                ORDER BY
                    `group`.group_name ASC;"
            );
            
            $grupos = array();
            $gruposSensores = array();
            
            foreach ($result as $row) {
                $id = $row["id_group"];
                $grupo = $row["group_name"];
                $sensors = $row["sensor_list"];
                
                if (!isset($gruposSensores[$grupo])) {
                    $gruposSensores[$grupo] = array();
                }

                $grupos[$id] = $grupo;
                
                $sensor = explode(",", $sensors);
                
                foreach ($sensor as $s) {
                    if (!in_array($s, $gruposSensores[$grupo])) {
                        $gruposSensores[$grupo][] = $s;
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
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="sensor-container">
            <h2>Selecione o Grupo</h2>
            <select name="grupo">
                <?php
                foreach ($grupos as $k => $v) {
                    echo '<option value="' . $k . '">Grupo ' . $v . '</option>';
                }
                ?>
            </select>
            <div class="sensor-update">
            </div>
            <h2>Período</h2>
            <input type="date" name="horaMinima" id="horaMinima" step="1" max="<?php echo date('Y-m-d') ?>" required>
            <input type="date" name="horaMaxima" id="horaMaxima" step="1" max="<?php echo date('Y-m-d') ?>" required>
            
            <div class="button-container">
                <button type="submit" class="btn-success" id="botaoCSV" name="botaoCSV">Gerar CSV</button>
                <button type="submit" class="btn-success" id="botaoJSON" name="botaoJSON">Gerar JSON</button>
            </div>
        </div>        
        </form>
    </div>
</div>
<script src="js/csvtools.js"></script>
<?php
    include('footer.inc.php');
    }
}else{
    header('Location: login.php');
}