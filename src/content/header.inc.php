<?php
require __DIR__ . "/../includes/config.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    if (basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == '') {
        $time = $arrConfig['reload_time'] ?? '00:10';
        list($hours, $minutes) = explode(':', $time);
        $totalSeconds = ($hours * 3600) + ($minutes * 60);

        echo '<meta http-equiv="refresh" content="' . $totalSeconds . '">';
    }
    ?>
    <link rel="stylesheet" href="css/tailwind.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <title><?php echo $arrConfig['site_title'];?></title>
</head>
<body class="h-screen">
    <?php
        require "content/nav.inc.php";
    ?>