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
                        $result = my_query("SELECT user_id, username, email,  IF(user_type = '1','Admin','Utilizador') as permissoes FROM users");
                        foreach ($result as $row)  
                        {   
                            echo '  
                            <tr> 
                            <td>'. $row["username"]. '</td>
                            <td>'. $row["email"]. '</td>  
                            <td>'. $row["permissoes"]. '</td> 
                            <td>
                            <div class="button-container">
                            <a type="button" class="button-table" href="editUser.php?id='. $row["user_id"].'" >Editar</a>
                            <a type="button" class="button-table delete" id="a_id" href="deleteUser.php?id='. $row["user_id"].'" >Eliminar</a>
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
