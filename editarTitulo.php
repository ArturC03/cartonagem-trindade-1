<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
  include('header.inc.php');

if(isset($_POST['submeter2'])){
  $arrConfig['site_title'] = $_POST['tit'];

  if (my_query("INSERT into titulo values(null, '" . $arrConfig['site_title']. "');") == TRUE) {
    echo "<br><p>Titulo atualizado.</p>";
  } else {
    echo "Erro na criação de novo título! Tente outra vez! "  . $mysqli->error;
  } 
  
  echo "<br><br><a id='voltar' href='home.php'> Voltar </a>";
}else{
  
?>


<main class="table">
  <form name="form01" method="POST" action="editarTitulo.php">
    <label for="tit">Novo Título: </label>
    <input type="text" id="tit" name="tit" required placeholder="Título" maxlength="30">
    <div>
      <input type="reset" id="reset">
      <input type="submit" id="submit" name="submeter2">
    </div>
  </form>
</main>
<?php
}
?>
</body>

<?php
  include('footer.inc.php');
}else{
  header('Location: login.php');
}