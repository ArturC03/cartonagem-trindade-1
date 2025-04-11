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

<!-- Botão para abrir o modal -->
<button class="btn absolute w-4 h-4 bottom-0 left-0 m-4" onclick="my_modal_3.showModal()">
  ?
</button>

<!-- Modal -->
<dialog id="my_modal_3" class="modal">
  <div class="modal-box">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h3 class="text-lg font-bold">Bem-vindo à Cartonagem Trindade</h3>
    <p class="py-4">Versão 1.1.0</p>
  </div>
</dialog>

<!-- Modal de Senha do Técnico -->
<dialog id="tech_password_modal" class="modal">
  <div class="modal-box w-96">
    <form id="tecForm" action="" method="post">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold text-lg">Opções do Técnico</h3>
        <form method="dialog">
          <button type="button" class="btn btn-sm btn-circle btn-ghost" id="btnTecnicoCancelar">✕</button>
        </form>
      </div>
      <div class="form-control w-full">
        <input type="password" placeholder="Password" class="input input-bordered w-full" id="tecPassword">
        <label class="label hidden" id="passwordError">
          <span class="label-text-alt text-error">Palavra-passe incorreta</span>
        </label>
      </div>
      <div class="modal-action">
        <button class="btn btn-primary" id="btnTecnicoConfirmar" type="button">Entrar</button>
      </div>
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button id="backdropClose">Fechar</button>
  </form>
</dialog>

<!-- Modal de Configurações - COM LARGURA AUMENTADA -->
<dialog id="settings_modal" class="modal">
  <div class="modal-box w-full md:w-11/12 max-w-7xl h-5/6 max-h-screen p-0">
    <iframe src="settings.php" scrolling="no" class="w-full h-full border-none" title="Settings"></iframe>
    <form method="dialog" class="modal-action absolute top-2 right-2 m-0">
      <button class="btn btn-circle btn-ghost text-lg" id="clmodal">✕</button>
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>Fechar</button>
  </form>
</dialog>


<p class="absolute bottom-0 w-screen text-lg z-10 text-center bg-gray-100 p-4 rounded-lg border-t border-gray-300" id="paragrafo">A carregar...</p>

<div class="fixed top-1/2 left-1/2 z-10">
    <span class="loading loading-ring loading-lg"></span>
</div>

<script src="js/index.js"></script>
<script src="js/getLastRead.js"></script>
<script src="js/menuTecnico.js"defer ></script>

<?php
require "content/footer.inc.php";
?>