const secretKeys = ['c', 't'];
const btnConfirmar = document.getElementById('btnTecnicoConfirmar');
const btnCancelar = document.getElementById('btnTecnicoCancelar');
const element = document.getElementById('inputTecPass');
const closemodal = document.getElementById('clmodal');
const passOpcTecInput = document.getElementById('tecPassword');
const form = document.getElementById('tecForm');


const notificationDiv = document.createElement('div');
    notificationDiv.className = 'float-left z-10 toast toast-center';
  
    const alertDiv = document.createElement('div');
    alertDiv.role = 'alert';
    alertDiv.className = 'alert alert-error justify-center items-center';
    alertDiv.id = 'notification';
  
    const spanText = document.createElement('span');
    spanText.textContent = 'Palavra-passe Incorreta';
  
    alertDiv.appendChild(spanText);
    notificationDiv.appendChild(alertDiv);

let pressedKeys = [];
let sequenceCount = 0;


form.addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the default form submission behavior
  btnConfirmar.click();
});

document.addEventListener('keydown', (e) => {
  if (e.altKey) pressedKeys.push('Alt');
  else pressedKeys.push(e.key.toLowerCase());

  if (pressedKeys.join(',') === secretKeys.join(',')) {
    sequenceCount++;
    pressedKeys = []; // Reset the pressed keys array

    if (sequenceCount === 2) {
      console.log('Secret shortcut unlocked!');
      if (element) {
        element.classList.remove('hidden');
        passOpcTecInput.focus();
        passOpcTecInput.value = '';
      }
      sequenceCount = 0; // Reset the sequence count
    }
  }
});

document.addEventListener('keyup', (e) => {
  pressedKeys = pressedKeys.filter(key => key !== e.key.toLowerCase() && key !== 'Alt');
});

btnConfirmar.addEventListener('click', function() {
  const userInput = passOpcTecInput.value;

  if (userInput === 'carTrindade') {
    const modal = document.getElementById('my_modal_4');
    modal.showModal();
    
  } else {

    document.body.appendChild(notificationDiv); // add the notification div to the page
  
    // Remove // 3000ms = 3 seconds
  }
});

if(document.getElementById('notification') !== null) {
  setTimeout(() => {
    document.body.removeChild(notificationDiv);
  }, 3000); // 3000ms = 3 seconds
}


btnCancelar.addEventListener('click', function() {
  if (element) {
    passOpcTecInput.value = '';
    element.classList.add('hidden');
  }
});

closemodal.addEventListener('click', function()
{
  const tecard = document.getElementById('tecard');
  passOpcTecInput.value = '';
  tecard.classList.add('hidden');
  location.reload();
});