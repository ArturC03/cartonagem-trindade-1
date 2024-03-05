<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');

if (isset($_POST['completeYes'])) {
	$id_exists = false;
	$id_sensor = $_POST['id'];

    $size_x = $_POST['size_x'];
    $size_y = $_POST['size_y'];
	$location_x = $_POST['location_x'];
	$location_y = $_POST['location_y'];
	$res = my_query("SELECT id_location FROM sensor WHERE id_sensor = '$id_sensor';");
    
	if ($res[0]['id_location'] != null) {
		if (my_query("UPDATE `location` SET `location_x`=$location_x,`location_y`=$location_y,`size_x`=$size_x,`size_y`=$size_y, id_user = '" . $_SESSION['username'] . "' where `id_location` = '"  . $res[0]['id_location'] . "';") == 1) {            
            echo "<script type='text/javascript'>
            alert('Localização atualizada com sucesso!')
            window.location = 'manageSensors.php';</script>";
		} else {
            echo "Error: " . $arrConfig['conn']->error;
		}
	} else {
        if (my_query("INSERT INTO location (location_x, location_y, size_x, size_y, id_user) VALUES ('$location_x', '$location_y', '$size_x', '$size_y', '" . $_SESSION['username'] . "')", 1) >= 1) {
            if (my_query("UPDATE sensor SET id_location = LAST_INSERT_ID(), id_user = '" . $_SESSION['username'] . "' WHERE id_sensor = '$id_sensor';", 1) == 1) {
                echo "<script type='text/javascript'>
                alert('Nova localização adicionada com sucesso!')
                window.location = 'manageSensors.php';</script>";
            } else {
                echo "Error: " . $arrConfig['conn']->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }
}
?>
<form method="post" id="SetLocation" name="SetLocation" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" onsubmit="return confirm('Pretende guardar a nova localização?');" >
    <div>
        <?php
            $id = $_GET['id'];
            $sqlC = "SELECT location_x,location_y, size_x, size_y  FROM location INNER JOIN sensor ON sensor.id_location = location.id_location WHERE sensor.id_sensor='$id'";
            $result = my_query($sqlC);
            $x = $result[0]['location_x'] * ($result[0]['size_x'] / $arrConfig['originalImageWidth']);
            $y = $result[0]['location_y'] * ($result[0]['size_y'] / $arrConfig['originalImageHeight']);
        ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input type="hidden" name="location_x" id="location_x" value="<?php echo $x ?>">
        <input type="hidden" name="location_y" id="location_y" value="<?php echo $y ?>">
        <input type="hidden" name="size_x" id="size_x" value="<?php echo $arrConfig['originalImageWidth'] ?>">
        <input type="hidden" name="size_y" id="size_y" value="<?php echo $arrConfig['originalImageHeight'] ?>">
        
        <h2>Definir Localização para o nó <?php echo $_GET['id']; ?></h2>
    </div>
    <div>
        <div class="canvas-container" style="aspect-ratio: <?php echo $arrConfig['originalImageWidth'] ?> / <?php echo $arrConfig['originalImageHeight'] ?>">
            <canvas id="factory" style="background-image: url(<?php echo $arrConfig['imageFactory'] ?>);"></canvas>
        </div>
    </div>
    <button type="submit" id="submit" name="completeYes" value="Guardar">Guardar</button>   
</form>

<script src="js/EditLocation.js"></script>
<?php
include('footer.inc.php');
}else{
    header('Location: login.php');
}