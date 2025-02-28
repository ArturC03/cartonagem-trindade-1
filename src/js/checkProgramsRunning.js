var checkTime = 10 * 1000; // Define um valor inicial padrão de 10 segundos
var intervalId; // Variável para armazenar o ID do setInterval

$(document).ready(function() {
    function checkServerStatus() {
        $.ajax({
            url: "./backend/check_programs_running.php", // URL para checar o status dos programas
            type: "GET",
            dataType: "json",
            success: function(data) {

                // Verificar se MySQL ou COM3 não estão em funcionamento
                if (data.mysql !== 'running') {
                    // Tentativa de executar o MySQL
                    $.ajax({
                        url: "./backend/start_program.php",
                        type: "GET",
                        data: { program: 'mysql' },
                        success: function(response) {
                            if (response.success) {
                                alert("MySQL foi iniciado com sucesso!");
                            } else {
                                alert("Não foi possível iniciar o MySQL.");
                            }
                        },
                        error: function() {
                            alert("Erro ao tentar iniciar o MySQL.");
                        }
                    });
                }

                if (data.com3 !== 'occupied') {
                    // Tentativa de executar a porta COM3
                    $.ajax({
                        url: "./backend/start_program.php",
                        type: "GET",
                        data: { program: 'com3' },
                        success: function(response) {
                            if (response.success) {
                                console.log("Porta COM3 foi ocupada com sucesso!");
                            } else {
                                console.log("Não foi possível ocupar a Porta COM3.");
                            }
                        },
                        error: function() {
                            console.log("Erro ao tentar ocupar a Porta COM3.");
                        }
                    });
                }

                // Atualiza o tempo de verificação com base no valor retornado pelo servidor
                checkTime = data.checkTime * 1000; // Converte para milissegundos
                console.log(`Tempo de verificação do status dos programas atualizado: ${checkTime}ms`);

                // Reinicia o intervalo com o novo valor de checkTime
                clearInterval(intervalId); // Limpa o intervalo anterior
                intervalId = setInterval(checkServerStatus, checkTime); // Inicia o novo intervalo
            },
            error: function() {
                alert("Erro ao carregar status dos programas.");
            }
        });
    }

    // Chama a função para verificar o status inicialmente
    checkServerStatus();
    // Inicia o intervalo com o valor inicial de checkTime
    intervalId = setInterval(checkServerStatus, checkTime);
});
