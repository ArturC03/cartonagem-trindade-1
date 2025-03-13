<?php
@session_start();
if (isset($_SESSION['username']))
    $id_type = my_query("SELECT id_type FROM user WHERE id_user = '" . $_SESSION['username'] . "'")[0]['id_type'];
else
    $id_type = -1;
?>

<!-- Botão para abrir o modal (inicialmente oculto) 
<button class="hidden" id="error-btn" onclick="errorModal.showModal()"></button>

Modal de Erro 
<dialog id="errorModal" class="modal">
  <div class="modal-box bg-red-100 border-l-4 border-red-600 shadow-lg">
    <div class="flex items-center" style="color:#ff5861">
      Ícone de erro
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12c0 4.97-4.03 9-9 9S3 16.97 3 12 7.03 3 12 3s9 4.03 9 9z" />
      </svg>
      <h3 class="text-xl font-bold text-red-50" id="error-title">Erro</h3>
    </div>
    <p class="py-4 my-4" id="error-message">Ocorreu um erro inesperado. Tente novamente mais tarde.</p>
    
    <div class="modal-action" style="text-align: right;">
      <form method="dialog">
        Botão de fechar com estilo de erro
        <?php if ($id_type == 1): ?>
          <button class="btn btn-primary" onclick="window.location.href='<?= $arrConfig['baseUrl'] ?>erros.php'">Detalhes</button>
          <button class="btn modal-open btn-ignore">Ignorar</button>
        <?php else: ?>
          <button type="button" class="btn btn-primary" onclick="document.getElementById('adminForm').submit();">Contactar o Administrador</button>
        <?php endif; ?>
      </form>

      Formulário oculto para POST
      <form id="adminForm" action="<?= $arrConfig['baseUrl'] ?>/backend/send_error_mail.php" method="POST">
        <input type="hidden" id="error-message" name="error_message">
        <input type="hidden" id="error-title" name="error_title">
      </form>
    </div>
  </div>
</dialog> -->

<button id="error-btn" class="btn hidden" onclick="document.getElementById('error-modal').showModal()"></button>

<dialog id="error-modal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg" id="error-title">Erro Detetado</h3>
    <p class="py-4" id="error-message">Mensagem de erro aqui.</p>
    <div class="modal-action">
      <form>
        <input type="hidden" name="error_title" value="">
        <input type="hidden" name="error_message" value="">
        
        <button class="btn btn-success btn-sm btn-resolve" data-id-log="" data-id-state="1">Resolvido</button>
        <button class="btn btn-error btn-sm btn-not-resolve" data-id-log="" data-id-state="3">Não Resolvido</button>
        <button class="btn btn-warning btn-sm btn-ignore" data-id-log="" data-id-state="2">Ignorar</button>
        <button class="btn btn-ghost btn-sm" id="error-modal-close" onclick="document.getElementById('error-modal').hide()">Fechar</button>
      </form>
    </div>
  </div>
</dialog>

<div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 hidden" id="loadingSpinner">
  <span class="loading loading-ring loading-lg"></span>
</div>
