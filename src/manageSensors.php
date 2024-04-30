<?php
require 'includes/config.inc.php';

if (isset($_SESSION['username'])) {
    include 'content/header.inc.php';
    ?>
    <div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
        <div class="card w-[90%] h-[80vh] bg-base-300 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h2 class="card-title">Gerir Sensores</h2>
                    <a href="reloadSensors.php" class="btn btn-sm btn-circle btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                        </svg>
                    </a>
                </div>

                <div class="overflow-x-auto max-h-[65vh]" id="table_body">
                    <table class="table table-pin-rows table-zebra">
                        <thead>
                            <tr>
                                <th>ID do Nó</th>
                                <th>Descrição</th>
                                <th>Localização</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = my_query("SELECT id_sensor, `description`, IF(id_location IS NULL, 'Localização Por Definir', 'Localização Definida') AS location, status FROM sensor;");
                            foreach ($result as $row) {
                                echo 
                                '<tr>
                                    <td>' . $row["id_sensor"] . '</td>
                                    <td>' . ($row["description"] != "" ? $row["description"] : "------------------------------") . '</td>
                                    <td>' . $row["location"] . '</td>
                                    <td>
                                        <div class="flex justify-end items-center gap-2">
                                            <a type="button" class="btn btn-primary text-base-100 w-40" href=\'editLocation.php?id=' . $row["id_sensor"] . '\'">Editar</a>
                                            <a type="button" id="state-button" class="btn w-40 text-base-100 ' . ($row["status"] == 1 ? "btn-success" : "btn-error") . '" href=\'changeSensorStatus.php?id=' . $row["id_sensor"] . '&status=' . $row["status"] . '\'">' . ($row["status"] == 1 ? "Ativo" : "Inativo") . '</a>
                                        </div>
                                    </td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    include 'footer.inc.php';
} else {
    header('Location: login.php');
}
