<?php
include('config.inc.php');
include('header.inc.php');
//include('monthdb.php');
//header("refresh: 10000;");  
?>

<div class="graph-containers">
    <canvas id='factory' class="d-none" style="background-image: url(<?php echo $arrConfig['imageFactory'] ?>);">
    </canvas>
    <canvas id='temp' class="d-none">
    </canvas>
</div>
<div class="loader">
  <div class="justify-content-center jimu-primary-loading"></div>
</div>
<script src="js/home.js"></script>

<?php
  include('footer.inc.php');
?>