<?php
require 'content/header.inc.php';

if (isset($_SESSION['username'])) {
    ?>
    <div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
        <div class="card card-side min-[400px]:w-96 w-11/12 lg:w-[90%] shadow-xl lg:h-full bg-base-300 justify-center">
            <form action="consultaTabela.php" method="POST" class="card-body w-full max-w-xs justify-center items-center text-center lg:border-r-8 lg:border-base-100">
                <h2 class="card-title mb-6">Pesquisa</h2>

                <div class="w-full max-w-xs flex justify-between join">
                    <input type="text" placeholder="Nenhum sensor selecionado" class="input input-bordered w-2/3 text-center join-item" disabled />
                    <button class="btn btn-primary w-1/3 join-item" onclick="modalSensors.showModal()">Escolher Sensores</button>
                </div>
                <input type="date" name="mindate" id="mindate" class="input input-bordered w-full max-w-xs" max="<?php echo date('Y-m-d') ?>" required>
                <input type="date" name="maxdate" id="maxdate" class="input input-bordered w-full max-w-xs" max="<?php echo date('Y-m-d') ?>" required>
                <input type="time" name="mintime" id="mintime" class="input input-bordered w-full max-w-xs">
                <input type="time" name="maxtime" id="maxtime" class="input input-bordered w-full max-w-xs">
                <button type="submit" class="btn btn-primary w-full max-w-xs">Pesquisar</button>
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
                    <form action="" class="h-full overflow-auto [&>*]:mb-3">
                        <div tabindex="0" class="collapse bg-base-200"> 
                            <div class="collapse-title text-xl font-medium">
                                Focus me to see content
                            </div>
                            <div class="collapse-content"> 
                                <p>tabindex="0" attribute is necessary to make the div focusable</p>
                            </div>
                        </div>
                        <div tabindex="0" class="collapse bg-base-200"> 
                            <div class="collapse-title text-xl font-medium">
                                Focus me to see content
                            </div>
                            <div class="collapse-content"> 
                                <p>tabindex="0" attribute is necessary to make the div focusable</p>
                            </div>
                        </div>
                        <div tabindex="0" class="collapse bg-base-200"> 
                            <div class="collapse-title text-xl font-medium">
                                Focus me to see content
                            </div>
                            <div class="collapse-content"> 
                                <p>tabindex="0" attribute is necessary to make the div focusable</p>
                            </div>
                        </div>
                        <div tabindex="0" class="collapse bg-base-200"> 
                            <div class="collapse-title text-xl font-medium">
                                Focus me to see content
                            </div>
                            <div class="collapse-content"> 
                                <p>tabindex="0" attribute is necessary to make the div focusable</p>
                            </div>
                        </div>
                        <div tabindex="0" class="collapse bg-base-200"> 
                            <div class="collapse-title text-xl font-medium">
                                Focus me to see content
                            </div>
                            <div class="collapse-content"> 
                                <p>tabindex="0" attribute is necessary to make the div focusable</p>
                            </div>
                        </div>
                        <div tabindex="0" class="collapse bg-base-200"> 
                            <div class="collapse-title text-xl font-medium">
                                Focus me to see content
                            </div>
                            <div class="collapse-content"> 
                                <p>tabindex="0" attribute is necessary to make the div focusable</p>
                            </div>
                        </div>
                        <div tabindex="0" class="collapse bg-base-200"> 
                            <div class="collapse-title text-xl font-medium">
                                Focus me to see content
                            </div>
                            <div class="collapse-content"> 
                                <p>tabindex="0" attribute is necessary to make the div focusable</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="">
                    <form method="dialog">
                        <button class="btn btn-primary absolute right-6 bottom-6">Salvar</button>
                    </form>
                </div>
            </div>
        </dialog>
    </div>
    <script src="js/archive.js"></script>
    <?php
    include 'content/footer.inc.html';
} else {
    header('Location: login.php');
}
