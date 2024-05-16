<?php
require 'content/header.inc.php';

if (isset($_POST['submit'])) {
    $id_exists = false;
    $id_sensor = $_POST['id-sensor'];

    $size_x = $_POST['size_x'];
    $size_y = $_POST['size_y'];
    $description = $_POST['description'];
    $location_x = $_POST['location_x'];
    $location_y = $_POST['location_y'];
    $res = my_query("SELECT id_location FROM sensor WHERE id_sensor = '$id_sensor';");

    $update = my_query("UPDATE sensor SET description = '$description' WHERE id_sensor = '$id_sensor';");

    if ($res[0]['id_location'] != null) {
        if (my_query("UPDATE `location` SET `location_x`=$location_x,`location_y`=$location_y,`size_x`=$size_x,`size_y`=$size_y, id_user = '" . $_SESSION['username'] . "' where `id_location` = '"  . $res[0]['id_location'] . "';") == 1) {
            echo "<script type='text/javascript'>
        alert('Sensor atualizado com sucesso!')
        window.location = 'manageSensor.php';</script>";
        } else {
            echo "Error: " . $arrConfig['conn']->error;
        }
    } else {
        if (my_query("INSERT INTO location (location_x, location_y, size_x, size_y, id_user) VALUES ('$location_x', '$location_y', '$size_x', '$size_y', '" . $_SESSION['username'] . "')", 1) >= 1) {
            if (my_query("UPDATE sensor SET id_location = LAST_INSERT_ID(), id_user = '" . $_SESSION['username'] . "' WHERE id_sensor = '$id_sensor';", 1) == 1) {
                echo "<script type='text/javascript'>
            alert('Sensor atualizado com sucesso!')
            window.location = 'manageSensor.php';</script>";
            } else {
                echo "Error: " . $arrConfig['conn']->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $arrConfig['conn']->error;
        }
    }
}
?>
<div id="data" class="hidden">
    <div id="image-width"><?php echo $arrConfig['originalImageWidth'] ?></div>
    <div id="image-height"><?php echo $arrConfig['originalImageHeight'] ?></div>
</div>
<div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
    <div class="card lg:card-side w-11/12 lg:w-[90%] shadow-xl h-full bg-base-300 justify-center">
        <form class="card-body w-full lg:max-w-xs justify-center items-center text-center lg:border-r-8 lg:border-b-0 border-base-100 border-b-8" method="post" id="SetLocation" name="SetLocation" enctype="multipart/form-data" action="<?php  echo basename($_SERVER['PHP_SELF']) ?>?id=<?php echo $_GET['id']; ?>">
            <?php
            $id = $_GET['id'];
            $sqlC = "SELECT location_x,location_y, size_x, size_y, `description`  FROM location INNER JOIN sensor ON sensor.id_location = location.id_location WHERE sensor.id_sensor='$id'";
            $result = my_query($sqlC);
            if (count($result) > 0) {
                $x = $result[0]['location_x'] * ($result[0]['size_x'] / $arrConfig['originalImageWidth']);
                $y = $result[0]['location_y'] * ($result[0]['size_y'] / $arrConfig['originalImageHeight']);
            } else {
                $x = -1;
                $y = -1;
            }
            ?>
            <input type="hidden" name="location_x" id="location_x" value="<?php echo $x ?>">
            <input type="hidden" name="location_y" id="location_y" value="<?php echo $y ?>">
            <input type="hidden" name="id-sensor" id="id-sensor" value="<?php echo $_GET['id']; ?>">
            <input type="hidden" name="size_x" id="size_x" value="<?php echo $arrConfig['originalImageWidth'] ?>">
            <input type="hidden" name="size_y" id="size_y" value="<?php echo $arrConfig['originalImageHeight'] ?>">
            <input type="hidden" name="cloud_radius" id="cloud_radius" value="<?php echo $arrConfig['cloud_radius'] ?>">

            <h2 class="card-title mb-6">Editar Sensor</h2>

            <input type="text" class="input input-bordered w-full max-w-xs" disabled value="<?php echo $_GET['id']; ?>">

            <textarea class="textarea textarea-bordered w-full max-w-xs resize-none mb-4 mt-2" name="description" placeholder="Descrição"><?php echo $result[0]['description']; ?></textarea>
            
            <button class="btn btn-primary w-full max-w-xs mb-3" type="submit" name="submit" value="Guardar">Guardar</button>
            <a class="link link-hover" href="manageSensor.php">Voltar</a>
        </form>
        <div class="w-full lg:w-[70vw] flex items-center justify-center lg:justify-normal">
            <canvas id="factory" class="bg-contain bg-no-repeat h-full" style="background-image: url(<?php echo $arrConfig['imageFactory'] ?>);"></canvas>
        </div>
    </div>
</div>

<script src="js/editSensor.js"></script>
<?php
require 'content/footer.inc.html';
