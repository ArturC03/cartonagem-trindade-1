<?php
require 'includes/config.inc.php';

if (isset($_SESSION['username'])) {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $_SESSION['id'] = $_GET['id'];
    } else if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    } else {
        header("location:manageUser.php");
    }

    include 'content/header.inc.php';

    if (isset($_POST['completeYes'])) {
        $username = $_POST['username'];
        $pass = $_POST['new-password'];
        $email = $_POST['email'];
        $userType = $_POST['admin'] == 'yes' ? '1' : '2';

        if (empty($pass)) {
            if (my_query("UPDATE `user` SET `username`='$username', `email`='$email', `id_type`='$userType', last_edited_by = '" . $_SESSION['username'] . "' WHERE id_user='" . $_SESSION['id'] . "'") == 1) {
                unset($_SESSION['id']);
                echo "<script type='text/javascript'>
			alert('Dados de utilizador atualizados com sucesso!!')
			window.location = 'manageUser.php';</script>";
            } else {
                unset($_SESSION['id']);
                echo "<script type='text/javascript'>
			alert('Erro ao atualizar os dados do utilizador!!')
			window.location = 'manageUser.php';</script>";
            }
        } else {
            $password = sha1($pass);

            if (my_query("UPDATE `user` SET `username`='$username', `email`='$email', `id_type`='$userType', `password`='$password', last_edited_by = '" . $_SESSION['username'] . "' WHERE id_user='" . $_SESSION['id'] . "'") == 1) {
                unset($_SESSION['id']);
                echo "<script type='text/javascript'>
			alert('Dados de utilizador atualizados com sucesso!!')
			window.location = 'manageUser.php';</script>";
            } else {
                unset($_SESSION['id']);
                echo "<script type='text/javascript'>
			alert('Erro ao atualizar os dados do utilizador!!')
			window.location = 'manageUser.php';</script>";
            }
        }
    }

    $result = my_query("SELECT * FROM user where id_user='" . $_SESSION['id'] . "';");
    ?>
    <div class="w-screen h-full max-h-[90vh] flex flex-col justify-center items-center">
        <div class="card min-[400px]:w-96 w-11/12 h-[600px] bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Alterar Dados do Utilizador</h2>
                <p>Edita os dados do utilizador.</p>
                <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
                <input type="text" placeholder="Username" id="username" name="username" class="input input-bordered mb-4 w-full max-w-xs" value="<?php echo $result[0]['username']; ?>" required />
                <input type="text" placeholder="Email" id="email" name="email" class="input input-bordered mb-4 w-full max-w-xs" value="<?php echo $result[0]['email']; ?>" required />
                <input type="password" placeholder="Password" id="new-password" name="new-password" class="input input-bordered mb-4 w-full max-w-xs" required />
                <input type="password" placeholder="Confirmar Password" id="confirm-password" name="confirm-password" class="input input-bordered mb-4 w-full max-w-xs" required />
                <div class="form-control w-full max-w-xs">
                    <label class="label cursor-pointer">
                        <span class="label-text">Administrador</span> 
                        <input type="radio" id="adminYes" name="permitions" class="radio" value="yes" <?php if ($result[0]['id_type'] == '1') echo "checked"; ?> />
                    </label>
                    <label class="label cursor-pointer">
                        <span class="label-text">Utilizador</span> 
                        <input type="radio" id="adminNo" name="permitions" class="radio" value="no" <?php if ($result[0]['id_type'] == '2') echo "checked"; ?> />
                    </label>
                </div>
                <button type="submit" name="completeYes" id="submitLogin" class="btn btn-primary w-full max-w-xs text-base mb-3">Editar Utilizador</button>
                <a class="link link-hover" href="manageUser.php">Voltar</a>
            </form>
        </div>
    </div>
    <script src="js/editarDados.js"></script>
    <?php
    include 'content/footer.inc.html';
} else {
    header('Location: login.php');
}
