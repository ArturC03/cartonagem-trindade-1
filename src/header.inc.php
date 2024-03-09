
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/setScreenWidth.js"></script>

    <title><?php echo $arrConfig['site_title'];?></title>
</head>
<body>
    <?php
        include("nav.inc.php");
    ?>
    <div class="main">