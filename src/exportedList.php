<?php
require 'content/header.inc.php';
?>
<script src="js/checkDeletion.js"></script>
<div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
    <div class="card w-[90%] h-[80vh] bg-base-300 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <h2 class="card-title">Gerir Agendamentos</h2>
                <a href="exportAuto.php" class="btn btn-sm btn-circle btn-ghost">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                </a>
            </div>

            <div class="overflow-x-auto max-h-[65vh]" id="table_body">
                <table class="table table-pin-rows table-zebra">
                    <thead>
                        <tr>
                            <th>ID Exportação</th>
                            <th>Sensores</th>
                            <th>Intervalo</th>
                            <th>Formato</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = my_query(
                            "SELECT
                                e.id_export,
                                i.interval_name,
                                e.generation_format,
                                GROUP_CONCAT(s.id_sensor SEPARATOR ', ') AS sensor_list
                            FROM
                                plantdb_new.export e
                            JOIN
                                plantdb_new.interval i ON e.id_interval = i.id_interval
                            JOIN
                                plantdb_new.export_sensor es ON e.id_export = es.id_export
                            JOIN
                                plantdb_new.sensor s ON es.id_sensor = s.id_sensor
                            GROUP BY
                                e.id_export;"
                        );    
                        foreach ($result as $row) {
                            echo '  
                        <tr>
                        <td>' . $row["id_export"] . '</td>
                        <td>' . $row["sensor_list"] . '</td>
                        <td>' . $row["interval_name"] . '</td>
                        <td>' . ($row["generation_format"] == 0 ? 'CSV' : 'JSON') . '</td>
                        <td>
                            <div class="flex justify-end items-center gap-2">
                                <a class="btn btn-primary w-40 text-base-100" href="exportedSingle.php?id=' . $row["id_export"] . '" >Ver ' . ($row["generation_format"] == 0 ? 'CSV' : 'JSON') . 's</a>
                                <a class="btn btn-error w-40 text-base-100" id="delete_exported" href="backend/delete_scheduled.php?id=' . $row["id_export"] . '" >Eliminar</a>
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
require 'content/footer.inc.php';

