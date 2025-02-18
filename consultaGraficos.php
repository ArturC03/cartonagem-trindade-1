<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
?>


<!DOCTYPE html>
<meta charset="utf-8">
<html>

<link rel="stylesheet" type="text/css" href="css/sensors.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js" integrity="sha512-UXumZrZNiOwnTcZSHLOfcTs0aos2MzBWHXOHOuB0J/R44QB0dwY5JgfbvljXcklVf65Gc4El6RjZ+lnwd2az2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/1.0.1/chartjs-plugin-zoom.min.js" integrity="sha512-b+q5md1qwYUeYsuOBx+E8MzhsDSZeoE80dPP1VCw9k/KA9LORQmaH3RuXjlpu3u1rfUwh7s6SHthZM3sUGzCkA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href=" https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<?php

include('nav.inc.php');


?>

<style type="text/css">
.buttonSensor.selected{
    background-color: lightgrey;
    color: black; 
    border:   2px solid #555555;
}
.buttonSensor:hover{
    background: grey;
}
.botao{
  float: right;
  margin-right: 30px;
  margin-top: 30px;
}
.botaoVista{
  width: 40px;
  height: 40px;
  background: url(images/tabela.ico);
  border: 1px solid #B4BBBB;
  border-radius: 3px;
  box-shadow: 0px 0px 1px lightgrey;
  margin-bottom: 35px;
}

.botaoBack{
  width: 40px;
  height: 40px;
  background: url(images/back_1.ico);
  border: 1px solid #B4BBBB;
  border-radius: 3px;
  box-shadow: 0px 0px 1px lightgrey;
  margin-bottom: 25px;
  margin-left: 10px;
}
.botaoVista:hover{
  box-shadow: 0px 0px 5px grey;
}
.botaoBack:hover{
  box-shadow: 0px 0px 5px grey;
}
.botaoVista:focus{
  outline: none;
}
.botaoBack:focus{
  outline: none;
}
.no{
  text-align: center;
}
.aaa{
  float: left;
  font-size: 25pt;
  font-weight: bold;
  margin-left: 30px;
  position: absolute;
  top: 85px; 
}
body{
  padding: 0;
  margin: 0;
  overflow-x: hidden;
  font-family: sans-serif;

}
.bbb{
  margin-right: 0;
}
.dashboard-container{
  width: 170%;
}

.dadosRecentesTemp{
  position: absolute;
  top: 20px;
  left: 240px;  
}
.dadosRecentesHum{
  position: absolute;
  top: 19px;
  left: 215px;  
}
.dadosRecentesPressao{
  position: absolute;
  top: 17px;
  margin-left: 170px;  
}
.dadosRecentesTC02{
  position: absolute;
  top: 17px;
  left: 215px;  
}
.dadosRecentesTVOC{
  position: absolute;
  top: 17px;
  margin-left: 220px;  
}
.ValueSize{
  font-size: 25pt;  
}
.botaoResetZoom{
  width: 40px;
  height: 40px;
  background: url(images/reload-icon.png);
  border: 1px solid #B4BBBB;
  border-radius: 3px;
  box-shadow: 0px 0px 1px lightgrey;
  margin-bottom: 35px;
  margin-left: 10px;
}
.botaoResetZoom:hover{
  box-shadow: 0px 0px 5px grey;
}
.botaoResetZoom:focus{
  outline: none;
}

</style>  
<body>
 
    <div class="botao">
      <button class="botaoVista" type="button" name="botaoAlterarVista" onclick="altera()">
      <button class="botaoResetZoom" type="button" name="botaoResetZoom" id="botaoResetZoom" onClick="resetZoom()">
      <button class="botaoBack" type="button" name="botaoBack" onclick="back()">


      <!--<button class="botaoBack" id="0102" type="button" name="botaoBack" onclick="SeeSensor(this.id)">-->
    </div>
    
  <div class="container-fluid page-container" style="margin: 0px;">
      <div class="no">
        <br>
        <?php
    
    require 'connect.inc.php';
    
        $a= $_GET['sensor'];
        $b= $_GET['comp'];
        $c= $_GET['data'];
        $e= $_GET['dataMin'];
        $f= $_GET['dataMax'];
        
        
        
        $g= substr($a, 2);
        $g= substr($g, 0, -10);
        
        ?>

        <?php

$timestamp= strtotime($e);
$diaMin= date('d', $timestamp);

$timestamp2= strtotime($f);
$diaMax= date('d', $timestamp2);

$i= 0;

while($diaMin <= $diaMax){
  $strdate[$i]= $diaMin;
  
  $i++;
  $diaMin++;
        }
        $strdate= implode(", ", $strdate);
        
        $sql = "SELECT distinct id_sensor FROM `location` where id_sensor = ".$g." order by id_sensor;";  
        
        $result = $mysqli->query($sql);
        //$sensorId = sensorId;
        while($row = mysqli_fetch_array($result))  
        {  
          
          echo "<div class='aaa' id='$g' onclick='SeeSensor(this.id)'>";
          echo 'Nó '. $row["id_sensor"];
          echo "</div>";
          
          
        }
        
        ?>
        <br>
      </div>
    <div class="row dashboard-container">
      <div class="col-10">
        <div class="row dashboard-rows">
          <div class="col-md-9 pr-md-1">
            <div class="graph-containers" style="width: 100%;">
              <br>
              <h3 style="margin-left: 1%;"><img class="img-responsive" src="images/temperature.png" alt="" width="40px" style="margin-bottom: 10px;"/>Temperatura - </h3>
              <div class="dadosRecentesTemp">
                <p class="ValueSize" id="Temp_actual"> °C</p>
              </div>
              <canvas id='canvasTemp' height="35"> {{ chart }}</canvas>
            </div>
          </div>
      </div>
        <div class="row dashboard-rows">
            
            <div class="col-md-9 pr-md-1">
                <div class="graph-containers" style="float: left; width: 49%;">
                    <br>
                    <h3 style="margin-left: 2%;"> <img class="img-responsive" src="images/humidity.png" alt="" width="35px" style="margin-bottom: 10px; margin-right: 5px;">Humidade - </h3>
                    <div class="dadosRecentesHum">
                      <p class="ValueSize" id="Hum_actual"> %</p>
                    </div>
                    <canvas id='canvasHum' height="60"> {{ chart }}></canvas>
                </div>
                <div class="graph-containers"
                    style="background-color: #fff; box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);  background-color: #fff; float: right; width: 49%;">
                    <br>
                    <h3 style="margin-left: 2%;"> <img class="img-responsive" src="images/pressure.png" alt="" width="35px" style="margin-bottom: 7px; margin-right: 5px;"/> Pressão - </h3>
                    <div class="dadosRecentesPressao">
                      <p class="ValueSize" id="Press_actual"> %</p>
                    </div>
                    <canvas id='canvasPress' height="62"> {{ chart }}></canvas>
                </div>
            </div>
        </div>
        
        <div class="row dashboard-rows">
            
            <div class="col-md-9 pr-md-1">
                <div class="graph-containers" style="float: left; width: 49%;">
                    <br>
                    <h3 style="margin-left: 2%;"> <img class="img-responsive" src="images/co2.png" alt="" width="35px" style="margin-bottom: 5px; margin-right: 10px;"/>Teor CO2 - </h3>
                    <div class="dadosRecentesTC02">
                      <p class="ValueSize" id="QA_actual"> %</p>
                    </div>
                    <canvas id='canvasQA' height="62"> {{ chart }}></canvas>
                </div>
                <div class="graph-containers" style="float: right; width: 49%;">
                    <br>
                    <h3 style="margin-left: 2%;"> <img class="img-responsive" src="images/tvoc.png" alt="" width="35px" style="margin-bottom: 5px; margin-right: 0px;"/> Teor TVOC - </h3>
                    <div class="dadosRecentesTVOC">
                      <p class="ValueSize" id="TVOC_actual"> %</p>
                    </div>
                    <canvas id='canvasTVOC' height="62"> {{ chart }}></canvas>
                </div>
            </div>
        </div>
      
      </div>
    </div>
  </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
    </body>
    </html>
    

  
    <script>

      document.addEventListener("DOMContentLoaded", function(event) { 
        document.getElementById("0101")();
     });
            
        $('.buttonSensor').on('click', function(){
            $('.buttonSensor').removeClass('selected');
            $(this).addClass('selected');
        });



      var socket = io.connect('http://localhost:8080');
      var dataTemperatura = [];
      var sensorId = '0129';
      //pedido
      socket.on('dbUpdated', function(status){
        console.log("A base de dados foi atualizada!!!!!!");
        
        socket.emit('dbRequest', sensorId);
      });
      
      //rececao dos dados
      socket.on('dbNewData', function(db){
        console.log('Dados recebidos!');

        dataTemperatura = db.map(sensor => sensor.temperature);
        dataHumidity = db.map(sensor => sensor.humidity);
        dataPressure = db.map(sensor => sensor.pressure);
        dataQA = db.map(sensor => sensor.eCO2);
        dataHour = db.map(sensor => sensor.hour);
        dataTVOC = db.map(sensor => sensor.eTVOC);
        dataMinT = db.map(sensor => sensor.MinT);
        dataMaxT = db.map(sensor => sensor.MaxT);
        dataMinH = db.map(sensor => sensor.MinH);
        dataMaxH = db.map(sensor => sensor.MaxH);
        dataMinP = db.map(sensor => sensor.MinP);
        dataMaxP = db.map(sensor => sensor.MaxP);
        dataMinC = db.map(sensor => sensor.MinC);
        dataMaxC = db.map(sensor => sensor.MaxC);
        dataMinV = db.map(sensor => sensor.MinV);
        dataMaxV = db.map(sensor => sensor.MaxV);

        dataHour = dataHour.reverse();
        dataTemperatura = dataTemperatura.reverse();
        dataHumidity = dataHumidity.reverse();
        dataPressure = dataPressure.reverse();
        dataQA = dataQA.reverse();
        dataTVOC = dataTVOC.reverse();
        dataMinT= dataMinT.reverse();
        dataMaxT = dataMaxT.reverse();
        dataMinH = dataMinH.reverse();
        dataMaxH = dataMaxH.reverse();
        dataMinP = dataMinP.reverse();
        dataMaxP = dataMaxP.reverse();
        dataMinC = dataMinC.reverse();
        dataMaxC = dataMaxC.reverse();
        dataMinV = dataMinV.reverse();
        dataMaxV = dataMaxV.reverse();

        
        UpdateGraph();
      });

      function UpdateGraph(){

    //temperature chart
    var ctx = document.getElementById('canvasTemp').getContext('2d');
    
    var myTempChart;
    if (myTempChart) myTempChart.destroy();
    myTempChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: dataHour, //hours,
          datasets: [
          { 
              data: dataTemperatura , //temp,
              backgroundColor: '#D55858',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#D55858",
              pointBorderColor: '#fff',
              borderColor: '#D55858',
              hoverBorderColor:"#D55858",
              fill: false
            },            
            ]
          },
          options: {
            
            scales: {
              x: {  
                display:true,
                min: dataHour[dataHour.length -30],
                max: dataHour[dataHour.length -1]
                
              },
              y: {
                display: true,
                
                min: Math.min.apply(this, dataMinT) - 20,
                max: Math.max.apply(this, dataMaxT) + 5
                
              }
            },
            plugins: {
              legend:{
              display: false
              },
              zoom:{
                pan:{
                  enabled: true,
                  mode: 'xy',
                  
                },
                zoom:{
                  wheel:{
                    enabled: true,
                    mode: 'xy'

                  },
                
                  
                }
                
              }
            }
          }
          
        });

      

      //Humidity chart
      var ctx2 = document.getElementById('canvasHum').getContext('2d');
      var myHumChart;
      if (myHumChart) myHumChart.destroy();
      myHumChart = new Chart(ctx2, {
        type: 'line',
        data: {
          labels: dataHour, //hours,
          datasets: [
          {
              data: dataHumidity,//hum,
              backgroundColor: '#3F87CE',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#3F87CE",
              pointBorderColor: '#fff',
              borderColor: '#3F87CE',
              hoverBorderColor:"#3F87CE",
              fill: false
            },            
            ]
          },
          options: {
            
            scales: {
              x: {
                display:true,
                
                min: dataHour[dataHour.length -30],
                max: dataHour[dataHour.length -1]
              },
              y: {
                display: true,
                
                min: Math.min.apply(this, dataMinH) - 20,
                max: Math.max.apply(this, dataMaxH) + 0
                
              }
            },
            plugins: {
              legend:{
              display: false
              },
              zoom:{
                pan:{
                  enabled: true,
                  mode: 'xy'
                },
                zoom:{
                  wheel:{
                    enabled: true,
                    mode: 'xy'
                  }
                }
                
              }
            }
          }
        });

      
      //Pressure chart
      var ctx3 = document.getElementById('canvasPress').getContext('2d');
      var myPressChart;
      if (myPressChart) myPressChart.destroy();
      myPressChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: dataHour, //hours,
            datasets: [
            {
              data: dataPressure,//press,
              backgroundColor: '#40B97C',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#40B97C",
              pointBorderColor: '#fff',
              borderColor: '#40B97C',
              hoverBorderColor:"#40B97C",
              fill: false
            },            
            ]
          },
          options: {
            
            scales: {
              x: {
                display:true,
                min: dataHour[dataHour.length -30],
                max: dataHour[dataHour.length -1]
                
              },
              y: {
                display: true,
                
                min: Math.min.apply(this, dataMinP) - 10,
                max: Math.max.apply(this, dataMaxP) + 15
                
              }
            },
            plugins: {
              legend:{
              display: false
              },
              zoom:{
                pan:{
                  enabled: true,
                  mode: 'xy'
                },
                zoom:{
                  wheel:{
                    enabled: true,
                    mode: 'xy'
                  }
                }
                
              }
            }
          }
        });

      //Qualidade do AR chart
      var ctx4 = document.getElementById('canvasQA').getContext('2d');
      var myQAChart;
      if (myQAChart) myQAChart.destroy();
      myQAChart = new Chart(ctx4, {
        type: 'line',
        data: {
          labels: dataHour, //hours,
          datasets: [
          {
              data: dataQA,//QA,
              backgroundColor: '#ffc61a',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#ffc61a",
              pointBorderColor: '#fff',
              borderColor: '#ffc61a',
              hoverBorderColor:"#ffc61a",
              fill: false
            },            
            ]
          },
          options: {
            
            scales: {
              x: {
                display:true,

                min: dataHour[dataHour.length -30],
                max: dataHour[dataHour.length -1]
              },
              y: {
                display: true,
                
                min: Math.min.apply(this, dataMinC) - 10,
                max: Math.max.apply(this, dataMaxC) + 10
                
              }
            },
            plugins: {
              legend:{
              display: false
              },
              zoom:{
                pan:{
                  enabled: true,
                  mode: 'xy'
                },
                zoom:{
                  wheel:{
                    enabled: true,
                    mode: 'xy'
                  }
                }
                
              }
            }
          }
        });

      

        //TVOC chart
      var ctx5 = document.getElementById('canvasTVOC').getContext('2d');
      var myVOCChart;
      if (myVOCChart) myVOCChart.destroy();
      myVOCChart = new Chart(ctx5, {
        type: 'line',
        data: {
          labels: dataHour, //hours,
          datasets: [
          {
              data: dataTVOC,//TVOC,
              backgroundColor: '#f28c23',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#f28c23",
              pointBorderColor: '#fff',
              borderColor: '#f28c23',
              hoverBorderColor:"#f28c23",
              fill: false
            },            
            ]
          },
          options: {
            
            scales: {
              x: {
                display:true,

                min: dataHour[dataHour.length -30],
                max: dataHour[dataHour.length -1]
              },
              y: {
                display: true,
                
                min: Math.min.apply(this, dataMinV) - 10,
                max: Math.max.apply(this, dataMaxV) + 10
                
              }
            },
            plugins: {
              legend:{
              display: false
              },
              zoom:{
                pan:{
                  enabled: true,
                  mode: 'xy'
                },
                zoom:{
                  wheel:{
                    enabled: true,
                    mode: 'xy'
                  }
                }
                
              }
            }
          }
        });


      console.log("dataTemperatura", dataTemperatura);
      document.getElementById("Temp_actual").innerHTML = parseFloat(dataTemperatura[dataTemperatura.length - 1]) + "°C";
      document.getElementById("Hum_actual").innerHTML = parseFloat(dataHumidity[dataHumidity.length - 1]) + "%";
      document.getElementById("Press_actual").innerHTML = parseFloat(dataPressure[dataPressure.length - 1]) + "hPa";
      document.getElementById("QA_actual").innerHTML = parseFloat(dataQA[dataQA.length - 1]) + "PPM";
      document.getElementById("TVOC_actual").innerHTML = parseFloat(dataTVOC[dataTVOC.length - 1]) + "PPB";
    }
    window.onload = SeeSensor('<?php echo $g ?>');

    function resetZoom(){
      window.location.reload();
    }
    
    function SeeSensor(clicked_id){
      
      function getParameterByName(name) {
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(window.location.href);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

// Lê o valor do parâmetro "sensor" da URL
var sensorParam = getParameterByName("sensor");

// Define a variável sensorId com o valor do parâmetro da URL
var sensorId = sensorParam;

// Solicita os dados do sensor usando o valor do parâmetro
socket.emit('dbRequest', sensorId);

    }
    function altera(){
      
      window.location.href = "consultaTabela.php?aaaa=<?php echo urlencode($a); ?>&bbbb=<?php echo urlencode($b); ?>&cccc=<?php echo urlencode($c); ?>&eeee=<?php echo urlencode($e); ?>&ffff=<?php echo urlencode($f); ?>";
    }
    function back(){
      
      window.location.href = "archive.php";
    }
  </script>
   <?php
//include('footer.php');
?>
<?php
}else{
  header('Location: login.php');
}