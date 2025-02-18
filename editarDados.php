<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
	include('header.inc.php');

  if(isset($_POST['completeYes'])) {
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
?>
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
  header('Location: login.php');
}
