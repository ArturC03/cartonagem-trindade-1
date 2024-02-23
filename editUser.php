<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
	include('header.inc.php');
	
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		$_SESSION['id'] = $_GET['id'];
	} else if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
	} else {
		header("location:manageUser.php");
	}

if(isset($_POST['completeYes'])) {
	$username = $_POST['username'];
	$pass = $_POST['new-password'] ; 
	$email = $_POST['email'] ; 
	$userType = $_POST['admin'] == 'yes' ? 1 : 0;

	if (empty($pass))
	{
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
		
		if (my_query("UPDATE `user` SET `username`='$username', `email`='$email', `user_type`='$userType', `password`='$password', last_edited_by = '" . $_SESSION['username'] . "' WHERE id_user='" . $_SESSION['id'] . "'") == 1) {
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


<div class="container">
	<h2>Alterar Dados do Utilizador</h2>

	<form id="userForm" class="user-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
		<input type="hidden" name="id" value="<?php echo $_SESSION['id'];?>">

		<label for="username" class="form-label">Utilizador:</label>
		<input type="text" id="username" name="username" class="form-input" value="<?php echo $result[0]['username'];?>" required>

		<label for="email" class="form-label">Email:</label>
		<input type="email" id="email" name="email" class="form-input" value="<?php echo $result[0]['email'];?>" required>

		<label for="password" class="form-label">Alterar Password:</label>
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

		<label for="confirmPassword" class="form-label">Confirmar Password:</label>
		<input type="password" id="confirm-password" name="confirm-password" class="form-input">

		<p class="radio-question">Conceder permissões de administrador?</p>

		<div class="radio-group" id="permitions">
			<label for="adminYes" class="radio-label"><input type="radio" id="adminYes" name="admin" value="yes" <?php if ($result[0]['user_type']== '1') echo "checked";?>>Sim</label>
			<label for="adminNo" class="radio-label"><input type="radio" id="adminNo" name="admin" value="no" <?php if ($result[0]['user_type']== '0') echo "checked";?>>Não</label>
		</div>

		<button type="submit" class="form-button" name="completeYes">Salvar</button>

	</form>
</div>
<script src="js/editarDados.js"></script>
<?php
	include('footer.inc.php');
}else{
	header('Location: login.php');
}