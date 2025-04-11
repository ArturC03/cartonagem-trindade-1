$(document).ready(function() {
  // Configuração das teclas secretas
  const secretKeys = ['c', 't'];
  let pressedKeys = [];
  let sequenceCount = 0;

  // Elementos DOM
  const $techPasswordModal = $('#tech_password_modal');
  const $settingsModal = $('#settings_modal');
  const $tecForm = $('#tecForm');
  const $passwordInput = $('#tecPassword');
  const $btnConfirmar = $('#btnTecnicoConfirmar');
  const $btnCancelar = $('#btnTecnicoCancelar');
  const $closeModal = $('#clmodal');
  const $passwordError = $('#passwordError');
  const $backdropClose = $('#backdropClose');

  // Event listener para submeter o form quando pressionar Enter
  $tecForm.on('submit', function(event) {
    event.preventDefault();
    $btnConfirmar.click();
  });

  // Detector de sequência de teclas
  $(document).on('keydown', function(e) {
    if (e.altKey && !pressedKeys.includes('Alt')) {
      pressedKeys.push('Alt');
    } else if (!pressedKeys.includes(e.key.toLowerCase())) {
      pressedKeys.push(e.key.toLowerCase());
    }

    if (pressedKeys.length >= secretKeys.length &&
        secretKeys.every((key, index) => pressedKeys.includes(key))) {
      sequenceCount++;
      pressedKeys = []; // Limpa as teclas pressionadas

      if (sequenceCount === 2) {
        // Abre o modal de senha do técnico
        $techPasswordModal[0].showModal();
        $passwordInput.focus().val('');
        $passwordError.addClass('hidden');
        sequenceCount = 0; // Reseta o contador de sequência
      }
    }
  });

  $(document).on('keyup', function(e) {
    pressedKeys = pressedKeys.filter(key => key !== e.key.toLowerCase() && (e.key !== 'Alt' || key !== 'Alt'));
  });

  // Função para validar a senha no backend via AJAX (usando jQuery)
  function verificarSenhaBackend(senha) {
    $.ajax({
      url: $(location).attr("origin") + "/cartonagem-trindade-25/backend/verificar_senha_tecnico.php",
      method: 'POST',
      data: { senha },
      dataType: 'json',
      success: function(data) {
        if (data.status === 'sucesso') {
          // Senha correta - fecha o modal de senha e abre o modal de configurações
          $techPasswordModal[0].close();
          setTimeout(function() {
            $settingsModal[0].showModal();
          }, 100);
        } else {
          // Senha incorreta - mostra o erro
          $passwordError.removeClass('hidden');
          $passwordInput.addClass('input-error');

          // Remove a classe de erro após 3 segundos
          setTimeout(function() {
            $passwordInput.removeClass('input-error');
          }, 3000);
        }
      },
      error: function() {
        console.log('Erro na requisição');
        $passwordError.removeClass('hidden').text('Erro ao verificar a senha. Tente novamente.');
      }
    });
  }

  // Validação da senha
  $btnConfirmar.on('click', function() {
    const userInput = $passwordInput.val();
    verificarSenhaBackend(userInput);
  });

  // Fechar o modal de senha quando cancelar
  $btnCancelar.on('click', function() {
    $passwordInput.val('');
    $techPasswordModal[0].close();
  });

  // Quando clicar em fechar no backdrop
  $backdropClose.on('click', function() {
    $passwordInput.val('');
    $passwordError.addClass('hidden');
  });

  // Fechar o modal de configurações e reiniciar
  $closeModal.on('click', function() {
    setTimeout(function() {
      location.reload();
    }, 100);
  });
});
