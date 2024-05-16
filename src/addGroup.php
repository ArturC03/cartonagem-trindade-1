<?php
require 'includes/config.inc.php';

if (isset($_POST['completeYes'])) {
    $grupo = $_POST['grupo'];
    foreach ($_POST as $k => $v) {
        if ($v == "on") {
            $sensores[] = $k;
        }
    }

    $result = my_query("INSERT INTO `group` (`group_name`,`id_user`) VALUES ('$grupo', '" . $_SESSION['username'] . "');");

    $result = my_query("SELECT id_group FROM `group` WHERE group_name = '$grupo';");
    $id = $result[0]['id_group'];

    foreach ($sensores as $s) {
        my_query("UPDATE sensor SET id_group = '$id', id_user = '" . $_SESSION['username'] . "' WHERE id_sensor = '$s';");
    }

    header('Location: manageGroup.php');
}

require 'content/header.inc.php';

$result2 = my_query("SELECT id_sensor FROM sensor WHERE id_group IS NULL;");
?>
<div class="w-screen h-full max-h-[90vh] flex flex-col justify-center items-center">
    <div class="card min-[400px]:w-96 w-11/12 h-[400px] bg-base-300 shadow-xl">
        <form class="card-body items-center text-center" action="" method="post" id="mainForm">
            <h2 class="card-title">Criar Grupo</h2>
            <p>Insere os dados do novo grupo.</p>

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

            <input type="text" placeholder="Grupo" id="grupo" name="grupo" class="input input-bordered w-full max-w-xs" required />
            <div class="w-full max-w-xs flex justify-between join mb-4 relative">
                <input type="text" placeholder="Nenhum sensor selecionado" id="sensorsText" class="input input-bordered w-2/3 text-center join-item" disabled />
                <input type="checkbox" class="-z-50 absolute left-1/4 bottom-0" id="sensorError" value="ERROR">
                <button type="button" class="btn btn-primary w-1/3 join-item" onclick="modalSensors.showModal()">Escolher Sensores</button>
            </div>
            
            <button type="submit" name="completeYes" id="submitLogin" class="btn btn-primary w-full max-w-xs text-base mb-3">Criar Grupo</button>
            <a class="link link-hover" href="manageGroup.php">Voltar</a>
        </form>
    </div>
    <dialog id="modalSensors" class="modal">
        <div class="modal-box w-11/12 max-w-5xl h-1/2">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-2xl">Seleção de sensores</h3>
            <div class="mt-3 w-full h-[70%]">
                <form action="" id="modalForm" class="h-full overflow-auto [&>*]:mb-3">
                    <div tabindex="0" class="collapse collapse-arrow bg-base-200">
                        <input type="radio" name="accordionSensors" /> 
                        <div class="collapse-title text-xl font-medium pr-5">
                            Sensores Não Atribuídos
                        </div>
                        <?php
                        $sensorQuery = "SELECT s.id_sensor
                                        FROM sensor s
                                        WHERE s.id_group IS NULL";

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
<script src="js/sensorsModal.js"></script>

<?php
require 'content/footer.inc.html';

