var checkTime = 10 * 1000; // Define um valor inicial padrão de 10 segundos
var intervalId; // Variável para armazenar o ID do setTimeout

// Função para exibir o modal com título e mensagem de erro
function showNotificationWithButton(title, message, date, id_error) {
    // Atualiza o título e a mensagem do modal
    $('#error-title').text(title);
    $('#error-message').text(message);
    
    $('input[name=error_title]').val(title); 
    $('input[name=error_message]').val(message); // Corrigido fechamento do seletor

    // Abre o modal
    $('#error-btn').click();
    $('.btn-ignore').attr('onclick', `window.location.href = 'update_error_state.php?id_error=${id_error}&date=${encodeURIComponent(date)}&id_state=2&title=${encodeURIComponent(title)}';`);
}

// Função para verificar erros no log
function checkReadingErrors() {
    const url = `${window.location.origin}/cartonagem-trindade-25/backend/insertReadingErrors.php`;
    // console.log(url);
    
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',  
        success: function(data) {
            try {
                // Verifica se a resposta contém dados
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(function(error) {
                        if (error.check_time) {
                            // Garante que seja convertido para milissegundos e que seja um número válido
                            if (typeof error.check_time === 'number' && error.check_time > 0) {
                                checkTime = error.check_time * 1000; // Converte para milissegundos
                            } else {
                                console.warn("check_time retornado é inválido:", error.check_time);
                            }
                        }

                        if (error.status === "added") {
                            console.log(`Erro adicionado: ${error.id_error} - ${error.error_date}`);
                            if (parseInt(error.id_error) !== 1) { // Garante comparação numérica
                                showNotificationWithButton(
                                    "Erro Detetado",
                                    `Erro de ID ${error.id_error} adicionado na data ${error.error_date}`,
                                    error.error_date,
                                    error.id_error
                                );
                            }
                        } else if (error.status === "exists") {
                            console.log(`Erro já existe: ${error.id_error} - ${error.error_date}`);
                        }
                    });
                } else {
                    // console.log("Nenhum erro encontrado na resposta");
                }

                // Reinicia o intervalo com o novo valor de checkTime
                clearTimeout(intervalId); // Limpa o timeout anterior
                intervalId = setTimeout(checkReadingErrors, checkTime); // Inicia um novo timeout com o novo checkTime

            } catch (error) {
                console.error("Erro ao processar a resposta do servidor:", error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Erro ao verificar erros:", textStatus, errorThrown);
            // Reinicia o timeout mesmo em caso de erro para tentar novamente
            clearTimeout(intervalId);
            intervalId = setTimeout(checkReadingErrors, checkTime);
        }
    });
}

// Chamar a função para verificar erros ao carregar a página
$(document).ready(function() {
    checkReadingErrors(); // Chama a função imediatamente
    intervalId = setTimeout(checkReadingErrors, checkTime); // Repetir a cada X segundos
});