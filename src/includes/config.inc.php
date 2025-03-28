<?php
@session_start();
global $arrConfig;

date_default_timezone_set("Europe/Lisbon");

$arrConfig['servername'] = 'localhost';
$arrConfig['username'] = 'root';
$arrConfig['password'] = '';
$arrConfig['dbname'] = 'plantdb_new';

require_once 'db.inc.php';

$result = my_query("SELECT * from site_settings");

foreach ($result as $row) {
    $arrConfig[$row['name']] = $row['value'];
}
$arrConfig['originalImageWidth'] = getimagesize(__DIR__ . "/../" . $arrConfig['imageFactory'])[0];
$arrConfig['originalImageHeight'] = getimagesize(__DIR__ . "/../" . $arrConfig['imageFactory'])[1];
$arrConfig['baseUrl'] = "http://localhost/cartonagem-trindade-25/";
$arrConfig['basePath'] = "C:\\xampp\\htdocs\\cartonagem-trindade-25";
$arrConfig['sensorProgramPath'] = $arrConfig['basePath'] . '/tools/RS232Monitorization2.1/RS232Monitorization.exe';

if (!str_contains($_SERVER['REQUEST_URI'], 'backend')) {
    $_SESSION['previous_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

$pagesWhiteList = array('login.php', 'recover.php', 'recoverForm.php', 'index.php', '', '404.php');

if (!isset($_SESSION['username']) && (!in_array(basename($_SERVER['PHP_SELF']), $pagesWhiteList) && !str_contains($_SERVER['PHP_SELF'], 'backend'))) {
    header('Location: login.php');
    exit;
}