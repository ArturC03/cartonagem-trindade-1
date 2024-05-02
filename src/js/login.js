$('#submitLogin').on('click', function(e) {
    e.preventDefault();
    loginAJAX();
});

function loginAJAX() {
    $.ajax({
        url: $(location).prop('href') + "backend/treat_login.php",
        type: "POST",
        dataType: "html",
        data: {
            username: $('#username').val(),
            password: $('#password').val()
        },
        complete(response) {
            var data = JSON.parse(response.responseText);
            if (data.success) {
                document.location.href = "index.php";
            }  else {
                $('#loginError')[0].classList.remove('hidden');
                $('#loginError')[0].classList.add('flex');
            }
        }
    });   
}