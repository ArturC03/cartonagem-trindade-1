$('#submitRecuperar').on('click', function(e) {
    e.preventDefault();
    sendEmail();
});

function sendEmail() {
    $.ajax({
        url: $(location).attr("origin") + "/cartonagem-trindade/backend/send_recovery_email.php",
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
                $('#recoverSuccess')[0].classList.remove('hidden');
                $('#recoverSuccess')[0].classList.add('flex');
            }  else {
                $('#recoverError')[0].classList.remove('hidden');
                $('#recoverError')[0].classList.add('flex');
            }
        }
    });   
}