<?php
include('config.inc.php');
include('header.inc.php');
//include('monthdb.php');
//header("refresh: 10000;");  
?>

<div class="graph-containers">
    <div>
      <canvas id='factory' class="d-none" style="background-image: url(<?php echo $arrConfig['imageFactory'] ?>);">
      </canvas>
    </div>
    <div>
      <canvas id='temp'>
      </canvas>
      <canvas id='temp-ticks'>
      </canvas>
    </div>
</div>
<div class="loader">
  <div class="justify-content-center jimu-primary-loading"></div>
</div>
<script src="js/home.js"></script>

<?php
  include('footer.inc.php');
?>