/*// Função para buscar erros não resolvidos
function fetchUnresolvedErrors() {
    // URL do arquivo PHP que retorna os erros
    const url = $(location).attr("origin") + "/cartonagem-trindade-25/backend/checkReadingErrors.php";

    // Fazer a requisição AJAX usando jQuery
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Verificar se há erros
            if (Array.isArray(data) && data.length > 0) {
                // Exibir os erros na página
                displayErrors(data);
            } else if (data.message) {
                // Exibir a mensagem quando não há erros
                displayMessage(data.message);
            } else {
               // Caso inesperado
                displayMessage("Erro ao processar a resposta do servidor.");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(url);
            console.error("Erro ao buscar erros:", textStatus, errorThrown);
            displayMessage("Erro na requisição. Tente novamente mais tarde.");
        }
    });
}

// Função para exibir os erros como toasts
function displayErrors(errors) {
    errors.forEach(error => {
        const toastElement = $(`
            <div class="toast">
                <div class="alert alert-error">
                    <span>
                        Erro ID: ${error.id_error}, 
                        Código: ${error.error_code}, 
                        Mensagem: ${error.error_message}
                    </span>
                    <button class="btn btn-sm btn-error" onclick="goToErrors()">Ir para a aba de erros</button>
                </div>
            </div>
        `);
        $('body').append(toastElement); // Adiciona o toast ao corpo da página
        setTimeout(() => {
            toastElement.remove(); // Remove o toast após 5 segundos
        }, 5000);
    });
}

// Função para exibir mensagens
function displayMessage(message) {
    const messageContainer = $('#messageContainer');
    messageContainer.html(message); // Exibir mensagem
}

// Função para redirecionar para a aba de erros
function goToErrors() {
    // Redirecionar para a aba de erros
    window.location.href = '/cartonagem-trindade-25/erros.php'; // Ajuste o caminho conforme necessário
}

// Chamar a função para buscar erros ao carregar a página
$(document).ready(function() {
    const checkInterval = 10; 

    fetchUnresolvedErrors(); // Chama a função imediatamente
    setInterval(fetchUnresolvedErrors, checkInterval * 1000); // Repetir a cada X segundos
});
*/