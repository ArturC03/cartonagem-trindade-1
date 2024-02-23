<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
	include('header.inc.php');
?>
    <script src="js/manageGroup.js"></script>
    <main class="table">
        <section class="table_header">
            <h1 class="title">Gerir Grupos</h1>
        </section>
        
        <section class="table_body">
            <table>
                <thead>
                    <tr>
                        <th>Grupo</th>
                        <th>Sensores</th>
                        <th>Editar</th>
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
                        foreach ($result as $row)  
                        {   
                            echo '  
                            <tr> 
                            <td>'. $row["group_name"]. '</td>
                            <td>'. $row["id_sensors"]. '</td>
                            <td>
                            <div class="button-container">
                            <a type="button" class="button-table" href="editGroup.php?id='. $row["id_group"].'" >Editar</a>
                            <a type="button" class="button-table delete" id="a_id" href="deleteGroup.php?id='. $row["id_group"].'" >Eliminar</a>
                            </div>
                            </td>  
                            </tr>  
                            ';  
                        }  
					?>
                </tbody>
            </table>
        </section>
        <button class="learn-more" onclick="window.location.href='addGroup.php';">
            <div class="circle">
                <div class="icon arrow"></div>
            </div>
            <span class="button-text">Adicionar Grupo</span>
        </button>
    </main>

<?php
    include('footer.inc.php');
} else {
    header('Location: login.php');
}