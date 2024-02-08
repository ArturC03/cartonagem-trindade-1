<script src="js/nav.js"></script>

<div class="full-menu">
  <div class="menu">
    <ul>
      <li id="title"><a href="home.php"><?php echo $arrConfig['site_title']; ?></a></li>
      <li><a href="home.php">Home</a></li>
      <li><a href="archive.php">Arquivo</a></li>
      <li><a href="csvtools.php">CSV</a></li>
    </ul>
  </div>

  <div class="icons">
    <div>
      <img id="dropbtn1" class="dropbtn" src="images/toolbox.svg" alt="">
      <div id="dropdown1" class="dropdown-content">
        <a href="manageSensors.php">Gerir Nós</a>
        <a href="manageUser.php">Gerir Utilizadores</a>
        <a href="manageGroup.php">Gerir Grupos</a>
        <a href="csvtimes.php">CSV Automático</a>
        <a href="settings.php">Definições</a>
      </div>
    </div>
    <div class="menu-mobile">
      <div class="menu-mobile-item">
        <?php
        switch ($_SERVER['PHP_SELF']) {
          case '/csvtools.php':
            echo '<p id="dropbtn3-1">CSV</p>';
            break;
          case '/archive.php':
            echo '<p id="dropbtn3-1">Arquivo</p>';
            break;
          case '/home.php':
            echo '<p id="dropbtn3-1">Home</p>';
            break;
          default:
            echo '<p id="dropbtn3-1">Home</p>';
            break;
        }
        ?>
        <img src="images/down-arrow.svg" class="dropbtn" id="dropbtn3"></img>
      </div>
      <div class="dropdown-content" id="dropdown3">
        <a href="home.php">Home</a>
        <a href="archive.php">Arquivo</a>
        <a href="csvtools.php">CSV</a>
      </div>
    </div>
    <div>
      <img id="dropbtn2" class="dropbtn" src="images/user.svg" alt="">
      <div id="dropdown2" class="dropdown-content">
        <?php
        if(isset($_SESSION['username'])){
          echo '<a href="manageUser.php">' . $_SESSION['username'] . '</a>';
          echo '<a href="logout.php">Logout</a>';
        }else{
          echo '<a href="login.php">Login</a>';
        }
        ?>
      </div>
    </div>
  </div>
</div>