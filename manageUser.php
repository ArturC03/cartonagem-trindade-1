<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
	include('header.inc.php');
?>
    <script src="js/manageUser.js"></script>
    <main class="table">
        <section class="table_header">
            <h1 class="title">Gerir Utilizadores</h1>
        </section>
        
        <section class="table_body">
            <table>
                <thead>
                    <tr>
                        <th>Utilizador</th>
                        <th>Email</th>
                        <th>Permissões</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php                        
                        $result = my_query("SELECT user.*, user_type.type FROM user INNER JOIN user_type ON user.id_type = user_type.id_type ORDER BY user.username ASC");
                        foreach ($result as $row)  
                        {   
                            echo '  
                            <tr> 
                            <td>'. $row["username"]. '</td>
                            <td>'. $row["email"]. '</td>  
                            <td>'. $row["type"]. '</td> 
                            <td>
                            <div class="button-container">
                            <a type="button" class="button-table" href="editUser.php?id='. $row["id_user"].'" >Editar</a>
                            <a type="button" class="button-table delete" id="a_id" href="deleteUser.php?id='. $row["id_user"].'" >Eliminar</a>
                            </div>
                            </td>  
                            </tr>  
                            ';  
                        }  
					?>
                </tbody>
            </table>
        </section>
        <button class="learn-more" onclick="window.location.href='addUser.php';">
            <div class="circle">
                <div class="icon arrow"></div>
            </div>
            <span class="button-text">Adicionar Utilizador</span>
        </button>
    </main>

<?php
    include('footer.inc.php');
} else {
    header('Location: login.php');
}
