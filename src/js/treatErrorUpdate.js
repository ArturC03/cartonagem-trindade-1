// Add this to your existing js/erros.js file or create a new file
$(document).ready(function() {
    // Attach click handlers to action buttons using event delegation
    $(document).on('click', '.estado-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const id_log = $(this).data('id-log');
        const id_state = $(this).data('id-state');
        
        updateErrorState(id_log, id_state, $(this));
    });
});

function updateErrorState(id_log, new_state_id, $button) {
    // Show loading spinner
    $('#loadingSpinner').removeClass('hidden');
    
    // Disable the button to prevent multiple clicks
    $button.prop('disabled', true);
    
    // Make AJAX request
    $.ajax({
        url: `${window.location.origin}/cartonagem-trindade-25/backend/update_error_state.php`,
        type: 'GET',
        data: {
            id_log: id_log,
            id_state: new_state_id
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Update the table row with new state
                // console.log(response);
                updateTableRow(id_log, new_state_id, response.state_name);
                
                // Show success toast
                showToast('Estado atualizado com sucesso!', 'success');
            } else {
                // Show error toast
                showToast(response.message || 'Erro ao atualizar estado', 'error');
            }
        },
        error: function(xhr, status, error) {
            // Show error toast
            showToast('Erro ao comunicar com o servidor', 'error');
            console.error('AJAX Error: ' + status + ' - ' + error);
        },
        complete: function() {
            // Hide loading spinner
            $('#loadingSpinner').addClass('hidden');
            
            // Re-enable the button
            $button.prop('disabled', false);
        }
    });
}

function updateTableRow(id_log, new_state_id, state_name) {
    
    // Encontrar a linha correspondente ao id_log
    const $row = $('table tbody tr').filter(function() {
        const currentId = $(this).find('td:eq(1)').text().trim();  // Procurar pelo id_log na segunda célula
        // console.log("Verificando linha, ID atual:", currentId);
        return currentId == id_log;  // Comparar com o id_log passado
    });

    if ($row.length > 0) {

        // Encontrar o índice escondido na linha correspondente
        const rowIndex = $row.find('input.row-index').val();  // Obter o valor do input hidden

        // Agora podemos usar rowIndex para realizar a atualização correta na tabela, se necessário
        
        // Atualizar o texto do estado (5ª coluna)
        const $stateCell = $row.find('td:eq(4)');
        
        $stateCell.text(state_name || getStateNameById(new_state_id));
        
        // Atualizar os botões de ação na última coluna
        const $actionsCell = $row.find('td:last');
        
        if ($actionsCell.length > 0) {
            // Limpar botões atuais
            $actionsCell.empty();

            // Adicionar novos botões baseados no novo estado
            if (new_state_id == 0) { // Resolvido
                $actionsCell.append(`
                    <a href="javascript:void(0);" class="btn btn-error btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="3">
                        Marcar como Não Resolvido
                    </a>
                `);
            } else if (new_state_id == 1) { // Novo
                $actionsCell.append(`
                    <a href="javascript:void(0);" class="btn btn-success btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="0">
                        Marcar como Resolvido
                    </a>
                    <a href="javascript:void(0);" class="btn btn-error btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="3">
                        Marcar como Não Resolvido
                    </a>
                    <a href="javascript:void(0);" class="btn btn-warning btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="2">
                        Ignorar
                    </a>
                `);
            } else if (new_state_id == 2) { // Ignorado
                $actionsCell.append(`
                    <a href="javascript:void(0);" class="btn btn-success btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="0">
                        Marcar como Resolvido
                    </a>
                    <a href="javascript:void(0);" class="btn btn-error btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="3">
                        Marcar como Não Resolvido
                    </a>
                `);
            } else if (new_state_id == 3) { // Não Resolvido
                $actionsCell.append(`
                    <a href="javascript:void(0);" class="btn btn-success btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="0">
                        Marcar como Resolvido
                    </a>
                    <a href="javascript:void(0);" class="btn btn-warning btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="2">
                        Ignorar
                    </a>
                `);
            }
        } else {
            console.log("Célula de ações não encontrada.");
        }
    } else {
        console.log("Linha com id_log não encontrada:", id_log);
    }
}


// Helper function to get state name by ID
function getStateNameById(state_id) {
    const stateNames = {
        0: 'Resolvido',
        1: 'Novo',
        2: 'Ignorado',
        3: 'Não Resolvido'
    };
    
    return stateNames[state_id] || 'Desconhecido';
}

// Function to show DaisyUI toast notifications
function showToast(message, type = 'info') {
    // Create toast element
    const toastId = 'toast-' + Date.now();
    
    const toastHTML = `
        <div id="${toastId}" class="toast toast-end">
            <div class="alert ${getAlertClass(type)}">
                <span>${message}</span>
            </div>
        </div>
    `;
    
    // Add to DOM
    $('body').append(toastHTML);
    
    // Show the toast
    setTimeout(() => {
        $(`#${toastId}`).addClass('opacity-100');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        $(`#${toastId}`).addClass('opacity-0');
        setTimeout(() => {
            $(`#${toastId}`).remove();
        }, 500);
    }, 3000);
}
