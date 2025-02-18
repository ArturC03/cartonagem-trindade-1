<?php
include('config.inc.php');
$id = $_GET['id'];
$status = $_GET['status'];
echo "Id: $id  Status: $status ";

if ($status == 1) {
    my_query("update `location` set status = 0 WHERE id_sensor = '$id'");
    header('Location: manageSensors.php'); 
    exit;
} elseif ($status == 0) {
    my_query("update `location` set status = 1 WHERE id_sensor = '$id'");
    header('Location: manageSensors.php'); 
    exit;
} else {
    echo "Primeiro é necessário definir uma localização!!";
} 
?>