<?php
require 'content/header.inc.php';

if (isset($_SESSION['username'])) {
    ?>
    <script src="js/checkDeletion.js"></script>
    <div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
        <div class="card w-[90%] h-[80vh] bg-base-300 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h2 class="card-title">Gerir Grupos</h2>
                    <a href="addGroup.php" class="btn btn-sm btn-circle btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </a>
                </div>

                <div class="overflow-x-auto max-h-[65vh]" id="table_body">
                    <table class="table table-pin-rows table-zebra">
                        <thead>
                            <tr>
                                <th>Grupo</th>
                                <th>Sensores</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = my_query(
                                "SELECT `group`.id_group, `group`.group_name, GROUP_CONCAT(sensor.id_sensor) AS id_sensors
                            FROM `group`
                            LEFT JOIN sensor ON sensor.id_group = `group`.id_group
                            GROUP BY `group`.id_group
                            ORDER BY `group`.group_name ASC;"
                            );
                            foreach ($result as $row) {
                                echo '  
                            <tr> 
                            <td>' . $row["group_name"] . '</td>
                            <td>' . $row["id_sensors"] . '</td>
                            <td>
                                <div class="flex justify-end items-center gap-2">
                                    <a class="btn btn-primary w-40 text-base-100" href="editGroup.php?id=' . $row["id_group"] . '" >Editar</a>
                                    <a class="btn btn-error w-40 text-base-100" id="delete_group" href="backend/delete_group.php?id=' . $row["id_group"] . '" >Eliminar</a>
                                </div>
                            </td>  
                            </tr>  
                            ';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
    include 'content/footer.inc.html';
} else {
    header('Location: login.php');
}
