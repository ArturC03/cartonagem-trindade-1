<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');

    if (isset($_POST['submit'])) {
        $sensoresSelecionados = $_POST['sensores'];
        $folderName = rand(100000, 999999);

        while (file_exists(__DIR__ . '/download/scheduled/' . $folderName)) {
            $folderName = rand(100000, 999999);
        }

        $result = my_query("INSERT INTO export (id_export, id_interval, generation_format, id_user) VALUES ( '$folderName', '" . $_POST['periodoSelecionado'] . "', '" . ($_POST['submit'] == 'CSV' ? 0 : 1) . "', " . $_SESSION['username'] . ");");
        if (!$result) {
            echo "<script>alert('Erro ao criar o agendamento');
            window.location.href = 'csvtimes.php';
            </script>";
        }

        foreach ($sensoresSelecionados as $sensor) {
            $result2 = my_query("INSERT INTO export_sensor (id_export, id_sensor) VALUES ('$folderName', '" . $sensor . "');");

            if (!$result2) {
                echo "<script>alert('Erro ao criar o agendamento');
                window.location.href = 'csvtimes.php';
                </script>";
            }
        }

        mkdir(__DIR__ . '\download\scheduled\\' . $folderName, 0777);

        header('Location: csvtimes.php');
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
        <div class="sensor-container2">
            <div class="sensors-select">
                <h2>Selecione o grupo</h2>
                <select name="grupo">
                    <?php
                foreach ($grupos as $k => $v) {
                    echo '<option value="' . $k . '">Grupo ' . $v . '</option>';
                }
                ?>
            </select>
            <div class="sensor-update">          
                </div>
                <p>Tipo de Agendamento</p>
                <select name="periodoSelecionado" id="periodo" required>
                    <option value="">Selecione uma opção</option>
                    <?php 
                        $result = my_query("SELECT * FROM `interval`");
                        foreach ($result as $row) {
                            echo '<option value="' . $row["id_interval"] . '">' . $row["interval_name"] . '</option>';
                        }
                    ?>
                </select>
                
                <div class="button-container">
                    <button type="submit" class="btn-success" name="submit" id="BotaoCSV" value="CSV">Agendar CSV</button>
                    <button type="submit" class="btn-success" name="submit" id="BotaoJSON" value="JSON">Agendar JSON</button>
                </div>
            </div>
            <div class="scheduled">
                <h2>Agendamentos</h2>

                <section class="table_body">
                    <?php
                        $result = my_query(
                            "SELECT
                                e.id_export,
                                i.interval_name,
                                e.generation_format,
                                GROUP_CONCAT(s.id_sensor SEPARATOR ', ') AS sensor_list
                            FROM
                                plantdb_new.export e
                            JOIN
                                plantdb_new.interval i ON e.id_interval = i.id_interval
                            JOIN
                                plantdb_new.export_sensor es ON e.id_export = es.id_export
                            JOIN
                                plantdb_new.sensor s ON es.id_sensor = s.id_sensor
                            GROUP BY
                                e.id_export;"
                        );

                        echo '<table>';
                        echo '<thead>';
                        echo '<tr><th>Ações</th><th>Tipo Agendamento</th><th>Formato</th><th>Sensores</th></tr>';
                        echo '</thead>';
                        
                        echo '<tbody>';
                        if (count($result) != 0) {    
                            foreach ($result as $row) {
                                echo '<tr>';
                                echo '<td class="button-container-table"><a class="button-table delete" href="deleteScheduled.php?id=' . $row["id_export"] . '">Eliminar</a><a class="button-table" href="download/scheduled/' . $row["id_export"] . '/">Ver ' . ($row["generation_format"] == 0 ? 'CSV' : 'JSON') . 's</a></td>';
                                echo '<td>' . $row["interval_name"] . '</td>';
                                echo '<td>' . ($row["generation_format"] == 0 ? 'CSV' : 'JSON') . '</td>';
                                echo '<td>' . $row["sensor_list"] . '</td>';
                                echo '</tr>';
                            }
                        }
                        echo '</tbody>';
                        echo '</table>';
                    ?>
                </section>
            </div>
        </div>
    </form>
</div>
    <script src="js/csvtools.js"></script>
<?php
    include('footer.inc.php');
    }
}else{
    header('Location: login.php');
}