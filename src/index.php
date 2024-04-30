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
    <div class="absolute top-10 right-10 flex flex-col justify-center align-center p-4 border-l-2 border-base-300 pl-8 bg-base-100 text-center">
        <h1 class="text-2xl font-semibold">Médias</h1>

        <div id="tempAvg" class="radial-progress mt-10 first:mt-0 border-8 text-black" style="--size:8vw" role="progressbar"><?php echo $average1; ?> ºC</div>
        <div id="humidityAvg" class="radial-progress mt-10 first:mt-0 border-8 text-black" style="--size:8vw" role="progressbar"><?php echo $average2; ?> %</div>
        <div id="pressureAvg" class="radial-progress mt-10 first:mt-0 border-8 text-black" style="--size:8vw" role="progressbar"><?php echo $average3; ?> hPa</div>
    
        <div class="divider before:bg-base-300 after:bg-base-300"></div>
        <h1 class="text-2xl font-semibold">Legenda</h1>

        <div class="w-full h-10 rounded-xl bg-gradient-to-r from-[hsla(180,100%,50%,0.8)] via-[hsla(120,100%,50%,0.8)] to-[hsla(0,100%,50%,0.8)] mt-3"></div>
        <div class="w-full flex justify-between items-center">
            <span>0ºC</span>
            <span>35ºC</span>
        </div>
    </div>
</div>

<div class="h-screen w-screen fixed top-0 flex items-center justify-center z-10">
    <span class="loading loading-ring loading-lg"></span>
</div>
<script src="js/index.js"></script>

<?php
require "content/footer.inc.html";
?>
