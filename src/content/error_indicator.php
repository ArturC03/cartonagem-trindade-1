<?php
@session_start();
if (isset($_SESSION['username']))
    $id_type = my_query("SELECT id_type FROM user WHERE id_user = '" . $_SESSION['username'] . "'")[0]['id_type'];
else
    $id_type = -1;
?>

<button id="error-btn" class="btn hidden" onclick=" event.preventDefault();document.getElementById('error-modal').showModal()"></button>

<dialog id="error-modal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg" id="error-title">Erro Detetado</h3>
    <div class="py-4">
      <p id="error-message">Mensagem de erro aqui.</p>
    <a href="erros.php" class="link ">Consultar a página de erros</a>
    </div>
    <div class="modal-action mt-2">
      <button class="btn btn-success btn-sm btn-resolve" data-id-log="" data-id-state="0">Resolvido</button>
      <button class="btn btn-error btn-sm btn-not-resolve" data-id-log="" data-id-state="3">Não Resolvido</button>
      <button class="btn btn-warning btn-sm btn-ignore" data-id-log="" data-id-state="2">Ignorar</button>
      <button class="btn btn-ghost btn-sm" onclick="document.getElementById('error-modal').close()">Fechar</button>
    </div>
  </div>
</dialog>



<div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 hidden" id="loadingSpinner">
  <span class="loading loading-ring loading-lg"></span>
</div>
