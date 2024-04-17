<?php
require 'content/header.inc.php';

if (isset($_SESSION['username'])) {
    ?>
    <div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
        <div class="card card-side min-[400px]:w-96 w-11/12 lg:w-[90%] shadow-xl lg:h-full bg-base-300 justify-center">
            <form action="consultaTabela.php" method="POST" class="card-body w-full max-w-xs justify-center items-center text-center lg:border-r-8 lg:border-base-100">
                <h2 class="card-title mb-6">Pesquisa</h2>
                <!-- <p>Escolha os nós e o intervalo de tempo para visualizar os dados.</p> -->

                <div class="w-full max-w-xs flex justify-between join">
                    <input type="text" placeholder="Nenhum sensor selecionado" class="input input-bordered w-2/3 text-center join-item" disabled />
                    <button class="btn btn-primary w-1/3 join-item" id="openModal">Escolher Sensores</button>
                </div>
                <input type="date" name="mindate" id="mindate" class="input input-bordered w-full max-w-xs" max="<?php echo date('Y-m-d') ?>" required>
                <input type="date" name="maxdate" id="maxdate" class="input input-bordered w-full max-w-xs" max="<?php echo date('Y-m-d') ?>" required>
                <input type="time" name="mintime" id="mintime" class="input input-bordered w-full max-w-xs">
                <input type="time" name="maxtime" id="maxtime" class="input input-bordered w-full max-w-xs">
                <button class="btn btn-primary w-full max-w-xs">Pesquisar</button>
            </form>
            <figure class="w-0 lg:w-full"><img class="hidden lg:block" src="<?php echo $arrConfig['imageFactory'] ?>" alt="Movie"/></figure>
        </div>
        <dialog id="modalSensors" class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="font-bold text-lg">Hello!</h3>
                <p class="py-4">Click the button below to close</p>
                <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
                </div>
            </div>
        </dialog>
        <!-- <div class="main-container">
            <form action="consultaTabela.php" method="POST" class="search" id="searchForm"> 
                <div class="title">
                    <h1>Arquivo</h1>
                </div>
                
                <label for="searchnos">Nós</label>
                <select class="searchnos" name="ids[]" id="" multiple required>
                    <?php 
                    $consulta = my_query("SELECT id_sensor FROM sensor WHERE sensor.status=1 ORDER BY LPAD(CAST(CONV(RIGHT(id_sensor, 2), 16, 10) AS SIGNED), 2, '0') ASC;");
                    foreach ($consulta as $resultado) {
                        echo "<option value=" . $resultado["id_sensor"] . ">" . $resultado["id_sensor"] . "</option>";
                    }
                    ?>
                </select>
                <label for="mindate">Data Início</label>
                <input type="date" name="mindate" id="mindate" max="<?php echo date('Y-m-d') ?>" required>
                <label for="maxdate">Data Fim</label>
                <input type="date" name="maxdate" id="maxdate" max="<?php echo date('Y-m-d') ?>" required>
                <label for="mintime">Hora Início</label>
                <input type="time" name="mintime" id="mintime">
                <label for="maxtime">Hora Fim</label>
                <input type="time" name="maxtime" id="maxtime">
                <div class="radio">
                    <input type="reset" value="Repor" name="reset" id="reset" class="reset" required>
                    <input type="submit" value="Pesquisar" name="submit" id="submit" class="submit" required>
                </div>
            </form>
            
            <div class="modal image-container">
                <img id="modalImage" src="<?php echo $arrConfig['imageFactory'] ?>" alt="Imagem Ampliada">
            </div>
        </div> -->
    </div>
    <script src="js/archive.js"></script>
    <?php
    include 'content/footer.inc.html';  
} else {
    header('Location: login.php');
}
