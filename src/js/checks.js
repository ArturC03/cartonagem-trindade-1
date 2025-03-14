// Sistema Unificado de Monitoramento
window.MonitoringSystem = (() => {
    // Registro de verificadores
    const checkers = {};
    
    // Utilitários comuns
    const utils = {
        formatDate: (dateStr) => {
            const date = new Date(dateStr);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${day}/${month}/${year} ${hours}:${minutes}`;
        },
        
        showToast: (message, type) => {
            // Implementação do toast (pode ser adaptada para o seu sistema)
            if (typeof showToast === 'function') {
                showToast(message, type);
            } else {
                console.log(`[${type.toUpperCase()}] ${message}`);
            }
        },
        
        showNotificationWithButton: (title, message, errorDate, id_error, id_log, isAuthenticated) => {
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
    };
    
    // Classe base para verificadores
    class BaseChecker {
        constructor(id, config) {
            this.id = id;
            this.config = {
                baseUrl: window.location.origin,
                appPath: '/cartonagem-trindade-25',
                endpoint: '',
                initialCheckTime: 10,
                timeout: 30000,
                enabled: true,
                ...config
            };
            this.checkTime = this.config.initialCheckTime * 1000;
            this.intervalId = null;
            this.isRunning = false;
        }
        
        start() {
            if (!this.isRunning && this.config.enabled) {
                this.check();
                this.isRunning = true;
                console.log(`Verificador ${this.id} iniciado`);
            }
            return this;
        }
        
        stop() {
            if (this.isRunning) {
                clearTimeout(this.intervalId);
                this.isRunning = false;
                console.log(`Verificador ${this.id} parado`);
            }
            return this;
        }
        
        check() {
            const url = `${this.config.baseUrl}${this.config.appPath}${this.config.endpoint}`;
            
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                timeout: this.config.timeout,
                success: (data) => {
                    try {
                        this.processData(data);
                    } catch (error) {
                        console.error(`Erro ao processar resposta em ${this.id}:`, error);
                    } finally {
                        this.scheduleNextCheck();
                    }
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error(`Erro na requisição AJAX em ${this.id}:`, textStatus, errorThrown);
                    this.scheduleNextCheck();
                }
            });
        }
        
        processData(data) {
            // Implementado nas subclasses
        }
        
        scheduleNextCheck() {
            clearTimeout(this.intervalId);
            this.intervalId = setTimeout(() => this.check(), this.checkTime);
        }
        
        updateConfig(newConfig) {
            if (newConfig) {
                Object.assign(this.config, newConfig);
            }
            return this;
        }
        
        getStatus() {
            return {
                id: this.id,
                isRunning: this.isRunning,
                checkTime: this.checkTime / 1000,
                config: { ...this.config }
            };
        }
    }
    
    // Verificador de Erros de Leitura
    class ErrorChecker extends BaseChecker {
        constructor(id, config) {
            super(id, {
                endpoint: '/backend/insertReadingErrors.php',
                ...config
            });
        }
        
        processData(data) {
            if (!Array.isArray(data) || data.length === 0) {
                console.log(`${this.id}: Nenhum erro encontrado na resposta`);
                return;
            }
            
            data.forEach(error => {
                // Atualiza o tempo de verificação se disponível
                if (error.check_time && typeof error.check_time === 'number' && error.check_time > 0) {
                    this.checkTime = error.check_time * 1000;
                    console.log(`${this.id}: Tempo de verificação atualizado para ${this.checkTime/1000} segundos`);
                }
                
                // Processa o status do erro
                if (error.status === "added") {
                    console.log(`${this.id}: Erro adicionado: ${error.id_error} - ${error.error_date}`);
                    
                    // Implemente a lógica de notificação se necessário
                } else if (error.status === "exists") {
                    console.log(`${this.id}: Erro já existe: ${error.id_error} - ${error.error_date}`);
                }
            });
        }
    }
    
    // Verificador de Validade de Dados
    class DataValidityChecker extends BaseChecker {
        constructor(id, config) {
            super(id, {
                endpoint: '/backend/manage_sensor_data.php',
                ...config
            });
        }
        
        processData(data) {
            if (!Array.isArray(data) || data.length === 0 || !data[0].check_time) {
                console.error(`${this.id}: Erro: Nenhum valor de tempo foi retornado.`);
                return;
            }
            
            const newCheckTime = data[0].check_time * 1000;
            
            if (newCheckTime > 0) {
                this.checkTime = newCheckTime;
                console.log(`${this.id}: Próxima verificação em: ${this.checkTime / 1000} segundos`);
            } else {
                console.warn(`${this.id}: Tempo de verificação inválido recebido:`, data[0].check_time);
            }
        }
    }
    
    // Verificador de Erros Pendentes
    class PendingErrorsChecker extends BaseChecker {
        constructor(id, config) {
            super(id, {
                endpoint: '/backend/checkReadingErrors.php',
                ...config
            });
        }
        
        processData(response) {
            try {
                if (response.success) {
                    if (Array.isArray(response.errors) && response.errors.length > 0) {
                        // Verifica se o usuário está autenticado
                        const isAuthenticated = response.isAuthenticated;
                        
                        // Processa cada erro
                        response.errors.forEach(error => {
                            const title = "Erro Pendente";
                            const message = `${error.error} (Data: ${utils.formatDate(error.error_date)})`;
                            
                            utils.showNotificationWithButton(
                                title,
                                message,
                                error.error_date,
                                error.id_error,
                                error.id_log,
                                isAuthenticated
                            );
                        });
                        
                        // Exibe a quantidade de erros pendentes
                        utils.showToast(`Existem ${response.errors.length} erros pendentes no sistema.`, 'warning');
                    } else {
                        console.log(`${this.id}: Nenhum erro pendente encontrado`);
                    }
                } else {
                    if (response.message) {
                        console.warn(`${this.id}: Aviso do servidor:`, response.message);
                    }
                }
            } catch (error) {
                console.error(`${this.id}: Erro ao processar resposta:`, error);
            }
        }
    }
    
    // Inicializa os handlers para os botões de ação
    const initializeErrorHandlers = () => {
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
                        utils.showToast('Estado atualizado com sucesso!', 'success');
                        $('#error-modal-close').click();
                    } else {
                        utils.showToast(response.message || 'Erro ao atualizar estado', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    utils.showToast('Erro ao comunicar com o servidor', 'error');
                },
                complete: function() {
                    $('#loadingSpinner').addClass('hidden');
                    $button.prop('disabled', false);
                }
            });
        });
    };
    
    // API pública
    return {
        // Inicializa o sistema com as configurações globais
        init: (config) => {
            // Inicializa os handlers para os botões de ação
            initializeErrorHandlers();
            
            // Retorna a instância para encadeamento
            return MonitoringSystem;
        },
        
        // Registra e inicia um novo verificador de erros
        createErrorChecker: (id, config) => {
            if (checkers[id]) {
                console.warn(`Verificador com ID '${id}' já existe. Retornando instância existente.`);
                return checkers[id];
            }
            
            checkers[id] = new ErrorChecker(id, config);
            return checkers[id];
        },
        
        // Registra e inicia um novo verificador de validade de dados
        createDataValidityChecker: (id, config) => {
            if (checkers[id]) {
                console.warn(`Verificador com ID '${id}' já existe. Retornando instância existente.`);
                return checkers[id];
            }
            
            checkers[id] = new DataValidityChecker(id, config);
            return checkers[id];
        },
        
        // Registra e inicia um novo verificador de erros pendentes
        createPendingErrorsChecker: (id, config) => {
            if (checkers[id]) {
                console.warn(`Verificador com ID '${id}' já existe. Retornando instância existente.`);
                return checkers[id];
            }
            
            checkers[id] = new PendingErrorsChecker(id, config);
            return checkers[id];
        },
        
        // Recupera um verificador existente por ID
        getChecker: (id) => {
            return checkers[id] || null;
        },
        
        // Inicia todos os verificadores registrados
        startAll: () => {
            Object.values(checkers).forEach(checker => checker.start());
            return MonitoringSystem;
        },
        
        // Para todos os verificadores registrados
        stopAll: () => {
            Object.values(checkers).forEach(checker => checker.stop());
            return MonitoringSystem;
        },
        
        // Lista todos os verificadores registrados
        listAll: () => {
            return Object.keys(checkers).map(id => checkers[id].getStatus());
        },
        
        // Utilitários expostos
        utils: utils
    };
})();

// Inicialização quando o documento estiver pronto
$(document).ready(() => {
    // Inicializa o sistema
    window.MonitoringSystem.init();
    
    // Cria e inicia os verificadores
    const errorChecker = window.MonitoringSystem.createErrorChecker('errorChecker', {
        // Configurações opcionais
    }).start();
    
    const dataValidityChecker = window.MonitoringSystem.createDataValidityChecker('dataValidityChecker', {
        // Configurações opcionais
    }).start();
    
    const pendingErrorsChecker = window.MonitoringSystem.createPendingErrorsChecker('pendingErrorsChecker', {
        // Configurações opcionais
    }).start();
    
    // Exibe o status de todos os verificadores
    console.log("Verificadores ativos:", window.MonitoringSystem.listAll());
});