// Função para exibir o modal com título e mensagem de erro
function showNotificationWithButton(title, message, date, id_error) {
    // Atualiza o título e a mensagem do modal
    $('#error-title').text(title);
    $('#error-message').text(message);
    
    $('input[name=error_title]').val(title); 
    $('input[name=error_message').val(message);

    // Abre o modal
    $('#error-btn').click();
    $('.btn-ignore').attr('onclick', "window.location.href = 'update_error_state.php?id_error=" + id_error + "&date=" + encodeURIComponent(date) + "&id_state=2&title=" + encodeURIComponent(title) + "';");

}

// Função para verificar erros no log
function checkReadingErrors() {
    const url = $(location).attr("origin") + "/cartonagem-trindade-25/backend/insertReadingErrors.php";
    console.log(url);
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',  // Alterei para 'json' pois o PHP está retornando um array de objetos JSON
        success: function(data) {
            try {
                // Verifica se a resposta contém dados
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(function(error) {
                        if (error.status === "added") {
                            console.log(`Erro adicionado: ${error.id_error} - ${error.error_date}`);
                            showNotificationWithButton("Erro Detetado", `Erro de ID ${error.id_error} adicionado na data ${error.error_date}`, error.error_date, error.id_error);
                        } else if (error.status === "exists") {
                            console.log(`Erro já existe: ${error.id_error} - ${error.error_date}`);
                        }
                    });
                } else {
                    console.log("Nenhum erro encontrado na resposta");
                }
            } catch (error) {
                console.error("Erro ao processar a resposta do servidor:", error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Erro ao verificar erros:", textStatus, errorThrown);
        }
    });
}

// Chamar a função para verificar erros ao carregar a página
$(document).ready(function() {
    const checkInterval = 10; // segundos
    checkReadingErrors(); // Chama a função imediatamente
    setInterval(checkReadingErrors, checkInterval * 1000); // Repetir a cada X segundos
});
