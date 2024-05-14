<?php
require 'content/header.inc.php';
?>
<script src="js/checkDeletion.js"></script>
<div class="w-screen h-full max-h-[90vh] flex justify-center items-center">
    <div class="card w-[90%] h-[80vh] bg-base-300 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <h2 class="card-title">Ficheiros do Agendamento <?php echo $_GET['id'] ?></h2>
                <a href="exportedList.php" class="btn btn-sm btn-circle btn-ghost">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                </a>
            </div>

            <div class="overflow-x-auto max-h-[65vh]" id="table_body">
                <table class="table table-pin-rows table-zebra">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data de Criação</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $folderPath = 'download/scheduled/' . $_GET['id'];

                        if (is_dir($folderPath)) {
                            $files = scandir($folderPath);

                            foreach ($files as $file) {
                                if ($file != '.' && $file != '..') {
                                    $filePath = $folderPath . '/' . $file;

                                    $fileName = basename($filePath);

                                    $fileDate = date("d/m/Y H:i", filemtime($filePath));

                                    echo '<tr>';
                                    echo '<td>' . $fileName . '</td>';
                                    echo '<td>' . $fileDate . '</td>';
                                    echo '<td>
                                            <div class="flex justify-end items-center gap-2">
                                                <a class="btn btn-primary w-40 text-base-100" href="'. $filePath .'" download>Download</a></td>
                                            </div>';
                                    echo '</tr>';
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
require 'content/footer.inc.html';

