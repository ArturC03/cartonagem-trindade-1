<?php
require 'content/header.inc.php';

if (isset($_POST['completeYes'])) {
    $pass = $_POST['new-password'];
    $password = sha1($pass);

    if (my_query("UPDATE user SET password='$password' WHERE token='" . $_SESSION['token'] . "'") == 1) {
        my_query("UPDATE user SET token=NULL WHERE token='" . $_SESSION['token'] . "'");
        unset($_SESSION['token']);

        echo "<script type='text/javascript'>
        alert('Password atualizada com sucesso!')
        window.location = 'backend/logout.php';</script>";
    } else {
        echo "<script>alert(Erro a atualizar password! Tente outra vez!); window.location = 'recoverForm.php'</script>";
    }

    exit;
}

if (isset($_GET['token'])) {
    $_SESSION['token'] = $_GET['token'];

    $result = my_query("SELECT * FROM user WHERE token = '" . $_SESSION['token'] . "'");
    if (count($result) > 0) {
        ?>
        <div class="w-screen h-full max-h-[90vh] flex flex-col justify-center items-center">
            <div class="card min-[400px]:w-96 w-11/12 h-[600px] bg-base-300 shadow-xl">
                <form class="card-body items-center text-center" action="" method="post">
                    <h2 class="card-title">Alterar Password</h2>
                    <p>Atualiza a password da tua conta.</p>
                    <input type="text" placeholder="Username" id="username" name="username" value="<?php echo $result[0]['username'] ?>" class="input input-bordered mb-4 w-full max-w-xs" disabled />
                    <input type="text" placeholder="Email" id="email" name="email" value="<?php echo $result[0]['email'] ?>" class="input input-bordered mb-4 w-full max-w-xs" disabled />
                    <input type="password" placeholder="Password" id="new-password" name="new-password" class="input input-bordered mb-4 w-full max-w-xs" required />
                    <input type="password" placeholder="Confirmar Password" id="confirm-password" name="confirm-password" class="input input-bordered mb-4 w-full max-w-xs" required />
                    <div class="form-control w-full max-w-xs">
                        <label class="label cursor-pointer">
                            <span class="label-text">Administrador</span> 
                            <input type="radio" id="adminYes" name="permitions" class="radio" value="yes" disabled <?php echo ($result[0]['id_type'] == '1' ? "checked" : ""); ?>/>
                        </label>
                        <label class="label cursor-pointer">
                            <span class="label-text">Utilizador</span> 
                            <input type="radio" id="adminNo" name="permitions" class="radio" value="no" disabled <?php echo ($result[0]['id_type'] == '2' ? "checked" : ""); ?>/>
                        </label>
                    </div>
                    <button type="submit" name="completeYes" id="submitLogin" class="btn btn-primary w-full max-w-xs text-base mb-3">Alterar Password</button>
                    <a class="link link-hover" href="manageUser.php">Voltar</a>
                </form>
            </div>
        </div>
        <script src="js/editarDados.js"></script>
        <?php

        include 'content/footer.inc.php';
    } else {
        unset($_SESSION['token']);
        echo "<script>alert('Token inválido!'); window.location = 'index.php'</script>";
    }
} else {
    echo "<script>alert('Token inválido!'); window.location = 'index.php'</script>";
}