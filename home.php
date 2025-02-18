<?php
include('config.inc.php');
include('header.inc.php');
//include('monthdb.php');
//header("refresh: 10000;");  
?>

<div class="graph-containers">
  <div id='heatMap1'>
    <svg width="<?php echo $viewportWidth * 100; ?>vw" height="<?php echo $heightInPixels; ?>" xmlns="http://www.w3.org/2000/svg">
      <image id="image" width="<?php echo $viewportWidth * 100; ?>vw" height="<?php echo $heightInPixels; ?>" href="images/plantaV3-noBG.png" />
    </svg>
  </div>
  <div id='GradTemperature'>
</div>
<div class="loader">
  <div class="justify-content-center jimu-primary-loading"></div>
</div>
<script src="js/home.js"></script>

<?php
  include('footer.inc.php');
?>