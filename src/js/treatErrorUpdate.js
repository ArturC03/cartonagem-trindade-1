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
    // Find the row with the matching id_log
    const $row = $('table tbody tr').filter(function() {
        return $(this).find('td:first').text() == id_log;
    });
    
    if ($row.length > 0) {
        // Update the state text (5th column)
        $row.find('td:eq(4)').text(state_name || getStateNameById(new_state_id));
        
        // Update action buttons in the last column
        const $actionsCell = $row.find('td:last');
        if ($actionsCell.length > 0) {
            // Clear current buttons
            $actionsCell.empty();
            
            // Add new buttons based on the state
            if (new_state_id == 0) { // Resolvido
                $actionsCell.append(`
                    <a href="#" class="btn btn-error btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="3">
                        Marcar como Não Resolvido
                    </a>
                `);
            } else if (new_state_id == 1) { // Novo
                $actionsCell.append(`
                    <a href="#" class="btn btn-success btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="0">
                        Marcar como Resolvido
                    </a>
                    <a href="#" class="btn btn-error btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="3">
                        Marcar como Não Resolvido
                    </a>
                    <a href="#" class="btn btn-warning btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="2">
                        Ignorar
                    </a>
                `);
            } else if (new_state_id == 2) { // Ignorado
                $actionsCell.append(`
                    <a href="#" class="btn btn-success btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="0">
                        Marcar como Resolvido
                    </a>
                    <a href="#" class="btn btn-error btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="3">
                        Marcar como Não Resolvido
                    </a>
                `);
            } else if (new_state_id == 3) { // Não Resolvido
                $actionsCell.append(`
                    <a href="#" class="btn btn-success btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="0">
                        Marcar como Resolvido
                    </a>
                    <a href="#" class="btn btn-warning btn-sm estado-btn" 
                       data-id-log="${id_log}" data-id-state="2">
                        Ignorar
                    </a>
                `);
            }
        }
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

// Helper function to get DaisyUI alert class based on type
function getAlertClass(type) {
    switch (type) {
        case 'success': return 'alert-success';
        case 'error': return 'alert-error';
        case 'warning': return 'alert-warning';
        default: return 'alert-info';
    }
}