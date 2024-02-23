<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
	include('header.inc.php');
	
	$id = $_GET['id'];

if(isset($_POST['completeYes'])) {
	$grupo = $_POST['grupo'];
	$sensores = $_POST['sensores'];
	
	$result = my_query("UPDATE group SET group_name = '$grupo', id_user = '" . $_SESSION['username'] . "' WHERE id_group = '$id';");

	if ($result == 0) {
		$flag = 0;
	}

	$result = my_query("UPDATE sensor SET id_group = NULL, id_user = '" . $_SESSION['username'] . "' WHERE id_group = '$id';");

	if ($result == 0) {
		$flag = 0;
	}
	foreach ($sensores as $s) {
		$result = my_query("UPDATE sensor SET id_group = '$id', id_user = '" . $_SESSION['username'] . "' WHERE id_sensor = '$s';");

		if ($result == 0) {
			$flag = 0;
		}
	}

	if ($flag == 0) {
		echo "<script type='text/javascript'>
		alert('Erro ao atualizar os dados do grupo!!')
		window.location = 'manageGroup.php';</script>";
	} else {
		header('Location: manageGroup.php');
	}
} 

$result = my_query("SELECT group.group_name FROM group WHERE id_group = '$id';");
$result2 = my_query("SELECT id_sensor FROM sensor;");
$result3 = my_query("SELECT sensor.id_sensor FROM sensor WHERE id_group = '$id';");

if (count($result3) > 0) {
	foreach ($result3 as $row) {
		$sensores_list[] = $row['id_sensor'];
	}
}else {
	$sensores_list = array();
}
?>


<div class="container">
	<h2>Alterar Dados do Grupo</h2>

	<form id="userForm" class="user-form" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" method="post">
		<input type="hidden" name="id" value="<?php echo $id;?>">

		<label for="grupo" class="form-label">Nome do Grupo:</label>
		<input type="text" id="grupo" name="grupo" class="form-input" value="<?php echo $result[0]['group_name'];?>" required>

		<div class="sensor-update">
			<?php 
				foreach ($result2 as $row) {
					echo '<label class="check-container">';
					echo '<input type="checkbox" class="checkbox" name="sensores[]" value="' . $row['id_sensor'] . '" ' . (in_array($row['id_sensor'], $sensores_list) ? 'checked' : '') . '>';
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
}else{
	header('Location: login.php');
}