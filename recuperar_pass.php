<?php
include 'config.inc.php';

if(isset($_POST['completeYes'])) {
  $pass = $_POST['new-password'];
  $password = sha1($pass);
  
  if (my_query("UPDATE user SET password='$password' WHERE token='" . $_SESSION['token'] . "'") == 1) {
    my_query("UPDATE user SET token=NULL WHERE token='" . $_SESSION['token'] . "'");
    unset($_SESSION['token']);
    
    echo "<script type='text/javascript'>
    alert('Password atualizada com sucesso!')
    window.location = 'logout.php';</script>";
  } else {
    echo "<script>alert(Erro a atualizar password! Tente outra vez!); window.location = 'recuperar_pass.php'</script>";
  }	
  
  exit;
}

if (isset($_GET['token'])) {
    $_SESSION['token'] = $_GET['token'];
    
    $result = my_query("SELECT * FROM user WHERE token = '" . $_SESSION['token'] . "'");
    if (count($result) > 0) {
        include 'header.inc.php';

        
        ?>
          <div class="container">
            <h2>Alterar Password</h2>
            <form method="post" class="modal-content" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return confirm('Pretende alterar a password?');">
              <div id="change-password-form">
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
                <button type="submit" name="completeYes" id="change-password-button">Alterar Password</button>
              </div>
            </form>
            <div id="change-password-feedback" class="hidden">
              <p id="feedback-message"></p>
            </div>
          </div>
          <script src="js/editarDados.js"></script>
          <?php
    include('footer.inc.php');          
    } else {
        header("Location: 404.html");
    }
} else {
    header("Location: 404.html");
}