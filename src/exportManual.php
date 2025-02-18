<?php
require 'includes/config.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['mindate']) && isset($_POST['maxdate'])) {
        ob_clean();

        foreach ($_POST as $k => $v) {
            if ($v == "on") {
                $ids[] = $k;
            }
        }
        $sensores = "(";
        foreach ($ids as $id) {
            $sensores = $sensores . "'" . $id . "',";
        }
        $sensores = substr($sensores, 0, -1);
        $sensores = $sensores . ")";

        $dataMinima = $_POST["mindate"];
        $dataMaxima = $_POST["maxdate"];

        $horaMinima = $_POST["mintime"];
        $horaMaxima = $_POST["maxtime"];

        $timestamp = strtotime($dataMaxima);
        $timestamp2 = strtotime($dataMinima);

        $dataMinima = date("y-m-d", $timestamp2);
        $dataMaxima = date("y-m-d", $timestamp);

        $comp2 = strlen($horaMinima);
        $comp3 = strlen($horaMaxima);

        if ($comp2 == 0 && $comp3 == 0) {
            $comp2 = "s.time BETWEEN '00:00:00' and '23:59:59' AND ";
        } elseif ($comp2 == 0 && $comp3 <> 0) {
            $comp2 = "s.time BETWEEN '00:00:00' and '" . $horaMaxima . "' and ";
        } elseif ($comp2 <> 0 && $comp3 <> 0) {
            $comp2 = "s.time BETWEEN '" . $horaMinima . "' and '" . $horaMaxima . "' AND ";
        } else {
            $comp2 = "s.time BETWEEN '" . $horaMinima . "' and '23:59:59' AND ";
        }

        $datas = "s.date BETWEEN '" . $dataMinima . "' and '" . $dataMaxima . "' AND ";

        $result = my_query("SELECT distinct s.id_sensor, s.date, s.time, s.temperature, s.humidity, s.pressure, s.altitude, s.eCO2, s.eTVOC FROM sensor_reading s where " . $comp2 . $datas . "s.id_sensor in $sensores order by date, time ASC");

        if (count($result) > 0) {
            if (isset($_POST['botaoCSV'])) {
                $fileName = __DIR__ . "/download/dados_sensores.csv";
                $file = fopen($fileName, 'w');
                fputcsv($file, array('id_sensors', 'Data', 'Hora', 'Temperatura', 'Humidade', 'Pressão', 'Altitude', 'CO2', 'TVOC'), ';');
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
            header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
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
    include 'content/header.inc.php';
    ?>
    <div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
        <div class="card card-side min-[400px]:w-96 w-11/12 lg:w-[90%] shadow-xl lg:h-full bg-base-300 justify-center">
            <form action="" method="POST" id="mainForm" class="card-body w-full max-w-xs justify-center items-center text-center lg:border-r-8 lg:border-base-100">
                <h2 class="card-title mb-6">Exportar</h2>

                <?php
                $sensorQuery = "SELECT s.id_sensor FROM sensor s";
                $sensorResult = my_query($sensorQuery);

                if (count($sensorResult) > 0) {
                    foreach ($sensorResult as $sensorRow) {
                        $sensorName = $sensorRow['id_sensor'];
                        ?>
                        <input type="checkbox" name="<?php echo $sensorName; ?>" class="hidden" />
                        <?php
                    }
                }
                ?>

                <div class="w-full max-w-xs flex justify-between join relative">
                    <input type="text" placeholder="Nenhum sensor selecionado" id="sensorsText" class="input input-bordered w-2/3 text-center join-item" disabled />
                    <input type="checkbox" class="-z-50 absolute left-1/4 bottom-0" id="sensorError" value="ERROR">
                    <button class="btn btn-primary w-1/3 join-item" onclick="modalSensors.showModal()">Escolher Sensores</button>
                </div>
                <input type="date" name="mindate" id="mindate" class="input input-bordered w-full max-w-xs" max="<?php echo date('Y-m-d') ?>" required>
                <input type="date" name="maxdate" id="maxdate" class="input input-bordered w-full max-w-xs" max="<?php echo date('Y-m-d') ?>" required>
                <input type="time" name="mintime" id="mintime" class="input input-bordered w-full max-w-xs">
                <input type="time" name="maxtime" id="maxtime" class="input input-bordered w-full max-w-xs">
                <div class="flex justify-between items-center w-full max-w-xs gap-2">
                    <button type="submit" name="botaoCSV" class="btn btn-primary w-[48%]">Gerar CSV</button>
                    <button type="submit" name="botaoJSON" class="btn btn-primary w-[48%]">Gerar JSON</button>
                </div>
            </form>
            <figure class="w-0 lg:w-full"><img class="hidden lg:block" src="<?php echo $arrConfig['imageFactory'] ?>" alt="Movie" /></figure>
        </div>
        <dialog id="modalSensors" class="modal">
            <div class="modal-box w-11/12 max-w-5xl h-1/2">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="font-bold text-2xl">Seleção de sensores</h3>
                <div class="mt-3 w-full h-[70%]">
                    <form action="" id="modalForm" class="h-full overflow-auto [&>*]:mb-3">
                        <?php
                        $groupQuery = "SELECT g.group_name FROM `group` g";
                        $groupResult = my_query($groupQuery);
                        $flag = true;

                        if (count($groupResult) > 0) {
                            foreach ($groupResult as $groupRow) {
                                $groupName = $groupRow['group_name'];
                                ?>
                                <div tabindex="0" class="collapse collapse-arrow bg-base-200">
                                    <input type="radio" name="accordionSensors" <?php $flag == true ? 'checked="checked"' : '' ?> />
                                    <div class="collapse-title text-xl font-medium pr-5">
                                        <?php echo $groupName; ?>
                                    </div>
                                    <?php
                                    $sensorQuery = "SELECT s.id_sensor
                                                FROM sensor s
                                                INNER JOIN `group` g ON g.id_group = s.id_group
                                                WHERE g.group_name = '$groupName'";

                                    $sensorResult = my_query($sensorQuery);
                                    ?>
                                    <div class="collapse-content">
                                        <div class="form-control">
                                            <label class="label cursor-pointer">
                                                <span class="label-text">Selecionar Tudo</span>
                                                <input type="checkbox" name="selectAll" class="checkbox" />
                                            </label>
                                        </div>
                                        <?php
                                        if (count($sensorResult) > 0) {
                                            foreach ($sensorResult as $sensorRow) {
                                                $sensorName = $sensorRow['id_sensor'];
                                                ?>
                                                <div class="form-control">
                                                    <label class="label cursor-pointer">
                                                        <span class="label-text"><?php echo $sensorName; ?></span>
                                                        <input type="checkbox" name="<?php echo $sensorName; ?>" class="checkbox" />
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                $flag = false;
                            }
                        }
                        ?>
                    </form>
                </div>
                <div class="">
                    <form method="dialog">
                        <button onclick="selectSensors()" class="btn btn-primary absolute right-6 bottom-6">Salvar</button>
                    </form>
                </div>
            </div>
        </dialog>
    </div>
    <script src="js/dateTimeCheck.js"></script>
    <script src="js/checkSensorsModal.js"></script>
    <script src="js/sensorsModal.js"></script>
    <?php
    include 'content/footer.inc.php';
}
