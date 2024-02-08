<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');

    if(isset($_POST['changePassword'])) {
        $id_exists = false;
        $passO =$_POST['current-password'];
        
        $passOld=sha1($passO);
        $pass = $_POST['new-password'] ; 
        $password = sha1($pass);
        $session_id = $_SESSION['username'];

        $res = my_query("SELECT * FROM users WHERE password LIKE '{$passOld}' and email LIKE '{$session_id}'");
        
        if (count($res) > 0)
        {
        if (my_query("UPDATE `users` SET `password`='$password' WHERE email='$session_id'") == TRUE) {
            echo "<script type='text/javascript'>
            alert('Password atualizada com sucesso!')
            window.location = 'logout.php';</script>";
        } else {
            header("location:editarDados.php?msg=failed");
        }
        }
        else
        {
        header("location:editarDados.php?msg=failed");
        }	
    }

    if(isset($_POST['changeTitle'])){
        $arrConfig['site_title'] = $_POST['tit'];

        if (my_query("INSERT into site_settings values(null, 'site_title', '" . $arrConfig['site_title']. "');") == TRUE) {
            echo "<script type='text/javascript'>
            alert('Título atualizado com sucesso!');
            window.location.href = 'home.php';</script>";
        } else {
            echo "<script type='text/javascript'>
            console.log('" . $mysqli->error . "');
            alert('Erro a atualizar o título!');
            </script>";
        }
    }

    if(isset($_POST['changeCloud'])) {
        $arrConfig['cloud_radius'] = $_POST['cloud'];

        if (my_query("INSERT into site_settings values(null, 'cloud_radius', '" . $arrConfig['cloud_radius']. "');") == TRUE) {
            echo "<script type='text/javascript'>
            alert('Raio da nuvem atualizado com sucesso!');
            window.location.href = 'home.php';</script>";
        } else {
            echo "<script type='text/javascript'>
            console.log('" . $mysqli->error . "');
            alert('Erro a atualizar o raio da nuvem!');
            </script>";
        }
    }
?>

<div class="col-container">
    <div class="col-left">
        <div class="container">
            <form name="form01" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="tit">Novo Título: </label>
                <input type="text" id="tit" name="tit" required placeholder="Título" maxlength="30">
                <div class="submit-reset-container">
                    <input type="reset" id="reset">
                    <input type="submit" id="submit" name="changeTitle">
                </div>
            </form>
        </div>

        <div class="container">
            <form name="form01" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="cloud">Raio da Nuvem: </label>
                <input type="number" id="cloud" name="cloud" value="<?php echo $arrConfig['cloud_radius']; ?>" required>
                <div class="submit-reset-container">
                    <input type="reset" id="reset">
                    <input type="submit" id="submit" name="changeCloud">
                </div>
            </form>
        </div>
    </div>

    <div class="col-right">
        <div class="container">
            <h2>Alterar Password</h2>
            <form method="post" class="modal-content" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return confirm('Pretende alterar a password?');">
                <div id="change-password-form">
                <div class="form-group">
                    <label for="current-password">Senha Atual</label>
                    <input type="password" id="current-password" name="current-password" required>
                    <?php
                    if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
                        echo '<span class="error-message" id="current-password-error">Password atual errada!</span>';
                    } 
                    ?>
                </div>
                <div class="form-group">
                    <label for="new-password">Nova Password</label>
                    <input type="password" id="new-password" name="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                    <span class="error-message" id="new-password-error"></span>
                </div>
                <div id="password-requirements">
                    <h3>Requisitos da Password:</h3>
                    <ul>
                        <li id="length">Pelo menos 8 caracteres</li>
                        <li id="capital">Pelo menos uma letra maiúscula</li>
                        <li id="letter">Pelo menos uma letra minúscula</li>
                        <li id="number">Pelo menos um número</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirmar Nova Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                    <span class="error-message" id="confirm-password-error"></span>
                </div>
                <button type="submit" name="changePassword" id="change-password-button">Alterar Password</button>
                </div>
            </form>
            <div id="change-password-feedback" class="hidden">
                <p id="feedback-message"></p>
            </div>
        </div>
    </div>
</div>
<script src="js/editarDados.js"></script>

<?php
  include('footer.inc.php');
}else{
  header('Location: login.php');
}