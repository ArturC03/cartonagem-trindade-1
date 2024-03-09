<?php
require __DIR__ . "/../includes/config.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/tailwind.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title><?php echo $arrConfig['site_title'];?></title>
</head>
<body>
    <?php
        require "content/nav.inc.php";
    ?>