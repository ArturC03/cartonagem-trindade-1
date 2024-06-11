function heatMapColorforValue(value, opacity = 1){
  var h;
  if (value <= 20) {
    h = 180 - (value / 20) * 60;
  } else {
    h = 120 - ((value - 20) / 15) * 120;
  }
  return "hsla(" + h + ", 100%, 50%, " + opacity + ")";
}

function getColorForData(temp, opacity, dataMin = 20, dataMax = 25, diff = 5) {
  var colorGood = "rgba(0, 255, 0, ";
  var colorBad = "rgba(255, 0, 0, ";
  var colorMedium = "rgba(255, 255, 0, ";

  if (temp < dataMin || temp > dataMax) {
    if (temp < Math.abs(dataMin - diff) || temp > Math.abs(dataMax + diff)) {
      return colorBad + opacity + ")";
    } else {
      return colorMedium + opacity + ")";
    }
  } else {
    return colorGood + opacity + ")";
  }
}

const factory = document.getElementById("factory");
const ctx_factory = factory.getContext("2d");
const imgX = document.getElementById("image-width").innerHTML;
const imgY = document.getElementById("image-height").innerHTML;
const tempAvg = document.getElementById("tempAvg");
const humidityAvg = document.getElementById("humidityAvg");
const pressureAvg = document.getElementById("pressureAvg");

var tempSum = 0;
var humiditySum = 0;
var pressureSum = 0;

Chart.defaults.plugins.legend.display = false;

console.log($(location).attr("pathname"));
console.log($(location).attr("origin"));

$.ajax({
  url: $(location).attr("origin") + "/cartonagem-trindade/backend/getsensordata.php",
  dataType: "json",
  Type: "GET",
  success: function (response) {
    var datasets = $.map(response, function (item, index) {
      tempSum += parseFloat(item.temperature_decimal);
      humiditySum += parseFloat(item.humidity);
      pressureSum += parseFloat(item.pressure);

      console.log(heatMapColorforValue(item.temperature_decimal / 35));

      return {
        label: item.label,
        data: [
          {
            x: item.x,
            y: item.y,
            r: item.radius,
          },
        ],
        backgroundColor: heatMapColorforValue(item.temperature_decimal, 0.6),
        borderColor: heatMapColorforValue(item.temperature_decimal)
      };
    });

    new Chart(factory, {
      type: "bubble",
      data: {
        datasets: datasets,
      },
      options: {
        maintainAspectRatio: true,
        aspectRatio: imgX / imgY,
        scales: {
          x: {
            bounds: "ticks",
            ticks: {
              precision: 5,
            },
            min: 0,
            max: 100,
            display: false,
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
            display: false,
            grid: {
              display: false,
            },
          },
        },
        plugins: {
          tooltip: {
            displayColors: true,
            callbacks: {
              title: function (context) {
                console.log(context);
                return context[0].dataset.label;
              },
              beforeBody: function (context) {
                var label = [""];
                label.push(
                  "Hora da Leitura: " +
                    response[context[0].datasetIndex].date +
                    " " +
                    response[context[0].datasetIndex].time
                );
                label.push("Temperatura: ");
                return label;
              },
              label: function (context) {
                return (
                  response[context.datasetIndex].temperature_decimal + " °C"
                );
              },
              afterBody: function (context) {
                var label = [""];
                label.push(
                  "Humidade: " +
                    response[context[0].datasetIndex].humidity +
                    "%"
                );
                label.push(
                  "Pressão: " +
                    response[context[0].datasetIndex].pressure +
                    " hPa"
                );
                if (response[context[0].datasetIndex].eCO2 != "") {
                  label.push(
                    "TVOC: " + response[context[0].datasetIndex].eTVOC + " ppb"
                  );
                  label.push(
                    "CO2: " + response[context[0].datasetIndex].eCO2 + " ppm"
                  );
                }
                return label;
              },
            },
          },
        },
      },
    });

    var tempAvgValue = tempSum / response.length;
    var humidityAvgValue = humiditySum / response.length;
    var pressureAvgValue = pressureSum / response.length;

    tempAvg.innerHTML = tempAvgValue.toFixed(2) + " °C";
    humidityAvg.innerHTML = humidityAvgValue.toFixed(2) + " %";
    pressureAvg.innerHTML = pressureAvgValue.toFixed(2) + " hPa";

    $.ajax({
      url: $(location).attr("origin") + "/cartonagem-trindade/backend/get_avg_values.php",
      dataType: "json",
      type: "GET",
      success: function (response) {
          tempAvg.style.backgroundColor = getColorForData(tempAvgValue, 0.8, response.min_avg_temp, response.max_avg_temp, response.max_diff);
          humidityAvg.style.backgroundColor = getColorForData(humidityAvgValue, 0.8, response.min_avg_humidity, response.max_avg_humidity, response.max_diff);
          pressureAvg.style.backgroundColor = getColorForData(pressureAvgValue, 0.8, response.min_avg_pressure, response.max_avg_pressure, response.max_diff);
          tempAvg.style.borderColor = getColorForData(tempAvgValue, 0, response.min_avg_temp, response.max_avg_temp, response.max_diff);
          humidityAvg.style.borderColor = getColorForData(humidityAvgValue, 0, response.min_avg_humidity, response.max_avg_humidity, response.max_diff);
          pressureAvg.style.borderColor = getColorForData(pressureAvgValue, 0, response.min_avg_pressure, response.max_avg_pressure, response.max_diff);
      },
      error: function (error) {
        console.log(error);
          alert("Erro ao carregar médias permitidas nos sensores.");
      },
  });

    var tempPercentage = ((tempAvgValue - 0) / (35 - 0)) * 100;
    var pressurePercentage = (Math.abs(pressureAvgValue - 1013) / (1017 - 1013)) * 100;

    console.log(tempPercentage);
    console.log(pressurePercentage);

    tempAvg.style.setProperty("--value", tempPercentage);
    humidityAvg.style.setProperty("--value", humidityAvgValue);
    pressureAvg.style.setProperty("--value", pressurePercentage);
  },
  error: function (error) {
    alert("Erro ao carregar dados dos sensores.");
    console.log(error);
  },
  complete: function () {
    $('div:has(.loading)').addClass("hidden");
    $("#factory").removeClass("hidden");
    $("#temp").removeClass("hidden");
  },
});

// $(window).on('resize', function() {
//   location.reload();
// });