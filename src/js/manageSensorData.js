var checkTime; // Intervalo de verificação dinâmico
var intervalId; // Variável para armazenar o ID do setTimeout

// Função para verificar a validade dos dados
function checkDataValidity() {
    const url = `${window.location.origin}/cartonagem-trindade-25/backend/manage_sensor_data.php`; // Altere para o caminho correto do PHP
    
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            try {
                // Verifica se a resposta contém dados e extrai o tempo de verificação
                if (Array.isArray(data) && data.length > 0 && data[0].check_time) {
                    checkTime = data[0].check_time * 1000; // Converte para milissegundos
                    
                    console.log(`Próxima verificação em: ${checkTime / 1000} segundos`);

                    // Reinicia o intervalo com o novo valor de checkTime
                    clearTimeout(intervalId); // Limpa o timeout anterior
                    intervalId = setTimeout(checkDataValidity, checkTime); // Inicia o novo timeout
                } else {
                    console.error("Erro: Nenhum valor de tempo foi retornado.");
                }
            } catch (error) {
                console.error("Erro ao processar a resposta do servidor:", error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // console.error("Erro ao verificar a validade dos dados:", textStatus, errorThrown);
            // Reinicia o timeout em caso de erro para tentar novamente
            clearTimeout(intervalId);
            intervalId = setTimeout(checkDataValidity, checkTime);
        }
    });
}

// Chama a função para verificar os dados ao carregar a página
$(document).ready(function() {
    checkDataValidity(); // Chama a função imediatamente
});