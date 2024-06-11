const factory = document.getElementById("factory");
const inputR = document.getElementById("cloud");

const imgX = document.getElementById("image-width").innerHTML;
const imgY = document.getElementById("image-height").innerHTML;

const tooltip = (context) => {
    var text = [];
    text.push("Radius: " + context.parsed.r);
    return text;
}

Chart.defaults.plugins.legend.display = false;
var data;
data = [
    {
        x: 50,
        y: 50,
        r: inputR.value,
    },
];

const chart = new Chart(factory, {
    type: "bubble",
    data: {
        datasets: [
            {
                label: "Sensor",
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

inputR.addEventListener("input", function (event) {
    var newRadius = inputR.value;

    // Update the radius value in the data array
    data[0].r = newRadius;

    // Update the chart
    chart.update("none");
});

$(document).ready(function() {
    $("#bgImageInput, #emailImageInput").change(function() {
        const input = this;
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const previewId = input.id.replace("Input", "");
                $("#" + previewId).attr("src", e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    });
});
