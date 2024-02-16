<?php 
include 'config.inc.php';

$periodo_geracao = $argv[1];

$result = my_query("SELECT * FROM hora WHERE periodo_geracao = '" . $periodo_geracao . "';");

if ($periodo_geracao == "MINUTE") {
    $min_datetime = new DateTime(date('Y-m-d H:i:00', strtotime('-2 minute')));
    $max_datetime = new DateTime(date('Y-m-d H:i:00', strtotime('-1 minute')));
} else if ($periodo_geracao == "HOURLY") {
    $min_datetime = new DateTime(date('Y-m-d H:i:00', strtotime('-1 hour')));
    $max_datetime = new DateTime(date('Y-m-d H:i:00'));
} else if ($periodo_geracao == "DAILY") {
    $min_datetime = new DateTime(date('Y-m-d 00:00:00', strtotime('-1 day')));
    $max_datetime = new DateTime(date('Y-m-d 23:59:59'));
} else if ($periodo_geracao == "WEEKLY") {
    $min_datetime = new DateTime(date('Y-m-d 00:00:00', strtotime('-1 week')));
    $max_datetime = new DateTime(date('Y-m-d 23:59:59'));
} else if ($periodo_geracao == "MONTHLY") {
    $min_datetime = new DateTime(date('Y-m-d 00:00:00', strtotime('-1 month')));
    $max_datetime = new DateTime(date('Y-m-d 23:59:59'));
}

foreach ($result as $row) {
    $result2 = my_query(
        "SELECT id_sensor, date, hour, temperature, humidity, pressure, altitude, eCO2, eTVOC " .
        "FROM sensors " .
        "WHERE id_sensor IN ('" . (mb_strpos($row['sensores'], ',') ? implode('\',\'', explode(',', $row['sensores'])) : $row['sensores']) . "') " .
        "AND sensors.date BETWEEN '" . $min_datetime->format('Y-m-d') . "' AND '" . $max_datetime->format('Y-m-d') . "' " .
        "AND sensors.hour BETWEEN '" . $min_datetime->format('H:i:s') . "' AND '" . $max_datetime->format('H:i:s') . "';"
    );

    if (count($result2) > 0) {
        $fileName = __DIR__ . "/download/scheduled/" . $row['id_hora'] . "/" . $row['num_ficheiros'];

        if ($row['tipo_geracao'] == 0) {
            // Generate CSV
            $fileName .= ".csv";
            $file = fopen($fileName, 'w');
            fputcsv($file, array('id_sensors', 'Data', 'Hora', 'Temperatura', 'Humidade','Pressão', 'Altitude', 'CO2', 'TVOC'), ';');

            foreach ($result2 as $row2) {
                $formattedTemperature = ltrim(sprintf("%.3f", $row2['temperature']), '0');
                $row2['temperature'] = $formattedTemperature;
                $formattedHumidity = ltrim(sprintf("%.3f", $row2['humidity']), '0');
                $row2['humidity'] = $formattedHumidity;
                
                $formattedPressure = ltrim(sprintf("%.3f", $row2['pressure']), '0');
                $row2['pressure'] = $formattedPressure;
                
                $formattedCo2 = ltrim(sprintf("%.3f", $row2['eCO2']), '0');
                $row2['eCO2'] = $formattedCo2;
                
                $formattedTvoc = ltrim(sprintf("%.3f", $row2['eTVOC']), '0');
                $row2['eTVOC'] = $formattedTvoc;
                
                fputcsv($file, $row2, ';');
            }
        } else if ($row['tipo_geracao'] == 1) {
            // Generate JSON
            $fileName .= ".json";
            $file = fopen($fileName, 'w');
            $data = array();

            foreach ($result2 as $row2) {
                $formattedTemperature = ltrim(sprintf("%.3f", $row2['temperature']), '0');
                $row2['temperature'] = $formattedTemperature;
                $formattedHumidity = ltrim(sprintf("%.3f", $row2['humidity']), '0');
                $row2['humidity'] = $formattedHumidity;
                
                $formattedPressure = ltrim(sprintf("%.3f", $row2['pressure']), '0');
                $row2['pressure'] = $formattedPressure;
                
                $formattedCo2 = ltrim(sprintf("%.3f", $row2['eCO2']), '0');
                $row2['eCO2'] = $formattedCo2;
                
                $formattedTvoc = ltrim(sprintf("%.3f", $row2['eTVOC']), '0');
                $row2['eTVOC'] = $formattedTvoc;
                
                $data[] = $row2;
            }

            fwrite($file, json_encode($data));
        }

        fclose($file);
        if (my_query("UPDATE hora SET num_ficheiros = " . ($row['num_ficheiros'] + 1) . " WHERE id_hora = " . $row['id_hora'] . ";") == 0) {
            echo "<script>alert(Erro ao atualizar o número de ficheiros, por favor contacte o administrador da BD.); window.location = 'csvtimes.php'</script>";
        }
    }
    
}