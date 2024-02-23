<?php
@session_start();
global $arrConfig;

date_default_timezone_set("Europe/Lisbon");

$arrConfig['servername'] = 'localhost';
$arrConfig['username'] = 'root';
$arrConfig['password'] = '';
$arrConfig['dbname'] = 'plantdb_new';

require_once('db.inc.php');

$result = my_query("SELECT * from site_settings");

foreach ($result as $row) {
  $arrConfig[$row['name']] = $row['value'];
}

$viewportWidth = 0.62;

if (!isset($_SESSION['screenWidth'])) {
  echo "<script src='https://code.jquery.com/jquery-3.7.1.min.js' integrity='sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=' crossorigin='anonymous'></script>";
  echo "<script src='js/setScreenWidth.js'></script>";

  echo "<script>document.location.reload();</script>";
}

$viewportWidthPixels = $_SESSION['screenWidth'] * $viewportWidth;

$originalImageWidth = getimagesize('images/plantaV3.png')[0];
$originalImageHeight = getimagesize('images/plantaV3.png')[1];

$heightInPixels = ($viewportWidthPixels / $originalImageWidth) * $originalImageHeight;