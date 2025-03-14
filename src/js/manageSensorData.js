// Configuração Global do Sistema de Verificação
window.AppConfig = window.AppConfig || {
    baseUrl: window.location.origin,
    appPath: '/cartonagem-trindade-25',
    services: {
        dataValidity: {
            endpoint: '/backend/manage_sensor_data.php',
            initialCheckTime: 10, // em segundos
            enabled: true,
            timeout: 30000 // timeout da requisição em ms
        },
        errorChecker: {
            endpoint: '/backend/insertReadingErrors.php',
            initialCheckTime: 10, // em segundos
            enabled: true,
            timeout: 30000 // timeout da requisição em ms
        }
        // Outros serviços podem ser adicionados aqui
    }
};

// Sistema de Verificação de Validade de Dados
const DataValidityChecker = (() => {
    // Configuração padrão (será substituída pela externa)
    let config = {
        baseUrl: window.location.origin,
        appPath: '/cartonagem-trindade-25',
        endpoint: '/backend/manage_sensor_data.php',
        initialCheckTime: 10,
        timeout: 30000,
        enabled: true
    };
    
    // Variáveis privadas
    let checkTime;
    let intervalId = null;
    let isRunning = false;
    
    // Função para inicializar com configuração externa
    const initialize = (externalConfig) => {
        // Mescla a configuração externa com a padrão
        if (externalConfig) {
            config = { ...config, ...externalConfig };
        }
        
        // Inicializa o tempo de verificação
        checkTime = config.initialCheckTime * 1000;
        
        console.log("DataValidityChecker inicializado com configuração:", config);
    };
    
    // Função principal para verificar a validade dos dados
    const checkDataValidity = () => {
        const url = `${config.baseUrl}${config.appPath}${config.endpoint}`;
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            timeout: config.timeout,
            success: (data) => {
                try {
                    processValidityData(data);
                } catch (error) {
                    console.error("Erro ao processar a resposta do servidor:", error);
                    scheduleNextCheck();
                }
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("Erro na requisição AJAX:", textStatus, errorThrown);
                scheduleNextCheck();
            }
        });
    };
    
    // Processa os dados de validade retornados
    const processValidityData = (data) => {
        if (!Array.isArray(data) || data.length === 0 || !data[0].check_time) {
            console.error("Erro: Nenhum valor de tempo foi retornado.");
            scheduleNextCheck();
            return;
        }
        
        // Extrai o tempo de verificação
        const newCheckTime = data[0].check_time * 1000; // Converte para milissegundos
        
        // Atualiza o tempo de verificação
        if (newCheckTime > 0) {
            checkTime = newCheckTime;
            console.log(`Próxima verificação em: ${checkTime / 1000} segundos`);
        } else {
            console.warn("Tempo de verificação inválido recebido:", data[0].check_time);
        }
        
        // Programa a próxima verificação
        scheduleNextCheck();
    };
    
    // Agenda a próxima verificação
    const scheduleNextCheck = () => {
        clearTimeout(intervalId);
        intervalId = setTimeout(checkDataValidity, checkTime);
    };
    
    // API pública
    return {
        // Inicializa e configura o verificador
        init: (externalConfig) => {
            initialize(externalConfig);
            return this; // Para permitir encadeamento
        },
        
        // Inicia o verificador de validade
        start: () => {
            if (!isRunning && config.enabled) {
                checkDataValidity();
                isRunning = true;
                console.log("Sistema de verificação de validade de dados iniciado");
            }
            return this; // Para permitir encadeamento
        },
        
        // Para o verificador de validade
        stop: () => {
            if (isRunning) {
                clearTimeout(intervalId);
                isRunning = false;
                console.log("Sistema de verificação de validade de dados parado");
            }
            return this; // Para permitir encadeamento
        },
        
        // Atualiza a configuração em tempo de execução
        updateConfig: (newConfig) => {
            if (newConfig) {
                // Mescla apenas os campos fornecidos
                Object.assign(config, newConfig);
                console.log("Configuração atualizada:", config);
            }
            return this; // Para permitir encadeamento
        },
        
        // Retorna o status atual
        getStatus: () => {
            return {
                isRunning,
                checkTime: checkTime / 1000,
                config: { ...config } // Retorna uma cópia da configuração
            };
        }
    };
})();

// Inicialização quando o documento estiver pronto
$(document).ready(() => {
    // Carrega a configuração global se disponível
    const globalConfig = window.AppConfig?.services?.dataValidity;
    
    // Inicializa e inicia o verificador de validade de dados
    DataValidityChecker
        .init(globalConfig)
        .start();
});

// Exemplo de uso da API para atualizar configuração em runtime
// DataValidityChecker.updateConfig({ initialCheckTime: 20 }).stop().start();