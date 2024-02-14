<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
  include('header.inc.php');
?>
    <div class="main-container">
        <form action="consultaTabela.php" method="POST" class="search"> 
            <div class="title">
                <h1>Arquivo</h1>
            </div>
            
            <label for="searchnos">Nós</label>
            <select class="searchnos" name="ids[]" id="" multiple required>
                <?php 
                $consulta = my_query("SELECT id_sensor FROM location WHERE location.status=1 GROUP BY id_sensor");
                foreach ($consulta as $resultado) {
                    echo "<option value=" . $resultado["id_sensor"] . ">" . $resultado["id_sensor"] . "</option>";
                }
                ?>
            </select>
            <label for="mindate">Data Início</label>
            <input type="date" name="mindate" required>
            <label for="maxdate">Data Fim</label>
            <input type="date" name="maxdate" required>
            <label for="mintime">Hora Início</label>
            <input type="time" name="mintime">
            <label for="maxtime">Hora Fim</label>
            <input type="time" name="maxtime">
            <div class="radio">
                <input type="reset" value="Repor" name="reset" id="reset" class="reset" required>
                <input type="submit" value="Pesquisar" name="submit" id="submit" class="submit" required>
            </div>
        </form>
        
        <div class="modal image-container">
            <img id="modalImage" src="images/plantaV3.png" alt="Imagem Ampliada">
        </div>
    </div>
<?php
  include('footer.inc.php');  
}else{
  header('Location: login.php');
}
