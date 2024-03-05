const factory = document.getElementById('factory');

$.ajax({
  url: 'getsensordata.php',
  dataType: 'json',
  Type:'GET',
  success: function(response) {
    const colors = [
      '#e6e6ff', '#d4d4ff', '#b3c0f3', '#99cdcc', '#80ea96', 
      '#80ff66', '#a5ff4d', '#ddff33', '#ffb91a', '#ff0300'
    ];
    var datasets = $.map(response, function(item, index) {
      var colorIndex = Math.floor(item.temperature * 10);
      return {
          data: [{
              label: item.label,
              x: item.x,
              y: item.y,
              r: item.radius,
          }],
          backgroundColor: colors[colorIndex]
      };
    });

    console.log(datasets);
    
    const image = new Image();
    image.src = 'images/plantas/plantaV1.png';
    let imageWidth = response[0].size_x;
    let imageHeight = response[0].size_y;
    console.log(imageWidth, imageHeight);

    const plugin = {
      id: 'customCanvasBackgroundImage',
      beforeDraw: (chart) => {
        if (image.complete) {
          const ctx = chart.ctx;
          const {top, left, width, height} = chart.chartArea;
          
          // Calculate the aspect ratios of the image and the chart area
          const imageRatio = image.width / image.height;
          const chartRatio = width / height;

          let newWidth, newHeight;

          // If the image ratio is greater than the chart ratio, set the width of the image to the width of the chart area and scale the height to maintain the aspect ratio
          // Otherwise, set the height of the image to the height of the chart area and scale the width to maintain the aspect ratio
          if (imageRatio > chartRatio) {
            newWidth = width;
            newHeight = width / imageRatio;
          } else {
            newHeight = height;
            newWidth = height * imageRatio;
          }

          // Calculate the x and y coordinates to center the image in the chart area
          const x = left - 34 + (width - newWidth) / 2;
          const y = top + (height - newHeight) / 2;

          ctx.drawImage(image, x, y, newWidth, newHeight);
        } else {
          image.onload = () => chart.draw();
        }
      }
    };

    Chart.defaults.plugins.legend.display = false;

    new Chart(factory, {
      type: "bubble",
      data: {
        datasets: datasets,
      },
      options: {
        maintainAspectRatio: true,
        // aspectRatio: imageWidth / imageHeight,
        scales: {
          x: {
            bounds: 'ticks',
            ticks: {
              precision: 5,
            },
            min: 0,
            max: 100,
            display: true,
            grid: {
              display: false,
            },
          },
          y: {
            ticks: {
              precision: 5,
            },
            min: 0,
            max: 100,
            reverse: true,
            display: true,
            grid: {
              display: false,
            },
          },
        },
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              var label = context.dataset.label || '';
              if (label) {
                label += ': ';
              }
              if (context.parsed.x !== null && context.parsed.y !== null) {
                label += '(' + context.parsed.x + ', ' + context.parsed.y + ')';
              }
              return label;
            }
          }
        }
      },
      // plugins: [plugin]
    });
  },
  error: function(error) {
    alert('Erro ao carregar dados dos sensores.');
    console.log(error);
  },
  complete: function() {
    $('.loader').addClass("d-none");
    $('#factory').removeClass("d-none");
  }
});


//   function SeeMeasure(measure){
//     SensorMeasure = measure;
//     UpdateGraph(SensorMeasure);
//   }

//   function UpdateGraph(SensorMeasure){
//     var ValorMinimo = 0;
//     var ValorMaximo = 0;

//     if(SensorMeasure=="temperature"){
//       DataMeasure = dataTemperatura;
//       DataMin = dataMinT;
//       DataMax = dataMaxT;
//       ValorMinimo = Math.min.apply(this, DataMin) - 10;
//       stepSize: 0.5;
//       ValorMaximo = Math.max.apply(this, DataMax) + 10;
//     } else if (SensorMeasure=="humidity"){
//       DataMeasure = dataHumidity;
//       DataMin = dataMinH;
//       DataMax = dataMaxH;
//       ValorMinimo = Math.min.apply(this, DataMin) - 10;
//       stepSize: 0.5;
//       ValorMaximo = Math.max.apply(this, DataMax) + 10;
//     } else if (SensorMeasure=="pressure"){
//       DataMeasure = dataPressure;
//       DataMin = dataMinP;
//       DataMax = dataMaxP;
//       ValorMinimo = Math.min.apply(this, DataMin) - 10;
//       stepSize: 0.5;
//       ValorMaximo = Math.max.apply(this, DataMax) + 10;
//     } else if (SensorMeasure=="co2"){
//       DataMeasure=dataQA;
//       DataMin = dataMinC;
//       DataMax = dataMaxC;
//       ValorMinimo = Math.min.apply(this, DataMin) - 10;
//       stepSize: 0.5;
//       ValorMaximo = Math.max.apply(this, DataMax) + 10;
//     } else if (SensorMeasure=="tvoc"){
//       DataMeasure=dataTVOC;
//       DataMin = dataMinV;
//       DataMax = dataMaxV;
//       ValorMinimo = Math.min.apply(this, DataMin) - 10;
//       stepSize: 0.5;
//       ValorMaximo = Math.max.apply(this, DataMax) + 10;
//     }

//     var ctx2 = document.getElementById('ChartLine').getContext('2d');
//     var myChart;
//     if (typeof myChart !== "undefined") {
//       myChart.destroy();
//     }
//     if (myChart) myChart.destroy();
//     myChart = new Chart(ctx2, {
//       type: 'line',
//       data: {
//         labels: dataHour,
//         datasets: [
//         {
//             data: DataMeasure,
//             backgroundColor: '#3F87CE',
//             hoverBackgroundColor:"#ffff",
//             pointBackgroundColor: "#3F87CE",
//             pointBorderColor: '#fff',
//             borderColor: '#3F87CE',
//             hoverBorderColor:"#3F87CE",
//             fill: false
//           }        
//           ]
//         },
//         options: {
//           maintainAspectRatio: false,
//           responsive: true,
//           legend:{
//             display: false
//           },
//           scales: {
//             xAxes: [{
//               display:true
//             }],
//             yAxes: [{
//               display: true,
//               ticks: {
//                 min: ValorMinimo,
//                 max: ValorMaximo
//               }
//             }]
//           }
//         }
//       });
//   }

//   var demoWrapper = document.getElementById('heatMap1');

//   demoWrapper.onmousemove = function(ev) {
//     var x = ev.layerX;
//     var y = ev.layerY;
//     var value = heatmapInstance.getValueAt({
//       x: x, 
//       y: y
//     });
    

//     actualTemperature = value;

//     renderTemperatures();

//   };

//   var actualTemperature = 0;

//   var GradTemperature;

//   renderTemperatures();

// function renderTemperatures() {
//   if (window.matchMedia("(max-width: 960px)").matches) {
//     var GradTemperature = {
//     "graphset": [
//       {
//         "type": "mixed",
//         "background-color":"none",
//         "scale-x": {
//           "guide":{
//             "visible":0
//           },
//           "tick":{
//             "line-color":"#A8A8A8",
//             "line-width":1
//           },
//           "line-width":1,
//           "line-color":"#A8A8A8",
//           "values":"0:35:1",
//           "format":"%v°C",
//           "markers":[
//             {
//               "type":"line",
//               "range":1
//             }    
//           ]
//         },
//         "scale-y":{
//           "visible":0
//         },
//         "tooltip":{
//             "visible":0
//         }, 
//         "plot":{
//           "bars-overlap":"100%",
//           "hover-state":{
//             "visible":0
//           }
//         },
//         "series": [
//           {
//             "type":"hbar",
//             "values": [35],
//             "gradient-colors":"#e6e6ff #d4d4ff #b3c0f3 #99cdcc #80ea96 #80ff66 #a5ff4d #ddff33 #ffb91a #ff0300",
//             "gradient-stops":"0.1 0.2 0.3 0.4 0.5 0.6 0.7 0.8 0.9 1",
//             "fill-angle":0
//           },
//           {
//             "type":"scatter",
//             "values":[actualTemperature],
//             "marker":{
//               "type":"rectangle",
//               "height":"20%",
//               "width":3
//             }
//           },        
//         ],
//         "gui":{
//           "contextMenu": {
//             "button": {
//               "visible": false
//             }
//           }
//         },
//       }
//     ]
//   };

//   zingchart.render({ 
//     id : 'GradTemperature', 
//     data : GradTemperature, 
//     height: 140, 
//     width: window.innerWidth - 50
//   });
//   } else {
//     var GradTemperature = {
//     "graphset": [
//       {
//         "type": "mixed",
//         "background-color":"none",
//         "scale-x": {
//           "visible":0
//         },
//         "scale-y":{
//           "guide":{
//             "visible":0
//           },
//           "tick":{
//             "line-color":"#A8A8A8",
//             "line-width":1
//           },
//           "line-width":1,
//           "line-color":"#A8A8A8",
//           "values":"0:35:1",
//           "format":"%v°C",
//           "markers":[
//             {
//               "type":"line",
//               "range":5
//             }    
//           ]
//         },
//         "tooltip":{
//             "visible":0
//         }, 
//         "plot":{
//           "bars-overlap":"100%",
//           "hover-state":{
//             "visible":0
//           }
//         },
//         "series": [
//           {
//             "type":"bar",
//             "values": [35],
//             "gradient-colors":"#e6e6ff #d4d4ff #b3c0f3 #99cdcc #80ea96 #80ff66 #a5ff4d #ddff33 #ffb91a #ff0300",
//             "gradient-stops":"0.1 0.2 0.3 0.4 0.5 0.6 0.7 0.8 0.9 1",
//             "fill-angle":-90
//           },
//           {
//             "type":"scatter",
//             "values":[actualTemperature],
//             "marker":{
//               "type":"rectangle",
//               "height":3,
//               "width":"20%"
//             }
//           },        
//         ],
//         "gui":{
//           "contextMenu": {
//             "button": {
//               "visible": false
//             }
//           }
//         },
//       }
//     ]
//   };
  
//   zingchart.render({ 
//     id : 'GradTemperature', 
//     data : GradTemperature, 
//     height: window.innerHeight - 100,
//     width: 140
//   });
// }
//   zingchart.bind('GradTemperature', 'contextmenu', function(p) { return false; });
// }