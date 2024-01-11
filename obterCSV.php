<?php
include('config.inc.php');

$sql = $_POST["sql"];
$result2 = my_query($sql);
$fileName = 'download/dados.csv';

$file = fopen($fileName, 'w');
fputcsv($file, array('id_sensors', 'Hora', 'Data', 'Temperatura', 'Humidade','Pressão','CO2','TVOC'),';');
foreach ($result2 as $row) {
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
    
    fputcsv($file, $row,';');
}
fclose($file);