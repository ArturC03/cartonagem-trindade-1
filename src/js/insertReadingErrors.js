// IMPORTANT: NÃO ESTÁ A SER UTILIZADO
// Configuração inicial
const ErrorChecker = (() => {
    // Variáveis privadas
    let checkTime = 10 * 1000; // Valor padrão: 10 segundos
    let intervalId = null;
    let isRunning = false;
    let baseUrl = window.location.origin;
    let appPath = '/cartonagem-trindade-25';
    
    // Função para mostrar notificação (comentada no original, mas melhorada aqui)
    const showNotificationWithButton = (title, message, date, id_error) => {
        $('#error-title').text(title);
        $('#error-message').text(message);
        
        $('input[name=error_title]').val(title); 
        $('input[name=error_message]').val(message);
        
        $('#error-btn').click();
        $('.btn-ignore').attr('onclick', 
            `window.location.href = '${baseUrl}${appPath}/backend/update_error_state.php?id_error=${id_error}&date=${encodeURIComponent(date)}&id_state=2&title=${encodeURIComponent(title)}';`
        );
    };
    
    // Função para verificar erros no log
    const checkReadingErrors = () => {
        const url = `${baseUrl}${appPath}/backend/insertReadingErrors.php`;
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            timeout: 30000, // Adicionando timeout de 30 segundos
            success: (data) => {
                try {
                    processErrorData(data);
                } catch (error) {
                    console.error("Erro ao processar a resposta do servidor:", error);
                } finally {
                    scheduleNextCheck();
                }
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("Erro na requisição AJAX:", textStatus, errorThrown);
                scheduleNextCheck();
            }
        });
    };
    
    // Processa os dados de erro retornados
    const processErrorData = (data) => {
        if (!Array.isArray(data) || data.length === 0) {
            console.log("Nenhum erro encontrado na resposta");
            return;
        }
        
        data.forEach(error => {
            // Atualiza o tempo de verificação se disponível
            if (error.check_time && typeof error.check_time === 'number' && error.check_time > 0) {
                checkTime = error.check_time * 1000;
                console.log(`Tempo de verificação atualizado para ${checkTime/1000} segundos`);
            }
            
            // Processa o status do erro
            if (error.status === "added") {
                console.log(`Erro adicionado: ${error.id_error} - ${error.error_date}`);
                
                // Descomentar para ativar notificações
                /*
                if (parseInt(error.id_error) !== 1) {
                    showNotificationWithButton(
                        "Erro Detetado",
                        `Erro de ID ${error.id_error} adicionado na data ${error.error_date}`,
                        error.error_date,
                        error.id_error
                    );
                }
                */
            } else if (error.status === "exists") {
                console.log(`Erro já existe: ${error.id_error} - ${error.error_date}`);
            }
        });
    };
    
    // Agenda a próxima verificação
    const scheduleNextCheck = () => {
        clearTimeout(intervalId);
        intervalId = setTimeout(checkReadingErrors, checkTime);
    };
    
    // API pública
    return {
        // Inicia o verificador de erros
        start: () => {
            if (!isRunning) {
                checkReadingErrors();
                isRunning = true;
                console.log("Sistema de verificação de erros iniciado");
            }
        },
        
        // Para o verificador de erros
        stop: () => {
            if (isRunning) {
                clearTimeout(intervalId);
                isRunning = false;
                console.log("Sistema de verificação de erros parado");
            }
        },
        
        // Configura a URL base e o caminho da aplicação
        configure: (config) => {
            if (config.baseUrl) baseUrl = config.baseUrl;
            if (config.appPath) appPath = config.appPath;
            if (config.initialCheckTime) checkTime = config.initialCheckTime * 1000;
            console.log("Configuração atualizada");
        },
        
        // Retorna o status atual
        getStatus: () => {
            return {
                isRunning,
                checkTime: checkTime / 1000,
                baseUrl,
                appPath
            };
        }
    };
})();

// Inicialização quando o documento estiver pronto
$(document).ready(() => {
    // Opcionalmente pode-se configurar antes de iniciar
    ErrorChecker.configure({ initialCheckTime: 15 });
    
    // Inicia o verificador de erros
    ErrorChecker.start();
});