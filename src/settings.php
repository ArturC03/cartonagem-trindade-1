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

if (isset($_POST['changeErrorCheck'])) {
    $checkTime = $_POST['error_check_time'];

    $arrConfig['error_check_time'] = $checkTime;
    if (my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('error_check_time', '" . $arrConfig['error_check_time']. "', '" . $_SESSION['username'] . "');") >= 1) {
            echo "<script type='text/javascript'>
            alert('Tempo de verificação de erros atualizado com sucesso!');
            window.location.href = 'settings.php';</script>";
        } else {
            echo "<script type='text/javascript'>
            alert('Erro a atualizar o tempo de verificação de erros!');
            </script>";
        }
    }

// if (isset($_POST['changeRunningCheck'])) {
//     $checkTime = $_POST['running_check_time'];
//     $arrConfig['running_check_time'] = $checkTime;
//     if (my_query("INSERT INTO site_settings (`name`,`value`,`id_user`) values('running_check_time', '" . $arrConfig['running_check_time']. "', '" . $_SESSION['username'] . "');") >= 1) {
//             echo "<script type='text/javascript'>
//             alert('Tempo de verificação de execução do programa atualizado com sucesso!');
//             window.location.href = 'settings.php';</script>";
//         } else {
//             echo "<script type='text/javascript'>
//             alert('Erro a atualizar o tempo de recarregamento!');
//             </script>";
//         }
//     }

if (isset($_POST['change_data_life'])) {
    // Receber os valores dos inputs diretamente no array $arrConfig
    $arrConfig['data_life_time_dias'] = $_POST['data_life_time_dias'];
    $arrConfig['data_life_time_horas'] = $_POST['data_life_time_horas'];
    $arrConfig['data_life_time_minutos'] = $_POST['data_life_time_minutos'];
    $arrConfig['data_life_time_segundos'] = $_POST['data_life_time_segundos'];

    // Atualizar os valores no banco de dados usando os valores do array $arrConfig
    if (my_query("INSERT INTO site_settings (`name`, `value`, `id_user`) VALUES
            ('data_life_time_dias', '" . $arrConfig['data_life_time_dias'] . "', '" . $_SESSION['username'] . "');") >= 1
        && my_query("INSERT INTO site_settings (`name`, `value`, `id_user`) VALUES
            ('data_life_time_horas', '" . $arrConfig['data_life_time_horas'] . "', '" . $_SESSION['username'] . "');") >= 1
        && my_query("INSERT INTO site_settings (`name`, `value`, `id_user`) VALUES
            ('data_life_time_minutos', '" . $arrConfig['data_life_time_minutos'] . "', '" . $_SESSION['username'] . "');") >= 1
        && my_query("INSERT INTO site_settings (`name`, `value`, `id_user`) VALUES
            ('data_life_time_segundos', '" . $arrConfig['data_life_time_segundos'] . "', '" . $_SESSION['username'] . "');") >= 1) {

        // Atribuir os valores de volta ao array $arrConfig
        echo "<script type='text/javascript'>
        alert('Configuração de tempo atualizada com sucesso!');
        window.location.href = 'settings.php';</script>";
    } else {
        echo "<script type='text/javascript'>
        alert('Erro ao atualizar os dados de tempo!');
        </script>";
    }
}
// Verificar se o formulário foi enviado
if (isset($_POST['changeCheckValidadeTime'])) {
    $checkValidadeTime = $_POST['check_validade_time'];
    $arrConfig['check_validade_time'] = $checkValidadeTime;
    
    // Salvar o valor no banco de dados
    if (my_query("INSERT INTO site_settings (`name`, `value`, `id_user`) VALUES('check_validade_time', '" . $arrConfig['check_validade_time'] . "', '" . $_SESSION['username'] . "');") >= 1) {
        echo "<script type='text/javascript'>
        alert('Frequência de verificação atualizada com sucesso!');
        window.location.href = 'settings.php';</script>";
    } else {
        echo "<script type='text/javascript'>
        alert('Erro ao atualizar a frequência de verificação!');
        </script>";
    }
}

?>

    <script>
        // Verifica se a página NÃO está dentro de um iframe
        if (window.self === window.top) {
            // Se não estiver num iframe, redireciona para 404
            window.location.href = "<?= $arrConfig['baseUrl'] ?>/404.php"; // Altere para a sua página de erro
        }
    </script>
<div id="data" class="hidden">
    <div id="image-width"><?php echo $arrConfig['originalImageWidth'] ?></div>
    <div id="image-height"><?php echo $arrConfig['originalImageHeight'] ?></div>
</div>
<input type="hidden" name="size_x" id="size_x" value="<?php echo $arrConfig['originalImageWidth'] ?>">
<input type="hidden" name="size_y" id="size_y" value="<?php echo $arrConfig['originalImageHeight'] ?>">
<div class="sm:card sm:bg-base-200 mx-4 sm:mx-10 mt-2 flex flex-col justify-around items-center h-full">
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

        <div class="flex justify-center items-center">
            <h1 class="text-3xl font-semibold p-3 border-t-2 border-b-2 border-neutral">Erros</h1>
        </div>

        <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Deteção de Erros</h2>
                <p>Edita o intervalo de tempo em que são verificados erros.</p>
                <input type="time" placeholder="Tempo" id="error_check_time" name="error_check_time" class="input input-bordered w-full max-w-xs" min="00:00" max="00:59" value="<?php echo $arrConfig['error_check_time'] ?>" required />
                <button type="submit" name="changeErrorCheck" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div>

        <!-- <div class="card bg-base-300 shadow-xl">
            <form class="card-body items-center text-center" action="" method="post">
                <h2 class="card-title">Verificação de Processos</h2>
                <p>Edita o intervalo de tempo em que é verificada a execução da Leitura de dados e da base de dados.</p>
                <input type="time" placeholder="Tempo" id="running_check_time" name="running_check_time" class="input input-bordered w-full max-w-xs" min="00:00" max="00:59" value="<?php echo $arrConfig['running_check_time'] ?>" required />
                <button type="submit" name="changeRunningCheck" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
            </form>
        </div> -->

        <div class="card bg-base-300 shadow-xl">
    <form class="card-body items-center text-center" action="" method="post">
        <h2 class="card-title">Validade dos Dados</h2>
        <p>Edite a quantidade de tempo que um dado tem antes de ser movido para o histórico de dados.</p>
        
<div class=" space-x-2 flex justify-center w-full">
    <div class="p-2 flex-1 flex flex-col items-center">
        <label for="data_life_time_dias" class="label text-sm w-20 text-center">Dias</label>
        <input type="number" id="data_life_time_dias" name="data_life_time_dias" placeholder="Dias" class="input input-bordered w-full" min="0" max="31" value="<?php echo $arrConfig['data_life_time_dias'] ?>" required />
    </div>
    <div class="py-2 flex-1 flex flex-col items-center">
        <label for="data_life_time_horas" class="label text-sm w-20 text-center">Horas</label>
        <input type="number" id="data_life_time_horas" name="data_life_time_horas" placeholder="Horas" class="input input-bordered w-full" min="0" max="23" value="<?php echo $arrConfig['data_life_time_horas'] ?>" required />
    </div>
    <div class="py-2 flex-1 flex flex-col items-center">
        <label for="data_life_time_minutos" class="label text-sm w-20 text-center">Minutos</label>
        <input type="number" id="data_life_time_minutos" name="data_life_time_minutos" placeholder="Minutos" class="input input-bordered w-full" min="0" max="59" value="<?php echo $arrConfig['data_life_time_minutos'] ?>" required />
    </div>
    <div class="py-2 flex-1 flex flex-col items-center">
        <label for="data_life_time_segundos" class="label text-sm w-20 text-center">Segundos</label>
        <input type="number" id="data_life_time_segundos" name="data_life_time_segundos" placeholder="Segundos" class="input input-bordered w-full" min="0" max="59" value="<?php echo $arrConfig['data_life_time_segundos'] ?>" required />
    </div>
</div>



<button type="submit" name="change_data_life" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>

    </form>
</div>
<div></div> <!-- placeholder -->
<div class="card bg-base-300 shadow-xl">
    <form class="card-body items-center text-center" action="" method="post">
        <h2 class="card-title">Verificar validade dos dados</h2>
        <p>Edita a frequência em que o programa verifica os dados que estão dentro e fora da validade.</p>
        <input type="time" placeholder="Tempo" id="check_validade_time" name="check_validade_time" class="input input-bordered w-full max-w-xs" min="00:00" max="59:59" value="<?php echo $arrConfig['check_validade_time'] ?>" required />
        <button type="submit" name="changeCheckValidadeTime" class="btn btn-primary mt-4 w-full max-w-xs">Guardar</button>
    </form>
</div>


<script>
    $('.navbar').addClass('hidden');
</script>

<script src="js/settings.js"></script>

<?php
require 'content/footer.inc.html';