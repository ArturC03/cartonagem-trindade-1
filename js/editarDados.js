var myInput = document.getElementById("new-password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.add("done");
  } else {
    letter.classList.remove("done");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.add("done");
  } else {
    capital.classList.remove("done");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.add("done");
  } else {
    number.classList.remove("done");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.add("done");
  } else {
    length.classList.remove("done");
  }
}

var confirm_password = document.getElementById("confirm-password");

function validatePassword(){
  if(myInput.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

myInput.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;