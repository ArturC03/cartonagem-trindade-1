var myInput = document.getElementById("new-password");

myInput.oninput = function() {
  var validityMessage = "";
  var lowerCaseLetters = /[a-z]/g;
  var upperCaseLetters = /[A-Z]/g;
  var numbers = /[0-9]/g;

  if(!myInput.value.match(lowerCaseLetters)) {  
    validityMessage = "Tem de conter pelo menos uma letra minúscula.";
  } else if(!myInput.value.match(upperCaseLetters)) {  
    validityMessage = "Tem de conter pelo menos uma letra maiúscula.";
  } else if(!myInput.value.match(numbers)) {  
    validityMessage = "Tem de conter pelo menos um número.";
  } else if(myInput.value.length < 8) {
    validityMessage = "Tem de conter pelo menos 8 carateres.";
  }

  myInput.setCustomValidity(validityMessage);
}

var confirm_password = document.getElementById("confirm-password");

function validatePassword(){
  if(myInput.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords não correspondem");
  } else {
    confirm_password.setCustomValidity('');
  }
}

myInput.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;