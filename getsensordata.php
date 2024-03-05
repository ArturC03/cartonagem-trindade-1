<?php
include('config.inc.php');

// Consulta os valores dos sensores
$result = my_query(
    "SELECT
    sr.id_sensor,
    l.location_x,
    l.location_y,
    l.size_x,
    l.size_y,
    sr.date,
    sr.time,
    ROUND(sr.temperature) AS temperatura_int
    FROM 
        location l
    INNER JOIN 
        sensor s ON l.id_location = s.id_location
    INNER JOIN 
        sensor_reading sr ON s.id_sensor = sr.id_sensor
    WHERE 
        s.status = 1
    AND
        sr.id_reading = (
            SELECT 
                MAX(id_reading)
            FROM 
                sensor_reading
            WHERE 
                id_sensor = s.id_sensor
        );"
);

// Cria um array para armazenar os dados dos sensores
$data = array();

// Adiciona cada linha do resultado da consulta ao array
foreach ($result as $row) {
    $data[] = array(
        'x' => $row['location_x'],
        'y' => $row['location_y'],
        'radius' => intval($arrConfig['cloud_radius']),
        'value' => $row['temperatura_int'] == 0 ? 1 : $row['temperatura_int'],
        'label' => $row['id_sensor'],
        'size_x' => $arrConfig['originalImageWidth'],
        'size_y' => $arrConfig['originalImageHeight']
    );
}

// Retorna os dados como JSON
echo json_encode($data);
