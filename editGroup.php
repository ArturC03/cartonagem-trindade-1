<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
	include('header.inc.php');
	
	$id = $_GET['id'];

if(isset($_POST['completeYes'])) {
	$grupo = $_POST['grupo'];
	$sensores = $_POST['sensores'];
	
	$result = my_query("UPDATE grupos SET grupo = '$grupo' WHERE id_grupo = $id;");

	foreach ($sensores as $s) {
		my_query("UPDATE location SET grupo = '$id' WHERE id_sensor = '$s';");
	}

	header('Location: manageGroup.php');
} 

$result = my_query("SELECT * FROM grupos where id_grupo = $id;");
$result2 = my_query("SELECT distinct id_sensor FROM location");
$result3 = my_query("SELECT distinct id_sensor FROM location where grupo = '" . $id . "'");

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
		<?php
			if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
				echo '<span style="color: red;">ERRO A ALTERAR OS DADOS!!!</span>';
			} 
		?>

		<label for="grupo" class="form-label">Nome do Grupo:</label>
		<input type="text" id="grupo" name="grupo" class="form-input" value="<?php echo $result[0]['grupo'];?>" required>

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