
<?php
include("config.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <?php if (file_exists('css/' . basename($_SERVER['PHP_SELF'], '.php') . '.css')) { ?>
        <link rel="stylesheet" href="css/<?php echo basename($_SERVER['PHP_SELF'], '.php')?>.css">
    <?php } ?>
    <link rel="stylesheet" href="css/nav.inc.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/heatmap.js/2.0.0/heatmap.min.js" integrity="sha512-FpvmtV53P/z7yzv1TAIVH7PNz94EKXs5aV6ts/Zi+B/VeGU5Xwo6KIbwpTgKc0d4urD/BtkK50IC9785y68/AA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src='http://cdn.zingchart.com/zingchart.min.js'></script>
    <script src="js/setScreenWidth.js"></script>

    <title><?php echo $arrConfig['site_title'];?></title>
</head>
<body>
    <?php
        include("nav.inc.php");
    ?>
    <div class="main">