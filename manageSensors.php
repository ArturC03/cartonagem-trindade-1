<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
	include('header.inc.php');
?>
    <main class="table">
        <section class="table_header">
            <h1 class="title">Gerir Nós</h1>
        </section>
        
        <section class="table_body">
            <table>
                <thead>
                    <tr>
                        <th>ID do Nó</th>
                        <th>Localização</th>
                        <th>Editar</th>
                        <th>Alterar Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $result = my_query("SELECT DISTINCT l.id_sensor , IF(l.location_x IS NULL,'Localização Por Definir','Localização Definida') as location, l.status FROM location l");
                        foreach ($result as $row) 
                        {
                            echo '<tr>';
                            echo '<td>' . $row["id_sensor"] . '</td>';
                            echo '<td>' . $row["location"] .'</td>';
                            echo '<td><a type="button" class="button-table" href=\'editLocation.php?id=' . $row["id_sensor"] . '\'">Editar</a></td>';
                            echo '<td><a type="button" id="state-button" class="button-table ' . ($row["status"] == 1 ? "active" : "inactive") . '" href=\'changeSensorStatus.php?id=' . $row["id_sensor"] . '&status=' . $row["status"] . '\'">' . ($row["status"] == 1 ? "Ativo" : "Inativo") . '</a></td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <script src="js/consultaTabela.js"></script>
<?php
	include('footer.inc.php');
}else{
	header('Location: login.php');
}