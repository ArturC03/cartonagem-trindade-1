<?php
require 'includes/config.inc.php';

if (!isset($_POST['mindate']) || !isset($_POST['maxdate'])) {
    header('Location: search.php');
} else {
    include 'content/header.inc.php';

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

    $comprimento = strlen($sensores);

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

    $sql = "SELECT distinct s.id_sensor, s.date, s.time, ROUND(s.temperature, 2) AS temperature, ROUND(s.humidity, 2) AS humidity,
ROUND(s.pressure, 2) AS pressure, ROUND(s.altitude, 2) AS altitude, ROUND(s.eCO2, 2) AS eCO2, ROUND(s.eTVOC, 2) AS eTVOC
FROM sensor_reading s where " . $comp2 . $datas . "s.id_sensor in $sensores ORDER BY date, time ASC";
    $sql2 = "SELECT distinct s.id_sensor, s.date, s.time, s.temperature, s.humidity, s.pressure, s.altitude, s.eCO2, s.eTVOC FROM sensor_reading s where " . $comp2 . $datas . "s.id_sensor in $sensores order by date, time ASC";
    ?>
    <p id="sql" class="hidden"><?php echo $sql; ?></p>
    <p id="sql2" class="hidden"><?php echo $sql2; ?></p>
    <script src="js/searchResults.js"></script>
    <div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
        <div class="card w-[90%] h-[80vh] bg-base-300 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h2 class="card-title">Pesquisa</h2>
                    <div>
                        <div class="dropdown dropdown-end">
                            <a role="button" tabindex="1" class="btn btn-circle btn-ghost">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                            </a>
                            <ul tabindex="1" class="menu menu-sm dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52 z-10">
                                <li><button class="learn-more" onclick="sendToCSV();">Obter CSV</button></li>
                                <li><button class="learn-more" onclick="sendToJSON();">Obter JSON</button></li>
                            </ul>
                        </div>
                        <a href="search.php" class="btn btn-sm btn-circle btn-ghost">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                        </a>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row justify-start md:items-center [&>*]:mr-3 [&>*]:mb-2">
                    <label for="column">Ordenar por:</label>
                    <select name="column" id="column" class="select select-bordered w-full max-w-xs">
                        <option value="">Predefinido (Data e Hora)</option>
                        <option value="0">ID</option>
                        <option value="1">Temperatura (ºC)</option>
                        <option value="2">Humidade (%)</option>
                        <option value="3">Pressão (HPA)</option>
                        <option value="4">CO2 (PPM)</option>
                        <option value="5">TVOC (PPB)</option>
                    </select>

                    <select name="order" id="order" class="select select-bordered w-full max-w-xs hidden">
                        <option value="0">Descendente</option>
                        <option value="1">Ascendente</option>
                    </select>
                </div>
                <div class="overflow-x-auto max-h-[50vh] md:max-h-[60vh]" id="table_body">
                    <table class="table table-pin-rows table-zebra">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data</th>
                                <th>Hora</th>
                                <th>Temperatura (ºC)</th>
                                <th>Humidade (%)</th>
                                <th>Pressão (HPA)</th>
                                <th>CO2 (PPM)</th>
                                <th>TVOC (PPB)</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed top-1/2 left-1/2 z-10">
        <span class="loading loading-ring loading-lg"></span>
    </div>
    <?php
}
require 'content/footer.inc.html';
