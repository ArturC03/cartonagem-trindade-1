const svg = document.querySelector("svg");
const inputX = document.getElementById("location_x");
const inputY = document.getElementById("location_y");
const lastX = inputX.value;
const lastY = inputY.value;

const image = new Image();
image.src = "images/plantas/plantaV1.png";
let imageWidth = 1688;
let imageHeight = 629;
console.log(imageWidth, imageHeight);

const plugin = {
    id: "customCanvasBackgroundImage",
    beforeDraw: (chart) => {
        if (image.complete) {
            const ctx = chart.ctx;
            const { top, left, width, height } = chart.chartArea;

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
            const x = left + (width - newWidth) / 2;
            const y = top + (height - newHeight) / 2;

            ctx.drawImage(image, x, y, newWidth, newHeight);
        } else {
            image.onload = () => chart.draw();
        }
    },
};

Chart.defaults.plugins.legend.display = false;

const chart = new Chart(factory, {
    type: "bubble",
    data: {
        datasets: [
            {
                label: "Location",
                data: [
                    {
                        x: lastX,
                        y: lastY,
                        r: 20,
                    },
                ],
                backgroundColor: "rgba(255, 99, 132, 0.6)",
                borderColor: "rgba(255, 99, 132, 1)",
                borderWidth: 1,
            },
        ],
    },
    options: {
        maintainAspectRatio: true,
        // aspectRatio: imageWidth / imageHeight,
        scales: {
            x: {
                bounds: "ticks",
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
            enabled: false,
        },
    },
    // plugins: [plugin],
});

document.getElementById("factory").addEventListener("click", function (event) {
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
            r: 20,
        });
    });

    inputX.value = xValue;
    inputY.value = yValue;
    console.log(xValue, yValue);

    // Update the chart
    chart.update("none");
});
