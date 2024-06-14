<?php
require 'content/header.inc.php';

if (isset($_POST['changeTitle'])) {
    $arrConfig['site_title'] = $_POST['tit'];

    if (my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('site_title', '" . $arrConfig['site_title']. "', '" . $_SESSION['username'] . "');") >= 1) {
        echo "<script type='text/javascript'>
        alert('Título atualizado com sucesso!');
        window.location.href = 'settings.php';</script>";
    } else {
        echo "<script type='text/javascript'>
        alert('Erro a atualizar o título!');
        </script>";
    }
}

if (isset($_POST['changeCloud'])) {
    $arrConfig['cloud_radius'] = $_POST['cloud'];

    if (my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('cloud_radius', '" . $arrConfig['cloud_radius']. "', '" . $_SESSION['username'] . "');") >= 1) {
        echo "<script type='text/javascript'>
        alert('Raio da nuvem atualizado com sucesso!');
        window.location.href = 'settings.php';</script>";
    } else {
        echo "<script type='text/javascript'>
        alert('Erro a atualizar o raio da nuvem!');
        </script>";
    }
}

if (isset($_POST['changeDiffs'])) {
    $arrConfig['max_avg_temp'] = $_POST['temp_max'];
    $arrConfig['max_avg_humidity'] = $_POST['humidity_max'];
    $arrConfig['max_avg_pressure'] = $_POST['pressure_max'];
    $arrConfig['min_avg_temp'] = $_POST['temp_min'];
    $arrConfig['min_avg_humidity'] = $_POST['humidity_min'];
    $arrConfig['min_avg_pressure'] = $_POST['pressure_min'];
    $arrConfig['max_diff'] = $_POST['diff'];
    if (my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('max_avg_temp', '" . $arrConfig['max_avg_temp']. "', '" . $_SESSION['username'] . "');") >= 1
        && my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('max_avg_humidity', '" . $arrConfig['max_avg_humidity']. "', '" . $_SESSION['username'] . "');") >= 1
        && my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('max_avg_pressure', '" . $arrConfig['max_avg_pressure']. "', '" . $_SESSION['username'] . "');") >= 1
        && my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('min_avg_temp', '" . $arrConfig['min_avg_temp']. "', '" . $_SESSION['username'] . "');") >= 1
        && my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('min_avg_humidity', '" . $arrConfig['min_avg_humidity']. "', '" . $_SESSION['username'] . "');") >= 1
        && my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('min_avg_pressure', '" . $arrConfig['min_avg_pressure']. "', '" . $_SESSION['username'] . "');") >= 1
        && my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('max_diff', '" . $arrConfig['max_diff']. "', '" . $_SESSION['username'] . "');") >= 1
    ) {
        echo "<script type='text/javascript'>
        alert('Valores ideais atualizados com sucesso!');
        window.location.href = 'settings.php';</script>";
    } else {
        echo "<script type='text/javascript'>
        alert('Erro a atualizar os valores ideais!');
        </script>";
    }
}

if (isset($_POST['changeBgImage'])) {
    echo $bgImage = $_FILES['bgImageInput']['name'];
    $bgImageTmp = $_FILES['bgImageInput']['tmp_name'];
    $bgImagePath = 'images/plantas/' . $bgImage;
    move_uploaded_file($bgImageTmp, $bgImagePath);
    $arrConfig['imageFactory'] = $bgImagePath;
    if (my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('imageFactory', '" . $arrConfig['imageFactory']. "', '" . $_SESSION['username'] . "');") >= 1) {
        echo "<script type='text/javascript'>
        alert('Imagem de fundo atualizada com sucesso!');
        window.location.href = 'settings.php';</script>";
    } else {
        echo "<script type='text/javascript'>
        alert('Erro a atualizar a imagem de fundo!');
        </script>";
    }
}

if (isset($_POST['changeEmailImage'])) {
    $emailImage = $_FILES['emailImageInput']['name'];
    $emailImageTmp = $_FILES['emailImageInput']['tmp_name'];
    $emailImagePath = 'images/' . $emailImage;
    move_uploaded_file($emailImageTmp, $emailImagePath);
    $arrConfig['imageEmail'] = $emailImagePath;
    if (my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('imageEmail', '" . $arrConfig['imageEmail']. "', '" . $_SESSION['username'] . "');") >= 1) {
        echo "<script type='text/javascript'>
        alert('Imagem de email atualizada com sucesso!');
        window.location.href = 'settings.php';</script>";
    } else {
        echo "<script type='text/javascript'>
        alert('Erro a atualizar a imagem de email!');
        </script>";
    }
}

if (isset($_POST['changeReload'])) {
    $reloadTime = $_POST['reload_time'];
    $arrConfig['reload_time'] = $reloadTime;
    if (my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('reload_time', '" . $arrConfig['reload_time']. "', '" . $_SESSION['username'] . "');") >= 1) {
        echo "<script type='text/javascript'>
        alert('Tempo de recarregamento atualizado com sucesso!');
        window.location.href = 'settings.php';</script>";
    } else {
        echo "<script type='text/javascript'>
        alert('Erro a atualizar o tempo de recarregamento!');
        </script>";
    }
}
?>
<div id="data" class="hidden">
    <div id="image-width"><?php echo $arrConfig['originalImageWidth'] ?></div>
    <div id="image-height"><?php echo $arrConfig['originalImageHeight'] ?></div>
</div>
<input type="hidden" name="size_x" id="size_x" value="<?php echo $arrConfig['originalImageWidth'] ?>">
<input type="hidden" name="size_y" id="size_y" value="<?php echo $arrConfig['originalImageHeight'] ?>">
<div class="sm:card sm:bg-base-200 mx-4 sm:mx-10 mt-2 flex flex-col justify-around items-center h-[88vh]">
    <div class="flex justify-center items-center pt-4">
        <h1 class="text-4xl font-bold p-3 border-t-2 border-b-2 border-neutral">Definições</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-4 p-3 overflow-x-auto max-h-[70vh]">
        <div class="flex justify-center items-center">
            <h1 class="text-3xl font-semibold p-3 border-t-2 border-b-2 border-neutral">Valores</h1>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Raio da nuvem</h2>
                <p>Edita o raio do círculo em cada sensor.</p>
                <div class="size-full max-w-xs max-h-[300px] flex justify-center items-center my-3">
                    <canvas id='factory' class="hidden bg-contain bg-no-repeat" style="background-image: url('<?php echo $arrConfig['imageFactory'] ?>')"></canvas>
                </div>
                <input type="number" placeholder="Raio" id="cloud" name="cloud" class="input input-bordered w-full max-w-xs" min="1" value="<?php echo $arrConfig['cloud_radius']; ?>" required />
                <button type="submit" name="changeCloud" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Valores ideais</h2>
                <p>Edita os valores para apresentação das médias.</p>

                <label for="temp_min" class="label">Temperatura (ºC)</label>
                <div class="grid grid-cols-2 w-full max-w-xs gap-2">
                    <input type="number" placeholder="Mínimo" id="temp_min" name="temp_min" class="input input-bordered w-full max-w-xs" min="1" value="<?php echo $arrConfig['min_avg_temp']; ?>" required />
                    <input type="number" placeholder="Máximo" id="temp_max" name="temp_max" class="input input-bordered w-full max-w-xs" min="1" value="<?php echo $arrConfig['max_avg_temp']; ?>" required />
                </div>

                <label for="temp_min" class="label">Humidade (%)</label>
                <div class="grid grid-cols-2 w-full max-w-xs gap-2">
                    <input type="number" placeholder="Mínimo" id="humidity_min" name="humidity_min" class="input input-bordered w-full max-w-xs" min="0" max="100" value="<?php echo $arrConfig['min_avg_humidity']; ?>" required />
                    <input type="number" placeholder="Máximo" id="humidity_max" name="humidity_max" class="input input-bordered w-full max-w-xs" min="0" max="100" value="<?php echo $arrConfig['max_avg_humidity']; ?>" required />
                </div>

                <label for="temp_min" class="label">Pressão (HPA)</label>
                <div class="grid grid-cols-2 w-full max-w-xs gap-2">
                    <input type="number" placeholder="Mínimo" id="pressure_min" name="pressure_min" class="input input-bordered w-full max-w-xs" min="800" max="1100" value="<?php echo $arrConfig['min_avg_pressure']; ?>" required />
                    <input type="number" placeholder="Máximo" id="pressure_max" name="pressure_max" class="input input-bordered w-full max-w-xs" min="800" max="1100" value="<?php echo $arrConfig['max_avg_pressure']; ?>" required />
                </div>

                <div class="form-control w-full max-w-xs">
                        <label for="diff" class="label">Diferença Máxima</label>
                        <input type="number" placeholder="Diferença" id="diff" name="diff" class="input input-bordered w-full max-w-xs" min="0" value="<?php echo $arrConfig['max_diff']; ?>" required />
                    </label>
                </div>

                <button type="submit" name="changeDiffs" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>

        <div class="flex justify-center items-center">
            <h1 class="text-3xl font-semibold p-3 border-t-2 border-b-2 border-neutral">Imagens</h1>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post" enctype="multipart/form-data">
                <h2 class="card-title">Background</h2>
                <p>Edita a imagem apresentada na página inicial.</p>
                <div class="size-full max-w-xs max-h-[300px] flex justify-center items-center my-3">
                    <img id="bgImage" src="<?php echo $arrConfig['imageFactory'] ?>" alt="" class="max-w-xs max-h-[300px]">
                </div>
                <input type="file" placeholder="Raio" id="bgImageInput" name="bgImageInput" class="file-input file-input-bordered w-full max-w-xs" required />
                <button type="submit" name="changeBgImage" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post" enctype="multipart/form-data">
                <h2 class="card-title">Email</h2>
                <p>Edita a imagem apresentada no email.</p>
                <div class="size-full max-w-xs max-h-[300px] flex justify-center items-center my-3">
                    <img id="emailImage" src="<?php echo $arrConfig['imageEmail'] ?>" alt="" class="max-w-xs max-h-[300px]">
                </div>
                <input type="file" placeholder="Raio" id="emailImageInput" name="emailImageInput" class="file-input file-input-bordered w-full max-w-xs" required />
                <button type="submit" name="changeEmailImage" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>

        <div class="flex justify-center items-center">
            <h1 class="text-3xl font-semibold p-3 border-t-2 border-b-2 border-neutral">Customização</h1>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Título</h2>
                <p>Edita o título apresentado na página.</p>
                <input type="text" placeholder="Título" id="tit" name="tit" class="input input-bordered w-full max-w-xs" value="<?php echo $arrConfig['site_title'] ?>" required />
                <button type="submit" name="changeTitle" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Reload</h2>
                <p>Edita o intervalo de reload da página inicial.</p>
                <input type="time" placeholder="Tempo" id="reload_time" name="reload_time" class="input input-bordered w-full max-w-xs" min="00:00" max="00:59" value="<?php echo $arrConfig['reload_time'] ?>" required />
                <button type="submit" name="changeReload" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>
    </div>
</div>
<script src="js/settings.js"></script>
<?php
require 'content/footer.inc.html';