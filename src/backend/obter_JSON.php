<?php
require '../includes/config.inc.php';

$sql = $_POST["sql"];
$result2 = my_query($sql);
$fileName = 'download/dados.json';

$data = array();
foreach ($result2 as $row) {
    $formattedTemperature = ltrim(sprintf("%.2f", $row['temperature']), '0');
    $row['temperature'] = $formattedTemperature;
    $formattedHumidity = ltrim(sprintf("%.2f", $row['humidity']), '0');
    $row['humidity'] = $formattedHumidity;
    
    $formattedPressure = ltrim(sprintf("%.2f", $row['pressure']), '0');
    $row['pressure'] = $formattedPressure;

    $formattedAltitude = ltrim(sprintf("%.2f", $row['altitude']), '0');
    $row['altitude'] = $formattedAltitude;

    $formattedCo2 = ltrim(sprintf("%.2f", $row['eCO2']), '0');
    $row['eCO2'] = $formattedCo2;

    $formattedTvoc = ltrim(sprintf("%.2f", $row['eTVOC']), '0');
    $row['eTVOC'] = $formattedTvoc;
    
    $data[] = $row;
}

$file = fopen($fileName, 'w');
fwrite($file, json_encode($data));
fclose($file);
header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
header('Content-Length: ' . filesize($fileName));
readfile($fileName);
