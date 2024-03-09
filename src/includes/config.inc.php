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
$arrConfig['imageFactory'] = 'images/plantas/plantaV3-noBG.png';