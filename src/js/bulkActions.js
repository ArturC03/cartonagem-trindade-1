$(document).ready(function() {
    // Estado das seleções
    let selectedItems = new Set();
    
    // Selecionar/desselecionar todos
    $('#selectAll').on('change', function() {
        const isChecked = $(this).prop('checked');
        
        // Atualizar todas as checkboxes
        $('.row-checkbox').prop('checked', isChecked);
        
        // Limpar ou preencher o conjunto de itens selecionados
        selectedItems.clear();
        
        if (isChecked) {
            // Adicionar todos os IDs ao conjunto
            $('.row-checkbox').each(function() {
                selectedItems.add($(this).data('id-log'));
            });
        }
        
        // Atualizar contagem e estado do botão
        updateSelectionStatus();
    });
    
    // Gestão de checkboxes individuais
    $(document).on('change', '.row-checkbox', function() {
        const id = $(this).data('id-log');
        
        if ($(this).prop('checked')) {
            selectedItems.add(id);
        } else {
            selectedItems.delete(id);
            // Desmarcar o "selecionar todos" se algum estiver desmarcado
            $('#selectAll').prop('checked', false);
        }
        
        // Atualizar contagem e estado do botão
        updateSelectionStatus();
    });
    
    // Atualizar contagem e estado do botão
    function updateSelectionStatus() {
        const count = selectedItems.size;
        $('#selectedCount').text(`${count} ${count === 1 ? 'item selecionado' : 'itens selecionados'}`);
        
        // Mostrar ou ocultar os controles de ação em massa
        if (count > 0) {
            $('#bulkActionControls').removeClass('hidden');
        } else {
            $('#bulkActionControls').addClass('hidden');
        }
        
        // Habilitar/desabilitar o botão de aplicar
        $('#applyBulkAction').prop('disabled', count === 0 || $('#bulkAction').val() === '');
    }
    
    // Alteração no dropdown de ação
    $('#bulkAction').on('change', function() {
        updateSelectionStatus();
    });
    
    // Aplicar ação em massa
    $('#applyBulkAction').on('click', function() {
        if (selectedItems.size === 0 || $('#bulkAction').val() === '') {
            return;
        }
        
        const newState = $('#bulkAction').val();
        const itemArray = Array.from(selectedItems);
        
        // Mostrar confirmação
        if (!confirm(`Deseja realmente alterar o estado de ${itemArray.length} itens?`)) {
            return;
        }
        
        // Mostrar loading spinner
        $('#loadingSpinner').removeClass('hidden');
        
        // Desabilitar botão durante o processamento
        $(this).prop('disabled', true);
        
        // Fazer requisição de atualização em massa
        $.ajax({
            url: `${window.location.origin}/cartonagem-trindade-25/backend/bulk_update_error_state.php`,
            type: 'POST',
            data: {
                id_logs: itemArray,
                id_state: newState
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Atualizar as linhas da tabela com novos estados
                    updateBulkTableRows(itemArray, newState, response.state_name);
                    
                    // Limpar seleções
                    selectedItems.clear();
                    $('.row-checkbox').prop('checked', false);
                    $('#selectAll').prop('checked', false);
                    updateSelectionStatus();
                    
                    // Resetar o dropdown
                    $('#bulkAction').val('');
                    
                    // Mostrar toast de sucesso
                    showToast(`${itemArray.length} itens atualizados com sucesso!`, 'success');
                } else {
                    // Mostrar toast de erro
                    showToast(response.message || 'Erro ao atualizar itens', 'error');
                }
            },
            error: function(xhr, status, error) {
                // Mostrar toast de erro
                showToast('Erro ao comunicar com o servidor', 'error');
                console.error('AJAX Error: ' + status + ' - ' + error);
            },
            complete: function() {
                // Esconder loading spinner
                $('#loadingSpinner').addClass('hidden');
                
                // Re-habilitar botão
                $('#applyBulkAction').prop('disabled', false);
            }
        });
    });
    
    // Função para atualizar múltiplas linhas da tabela
    function updateBulkTableRows(idLogs, newStateId, stateName) {
        idLogs.forEach(id_log => {
            updateTableRow(id_log, newStateId, stateName);
        });
    }
});