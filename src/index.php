<?php
require "content/header.inc.php";
?>

<div class="flex justify-between max-h-[90vh] items-stretch lg:items-center flex-col lg:flex-row p-3">
    <div class="w-[89vw] h-full">
        <canvas id='factory' class="hidden bg-[url(<?php echo $arrConfig['imageFactory'] ?>)] bg-contain bg-no-repeat"></canvas>
    </div>
    <div class="w-[4vw] h-full">
        <canvas id='temp' class="hidden bg-[linear-gradient(to top, #e6e6ff, #d4d4ff, #b3c0f3, #99cdcc, #80ea96, #80ff66, #a5ff4d, #ddff33, #ffb91a, #ff0300)]"></canvas>
    </div>
</div>

<div class="h-screen w-screen fixed top-0 flex items-center justify-center z-10">
    <span class="loading loading-ring loading-lg"></span>
</div>
<script src="js/home.js"></script>

<?php
require "content/footer.inc.php";
?>
