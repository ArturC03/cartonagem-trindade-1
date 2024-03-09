const factory = document.getElementById("factory");
const ctx_factory = factory.getContext("2d");
const colors = [
  "#e6e6ff",
  "#d4d4ff",
  "#b3c0f3",
  "#99cdcc",
  "#80ea96",
  "#80ff66",
  "#a5ff4d",
  "#ddff33",
  "#ffb91a",
  "#ff0300",
];

Chart.defaults.plugins.legend.display = false;

$.ajax({
  url: "tools/getsensordata.php",
  dataType: "json",
  Type: "GET",
  success: function (response) {
    var datasets = $.map(response, function (item, index) {
      console.log(item.label);
      var colorIndex = Math.floor(item.temperature * 10);
      return {
        label: item.label,
        data: [
          {
            x: item.x,
            y: item.y,
            r: item.radius,
          },
        ],
        backgroundColor: colors[colorIndex],
      };
    });

    new Chart(factory, {
      type: "bubble",
      data: {
        datasets: datasets,
      },
      options: {
        maintainAspectRatio: true,
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
                    "hPa"
                );
                if (response[context[0].datasetIndex].eCO2 != "") {
                  label.push(
                    "TVOC: " + response[context[0].datasetIndex].eTVOC + "ppb"
                  );
                  label.push(
                    "CO2: " + response[context[0].datasetIndex].eCO2 + "ppm"
                  );
                }
                return label;
              },
            },
          },
        },
      },
    });

    const temp = document.getElementById("temp");
    const ctx_temp = temp.getContext("2d");
    const gradient = ctx_temp.createLinearGradient(0, temp.height, 0, 0);
    

    for (var i = 0; i < colors.length; i++) {
      var position = i / (colors.length - 1);

      gradient.addColorStop(position, colors[i]);
    }

    new Chart(temp, {
      type: "line",
      data: {
        labels: ["", ""],
        datasets: [
          {
            label: "Temperatura",
            data: [0, 0],
            borderColor: ["rgba(0, 0, 0)"],
            tension: 0.1,
            fill: false,
            pointRadius: 0.00001,
          },
        ],
      },
      options: {
        aspectRatio: 2.25 / 35,
        legend: {
          display: false,
        },
        scales: {
          x: {
            display: false,
          },
          y: {
            display: true,
            min: 0,
            max: 35,
            border: {
              display: false,
            },
            grid: {
              display: true,
            },
            ticks: {
              color: "black",
              font: {
                size: 11,
              },
            },
          },
        },
        events: [],
        plugins: {
          tooltip: {
            enabled: false,
          },
        },
      },
    });
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
