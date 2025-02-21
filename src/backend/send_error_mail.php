<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../includes/mail.inc.php';
require_once '../includes/config.inc.php';

if (isset($_POST)){
    my_send_email("arturvicentecruz@proton.me",  "TESTES - ".$_POST['error_title'],$_POST['error_message']);
die();
}
header("Location: ".$_SERVER['HTTP_REFERER']);
?>