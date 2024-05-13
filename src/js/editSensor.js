const factory = document.getElementById("factory");
const id = document.getElementById("id-sensor");
const inputX = document.getElementById("location_x");
const inputY = document.getElementById("location_y");
const inputR = document.getElementById("cloud_radius");
const lastX = inputX.value;
const lastY = inputY.value;
const imgX = document.getElementById("image-width").innerHTML;
const imgY = document.getElementById("image-height").innerHTML;

const tooltip = (context) => {
    var text = [];
    text.push("X: " + context.parsed.x);
    text.push("Y: " + context.parsed.y);
    return text;
}

Chart.defaults.plugins.legend.display = false;
var data;
if (lastX != -1 && lastY != -1) {
    data = [
        {
            x: lastX,
            y: lastY,
            r: inputR.value,
        },
    ];
} else {
    data = [];
}

const chart = new Chart(factory, {
    type: "bubble",
    data: {
        datasets: [
            {
                label: id.value,
                data: data,
                backgroundColor: "rgba(255, 99, 132, 0.6)",
                borderColor: "rgba(255, 99, 132, 1)",
                borderWidth: 1,
            },
        ],
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
                displayColors: false,
                callbacks: {
                    title: function (context) {
                        return context[0].dataset.label;
                    },
                    label: function (context) {
                        var label = "";
                        if (context.parsed.x !== null && context.parsed.y !== null) {
                            label += "X: " + Math.round((context.parsed.x + Number.EPSILON) * 100) / 100 + ", Y: " + Math.round((context.parsed.y + Number.EPSILON) * 100) / 100;
                        }
                        return label;
                    },
                },
            },
        },
    },
});

factory.addEventListener("click", function (event) {
    var rect = this.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;

    // Convert the click coordinates to chart data coordinates
    var xValue = chart.scales.x.getValueForPixel(x);
    var yValue = chart.scales.y.getValueForPixel(y);

    chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
    });

    // Add a new bubble to the chart data
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push({
            x: xValue,
            y: yValue,
            r: inputR.value,
        });
    });

    inputX.value = xValue;
    inputY.value = yValue;
    console.log(xValue, yValue);

    // Update the chart
    chart.update("none");
});
