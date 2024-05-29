<?php
require 'content/header.inc.php';

if (isset($_POST['changeTitle'])) {
    $arrConfig['site_title'] = $_POST['tit'];

    if (my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('site_title', '" . $arrConfig['site_title']. "', '" . $_SESSION['username'] . "');") >= 1) {
        echo "<script type='text/javascript'>
        alert('Título atualizado com sucesso!');
        window.location.href = 'home.php';</script>";
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
        window.location.href = 'home.php';</script>";
    } else {
        echo "<script type='text/javascript'>
        alert('Erro a atualizar o raio da nuvem!');
        </script>";
    }
}
?>
<div class="w-screen flex justify-evenly gap-4">
    <div class="card bg-base-300 shadow-xl w-auto">
        <form class="card-body items-center text-center" action="" method="post">
            <h2 class="card-title">Título</h2>
            <p>Edita o título apresentado na página.</p>
            <input type="text" placeholder="Título" id="tit" name="tit" class="input input-bordered mb-4 w-full max-w-xs" required />
            <button type="submit" name="changeTitle" class="btn btn-primary w-full max-w-xs">Guardar</button>
        </form>
    </div>

    <div class="card bg-base-300 shadow-xl w-auto">
        <form class="card-body items-center text-center" action="" method="post">
            <h2 class="card-title">Raio da nuvem</h2>
            <p>Edita o raio do círculo em cada sensor.</p>
            <input type="number" placeholder="Raio" id="cloud" name="cloud" class="input input-bordered mb-4 w-full max-w-xs" min="1" value="<?php echo $arrConfig['cloud_radius']; ?>" required />
            <button type="submit" name="changeCloud" class="btn btn-primary w-full max-w-xs">Guardar</button>
        </form>
    </div>
    <div class="card bg-base-300 shadow-xl w-auto">
        <form class="card-body items-center text-center" action="" method="post">
            <h2 class="card-title">Raio da nuvem</h2>
            <p>Edita o raio do círculo em cada sensor.</p>
            <input type="number" placeholder="Raio" id="cloud" name="cloud" class="input input-bordered mb-4 w-full max-w-xs" min="1" value="<?php echo $arrConfig['cloud_radius']; ?>" required />
            <button type="submit" name="changeTitle" class="btn btn-primary w-full max-w-xs">Guardar</button>
        </form>
    </div>
</div>
<?php
require 'content/footer.inc.html';