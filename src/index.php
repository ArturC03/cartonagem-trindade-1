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
<div class="fixed top-1/2 left-1/2 z-10">
    <span class="loading loading-ring loading-lg"></span>
</div>

<!-- Indicador de refresh -->
<div id="tecard" class="top-1/2 left-1/2 absolute inset-0 flex items-center justify-center">
  <div class="fixed card bg-base-100 w-96 shadow-xl top-1/2 hidden left-1/2 absolute inset-0 flex items-center justify-center bg-white p-6 shadow-md" id="inputTecPass" style="transform: translate(-100%, -50%);">
    <form class="card-body" id="tecForm" action="" method="post">
      <h2 class="card-title">Opções do Técnico</h2>
      <div class="card-actions justify-end place-items-end">
        <input type="password" placeholder="Password" class="input input-bordered w-full max-w-xs" id="tecPassword">
      </div>
      <div class="card-actions flex justify-between p-2">
        <button class="btn btn-ghost" id="btnTecnicoCancelar" type="button">Cancelar</button>
        <button class="btn btn-primary" id="btnTecnicoConfirmar" type="button">Entrar</button>
      </div>
    </form>
  </div>
</div>

<dialog id="my_modal_4" class="modal fixed inset-0">
  <div class="modal-box flex flex-grow overflow-x-hidden" style="width: 96vw; height: 96vh; max-width: none; max-height: none; padding: 0;">
    <iframe src="settings.php" class="w-full h-full" title="Settings"></iframe>
    <div class="modal-action">
      <form method="dialog">
        <button class="btn btn-2Xl btn-circle btn-ghost absolute right-2 top-2 text-2xl" id="clmodal">✕</button>
      </form>
    </div>
  </div>
</dialog>

<script src="js/menuTecnico.js"></script>
<script src="js/index.js"></script>

<?php
require "content/footer.inc.php";
?>