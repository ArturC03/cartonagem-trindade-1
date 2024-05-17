<?php
require "../includes/config.inc.php";

$sql = "SELECT DISTINCT id_sensor FROM sensor_reading";
$result = my_query($sql);
if (count($result) > 0) {
    foreach ($result as $row) {
        $id_sensor = $row["id_sensor"];

        $sql = "SELECT id_sensor FROM sensor WHERE id_sensor = '$id_sensor'";
        $result = my_query($sql);
        if (count($result) == 0) {
            $sql = "INSERT INTO sensor (id_sensor, `status`, id_user) VALUES ('$id_sensor', '0', '$_SESSION[username]')";
            my_query($sql);
        }
    }
}

header("Location: ../manageSensor.php");