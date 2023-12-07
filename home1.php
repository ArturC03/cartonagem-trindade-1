<?php
include('config.inc.php');
include('header.inc.php');
// include('monthdb.php');

header("refresh: 10000;");  

?>

<div class="graph-containers">
  <div class="Wrapper">
    <div id='heatMap1'>
      <img id="planta" src='images/plantaV3.png'/>
      <!-- <canvas id="canvasHeat"></canvas>  -->
    </div>
</div>
<div id='GradTemperature'>

<?php
  include('footer.inc.php');
?>
<script> 
  var heatmapInstance = h337.create({
    container: document.getElementById('heatMap1')
  });

  var points = [];
  $.ajax({
    url: 'getsensordata.php',
    dataType: 'json',
    Type:'GET',
    success: function(data1) {
      for (var i = 0; i < data1.data.length; i++) {
        {
          var point = {
            x: data1.data[i].x,
            y: data1.data[i].y,
            value: data1.data[i].value,
            radius: 25
          }
          points.push(point);
        }
      }
      var data_final = {
        min: 0,
        max: 35,
        data: points
      }
      heatmapInstance.setData(data_final);
      console.log(data1);
    },
    error: function() {
      alert('Erro ao carregar dados dos sensores.');
    }
  }); 

  function SeeMeasure(measure){
    SensorMeasure = measure;
    UpdateGraph(SensorMeasure);
  }

  function UpdateGraph(SensorMeasure){
    var ValorMinimo = 0;
    var ValorMaximo = 0;

    if(SensorMeasure=="temperature"){
      DataMeasure = dataTemperatura;
      DataMin = dataMinT;
      DataMax = dataMaxT;
      ValorMinimo = Math.min.apply(this, DataMin) - 10;
      stepSize: 0.5;
      ValorMaximo = Math.max.apply(this, DataMax) + 10;
    } else if (SensorMeasure=="humidity"){
      DataMeasure = dataHumidity;
      DataMin = dataMinH;
      DataMax = dataMaxH;
      ValorMinimo = Math.min.apply(this, DataMin) - 10;
      stepSize: 0.5;
      ValorMaximo = Math.max.apply(this, DataMax) + 10;
    } else if (SensorMeasure=="pressure"){
      DataMeasure = dataPressure;
      DataMin = dataMinP;
      DataMax = dataMaxP;
      ValorMinimo = Math.min.apply(this, DataMin) - 10;
      stepSize: 0.5;
      ValorMaximo = Math.max.apply(this, DataMax) + 10;
    } else if (SensorMeasure=="co2"){
      DataMeasure=dataQA;
      DataMin = dataMinC;
      DataMax = dataMaxC;
      ValorMinimo = Math.min.apply(this, DataMin) - 10;
      stepSize: 0.5;
      ValorMaximo = Math.max.apply(this, DataMax) + 10;
    } else if (SensorMeasure=="tvoc"){
      DataMeasure=dataTVOC;
      DataMin = dataMinV;
      DataMax = dataMaxV;
      ValorMinimo = Math.min.apply(this, DataMin) - 10;
      stepSize: 0.5;
      ValorMaximo = Math.max.apply(this, DataMax) + 10;
    }

    var ctx2 = document.getElementById('ChartLine').getContext('2d');
    var myChart;
    if (typeof myChart !== "undefined") {
      myChart.destroy();
    }
    if (myChart) myChart.destroy();
    myChart = new Chart(ctx2, {
      type: 'line',
      data: {
        labels: dataHour,
        datasets: [
        {
            data: DataMeasure,
            backgroundColor: '#3F87CE',
            hoverBackgroundColor:"#ffff",
            pointBackgroundColor: "#3F87CE",
            pointBorderColor: '#fff',
            borderColor: '#3F87CE',
            hoverBorderColor:"#3F87CE",
            fill: false
          }        
          ]
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          legend:{
            display: false
          },
          scales: {
            xAxes: [{
              display:true
            }],
            yAxes: [{
              display: true,
              ticks: {
                min: ValorMinimo,
                max: ValorMaximo
              }
            }]
          }
        }
      });

    

    console.log("dataTemperatura", dataTemperatura);
  }

  var demoWrapper = document.querySelector('.Wrapper');

  demoWrapper.onmousemove = function(ev) {
    var x = ev.layerX;
    var y = ev.layerY;
    var value = heatmapInstance.getValueAt({
      x: x, 
      y: y
    });
    

    actualTemperature = value;

    renderTemperatures();

  };

  var actualTemperature = 0;

  var GradTemperature;

  renderTemperatures();

function renderTemperatures() {
  var GradTemperature = {
                  "graphset": [
        {
            "type": "mixed",
            "background-color":"none",
            "scale-x":{
                "visible":0
            },
            "scale-y":{
                "guide":{
                    "visible":0
                },
                "tick":{
                    "line-color":"#A8A8A8",
                    "line-width":1
                },
                "line-width":1,
                "line-color":"#A8A8A8",
                "values":"0:35:1",
                "format":"%v°C",
                "markers":[
                    {
                        "type":"line",
                        "range":5
                    }    
                ]
            },
            "tooltip":{
                "visible":0
            },
            
            "plot":{
                "bars-overlap":"100%",
                "hover-state":{
                    "visible":0
                }
            },
            "series": [
                {
                    "type":"bar",
                    "values": [35],
                    "gradient-colors":"#e6e6ff #d4d4ff #b3c0f3 #99cdcc #80ea96 #80ff66 #a5ff4d #ddff33 #ffb91a #ff0300",
                    "gradient-stops":"0.1 0.2 0.3 0.4 0.5 0.6 0.7 0.8 0.9 1",
                    "fill-angle":-90
                },
                {
                  "type":"scatter",
                  "values":[actualTemperature],
                  "marker":{
                    "type":"rectangle",
                    "height":3,
                    "width":"20%"
                  }
                  },
                    
                  
              ]
          }
      ]
  };

    zingchart.render({ 
        id : 'GradTemperature', 
        data : GradTemperature, 
        height: 600, 
        width: 140
    });
  }
</script>