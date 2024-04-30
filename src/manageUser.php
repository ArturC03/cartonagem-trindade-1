<?php
require 'includes/config.inc.php';

if (isset($_SESSION['username'])) {
    include 'content/header.inc.php';
    ?>
    <script src="js/manageUser.js"></script>
    <div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
        <div class="card w-[90%] h-[80vh] bg-base-300 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h2 class="card-title">Gerir Utilizadores</h2>
                    <a href="addUser.php" class="btn btn-sm btn-circle btn-ghost">
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
                                <th>Utilizador</th>
                                <th>Email</th>
                                <th>Permissões</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = my_query("SELECT user.*, user_type.type FROM user INNER JOIN user_type ON user.id_type = user_type.id_type ORDER BY user.username ASC");
                            foreach ($result as $row) {
                                echo '  
                            <tr> 
                            <td>' . $row["username"] . '</td>
                            <td>' . $row["email"] . '</td>  
                            <td>' . $row["type"] . '</td> 
                            <td>
                                <div class="flex justify-end items-center gap-2">
                                    <a class="btn btn-primary w-40 text-base-100" href="editUser.php?id=' . $row["id_user"] . '" >Editar</a>
                                    <a class="btn btn-error w-40 text-base-100" id="a_id" href="deleteUser.php?id=' . $row["id_user"] . '" >Eliminar</a>
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
