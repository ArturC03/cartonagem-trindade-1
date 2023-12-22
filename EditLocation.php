<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');

if (isset($_POST['completeYes'])) {
    require 'connect.inc.php';

	$id_exists = false;
	$id_sensor = $_POST['id'];
	$location_x = $_POST['location_x'];
	$location_y = $_POST['location_y'];
    $size_x = $_POST['size_x'];
    $size_y = $_POST['size_y'];
	$sqlCheck = "SELECT id_sensor FROM location WHERE id_sensor='$id_sensor'";
	$res = mysqli_query($mysqli, $sqlCheck);
    
    
	if (mysqli_num_rows($res) > 0) {
        $sql = "UPDATE `location` SET `location_x`='$location_x',`location_y`='$location_y',`size_x`='$size_x',`size_y`='$size_y' where `id_sensor` = '$id_sensor';";
        
		if ($mysqli->query($sql) === TRUE) {
            echo "<script type='text/javascript'>
            window.location = 'manageSensors.php';</script>";
		} else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
		}
	} else if (mysqli_num_rows($res) == 0) {

        $sql = "INSERT INTO location (location_x, location_y, size_x, size_y, id_sensor) VALUES 
			('$location_x', '$location_y', '$size_x', '$size_y', '$id_sensor' )";

if ($mysqli->query($sql) === TRUE) {
    echo "<script type='text/javascript'>
    alert('Nova localização adicionada com sucesso!')
    window.location = 'manageSensors.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}
}
}

?>
<form method="post" id="SetLocation" name="SetLocation" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return confirm('Pretende guardar a nova localização?');" >
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
        $id = $_GET['id'];
        $sqlC = "SELECT location_x,location_y  FROM location WHERE id_sensor='$id'";
        $result = $mysqli->query($sqlC);
        while ($row = mysqli_fetch_array($result)) {
            $x = $row['location_x'];
            $y = $row['location_y'];
        }
        ?>
        <svg width="90vw" height="80vh" xmlns="http://www.w3.org/2000/svg">
            <image id="image" width="90vw" height="80vh" href="images/plantaV3.png" />
            <?php
            if ($x != null && $y != null) {
                echo '<circle id="circle" cx="' . $x . '" cy="' . $y . '" r="10" fill="#FF5733" />';
            }
            ?>
        </svg>
    </div>
    <button type="submit" id="submit" name="completeYes" value="Guardar"><a href="#"><span>Guardar</span></a></button>   
</form>

<script src="js/EditLocation.js"></script>
<script src="js/setImageSize.js"></script>
<?php
include('footer.inc.php');
}else{
    header('Location: login.php');
}