<?php
require 'content/header.inc.php';

if (isset($_POST['completeYes'])) {
    $username = $_POST['username'];
    $pass = $_POST['new-password'];
    $password = sha1($pass);
    $email = $_POST['email'];
    $userType = $_POST['permitions'] == 'yes' ? '1' : '2';
    $sqlCheck1 = "SELECT email FROM user WHERE email='$email'";
    $sqlCheck2 = "SELECT username FROM user WHERE username='$username'";

    if (count(my_query($sqlCheck1)) != 0 || count(my_query($sqlCheck2)) != 0) {
        echo "<script type='text/javascript'>
        alert('O utilizador inserido já existe!')
        window.location = 'addUser.php';</script>";
    } else {
        $sql = "INSERT INTO user (username, email, password, id_type, last_edited_by) VALUES ('$username', '$email', '$password', '$userType', " . $_SESSION['username'] . ")";

        if (my_query($sql, 1) >= 1) {
            echo "<script type='text/javascript'>
            alert('Novo utilizador adicionado com sucesso!')
            window.location = 'manageUser.php';</script>";
        } else {
            echo "<script type='text/javascript'>
            alert('Erro na criação do novo utilizador! Tente outra vez! "  . $arrConfig['conn']->error . "');
            window.location = 'addUser.php';</script>";
        }
    }
}
?>
<div class="w-screen h-full max-h-[90vh] flex flex-col justify-center items-center">
    <div class="card min-[400px]:w-96 w-11/12 h-[600px] bg-base-300 shadow-xl">
        <form class="card-body items-center text-center" action="" method="post">
            <h2 class="card-title">Criar Utilizador</h2>
            <p>Insere os dados do novo utilizador.</p>
            <input type="text" placeholder="Username" id="username" name="username" class="input input-bordered mb-4 w-full max-w-xs" required />
            <input type="text" placeholder="Email" id="email" name="email" class="input input-bordered mb-4 w-full max-w-xs" required />
            <input type="password" placeholder="Password" id="new-password" name="new-password" class="input input-bordered mb-4 w-full max-w-xs" required />
            <input type="password" placeholder="Confirmar Password" id="confirm-password" name="confirm-password" class="input input-bordered mb-4 w-full max-w-xs" required />
            <div class="form-control w-full max-w-xs">
                <label class="label cursor-pointer">
                    <span class="label-text">Administrador</span> 
                    <input type="radio" id="adminYes" name="permitions" class="radio" value="yes" />
                </label>
                <label class="label cursor-pointer">
                    <span class="label-text">Utilizador</span> 
                    <input type="radio" id="adminNo" name="permitions" class="radio" value="no" checked />
                </label>
            </div>
            <button type="submit" name="completeYes" id="submitLogin" class="btn btn-primary w-full max-w-xs text-base mb-3">Criar Utilizador</button>
            <a class="link link-hover" href="manageUser.php">Voltar</a>
        </form>
    </div>
</div>
<script src="js/editarDados.js"></script>
<?php

require 'content/footer.inc.html';
