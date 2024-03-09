function voltarRecuperarPass() {
    const login = document.getElementById("login");
    const recuperarPass = document.getElementById("recuperarPass");
    const flipboxinner = document.getElementById("flipboxinner");

    if (login.classList.contains("active")) {
        login.classList.remove("active");
        recuperarPass.classList.add("active");

        flipboxinner.style.transform = "rotateY(180deg)";
    } else {
        recuperarPass.classList.remove("active");
        login.classList.add("active");

        flipboxinner.style.transform = "rotateY(0deg)"; 
    }
}


function voltarLogin() {
    const login = document.getElementById("login");
    const recuperarPass = document.getElementById("recuperarPass");
    const flipboxinner = document.getElementById("flipboxinner");

    recuperarPass.classList.remove("active");
    login.classList.add("active");

    flipboxinner.style.transform = "rotateY(0deg)"; 
}

$('#submitRecuperar').on('click', function(e) {
    e.preventDefault();
    sendEmail();
});

function sendEmail() {
    $.ajax({
        url: "send_email.php",
        type: "POST",
        dataType: "html",
        data: {
            email: $('#recoverEmail').val(),
            tipo: '1'
        },
        complete(response) {
            var data = JSON.parse(response.responseText);
            if (data.success) {
                $('#recoverEmail').val('');
                $('#message-div')[0].innerHTML = "O email será enviado caso exista um registo com o email informado. Verifique sua caixa de entrada e spam."
            }else {
                $('#message-div')[0].innerHTML = data.message;
            }
        }
    });   
}