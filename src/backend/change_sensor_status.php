<?php
require "../includes/config.inc.php";

$id = $_GET['id'];
$status = $_GET['status'];

if ($status == 1) {
    my_query("UPDATE sensor SET status = 0, id_user = '" . $_SESSION['username'] . "' WHERE id_sensor = '$id'");
    header('Location: manageSensors.php'); 
    exit;
} elseif ($status == 0) {
    my_query("UPDATE sensor SET status = 1, id_user = '" . $_SESSION['username'] . "' WHERE id_sensor = '$id'");
    header('Location: manageSensors.php'); 
    exit;
}