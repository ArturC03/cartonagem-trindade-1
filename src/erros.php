<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'includes/config.inc.php';
include 'content/header.inc.php';

// Definir colunas permitidas para ordenação
$allowed_columns = ['id_log', 'id_error', 'error_date', 'username', 'state'];
$allowed_orders = ['ASC', 'DESC'];

// Obter parâmetros da URL com validação
$column = isset($_GET['sort']) && in_array($_GET['sort'], $allowed_columns) ? $_GET['sort'] : 'error_date';
$order = isset($_GET['order']) && in_array($_GET['order'], $allowed_orders) ? $_GET['order'] : 'DESC';

// Obter parâmetros de filtro
$filter_id_log = isset($_GET['filter_id_log']) ? $_GET['filter_id_log'] : '';
$filter_id_error = isset($_GET['filter_id_error']) ? $_GET['filter_id_error'] : '';
$filter_username = isset($_GET['filter_username']) ? $_GET['filter_username'] : '';
$filter_state = isset($_GET['filter_state']) ? $_GET['filter_state'] : '';

// Obter estados possíveis para o filtro
$states_result = my_query("SELECT id, state FROM error_state");
$states = [];
foreach ($states_result as $state) {
    $states[] = $state;
}

// Construir consulta SQL com filtros dinâmicos
$sql = "SELECT l.id_log, l.id_error, l.error_date, u.username, e.id AS state_id, e.state
        FROM error_log AS l
        LEFT JOIN error_state AS e ON l.error_state_id = e.id
        LEFT JOIN user AS u ON l.id_user = u.id_user
        WHERE 1=1";  // Adiciona condição para garantir que a consulta sempre retorna algo

// Adiciona filtros ao SQL
if ($filter_id_log) {
    $sql .= " AND l.id_log = ".my_escape_string((int)$filter_id_log);
}
if ($filter_id_error) {
    $sql .= " AND l.id_error = " . my_escape_string($filter_id_error);
}
if ($filter_username) {
    $sql .= " AND u.username LIKE '%" . my_escape_string($filter_username) . "%'";
}
if ($filter_state) {
    $sql .= " AND e.state LIKE '" . my_escape_string($filter_state) . "'";
}

// Adiciona ordenação
$sql .= " ORDER BY $column $order";

$result = my_query($sql);

$res = my_query("SELECT id_type FROM user WHERE id_user =". (int)$_SESSION['username']);
$id_type = $res[0]['id_type'];
?>

<div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
    <div class="card w-[90%] h-[80vh] bg-base-300 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <h2 class="card-title">Logs de Erros</h2>
            </div>

            <!-- formulário de Filtro -->
            <form method="GET" class="flex space-x-4">
                <div class="flex mb-4 space-x-4" style="flex-wrap:wrap;">
                <div class="mr-4">
    <input type="text" name="filter_id_log" placeholder="ID Log" value="<?php echo htmlspecialchars($filter_id_log); ?>" class="input input-sm" />
</div>
<div class="mx-4">
    <input type="text" name="filter_id_error" placeholder="ID Erro" value="<?php echo htmlspecialchars($filter_id_error); ?>" class="input input-sm" />
</div>
<div class="mr-4">
    <input type="text" name="filter_username" placeholder="Utilizador" value="<?php echo htmlspecialchars($filter_username); ?>" class="input input-sm" />
</div>

<!-- Filtro por estado como select -->
<div class="mx-4">
    <select name="filter_state" class="input input-sm">
        <option value="">Selecione o estado</option>
        <?php foreach ($states as $state): ?>
            <option value="<?php echo $state['state']; ?>" <?php echo $state['state'] === $filter_state ? 'selected' : ''; ?>><?php echo $state['state']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<button type="submit" class="btn  btn-primary">
            <i class="fas fa-filter"></i> <!-- Ícone do Font Awesome para filtro -->
            Filtrar
        </button>
               </div>
            </form>

            <div class="overflow-x-auto max-h-[50vh] md:max-h-[60vh]" id="table_body">
                <table class="table table-pin-rows table-zebra">
                    <thead>
                        <tr>
                            <th>
                                <a href="?sort=id_log&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>" class="flex items-center space-x-2">
                                    <span>ID Log</span>
                                    <?php if ($column === 'id_log'): ?>
                                        <i class="fas fa-arrow-<?php echo $order === 'ASC' ? 'up' : 'down'; ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?sort=id_error&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>" class="flex items-center space-x-2">
                                    <span>ID Erro</span>
                                    <?php if ($column === 'id_error'): ?>
                                        <i class="fas fa-arrow-<?php echo $order === 'ASC' ? 'up' : 'down'; ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?sort=error_date&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>" class="flex items-center space-x-2">
                                    <span>Data Erro</span>
                                    <?php if ($column === 'error_date'): ?>
                                        <i class="fas fa-arrow-<?php echo $order === 'ASC' ? 'up' : 'down'; ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?sort=username&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>" class="flex items-center space-x-2">
                                    <span>Utilizador</span>
                                    <?php if ($column === 'username'): ?>
                                        <i class="fas fa-arrow-<?php echo $order === 'ASC' ? 'up' : 'down'; ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?sort=state&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>" class="flex items-center space-x-2">
                                    <span>Estado Erro</span>
                                    <?php if ($column === 'state'): ?>
                                        <i class="fas fa-arrow-<?php echo $order === 'ASC' ? 'up' : 'down'; ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <?php if ($id_type == 1) { ?>
                                <th>Ações</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($result as $row){ ?>
                            <tr ondblclick="openModal(<?php echo $row['id_log']; ?>)" style="cursor: pointer;">
                                <td><?php echo $row['id_log']; ?></td>
                                <td><?php echo $row['id_error']; ?></td>
                                <td><?php echo $row['error_date']; ?></td>
                                <td><?php echo $row['username'] ?? 'na'; ?></td>
                                <td><?php echo $row['state']; ?></td>
<?php if ($id_type == 1) { ?>
    <td>
        <?php if ($row['state_id'] == 0) { ?>
            <a href="#" class="btn btn-error btn-sm estado-btn" 
               data-id-log="<?php echo $row['id_log']; ?>" data-id-state="3">
                Marcar como Não Resolvido
            </a>
        <?php } elseif ($row['state_id'] == 1) { ?>
            <a href="#" class="btn btn-success btn-sm estado-btn" 
               data-id-log="<?php echo $row['id_log']; ?>" data-id-state="0">
                Marcar como Resolvido
            </a>
            <a href="#" class="btn btn-error btn-sm estado-btn" 
               data-id-log="<?php echo $row['id_log']; ?>" data-id-state="3">
                Marcar como Não Resolvido
            </a>
            <a href="#" class="btn btn-warning btn-sm estado-btn" 
               data-id-log="<?php echo $row['id_log']; ?>" data-id-state="2">
                Ignorar
            </a>
        <?php } elseif ($row['state_id'] == 2) { ?>
            <a href="#" class="btn btn-success btn-sm estado-btn" 
               data-id-log="<?php echo $row['id_log']; ?>" data-id-state="0">
                Marcar como Resolvido
            </a>
            <a href="#" class="btn btn-error btn-sm estado-btn" 
               data-id-log="<?php echo $row['id_log']; ?>" data-id-state="3">
                Marcar como Não Resolvido
            </a>
        <?php } elseif ($row['state_id'] == 3) { ?>
            <a href="#" class="btn btn-success btn-sm estado-btn" 
               data-id-log="<?php echo $row['id_log']; ?>" data-id-state="0">
                Marcar como Resolvido
            </a>
            <a href="#" class="btn btn-warning btn-sm estado-btn" 
               data-id-log="<?php echo $row['id_log']; ?>" data-id-state="2">
                Ignorar
            </a>
        <?php } ?>
    </td>
<?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-sm text-gray-700 mt-4">
                <p><strong>Nota:</strong> Clique duas vezes sobre um registro para visualizar os detalhes do erro.</p>
            </div>
        </div>
    </div>
</div>


<!-- Detalhes do Erro -->
<div class="modal" id="errorModal">
    <div class="modal-box w-full max-w-full flex flex-col p-0 m-0">
        <div class="flex justify-between items-center bg-gray-800 text-white p-4">
            <h3 class="font-bold text-xl" id="log_title"></h3>
            <button class="btn btn-sm btn-circle btn-ghost text-white" onclick="closeModal()">✕</button>
        </div>

        <!-- Aqui iremos injetar o conteúdo carregado via AJAX -->
        <div id="modalContent" class="w-full h-full overflow-y-auto p-4">
            <!-- Conteúdo carregado dinamicamente será injetado aqui -->
        </div>
    </div>
</div>
<div class="fixed top-1/2 left-1/2 z-10 hidden" id="loadingSpinner">
    <span class="loading loading-ring loading-lg"></span>
</div>

<script src="js/erros.js"></script>
<script src="js/treatErrorUpdate.js"></script>

<script>
    function filterTable() {
        let column = document.getElementById('column').value;
        let order = document.getElementById('order').value;
        window.location.href = window.location.pathname + `?sort=${column}&order=${order}`;
    }
</script>

<?php
require 'content/footer.inc.php';
?>
