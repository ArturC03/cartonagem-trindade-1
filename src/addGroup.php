<?php
require 'config.inc.php';

if (isset($_SESSION['username'])) {
	include('header.inc.php');

	if (isset($_POST['completeYes'])) {
		$grupo = $_POST['grupo'];
		$sensores = $_POST['sensores'];

		$result = my_query("INSERT INTO `group` (`group_name`,`id_user`) VALUES ('$grupo', '" . $_SESSION['username'] . "');");

		$result = my_query("SELECT id_group FROM `group` WHERE group_name = '$grupo';");
		$id = $result[0]['id_group'];

		foreach ($sensores as $s) {
			my_query("UPDATE sensor SET id_group = '$id', id_user = '" . $_SESSION['username'] . "' WHERE id_sensor = '$s';");
		}

		header('Location: manageGroup.php');
	}

	$result2 = my_query("SELECT id_sensor FROM sensor WHERE id_group IS NULL;");
	?>


	<div class="container">
		<h2>Adicionar Dados do Grupo</h2>

		<form id="userForm" class="user-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<label for="grupo" class="form-label">Nome do Grupo:</label>
			<input type="text" id="grupo" name="grupo" class="form-input" value="" required>

			<div class="sensor-update">
				<?php
				foreach ($result2 as $row) {
					echo '<label class="check-container">';
					echo '<input type="checkbox" class="checkbox" name="sensores[]" value="' . $row['id_sensor'] . '">';
					echo '<div class="checkmark"></div>';
					echo '<span>' . $row['id_sensor'] . '</span>';
					echo '</label>';
				}
				?>
			</div>

			<button type="submit" class="form-button" name="completeYes">Salvar</button>

		</form>
	</div>
	<?php
	include('footer.inc.php');
} else {
	header('Location: login.php');
}
