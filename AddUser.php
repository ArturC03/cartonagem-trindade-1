<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
	include('header.inc.php');
	
	if(isset($_POST['completeYes'])) {
		$id_exists = false;
		$username = $_POST['username'];
		$pass = $_POST['new-password'] ; 
		$password = sha1($pass);
		$email = $_POST['email'] ; 
		$userType = $_POST['permitions'] == 'yes' ? '1' : '0';
		$sqlCheck = "SELECT email FROM users WHERE email='$email'";
		$res = my_query($sqlCheck);
	
		if (count($res) != 0)
		{
			echo "<script type='text/javascript'>
			alert('O email inserido já existe!')
			window.location = 'addUser.php';</script>";
		}
		else
		{
			$sql = "INSERT INTO `users`(`username`, `email`, `user_type`, `password`) VALUES ('$username','$email','$userType','$password')";

			if (my_query($sql) == TRUE) {
				echo "<script type='text/javascript'>
				alert('Novo utilizador adicionado com sucesso!')
				window.location = 'manageUser.php';</script>";
			} else {
				echo "erro na criação so novo utilizador! Tente outra vez! "  . $arrConfig['conn']->error;
			} 
		}
	} 	
?>
	<div class="container">
        <h2>Criar Utilizador</h2>

        <form id="userForm" class="user-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <label for="username" class="form-label">Utilizador:</label>
            <input type="text" id="username" name="username" class="form-input" required>

            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-input" required>

            <label for="new-password" class="form-label">Password:</label>
            <input type="password" id="new-password" name="new-password" class="form-input">
			
			<div id="password-requirements">
				<h3>Requisitos da Password:</h3>
				<ul>
					<li id="length">Pelo menos 8 caracteres</li>
					<li id="capital">Pelo menos uma letra maiúscula</li>
					<li id="letter">Pelo menos uma letra minúscula</li>
					<li id="number">Pelo menos um número</li>
				</ul>
			</div>

            <label for="confirm-password" class="form-label">Confirmar Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" class="form-input">


            <p class="radio-question">Conceder permissões de administrador?</p>

            <div class="radio-group">
                <label for="adminYes" class="radio-label"><input type="radio" id="adminYes" name="permitions" value="yes">Sim</label>
                <label for="adminNo" class="radio-label"><input type="radio" id="adminNo" name="permitions" value="no" checked>Não</label>
            </div>

            <button type="submit" class="form-button" name="completeYes">Criar</button>

        </form>
    </div>
	<script src="js/editarDados.js"></script>
<?php

include('footer.inc.php');
}else{
	header('Location: login.php');
}