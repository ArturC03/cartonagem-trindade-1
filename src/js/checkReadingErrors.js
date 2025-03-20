// IMPORTANT: NÃO ESTÁ A SER UTILIZADO
// Função para exibir o modal com título e mensagem de erro
function showNotificationWithButton(title, message, errorDate, id_error, id_log, isAuthenticated) {
    $('#error-title').text(title);
    $('#error-message').text(message);
    
    // Preenche os campos do formulário
    $('input[name=error_title]').val(title); 
    $('input[name=error_message]').val(message);
    
    // Exibe os botões de ação apenas se o usuário estiver autenticado
    if (isAuthenticated) {
        // Se o usuário estiver autenticado, os botões de ação são exibidos
        $('.btn-resolve').attr('data-id-log', id_log);
        $('.btn-resolve').attr('data-id-state', 1); // Estado 'Resolvido'
        
        $('.btn-not-resolve').attr('data-id-log', id_log);
        $('.btn-not-resolve').attr('data-id-state', 3); // Estado 'Não Resolvido'
        
        $('.btn-ignore').attr('data-id-log', id_log);
        $('.btn-ignore').attr('data-id-state', 2); // Estado 'Ignorado'
        
    } else {
        // Se o usuário não estiver autenticado, esconde os botões de ação
        $('.btn-resolve').hide();
        $('.btn-not-resolve').hide();
        $('.btn-ignore').hide();
    }
    
    // Exibe o modal
    $('#error-btn').click();
}

// Função para formatar a data (ajustada para o formato 'DD/MM/YYYY HH:mm')
function formatDate(dateStr) {
    const date = new Date(dateStr);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    return `${day}/${month}/${year} ${hours}:${minutes}`;
}

// Função para verificar erros pendentes na base de dados
function checkPendingErrors() {
    $.ajax({
        url: `${window.location.origin}/cartonagem-trindade-25/backend/checkReadingErrors.php`,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            try {
                if (response.success) {
                    if (Array.isArray(response.errors) && response.errors.length > 0) {
                        // Aqui, você verifica se o usuário está autenticado (use a lógica do seu backend)
                        const isAuthenticated = response.isAuthenticated; // Ou use outra forma de saber se o usuário está autenticado

                        // Passa a flag isAuthenticated para a função showNotificationWithButton para cada erro
                        response.errors.forEach(error => {
                            const title = "Erro Pendentes";
                            const message = `${error.error} (Data: ${formatDate(error.error_date)})`;  // Inclui a data na mensagem
                            showNotificationWithButton(
                                title,
                                message,
                                error.error_date,
                                error.id_error,
                                error.id_log,
                                isAuthenticated
                            );
                        });

                        // Exibe a quantidade de erros pendentes com um alert
                        showToast(`Existem ${response.errors.length} erros pendentes no sistema.`, 'warning');
                    }
                } else {
                    if (response.message) {
                        console.warn("Aviso do servidor:", response.message);
                    }
                }
            } catch (error) {
                console.error("Erro ao processar resposta do servidor:", error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Erro ao verificar erros pendentes:", textStatus, errorThrown);
        }
    });
}

// Inicializa os handlers para os botões de ação
$(document).ready(function() {
    checkPendingErrors();
    
    $(document).on('click', '.btn-resolve, .btn-not-resolve, .btn-ignore', function(e) {
        e.preventDefault();
        
        const id_log = $(this).data('id-log');
        const id_state = $(this).data('id-state');
        const $button = $(this);
        
        $button.prop('disabled', true);
        $('#loadingSpinner').removeClass('hidden');
        
        $.ajax({
            url: `${window.location.origin}/cartonagem-trindade-25/backend/update_error_state.php`,
            type: 'POST',
            data: {
                id_log: id_log,
                id_state: id_state
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Removendo showToast, substituindo por alert conforme solicitado
                    showToast('Estado atualizado com sucesso!', 'success');
                    $('#error-modal-close').click();
                } else {
                    showToast(response.message || 'Erro ao atualizar estado', 'error');
                }
            },
            error: function(xhr, status, error) {
                showToast('Erro ao comunicar com o servidor', 'error');
            },
            complete: function() {
                $('#loadingSpinner').addClass('hidden');
                $button.prop('disabled', false);
            }
        });
    });
});
