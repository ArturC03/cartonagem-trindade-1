<?php
require 'content/header.inc.php';

if (isset($_SESSION['username'])) {
    if (isset($_POST['submit'])) {
        $sensoresSelecionados = $_POST['sensores'];
        $folderName = rand(100000, 999999);

        while (file_exists(__DIR__ . '/download/scheduled/' . $folderName)) {
            $folderName = rand(100000, 999999);
        }

        $result = my_query("INSERT INTO export (id_export, id_interval, generation_format, id_user) VALUES ( '$folderName', '" . $_POST['periodoSelecionado'] . "', '" . ($_POST['submit'] == 'CSV' ? 0 : 1) . "', " . $_SESSION['username'] . ");");
        if (!$result) {
            echo "<script>alert('Erro ao criar o agendamento');
            window.location.href = 'csvtimes.php';
            </script>";
        }

        foreach ($sensoresSelecionados as $sensor) {
            $result2 = my_query("INSERT INTO export_sensor (id_export, id_sensor) VALUES ('$folderName', '" . $sensor . "');");

            if (!$result2) {
                echo "<script>alert('Erro ao criar o agendamento');
                window.location.href = 'csvtimes.php';
                </script>";
            }
        }

        mkdir(__DIR__ . '\download\scheduled\\' . $folderName, 0777);

        header('Location: csvtimes.php');
    } else {
        ?>
        <div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
            <div class="card card-side min-[400px]:w-96 w-11/12 lg:w-[90%] shadow-xl lg:h-full bg-base-300 justify-center">
                <form action="" method="POST" id="mainForm" class="card-body w-full max-w-xs justify-center items-center text-center lg:border-r-8 lg:border-base-100">
                    <h2 class="card-title mb-6">Exportação Agendada</h2>

                    <?php
                    $sensorQuery = "SELECT s.id_sensor FROM sensor s";
                    $sensorResult = my_query($sensorQuery);

                    if (count($sensorResult) > 0) {
                        foreach ($sensorResult as $sensorRow) {
                            $sensorName = $sensorRow['id_sensor'];
                            ?>
                            <input type="checkbox" name="<?php echo $sensorName; ?>" class="hidden" />
                            <?php
                        }
                    }
                    ?>

                    <div class="w-full max-w-xs flex justify-between join">
                        <input type="text" placeholder="Nenhum sensor selecionado" id="sensorsText" class="input input-bordered w-2/3 text-center join-item" disabled />
                        <button class="btn btn-primary w-1/3 join-item" onclick="modalSensors.showModal()">Escolher Sensores</button>
                    </div>
                    <select name="periodoSelecionado" id="periodo" class="select w-full max-w-xs" required>
                        <option value="">Selecione uma opção</option>
                        <?php 
                        $result = my_query("SELECT * FROM `interval`");
                        foreach ($result as $row) {
                            echo '<option value="' . $row["id_interval"] . '">' . $row["interval_name"] . '</option>';
                        }
                        ?>
                    </select>

                    <div class="flex justify-between items-center w-full max-w-xs gap-2">
                        <button type="submit" name="botaoCSV" class="btn btn-primary w-[48%]">Agendar CSV</button>
                        <button type="submit" name="botaoJSON" class="btn btn-primary w-[48%]">Agendar JSON</button>
                    </div>
                    <a class="link mt-6" href="exportedList.php">Ver Agendamentos</a>
                </form>
                <figure class="w-0 lg:w-full"><img class="hidden lg:block" src="<?php echo $arrConfig['imageFactory'] ?>" alt="Movie" /></figure>
            </div>
            <dialog id="modalSensors" class="modal">
                <div class="modal-box w-11/12 max-w-5xl h-1/2">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                    <h3 class="font-bold text-2xl">Seleção de sensores</h3>
                    <div class="mt-3 w-full h-[70%]">
                        <form action="" id="modalForm" class="h-full overflow-auto [&>*]:mb-3">
                            <?php
                            $groupQuery = "SELECT g.group_name FROM `group` g";
                            $groupResult = my_query($groupQuery);
                            $flag = true;

                            if (count($groupResult) > 0) {
                                foreach ($groupResult as $groupRow) {
                                    $groupName = $groupRow['group_name'];
                                    ?>
                                    <div tabindex="0" class="collapse collapse-arrow bg-base-200">
                                        <input type="radio" name="accordionSensors" <?php $flag == true ? 'checked="checked"' : '' ?> />
                                        <div class="collapse-title text-xl font-medium pr-5">
                                            <?php echo $groupName; ?>
                                        </div>
                                        <?php
                                        $sensorQuery = "SELECT s.id_sensor
                                                    FROM sensor s
                                                    INNER JOIN `group` g ON g.id_group = s.id_group
                                                    WHERE g.group_name = '$groupName'";

                                        $sensorResult = my_query($sensorQuery);
                                        ?>
                                        <div class="collapse-content">
                                            <div class="form-control">
                                                <label class="label cursor-pointer">
                                                    <span class="label-text">Selecionar Tudo</span>
                                                    <input type="checkbox" name="selectAll" class="checkbox" />
                                                </label>
                                            </div>
                                            <?php
                                            if (count($sensorResult) > 0) {
                                                foreach ($sensorResult as $sensorRow) {
                                                    $sensorName = $sensorRow['id_sensor'];
                                                    ?>
                                                    <div class="form-control">
                                                        <label class="label cursor-pointer">
                                                            <span class="label-text"><?php echo $sensorName; ?></span>
                                                            <input type="checkbox" name="<?php echo $sensorName; ?>" class="checkbox" />
                                                        </label>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    $flag = false;
                                }
                            }
                            ?>
                        </form>
                    </div>
                    <div class="">
                        <form method="dialog">
                            <button onclick="selectSensors()" class="btn btn-primary absolute right-6 bottom-6">Salvar</button>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
        <script src="js/csvtools.js"></script>
        <?php
        include 'content/footer.inc.html';
    }
} else {
    header('Location: login.php');
}