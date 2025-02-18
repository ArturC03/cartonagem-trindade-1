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
$order = isset($_GET['order']) && in_array($_GET['order'], $allowed_orders) ? $_GET['order'] : 'ASC';

// Consulta com ordenação dinâmica
$sql = "SELECT l.id_log, l.id_error, l.error_date, u.username, e.id AS state_id, e.state
FROM error_log AS l
LEFT JOIN error_state AS e ON l.error_state_id = e.id
LEFT JOIN user AS u ON l.id_user = u.id_user
ORDER BY $column $order";
$result = my_query($sql);

$res = my_query("SELECT id_type FROM user WHERE id_user =". (int)$_SESSION['username']);
$id_type = $res[0]['id_type'];
?>

<div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
    <div class="card w-[90%] h-[80vh] bg-base-300 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <h2 class="card-title">Logs de Erros</h2>
                <a href="search_logs.php" class="btn btn-sm btn-circle btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                </a>
            </div>

            <div class="overflow-x-auto max-h-[50vh] md:max-h-[60vh]" id="table_body">
                <table class="table table-pin-rows table-zebra">
                    <thead>
                        <tr>
                            <th>ID Log</th>
                            <th>ID Erro</th>
                            <th>Data Erro</th>
                            <th>Utilizador</th>
                            <th>Estado Erro</th>
                            <?php if ($id_type == 1) { ?>
                                <th>Ações</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($result as $row){ ?>
                            <tr>
                                <td><?php echo $row['id_log']; ?></td>
                                <td><?php echo $row['id_error']; ?></td>
                                <td><?php echo $row['error_date']; ?></td>
                                <td><?php echo $row['username'] ?? 'na'; ?></td>
                                <td><?php echo $row['state']; ?></td>
                                <?php if ($id_type == 1) { ?>
                                    <td>
                                        <?php if ($row['state_id'] == 0) { ?>
                                            <a href="update_error_state.php?id_log=<?php echo $row['id_log']; ?>&id_state=3" class="btn btn-error btn-sm">Marcar como Não Resolvido</a>
                                        <?php } elseif ($row['state_id'] == 1) { ?>
                                            <a href="update_error_state.php?id_log=<?php echo $row['id_log']; ?>&id_state=0" class="btn btn-success btn-sm">Marcar como Resolvido</a>
                                            <a href="update_error_state.php?id_log=<?php echo $row['id_log']; ?>&id_state=3" class="btn btn-error btn-sm">Marcar como Não Resolvido</a>
                                            <a href="update_error_state.php?id_log=<?php echo $row['id_log']; ?>&id_state=2" class="btn btn-warning btn-sm">Ignorar</a>
                                        <?php } elseif ($row['state_id'] == 2) { ?>
                                            <a href="update_error_state.php?id_log=<?php echo $row['id_log']; ?>&id_state=0" class="btn btn-success btn-sm">Marcar como Resolvido</a>
                                            <a href="update_error_state.php?id_log=<?php echo $row['id_log']; ?>&id_state=3" class="btn btn-error btn-sm">Marcar como Não Resolvido</a>
                                        <?php } elseif ($row['state_id'] == 3) { ?>
                                            <a href="update_error_state.php?id_log=<?php echo $row['id_log']; ?>&id_state=0" class="btn btn-success btn-sm">Marcar como Resolvido</a>
                                            <a href="update_error_state.php?id_log=<?php echo $row['id_log']; ?>&id_state=2" class="btn btn-warning btn-sm">Ignorar</a>
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

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
