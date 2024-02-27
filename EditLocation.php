<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');

if (isset($_POST['completeYes'])) {
	$id_exists = false;
	$id_sensor = $_POST['id'];

	$location_x = $_POST['location_x'];
	$location_y = $_POST['location_y'];
    $size_x = $_POST['size_x'];
    $size_y = $_POST['size_y'];
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
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input type="hidden" name="location_x" id="location_x">
        <input type="hidden" name="location_y" id="location_y">
        <input type="hidden" name="size_x" id="size_x">
        <input type="hidden" name="size_y" id="size_y">
        
        <h2>Definir Localização para o nó <?php echo $_GET['id']; ?></h2>
    </div>
    <div>
        <?php
        // FUNCIONALIDADE DESATIVADA DE MOSTRAR CIRCULO NA LOCALIZACAO 1
        // $id = $_GET['id'];
        // $sqlC = "SELECT location_x,location_y, size_x, size_y  FROM location WHERE id_sensor='$id'";
        // $result = $mysqli->query($sqlC);
        // while ($row = mysqli_fetch_array($result)) {
        //     $x = $row['location_x'] * ($row['size_x'] / $originalImageWidth);
        //     $y = $row['location_y'] * ($row['size_y'] / $originalImageHeight);
        // }
        ?>
        <svg width="<?php echo $viewportWidth * 100; ?>vw" height="<?php echo $heightInPixels; ?>" xmlns="http://www.w3.org/2000/svg">
            <image id="image" width="<?php echo $viewportWidth * 100; ?>vw" height="<?php echo $heightInPixels; ?>" href="images/plantaV3.png" />
            <?php
            // FUNCIONALIDADE DESATIVADA DE MOSTRAR CIRCULO NA LOCALIZACAO 2
            // if ($x != null && $y != null) {
            //     echo '<circle id="circle" cx="' . $x . '" cy="' . $y . '" r="10" fill="#FF5733" />';
            // }
            ?>
        </svg>
    </div>
    <button type="submit" id="submit" name="completeYes" value="Guardar">Guardar</button>   
</form>

<script src="js/EditLocation.js"></script>
<script src="js/setImageSize.js"></script>
<?php
include('footer.inc.php');
}else{
    header('Location: login.php');
}