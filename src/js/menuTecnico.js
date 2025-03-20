
// Configuração das teclas secretas
const secretKeys = ['c', 't'];
let pressedKeys = [];
let sequenceCount = 0;

// Elementos DOM
const techPasswordModal = document.getElementById('tech_password_modal');
const settingsModal = document.getElementById('settings_modal');
const tecForm = document.getElementById('tecForm');
const passwordInput = document.getElementById('tecPassword');
const btnConfirmar = document.getElementById('btnTecnicoConfirmar');
const btnCancelar = document.getElementById('btnTecnicoCancelar');
const closeModal = document.getElementById('clmodal');
const passwordError = document.getElementById('passwordError');
const backdropClose = document.getElementById('backdropClose');

// Event listener para submitir o form quando pressionar Enter
tecForm.addEventListener('submit', function(event) {
  event.preventDefault();
  btnConfirmar.click();
});

// Detector de sequência de teclas
document.addEventListener('keydown', (e) => {
  // Adiciona a tecla Alt ou a tecla pressionada ao array
  if (e.altKey && !pressedKeys.includes('Alt')) {
    pressedKeys.push('Alt');
  } else if (!pressedKeys.includes(e.key.toLowerCase())) {
    pressedKeys.push(e.key.toLowerCase());
  }

  // Verifica se a sequência correta foi pressionada
  if (pressedKeys.length >= secretKeys.length && 
      secretKeys.every((key, index) => pressedKeys.includes(key))) {
    sequenceCount++;
    pressedKeys = []; // Limpa as teclas pressionadas

    if (sequenceCount === 2) {
      // Abre o modal de senha do técnico
      techPasswordModal.showModal();
      passwordInput.focus();
      passwordInput.value = '';
      passwordError.classList.add('hidden');
      sequenceCount = 0; // Reseta o contador de sequência
    }
  }
});

document.addEventListener('keyup', (e) => {
  // Remove a tecla do array quando for solta
  pressedKeys = pressedKeys.filter(key => key !== e.key.toLowerCase() && (e.key !== 'Alt' || key !== 'Alt'));
});

// Validação da senha
btnConfirmar.addEventListener('click', function() {
  const userInput = passwordInput.value;

  if (userInput === 'carTrindade') {
    // Senha correta - fecha o modal de senha e abre o modal de configurações
    techPasswordModal.close();
    setTimeout(() => {
      settingsModal.showModal();
    }, 100);
  } else {
    // Senha incorreta - mostra o erro
    passwordError.classList.remove('hidden');
    passwordInput.classList.add('input-error');
    
    // Remove a classe de erro após 3 segundos
    setTimeout(() => {
      passwordInput.classList.remove('input-error');
    }, 3000);
  }
});

// Fechar o modal de senha quando cancelar
btnCancelar.addEventListener('click', function() {
  passwordInput.value = '';
  techPasswordModal.close();
});

// Quando clicar em fechar no backdrop
backdropClose.addEventListener('click', function() {
  passwordInput.value = '';
  passwordError.classList.add('hidden');
});

// Fechar o modal de configurações e reiniciar
closeModal.addEventListener('click', function() {
  setTimeout(() => {
    location.reload();
  }, 100);
});