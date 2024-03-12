<?php
require "content/header.inc.php";

$average1 = 20;
$average2 = 65;
$average3 = 20;
?>

<div id="data" class="hidden">
    <div id="image-width"><?php echo $arrConfig['originalImageWidth'] ?></div>
    <div id="image-height"><?php echo $arrConfig['originalImageHeight'] ?></div>
</div>

<div class="relative flex justify-center align-center w-screen max-h-[90vh] items-stretch lg:items-center flex-col lg:flex-row p-3">
    <div class="w-[70vw]">
        <canvas id='factory' class="hidden bg-contain bg-no-repeat" style="background-image: url('<?php echo $arrConfig['imageFactory'] ?>')"></canvas>
    </div>
    <div class="absolute top-10 right-10 flex flex-col justify-center align-center p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-semibold">Médias</h1>

        <div id="tempAvg" class="radial-progress mt-10 first:mt-0 border-8 text-black" style="--size:8vw" role="progressbar"><?php echo $average1; ?> ºC</div>
        <div id="humidityAvg" class="radial-progress mt-10 first:mt-0 border-8 text-black" style="--size:8vw" role="progressbar"><?php echo $average2; ?> %</div>
        <div id="pressureAvg" class="radial-progress mt-10 first:mt-0 border-8 text-black" style="--size:8vw" role="progressbar"><?php echo $average3; ?> hPa</div>
    
        <div class="divider"></div>
        <h1 class="text-2xl font-semibold">Legenda</h1>

    </div>
</div>

<div class="h-screen w-screen fixed top-0 flex items-center justify-center z-10">
    <span class="loading loading-ring loading-lg"></span>
</div>
<script src="js/home.js"></script>

<?php
require "content/footer.inc.php";
?>
