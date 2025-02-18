<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
	include('header.inc.php');
?>
    <script src="js/manageGroup.js"></script>
    <main class="table">
        <section class="table_header">
            <h1 class="title">Gerir Grupos</h1>    
            <div class="input-group">
                <input type="search" placeholder="Procurar dados...">
                <img src="images/search.svg" alt="">
            </div>
            <div class="radio-inputs">
                <label class="radio">
                    <input type="radio" name="column" value="0">
                    <span class="name">Grupo</span>
                </label>
                <label class="radio">
                    <input type="radio" name="column" value="1">
                    <span class="name">Sensores</span>
                </label>
            </div>
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
                        $result = my_query("SELECT grupos.id_grupo, grupos.grupo, GROUP_CONCAT(DISTINCT id_sensor) AS id_sensors
                        FROM grupos
                        LEFT JOIN location ON location.grupo = grupos.id_grupo
                        GROUP BY grupos.id_grupo
                        ORDER BY grupos.grupo;
                        ");
                        foreach ($result as $row)  
                        {   
                            echo '  
                            <tr> 
                            <td>'. $row["grupo"]. '</td>
                            <td>'. $row["id_sensors"]. '</td>
                            <td>
                            <div class="button-container">
                            <a type="button" class="button-table" href="editGroup.php?id='. $row["id_grupo"].'" >Editar</a>
                            <a type="button" class="button-table delete" id="a_id" href="deleteGroup.php?id='. $row["id_grupo"].'" >Eliminar</a>
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
    <script src="js/consultaTabela.js"></script>

<?php
    include('footer.inc.php');
} else {
    header('Location: login.php');
}