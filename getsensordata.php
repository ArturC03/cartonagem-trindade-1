<?php
include('config.inc.php');

// Consulta os valores dos sensores
$result = my_query("SELECT 
location.id_sensor,
location.location_x,
location.location_y,
location.size_x,
location.size_y,
CAST(sensors.temperature AS SIGNED) AS temperatura_int
FROM 
location
INNER JOIN 
sensors 
ON 
location.id_sensor = sensors.id_sensor
WHERE 
location.status = 1
AND
sensors.sensor_id IN (
    SELECT 
        MAX(sensor_id) AS max_sensor_id
    FROM 
        sensors
    GROUP BY 
        id_sensor
)
;
");

// Cria um array para armazenar os dados dos sensores
$data = array();

// Adiciona cada linha do resultado da consulta ao array
foreach ($result as $row) {
  $data[] = array(
    'x' => $row['location_x'],
    'y' => $row['location_y'],
    'size_x' => $row['size_x'],
    'size_y' => $row['size_y'],
    'value' => $row['temperatura_int'] == 0 ? 1 : $row['temperatura_int'],
  );
}

// Retorna os dados como JSON
echo json_encode(array(
  'min' => 0,
  'max' => 35,
  'data' => $data
));
?>