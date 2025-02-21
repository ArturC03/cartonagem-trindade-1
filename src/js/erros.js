// Função para abrir o modal e carregar o conteúdo via AJAX
function openModal(id_log) {
    // Mostrar o spinner de carregamento
    document.getElementById('loadingSpinner').classList.remove('hidden');

    // Fazer o AJAX para pegar os dados de erro.php
    $.ajax({
        url: './backend/erro.php', // Carregar a página erro.php
        type: 'GET', // Tipo de requisição
        data: { id_log: id_log },
        dataType: 'json',
        success: function(response) {
            const logChanges = response.log_changes;
            console.log(response);

            // Definir título do modal
            $('#log_title').text(`Detalhes: Log ${response.error.id_log}`);

            // Definir conteúdo inicial do modal
            let modalContent = `
                <div class="block px-4 mx-4">
                    <p><strong>Mensagem: </strong>${response.error.error}</p>
                    <p><strong>Erro detectado em: </strong>${new Date(response.error.error_date).toLocaleString()}</p>
                    <br>
`;

if (response.log_changes.length > 0) {
    modalContent += `                    <h2 class="font-bold text-xl">Alterações</h2>`;
}
            modalContent += `                        </div>
                <div class="overflow-y-auto max-h-[60vh] flex items-center align-middle" style="flex-wrap:wrap; align-self:center">`;
            // Preencher histórico de mudanças
            logChanges.forEach(change => {
                modalContent += `
                    <div class="flex items-center space-x-4">
                        <div class="p-4 bg-gray-200 rounded-lg shadow-md">
                            <p><strong>${change.username}</strong></p>
                            <p class="text-sm text-gray-600"><strong>Estado: </strong>${change.state}</p>
                            <p class="text-xs text-gray-500">${new Date(change.change_date).toLocaleString()}</p>
                        </div>
                        <div class="text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </div>
                `;
            });

            // Fechar a div que estava aberta para o histórico de mudanças
            modalContent += `</div>`; // Esta linha fecha a div do histórico de mudanças

            // Injetar o conteúdo no modal
            document.getElementById('modalContent').innerHTML = modalContent;

            // Abrir o modal
            document.getElementById('errorModal').classList.add('modal-open');
        },
        error: function() {
            alert('Erro ao carregar os detalhes do erro');
        },
        complete: function() {
            // Esconder o spinner de carregamento após a resposta
            document.getElementById('loadingSpinner').classList.add('hidden');
        }
    });
}

// Função para fechar o modal
function closeModal() {
    // Remover a classe para fechar o modal
    document.getElementById('errorModal').classList.remove('modal-open');

    // Limpar o conteúdo do modal
    document.getElementById('modalContent').innerHTML = '';

    // Limpar o título do modal
    document.getElementById('log_title').innerHTML = '';
}
