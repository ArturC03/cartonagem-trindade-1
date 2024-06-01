<?php
require '../includes/config.inc.php';

$minAvgTemp = $arrConfig['min_avg_temp'];
$maxAvgTemp = $arrConfig['max_avg_temp'];
$minAvgHumidity = $arrConfig['min_avg_humidity'];
$maxAvgHumidity = $arrConfig['max_avg_humidity'];
$minAvgPressure = $arrConfig['min_avg_pressure'];
$maxAvgPressure = $arrConfig['max_avg_pressure'];

$data = [
    'min_avg_temp' => $minAvgTemp,
    'max_avg_temp' => $maxAvgTemp,
    'min_avg_humidity' => $minAvgHumidity,
    'max_avg_humidity' => $maxAvgHumidity,
    'min_avg_pressure' => $minAvgPressure,
    'max_avg_pressure' => $maxAvgPressure
];

$jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;