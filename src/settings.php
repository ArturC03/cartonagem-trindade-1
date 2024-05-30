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
<div class="card bg-base-200 mx-10 mt-2 flex flex-col justify-around items-center h-[90vh]">
    <div class="flex justify-center items-center pt-4">
        <h1 class="text-4xl font-bold p-3 border-t-2 border-b-2 border-neutral">Definições</h1>
    </div>
    <div class="grid grid-cols-3 gap-4 p-3 overflow-x-auto max-h-[70vh]">
        <div class="flex justify-center items-center">
            <h1 class="text-3xl font-semibold p-3 border-t-2 border-b-2 border-neutral">Valores</h1>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Raio da nuvem</h2>
                <p>Edita o raio do círculo em cada sensor.</p>
                <input type="number" placeholder="Raio" id="cloud" name="cloud" class="input input-bordered w-full max-w-xs" min="1" value="<?php echo $arrConfig['cloud_radius']; ?>" required />
                <button type="submit" name="changeCloud" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Valores ideais</h2>
                <p>Edita os valores para apresentação das médias.</p>
                <input type="number" placeholder="Temperatura (ºC)" id="cloud" name="cloud" class="input input-bordered w-full max-w-xs" min="1" value="" required />
                <input type="number" placeholder="Humidade (%)" id="cloud" name="cloud" class="input input-bordered w-full max-w-xs" min="1" value="" required />
                <input type="number" placeholder="Pressão (MPa)" id="cloud" name="cloud" class="input input-bordered w-full max-w-xs" min="1" value="" required />
                <button type="submit" name="changeTitle" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>

        <div class="flex justify-center items-center">
            <h1 class="text-3xl font-semibold p-3 border-t-2 border-b-2 border-neutral">Imagens</h1>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Background</h2>
                <p>Edita a imagem apresentada na página inicial.</p>
                <input type="file" placeholder="Raio" id="cloud" name="cloud" class="file-input file-input-bordered w-full max-w-xs" required />
                <button type="submit" name="changeCloud" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Email</h2>
                <p>Edita a imagem apresentada no email.</p>
                <input type="file" placeholder="Raio" id="cloud" name="cloud" class="file-input file-input-bordered w-full max-w-xs" required />
                <button type="submit" name="changeCloud" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>

        <div class="flex justify-center items-center">
            <h1 class="text-3xl font-semibold p-3 border-t-2 border-b-2 border-neutral">Customização</h1>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Título</h2>
                <p>Edita o título apresentado na página.</p>
                <input type="text" placeholder="Título" id="tit" name="tit" class="input input-bordered w-full max-w-xs" required />
                <button type="submit" name="changeTitle" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>
        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Reload</h2>
                <p>Edita o intervalo de reload da página inicial.</p>
                <input type="time" placeholder="Tempo" id="tit" name="tit" class="input input-bordered w-full max-w-xs" value="00:00" required />
                <button type="submit" name="changeTitle" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>
    </div>
</div>
<?php
require 'content/footer.inc.html';